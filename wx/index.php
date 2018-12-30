<?php
   //获得参数 signature nonce token timestamp echostr
    $nonce     = $_GET['nonce'];
    $token     = 'dog';
    $timestamp = $_GET['timestamp'];
    $echostr   = $_GET['echostr'];
    $signature = $_GET['signature'];
    //形成数组，然后按字典序排序
    $array = array();
    $array = array($nonce, $timestamp, $token);
    sort($array);
    //拼接成字符串,sha1加密 ，然后与signature进行校验
    $str = sha1( implode( $array ) );
    if( $str == $signature && $echostr ){
        //第一次接入weixin api接口的时候
        echo  $echostr;
        exit;
    }


else{

        //1.获取到微信推送过来post数据（xml格式）
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        //2.处理消息类型，并设置回复类型和内容
        $postObj = simplexml_load_string( $postArr );
        //判断该数据包是否是订阅的事件推送
        if( strtolower( $postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if( strtolower($postObj->Event == 'subscribe') ){
                //回复用户消息(纯文本格式)
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  =  'text';
                $content  = '欢迎关注我们的微信公众账号,此公众号为测试公众号！';
                $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
            }
        }
      
      //判断该数据包是否是文本消息
        if( strtolower( $postObj->MsgType) == 'text'){
             //接受文本信息
    		$content = $postObj->Content;
             //回复用户消息(纯文本格式)
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  =  'text';
          		//天气情况
          		
          		$head="当前实况：\n";
          		$wendu="气温：3℃-5℃\n";
          		$jiangshui="降水：00mm\n";
          		$fengxiangfengsu="风力风速：东北风 微风\n";
          		$kongqizhiliang="空气质量：优良\n";
          		$xiangduishidu="相对湿度：57%\n";
          		$weilaisantian="未来三天天气情况：\n";
          		$day1="星期五：\n";
          		$day2="星期六：\n";
          		$day3="星期日：\n";
          		$day1tianqi="7℃，多云，西风，微风\n";
          		$day2tianqi="9℃，晴，西南风，微风\n";
          		$day3tianqi="10℃，阴，北风，大风\n";
                $content  = $content.$head.$wendu.$jiangshui.$fengxiangfengsu.$kongqizhiliang.$xiangduishidu.$weilaisantian.$day1.$day1tianqi.$day2.$day2tianqi.$day3.$day3tianqi;
           //$content  = '您发送的内容是：'.$content;
                $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
        }
    }