<?php
while (true) {
    $amount = 0;
    $feedamount = 100;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ranch-api.kuroro.com/api/Clicks/MiningAndFeeding');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: ranch-api.kuroro.com',
        'Sec-Ch-Ua: "Chromium";v="127", "Not)A;Brand";v="99"',
        'Accept-Language: en-US',
        'Sec-Ch-Ua-Mobile: ?0',
        'Authorization: Bearer query_id=AAG01GwxAwAAALTUbDFR7D8Y&user=%7B%22id%22%3A7271666868%2C%22first_name%22%3A%22Daryadi%22%2C%22last_name%22%3A%22Gumelar%20%F0%9F%8D%85%22%2C%22username%22%3A%22kontalkantilkontol%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1725362949&hash=b7f1758f4c3c38633d280e457fc6f6943a7196a7bfff51b747434f4be17301f5',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.100 Safari/537.36',
        'Content-Type: application/json',
        'Accept: application/json',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Origin: https://ranch.kuroro.com',
        'Sec-Fetch-Site: same-site',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://ranch.kuroro.com/',
        'Accept-Encoding: gzip, deflate, br',
        'Priority: u=1, i',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"feedAmount":' . $feedamount . ',"mineAmount":' . $amount . '}');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    
    curl_close($ch);
    
    echo "Claim +" . $amount . " | Feed +" . $feedamount . "\n";

    // Wait for 5 seconds before the next request
    sleep(2);
}
?>
