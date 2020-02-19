<?php
//微信接口
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];

    $token = 'thisiswechat';
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $hash_str = sha1(implode($tmpArr));

    if($signature == $hash_str){
        if(isset($_GET['echostr'])){
            //用于微信验证token
            echo $_GET['echostr'];exit;
        }else{
            //微信推送的消息
            $xml = file_get_contents("php://input");
            //xml转成对象
            $xmlObj = simplexml_load_string($xml);
            //关注回复
            if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe'){
                 $info =  "<xml>
                          <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                          <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                          <CreateTime>time()</CreateTime>
                          <MsgType><![CDATA[text]]></MsgType>
                          <Content><![CDATA[".您好，欢迎关注！."]]></Content>
                        </xml>";
                file_put_contents("./error_log.txt",json_encode($info));
                echo $info;
            }
        }
    }


//写文件里
//file_put_contents("./log.txt",json_encode($_GET)); //微信发来的数据
//file_put_contents("./log1.txt",file_get_contents("php://input")); //接收原始xml数据或json数据流

