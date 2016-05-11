<?php
/**
  * wechat php test
  */
//include_once("filterKeyword.php")
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
// $wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";             
                if(!empty( $keyword ))
                {
                    $msgType = "text";
                    $contentStr =" ";
                    switch ($keyword) {
                        case '1':
                            # code...
                           $contentStr = "sb wake up!!";
                            break;
                        
                        default:
                            # code...
                            $contentStr +=  ."balabala"; 
                            break;
                    }
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }else{
                    echo "Input something...";
                }

        }else {
            echo "";
            exit;
        }
    }
        
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}


function keywordSelect($keyword){
    $returnstr ="heihei";
    /*
    switch ($keyword) {
        case '?':
        case "？":
            # code...
            //setcookie("choose","",time()-3600);
            $returnstr = "你可能想知道\n";
            //$returnstr += ."【1】号码\n【2】我名字= -\n";
            
            break;

        case "1":
            if(!isset($_COOKIE["choose"])){

                $returnstr += ."你可能想知道\n";
                $returnstr += ."【1】特殊服务号码\n【2】通讯服务号码\n【3】本人手机号码\n";
            //  setcookie("choose","num",time()+3600);
            
            }else{
                switch($_COOKIE["choose"]){
                    case "num":

                    $returnstr += "报警 110\n";
                    break;
                }
            }
            
            break;
        case "2":
            if(!isset($_COOKIE["choose"])){

                $returnstr += ."我名字就在写在上面啊sx\n";

                
            
            }else{
                switch($_COOKIE["choose"]){
                    case "num":
                        $returnstr += ."移动 10086\n";
                        break;
                }
            
            }

            break;
            
        case "3":
            if(!isset($_COOKIE["choose"])){
                $returnstr +=. "13710685836 别打骚扰电话哦XD\n";           
            }else{
                switch($_COOKIE["choose"]){
                    case "num":
                        $returnstr +=. "移动 10086\n";
                        break;
                }
            }

            break;

        default:
            # code...
            $returnstr  ="excuse me?!";
            break;
    }*/
    return $keyword;
}

?>