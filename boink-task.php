<?php
// Check if the token is provided as a command line argument
if ($argc < 2) {
    echo "Usage: php script.php <your_token>" . PHP_EOL;
    exit(1);
}

// Get the token from the command line argument
$token = $argv[1];

// List of actions to process
$actions = [
    "playTonEarnTonCook",
    "playDejenDog",
    "joinDejenDog",
    "playTravelFrog",
    "joinTravelFrog",
    "telegramJoinGoats3",
    "playMergePals",
    "joinMergePals",
    "twitterFollowAcidGames",
    "twitterFollowBeastLeague",
    "telegramPlayFrogMates",
    "telegramPlayLizarts",
    "twitterFollowMakeFrens",
    "telegramPlayMakeFrens",
    "telegramPlayTonGoldMiner",
    "telegramJoinTapMonsters",
    "telegramPlayTapMonsters",
    "telegramPlayEggTapper"
];

// Base URL for API requests
$baseURL = 'https://boink.astronomica.io/api/rewardedActions/';

// Function to send a POST request
function sendRequest($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: boink.astronomica.io',
        'Content-Length: 2',
        'Sec-Ch-Ua: "Chromium";v="127", "Not)A;Brand";v="99"',
        'Accept-Language: en-US',
        'Sec-Ch-Ua-Mobile: ?0',
        "Authorization: $token",  // Use the token from command line input
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.100 Safari/537.36',
        'Content-Type: application/json',
        'Accept: application/json, text/plain, */*',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Origin: https://boink.astronomica.io',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://boink.astronomica.io/earn',
        'Accept-Encoding: gzip, deflate', // Request only encodings that cURL supports
        'Priority: u=1, i',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Automatically decode the response
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate'); // Handle gzip and deflate encodings

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch) . PHP_EOL;
    } else {
        echo 'Response: ' . $response . PHP_EOL; // Output readable response
    }

    curl_close($ch);
}

// Loop through each action and send requests
foreach ($actions as $action) {
    // Construct URLs for each action
    $clickedURL = $baseURL . "rewardedActionClicked/$action?p=weba";
    $claimURL = $baseURL . "claimRewardedAction/$action?p=weba";

    // Send request to rewardedActionClicked URL
    echo "Sending requests $clickedURL" . PHP_EOL;
    sendRequest($clickedURL, $token);

    // Send request to claimRewardedAction URL
    echo "Success claim $claimURL" . PHP_EOL;
    sendRequest($claimURL, $token);
}
?>
