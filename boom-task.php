<?php
// List of task names
$tasks = [
    "tg0334_join_bits_tonbox",
    "tg0315_sub_bits",
    "tg0318_react_bits",
    "tg0313_participate_10kraffle",
    "tg0328_partners_owlsonton",
    "tg0339_partners_boinkers",
    "tg0327_partners_tapgpt",
    "x021_sub_tonnyx",
    "tg0340_partners_tassbeeh",
    "tg0341_partners_prime",
    "tg0325_partners_frogfarm",
    "tg0312_partners_tonsoffriends",
    "tg0253_partners_cexio",
    "tg0342_partners_toncapy",
    "youtube0113_birds",
    "tg0320_partners_tassbeeh",
    "tg0321_partners_prime",
    "x016_sub_slingshot",
    "tg0204_corn_dontopen",
    "task_page_watch_adds_repeatable",
    "task_page_tg0001",
    "task_page_tg0002",
    "tg0161_channel_boost",
    "tiktok0104_sub_boom",
    "youtube0111_sub_boom",
    "task_page_x0001",
    "task_page_tg0004",
    "task_page_tg0006",
    "task_page_youtube0001",
    "task_page_x0003",
    "task_page_tiktok0001",
    "task_page_tg0005",
    "x017_sub_slingshot",
    "tg0309_partners_toncapy",
    "tg0171_participate_raffle_boom",
    "tg0314_partners_boinkers",
    "tg0073_partners_SimpleCoin",
    "tg0070_partners_Wcoin",
    "tg0310_partners_memefi",
    "tg0177_partners_dotcoin_bot",
    "tg0178_partners_dotcoin_channel",
    "tg0236_influence_cryptoxavgx",
    "tg0150_partners_tranding",
    "tg0151_partners_tranding",
    "tg062_partners_timefarm",
    "tg0083_partners_tomarket",
    "tg0205_corn_friendearns",
    "x018_sub_slingshot",
    "tg0179_partners_ghost_bot",
    "tg0322_influence_geekston",
    "tg0231_partners_goats",
    "tg0172_react_3mlnsubs",
    "youtube0114_8thvideo",
    "youtube0115_8thshort",
    "tiktok0106_8thvideo",
    "tg0335_partners_xempire",
    "tg0206_corn_takechance"
];

// Loop through each task and make the API requests
foreach ($tasks as $task) {
    // API URL for 'start' request
    $startUrl = 'https://api-bot.backend-boom.com/api/v1/socialtask/start?access_token=2cf78201-af0c-4e27-b33a-4b9191cc4714';
    // Start request payload
    $startPayload = json_encode(['name' => $task, 'adId' => null]);

    // Initialize cURL for start request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $startUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: api-bot.backend-boom.com',
        'Content-Length: ' . strlen($startPayload),
        'Sec-Ch-Ua: "Chromium";v="127", "Not)A;Brand";v="99"',
        'Sid: 833c4a50-5c8e-49b8-98cc-b623a26e1361',
        'Accept-Language: en-US',
        'Sec-Ch-Ua-Mobile: ?0',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.100 Safari/537.36',
        'App-Token: MgRecS578TubGhZ8DNh6hK',
        'Content-Type: application/json',
        'Accept: application/json, text/plain, */*',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Origin: https://bot.backend-boom.com',
        'Sec-Fetch-Site: same-site',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://bot.backend-boom.com/',
        'Accept-Encoding: gzip, deflate, br',
        'Priority: u=1, i',
        'Connection: keep-alive',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $startPayload);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute the start request
    $startResponse = curl_exec($ch);
    curl_close($ch);

    // Log the response (optional)
    echo "Start Response for task $task: $startResponse\n";

    // API URL for 'claim' request
    $claimUrl = 'https://api-bot.backend-boom.com/api/v1/socialtask/claim?access_token=2cf78201-af0c-4e27-b33a-4b9191cc4714';
    // Claim request payload
    $claimPayload = json_encode(['name' => $task]);

    // Initialize cURL for claim request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $claimUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: api-bot.backend-boom.com',
        'Content-Length: ' . strlen($claimPayload),
        'Sec-Ch-Ua: "Chromium";v="127", "Not)A;Brand";v="99"',
        'Sid: 833c4a50-5c8e-49b8-98cc-b623a26e1361',
        'Accept-Language: en-US',
        'Sec-Ch-Ua-Mobile: ?0',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.100 Safari/537.36',
        'App-Token: MgRecS578TubGhZ8DNh6hK',
        'Content-Type: application/json',
        'Accept: application/json, text/plain, */*',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Origin: https://bot.backend-boom.com',
        'Sec-Fetch-Site: same-site',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://bot.backend-boom.com/',
        'Accept-Encoding: gzip, deflate, br',
        'Priority: u=1, i',
        'Connection: keep-alive',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $claimPayload);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute the claim request
    $claimResponse = curl_exec($ch);
    curl_close($ch);

    // Log the response (optional)
    echo "Claim Response for task $task: $claimResponse\n";
}
?>
