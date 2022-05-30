<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LineBotController extends Controller
{
    public function reply(Request $request){
        $access_token = 'gqgEkKz8kKUIJ9XwgmBhK3ZbPnzK2W4H6XfBmLMXZ8UJjzmCy9NSzldWU0XFDYK9+Oz6tpXagzwmtOvRfZvfpYFsIe51T9vX2ljZ79r2xu7UYZj/nyXgUdstJ6qc0aiFAUzQXf303D3Tx8Uq4DcV5QdB04t89/1O/w1cDnyilFU=';
        // DB::table('access_log')->insert([
        //     'url' => 'LINEBOT',
        //     'query_string' => json_encode($request->all()),
        //     'method' => $request->method(),
        //     'created_at' => date('Y-m-d H:i:s'),
        // ]);
        $content = json_encode($request->all());
        $content = json_decode($content, true);
        $events = $content['events'];

        $userId = $events[0]['source']['userId'];
        $replyToken = $events[0]['replyToken'];
        $text = $events[0]['message']['text'];

        if($text != 'สวัสดี'){
            exit();
        }

        $messages = [
            'type' => 'text',
            'text' => $userId
        ];
        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
            'replyToken' => $replyToken,
            'messages' => [$messages],
        ];
        
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
        $post = json_encode($data);
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
