import requests
import json
import time
import logging
import warnings
from datetime import datetime

# Suppress SSL warnings
warnings.simplefilter('ignore')

# Set up logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(message)s')

# ANSI escape sequences for coloring
RESET = "\033[0m"
GREEN = "\033[92m"
RED = "\033[91m"
YELLOW = "\033[93m"
BLUE = "\033[94m"

def log_message(message, color=RESET):
    logging.info(f"{color}{message}{RESET}")

def check_balance(telegram_data):
    url = 'https://elb.seeddao.org/api/v1/profile/balance'
    headers = {
        'User-Agent': 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        'telegram-data': telegram_data
    }

    try:
        response = requests.get(url, headers=headers, verify=False)
        response_data = response.json()

        if 'data' in response_data:
            balance = response_data['data']
            log_message(f"Balance Check: Token is valid. Current balance: {balance / 1_000_000_000} SEED", GREEN)
            return balance
        else:
            log_message("Balance Check: Token is invalid or expired. Please re-enter your Telegram Data.", RED)
            return None
    except requests.RequestException as e:
        log_message(f"Balance Check Error: {str(e)}", RED)
        return None

def buy_item(market_id, telegram_data):
    url = 'https://elb.seeddao.org/api/v1/market-item/buy'
    headers = {
        'User-Agent': 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        'Content-Type': 'application/json',
        'telegram-data': telegram_data
    }
    payload = json.dumps({"market_id": market_id})

    while True:  # Keep trying to buy the item
        try:
            response = requests.post(url, headers=headers, data=payload, verify=False)
            response_data = response.json()

            if 'data' in response_data and response_data['data']['status'] == "bought":
                log_message(f"Successfully bought item with market ID: {response_data['data']['id']}", GREEN)
                
                # Check balance after successful purchase
                check_balance(telegram_data)
                
                break  # Exit loop on success
            elif response_data.get('code') == "resource-not-found":
                log_message("Buy Item Error: Item not found. Stopping attempts.", RED)
                break  # Exit loop if item is not found
            else:
                log_message(f"Buy Item Error: {response_data.get('message', 'No message')}", YELLOW)
                time.sleep(1)  # Wait before trying again
        except requests.RequestException as e:
            log_message(f"Buy Item Error: {str(e)}", RED)

def find_and_buy_items(telegram_data):
    price_limits = {
        "common": 0.9,
        "uncommon": 0.9,
        "rare": 1.0
    }
    
    types = ["common", "uncommon", "rare"]
    
    while True:
        for worm_type in types:
            log_message(f"Searching for {worm_type} items...", BLUE)
            url = f'https://elb.seeddao.org/api/v1/market/v2?market_type=worm&worm_type={worm_type}&sort_by_price=ASC&page=1'
            headers = {
                'User-Agent': 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
                'telegram-data': telegram_data
            }

            response = requests.get(url, headers=headers, verify=False)
            response_data = response.json()

            if 'data' in response_data and 'items' in response_data['data']:
                items = response_data['data']['items']
                found_item = False

                for item in items:
                    price_gross = item['price_gross'] / 1_000_000_000  # Convert to SEED
                    if price_gross < price_limits[worm_type]:
                        found_item = True
                        log_message(f"Found cheap {worm_type} item with ID: {item['id']} for {price_gross} SEED", GREEN)
                        buy_item(item['id'], telegram_data)  # Try to buy the item
                        time.sleep(1)  # Wait a bit between purchases
                
                if not found_item:
                    log_message(f"[{datetime.now()}] No more items found for {worm_type}", YELLOW)
            else:
                log_message(f"[{datetime.now()}] No items found for {worm_type}", YELLOW)

if __name__ == "__main__":
    telegram_data = input("Your Telegram Data: ")
    
    balance = check_balance(telegram_data)
    if balance is not None:
        find_and_buy_items(telegram_data)
