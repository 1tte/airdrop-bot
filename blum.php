<?php
// Function to make a cURL request
function makeCurlRequest($url, $method = 'GET', $headers = [], $body = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method === 'POST' && $body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}

// Headers for all requests
$headers = [
    'accept: application/json, text/plain, */*',
    'accept-language: en-US,en;q=0.9',
    'authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJoYXNfZ3Vlc3QiOmZhbHNlLCJ0eXBlIjoiQUNDRVNTIiwiaXNzIjoiYmx1bSIsInN1YiI6IjYwNWQyYTY5LTU4MzYtNGUwZC04YTlkLTEyMWQ0M2RmMTdhMyIsImV4cCI6MTcyNTgxNTgxOCwiaWF0IjoxNzI1ODEyMjE4fQ.SSrk1EFqB5_MXn7k6zwY18UzGkZ7Q5n6Bi0AEoi-Eh0',
    'origin: https://telegram.blum.codes',
    'priority: u=1, i',
    'sec-ch-ua: "Chromium";v="128", "Not;A=Brand";v="24", "Microsoft Edge";v="128", "Microsoft Edge WebView2";v="128"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',
];

// Get user balance and extract playPasses
echo "Fetching user balance...\n";
$balanceResponse = makeCurlRequest('https://game-domain.blum.codes/api/v1/user/balance', 'GET', $headers);
$balanceData = json_decode($balanceResponse, true);

if (isset($balanceData['playPasses'])) {
    $playPasses = $balanceData['playPasses'];
    echo "Available play passes: $playPasses\n";

    // Loop to play the game and claim the reward based on playPasses count
    for ($i = 0; $i < $playPasses; $i++) {
        echo "\nPlaying game pass " . ($i + 1) . "...\n";
        $playResponse = makeCurlRequest(
            'https://game-domain.blum.codes/api/v1/game/play', 
            'POST', 
            array_merge($headers, ['content-length: 0'])
        );

        // Decode response to extract gameId
        $playData = json_decode($playResponse, true);
        if (isset($playData['gameId'])) {
            $gameId = $playData['gameId'];
            echo "Game played successfully. Game ID: $gameId\n";

            // Add a 30-second delay before claiming the game reward
            echo "Waiting for 30 seconds before claiming the reward...\n";
            sleep(30);

            // Second request: Claim the game reward
            echo "Claiming game reward...\n";
            $claimBody = json_encode(['gameId' => $gameId, 'points' => 500]);
            $claimResponse = makeCurlRequest(
                'https://game-domain.blum.codes/api/v1/game/claim', 
                'POST', 
                array_merge($headers, ['content-type: application/json']), 
                $claimBody
            );

            echo "Claim Response: SUCCESS CLAIM +300 POINTS\n";
        } else {
            echo "Failed to retrieve gameId from play response.\n";
        }
    }
} else {
    echo "Failed to retrieve playPasses from balance response.\n";
}
