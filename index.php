<?php
$access_token = 'JyHZe860ykSn2FufkTtH4DMEL3YhZd0egdsfVgNfF3moQSSFr4Kgo/K01vXzGzGdqXSYFFX/l1Y3yKJqIuZ1DLuRzmJrmyAH9toE32q3j5K1wVnlPQZhowfpJemzE5kSlRKHSiyE7quuYD76T5u5QgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message') {
			// Get text sent
			//$text = $event['source']['userId'];
			$Displayname = "";
			$pictureUrl = "";
			$statusMessage = "";
			/*$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
			$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'bd31aa28b9185fe8a1ddb826dd018921']);
			$response = $bot->getProfile($event['source']['userId']);
			if ($response->isSucceeded()) {
			    $profile = $response->getJSONDecodedBody();
			    $Displayname = $profile['displayName'];
			    $pictureUrl = $profile['pictureUrl'];
			    $statusMessage = $profile['statusMessage'];
			}*/
			
			$text = "UserId : " . $event['source']['userId'] . "\nType : ". $event['message']['type']. "\nText : ". $event['message']['text'];
			//$text = "DisplayName : " . $Displayname . ", pictureUrl : " . $pictureUrl . ", statusMessage : " . $statusMessage
			
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
