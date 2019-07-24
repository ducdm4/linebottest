<?php

file_put_contents ( 'test.log' , "00\r\n" );
$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'fjCRT6Op0+MIL/3yjAsVF23JbeczZ0ca9PZ2Za4GL0hWq+Vgc/igm5NDu/2MXRZYJuJReTZ46oeoeazkKBdrb3QMi/MU34p922AylnsMun0mNKDUu05+o48feg6dV0dLRIKO5kN3fbDKeiCLvet7TgdB04t89/1O/w1cDnyilFU=';
$channelSecret = '05d6cf61c27fa17388251fbed964a974';


//test
// $ACCESS_TOKEN = '3h/+CibBjUgztlMsKBtljzJVfRtjFtCywPZ0xgLIYmMAAgDVnejEaSShJvE38RxKYu3fnImqeE4Kfxiw4Lpkaik/5QdGbLkXedSgMiVxu/yWfj3rD4R+EUHObk359e5r5zmIkh7Ijvv+ZOUV5SliBwdB04t89/1O/w1cDnyilFU=';
// $channelSecret = '6f1b88ae2d2df33d5c73cd1a69bc3b3e';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
