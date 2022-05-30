<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class CustomerEndCourseNotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customerEndCouse:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = date('Y-m-d',strtotime("+1 days"));
        $sql = "SELECT * FROM (
                    SELECT count(*) as date_quantity, id, code, shipping_name, shipping_phone, course_started_at, delivered_at FROM (
                        SELECT orders.id, orders.code, orders.shipping_name, orders.shipping_phone, orders.course_started_at, order_details.delivered_at FROM orders
                        LEFT JOIN order_details ON orders.id = order_details.order_id
                        WHERE orders.type = 'course' AND order_details.status <> 'delivered' AND orders.deleted_at is null
                        GROUP BY order_details.delivered_at,orders.id
                        ORDER BY orders.id ASC, order_details.delivered_at ASC) as tb1
                    GROUP BY id
                    HAVING date_quantity < 2
                    ORDER BY delivered_at ASC) as tb2
                WHERE date(delivered_at) = '${today}'
                ";

        $result = DB::select($sql);
        if(!count($result)){
            exit();
        }

        $access_token = 'gqgEkKz8kKUIJ9XwgmBhK3ZbPnzK2W4H6XfBmLMXZ8UJjzmCy9NSzldWU0XFDYK9+Oz6tpXagzwmtOvRfZvfpYFsIe51T9vX2ljZ79r2xu7UYZj/nyXgUdstJ6qc0aiFAUzQXf303D3Tx8Uq4DcV5QdB04t89/1O/w1cDnyilFU=';
        $users = ['U40842034a9108a52263b5037fd4a5cef', 'U4db68989e181c6bdba4fc440accda7c4', 'U0878b3cf4f72f2bd58a56f1075dcfda4', 'U90462125b9f8faa63a7b4de1d198d6b7','U606db9a9a184bc46b839fc63f699608e'];
        // $users = ['U40842034a9108a52263b5037fd4a5cef'];

        $customer = '';
        foreach($result as $data){
            $customer .= $data->shipping_name.' '.$data->shipping_phone.''."\r\n";
        }
        $message = array(
            [
                'type' =>'text',
                'text' =>'SWH Cleanfood มีลูกค้าที่จะจบคอร์สในวันที่ '.$today.' จำนวน '.count($result). ' คน'."\r\n".$customer
            ]
        );

        $url = 'https://api.line.me/v2/bot/message/push';
        foreach($users as $user){
            $data = [
                'to' => $user,
                'messages' => $message,
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
        }
    }
}
