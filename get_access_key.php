<?php
include_once './config/config.php';

$access_token=file_get_contents('./config/access_token.txt');
$access_token=json_decode($access_token,true);
//刷新access_token
if(($access_token['expires_in']+$access_token['time'])-time() <=300 ){

    //配置访问地址及参数
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type={$grant_type}&appid={$appid}&secret={$appsecret}";
    //访问请求
    $response = file_get_contents($url); //发起get请求
    $response = json_decode($response,true);
    if(isset($response['access_token'])){
        $response['time']=time();
        //保存access_token
        file_put_contents('./config/access_token.txt',json_encode($response));
    }else{
        //记录错误日志
        file_put_contents('./log/error_log.txt',$response);
    }
    print_r($response);die;
}
echo 'time()'.print_r($access_token);die;