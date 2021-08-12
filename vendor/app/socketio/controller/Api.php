<?php
/*
 * @Title: 
 * @Author: wzs
 * @Date: 2020-06-16 10:52:38
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 17:10:19
 * @Description: 
 */ 
namespace app\socketio\controller;

require_once VENDOR_PATH . "workerman/phpsocket.io/src/autoload.php";

use PHPSocketIO\SocketIO;
use Workerman\Worker;

class Api
{
    public function index()
    {
        // 推送的url地址，使用自己的服务器地址
        $push_api_url = "http://0.0.0.0:5880";//这里同样不需要更改IP。只是端口一定需要和server.php onworker的一样
        $post_data = array(
           "type" => "publish",
           "content" => "这个是推送的测试数据",
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);
    }
}