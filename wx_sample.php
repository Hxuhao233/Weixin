<?php
/**
  * wechat php test
  * 
  */
echo 'start';
//define your token
define("TOKEN", "weixin");
include_once("filterKeyword.php");
$wechatObj = new wechatCallbackapiTest();
//验证函数
//$wechatObj->valid();
//自动回复
$wechatObj->responseMsg();
echo 'hi,sb~';
class wechatCallbackapiTest
{
    public function valid()
    {
        //接收随机字符串
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /**
     * 自动回复
     * @return [type] [description]
     */
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
                $fromUsername = $postObj->FromUserName;             //发送方账号
                $toUsername = $postObj->ToUserName;                     //开发者微信号
                $keyword = trim($postObj->Content);                             //文本消息
                $time = time();
                
                //消息类型(6种)
                $msgType = $postObj->MsgType;

                //文本发送模板
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";        

                switch ($msgType) {
                    case 'text':
                        # code...
                            
                    //回复类型
                    $msgType = "text";
		
		//  $contentStr = "xixi";                  
                    //回复内容
                 //   $contentStr = keywordSelect($keyword);
                 $returnstr;
                  switch ($keyword) {
        case '?':
        case "？":
            # code...
            //setcookie("choose","",time()-3600);
            $returnstr += "你可能想知道\n";
            $returnstr += "【1】号码\n【2】我名字= -\n";
            

            break;

        case "1":
            if(!isset($_COOKIE["choose"])){

                $returnstr += "你可能想知道\n";
                $returnstr += "【1】特殊服务号码\n【2】通讯服务号码\n【3】本人手机号码\n";
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

                $returnstr += "我名字就在写在上面啊sx\n";

                
            
            }else{
                switch($_COOKIE["choose"]){
                    case "num":
                        $returnstr += "移动 10086\n";
                        break;
                }
            
            }

            break;
            
        case "3":
            if(!isset($_COOKIE["choose"])){

                $returnstr += "13710685836 别打骚扰电话哦XD\n";

                
            
            }else{
            
                switch($_COOKIE["choose"]){
                    case "num":
                        $returnstr += "移动 10086\n";
                        break;
                }
            }

            break;

        default:
            # code...
            break;
    }
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $returnstr);
                    //echo $resultStr;

                        break;
                    
                    default:
                        # code...
                        break;
                }




        }else {
            echo "";
            exit;
        }
    }
        
    /**
     * 用户签名认证
     * @return [type] [description]
     */
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
    //数组转字符串再加密
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    
    if( $tmpStr == $signature ){
        return true;
    }else{
        return false;
    }
    }
}

?>
