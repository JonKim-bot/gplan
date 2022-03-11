<?php


/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */
     function debug($data)
    {

        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();

    }

    function alert($message){
        echo "<script>alert('".$message."')</script>";
    }

    function locationhref($path){
        echo "<script>location.href='".$path."';</script>";
    }
    function get_buyer_status($status_id){
        if($status_id == 0){
            
            return "Pending";
        }
        if($status_id == 2){
            return "Submit document";
        }
        if($status_id == 3){
            return "Ready to collect";
        }
    }
    function dd($data)
    {

        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();

    }

    function get_level($level){
        if($level <= 2){
            return "member";
        }
        else if($level <= 3){
            return "supervisor";
        }else if($level <= 6){
            return "manager";
        }else 
        {
            return "director";
        }
    }


    function getip() { 
        $ip=false;
                 if (isset($_SERVER)) {
                    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        
                        foreach ($arr as $ip) {
                            $ip = trim($ip);
        
                            if ($ip != 'unknown') {
                                $realip = $ip;
                                break;
                            }
                        }
                    } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                        $realip = $_SERVER['HTTP_CLIENT_IP'];
                    } else if (isset($_SERVER['REMOTE_ADDR'])) {
                        $realip = $_SERVER['REMOTE_ADDR'];
                    } else {
                        $realip = '0.0.0.0';
                    }
                } else if (getenv('HTTP_X_FORWARDED_FOR')) {
                    $realip = getenv('HTTP_X_FORWARDED_FOR');
                } else if (getenv('HTTP_CLIENT_IP')) {
                    $realip = getenv('HTTP_CLIENT_IP');
                } else {
                    $realip = getenv('REMOTE_ADDR');
                }
        
                preg_match('/[\\d\\.]{7,15}/', $realip, $onlineip);
                $realip = (!empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0');
                return $realip;
        }
        
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
      }
      function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
      }

      function getImageType($type_id){
        if($type_id == 0){
            return 'Exteriod';
        }

        if($type_id == 1){
            return 'Interiod';
        }

        if($type_id == 2){
            return 'Damage';
        }

        if($type_id == 3){
            return 'Document';
        }
      }
//计算小数点后位数
function getFloatLength($num) {
	$count = 0;

	$temp = explode ( '.', $num );

	if (sizeof ( $temp ) > 1) {
		$decimal = end ( $temp );
		$count = strlen ( $decimal );
	}

	return $count;
}

//PHP的两个科学计数法转换为字符串的方法
function NumToStr($num) {
    if (stripos($num, 'e') === false)
        return $num;
    $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"'); //出现科学计数法，还原成字符串
    $result = "";
    while ($num > 0) {
        $v = $num - floor($num / 10) * 10;
        $num = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}

function xml_to_array( $xml )
{
    return json_decode(json_encode((array) simplexml_load_string($xml)), true);
}

function http_request_json($url,$post_data){    
   
    $ch = curl_init();//打开
    $Pt=http_build_query($post_data);
    //echo $Pt;
//  exit;
    //exit;
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$Pt);
    //echo $post_data;111111
    //exit;
    $response  = curl_exec($ch);
    curl_close($ch);//关闭
    ECHO ($response);//1
    //exit;///1
    //ECHO $response;
    $result = json_decode($response,true);
    //pr($result);//1
    //exit;
     return $result;    
}

function geturl(){
    return $_SERVER['HTTP_HOST'];
}


function createtable($list,$filename,$header=array(),$index = array()){    
    header("Content-type:application/vnd.ms-excel");    
    header("Content-Disposition:filename=".$filename.".xls");    
    $teble_header = implode("\t",$header);  
    $strexport = $teble_header."\r";  
    foreach ($list as $row){    
        foreach($index as $val){  
            $strexport.=$row[$val]."\t";     
        }  
        $strexport.="\r";   
  
    }    
    $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);    
    exit($strexport);       
}  

function array_remove($data, $key){  
    if(!array_key_exists($key, $data)){  
        return $data;  
    }  
    $keys = array_keys($data);  
    $index = array_search($key, $keys);  
    if($index !== FALSE){  
        array_splice($data, $index, 1);  
    }  
    return $data;  
}  

function curl_post($url,$data = null)
{
     $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);  
    if (!empty($data)){  
        curl_setopt($curl, CURLOPT_POST, 1);  
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  
    }  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    $output = curl_exec($curl);  
    curl_close($curl);  
    return $output;  
}

function phpPost($url, $post_data=array(), $timeout=5,$header=""){
    $header=empty($header)?defaultHeader():$header;
    $post_string = http_build_query($post_data);
    $header.="Content-length: ".strlen($post_string);
    $opts = array(
        'http'=>array(
            'protocol_version'=>'1.0',//http协议版本(若不指定php5.2系默认为http1.0)
            'method'=>"POST",//获取方式
            'timeout' => $timeout ,//超时时间
            'header'=> $header,
            'content'=> $post_string)
        );
    $context = stream_context_create($opts);
    return  @file_get_contents($url,false,$context);
}

function defaultHeader(){
    $header="User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12\r\n";
    $header.="Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n";
    $header.="Accept-language: zh-cn,zh;q=0.5\r\n";
    $header.="Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n";
    return $header;
}