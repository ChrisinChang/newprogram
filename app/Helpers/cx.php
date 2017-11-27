<?php
/*****************************
 * 
 * 
 * 
 * 
 * 
 * *************************/

if( !function_exists('print_cx') ){
    
function print_cx( $_arr, $_b = false ) {
    $_str =  "<pre>";
    $_str .= print_r( $_arr, true );
    $_str .=  "</pre>";

    if ( $_b == true ) {
        return $_str;
    }else {
        echo $_str;
        return $_str;
    }
}

}

if( !function_exists('_cx_array_to_string') ){

    function _cx_array_to_string( $_arr ) {
        $att = '';
        foreach ( (array)$_arr as $key => $val ) {
            $att .= $key . "='" . $val . "'";
        }
        return $att;
    }
}

if( !function_exists('cx_getHtmlTag') ){
    function cx_getHtmlTag( $_tag, $_arr, $_val ,$_click = '') {
        return "<" . $_tag . " " . _cx_array_to_string( $_arr ) . " ".$_click.">" . $_val . "</" . $_tag . ">";
    }
}


if( !function_exists('cxdb_checkArray') ){
    function cxdb_checkArray( $aSet , $aData ){
        $setData = [];
        
        foreach( $aSet as $_set ){
            if( array_key_exists($_set , $aData) ){
                $setData[ $_set ] = $aData[ $_set ];
            }
        }
        return $setData;
    }
}





/*
藍色: primary
紅色: danger
淡藍: info
綠色: success
黃色 warning

*/
if( !function_exists('cxcore_alert') ){
    function cxcore_alert(  $_msg , $_type = "info" ){
        $sHtml = "";
        
        $_message = $_msg;
        $_span = cx_getHtmlTag( "span" , [ "aria-hidden"=>"true" ] , "x" );
        $_button = cx_getHtmlTag( "button" , ['type' => 'button' , 'class'=> 'close' , "data-dismiss" => 'alert' , "aria-label"=>'Close' ] , $_span  );
  
        $sHtml = cx_getHtmlTag("div" ,
                    [ "class" =>"alert dark alert-".$_type." alert-dismissible" , "role"=>"alert"   ],
                    $_button . $_message
                );
        
        
        return $sHtml;
    }
}


if( !function_exists('cxcore_msg_json2html') ){
    function cxcore_msg_json2html( $json , $lang = "tw" ){
        $sHtml = "";
        $_arr = json_decode( $json ,true );
        
        // print_cx($_arr);exit();
        
        foreach( (array)$_arr as $_key => $_val  ){
            if( is_array($_val) ){
                foreach( $_val as $_v ){
                    $sHtml .= $_key . ":" . $_v . "<br/>";
                }
            }else{
                $sHtml .= $_key . ":" . $_val . "<br/>";
            }
            
        }
        
        return $sHtml;
    }

}

if( !function_exists('cxcore_isInt') ){
    function cxcore_isInt( $_int_str ){
        $_val = "";
        if( !is_numeric($_int_str) ){
            return false;
        }
        
        if( strpos($_int_str , '.' ) ){
            return false;
        }
        return true;
    }
}


function cxcore_domian_salf($str){
    $str = str_replace( " " , "" , $str  );
    $str = str_replace( "http://" , "" , trim( $str ) );
    $str = str_replace( "https://" , "" , $str );
    
    $str = preg_replace("/[^A-Za-z0-9\-_]/", "", $str);
    return $str;
}

if( !function_exists('cxcore_domain2array') ){
    function cxcore_domain2array( $domian ) //驗證身份證
    {
        // echo $domian . " to ";
        // $domian = cxcore_domian_salf( $domian );
        // echo $domian;
        $aDomain = explode(".", trim( $domian ) );
        $sSub =  cxcore_domian_salf( $aDomain[0] );
        if( count( $aDomain ) < 2 ){
            return ['sub' => 'null' , 'main'=>'null'];
        }
        $main = "";
        for( $i =1 ;$i < count($aDomain) ;$i++ ){
            //"([A-Za-z])([0-9])"
            // ereg_replace("[a-zA-Z]","",$string)
            if( $i != 1 ){
                $main .= "." . cxcore_domian_salf( $aDomain[$i] );
            }else{
                $main .= cxcore_domian_salf( $aDomain[$i] );
            }
        }
        return ['sub' => $sSub , 'main'=> $main ];
        
    }
}




if( !function_exists('cxcore_isTwID') ){
    function cxcore_isTwID( $id ) //验证 身份证字号 格式 
    {
        //建立字母分数阵列
        $head = array( 'A'=>10, 'B'=>11, 'C'=>12, 'D'=>13, 'E'=>14, 'F'=>15,
            'G'=>16, 'H'=>17, 'I'=>34, 'J'=>18, 'K'=>19, 'L'=>20,
            'M'=>21, 'N'=>22, 'O'=>35, 'P'=>23, 'Q'=>24, 'R'=>25,
            'S'=>26, 'T'=>27, 'U'=>28, 'V'=>29, 'W'=>32, 'X'=>30,
            'Y'=>31, 'Z'=>33 );
        //检查身份字格式是否正确
        if ( ereg( "^[A-Za-z][1-2][0-9]{8}$", $id ) ) {
            //切开字串
            for ( $i=0; $i<10; $i++ ) {
                $idArray[$i] = substr( $id, $i, 1 );
            }
            $idArray[0] = strtoupper( $idArray[0] ); //小写转大写
            //取得字母分数&建立加权分数
            $a[0] = substr( $head[$idArray[0]], 0, 1 );
            $a[1] = substr( $head[$idArray[0]], 1, 1 );
            $total = $a[0]*1+$a[1]*9;
            //取得数字分数&建立加权分数
            for ( $j=1; $j<=8; $j++ ) {
                $total += $idArray[$j]*( 9-$j );
            }
            //检查比对码
            if ( $total%10 == 0 ) {
                $checksum = 0;
            } else {
                $checksum = 10-$total%10;
            }
            if ( $idArray[9] == $checksum ) {
                return true;
            } else {
                return false;
            }
            return false;
        }
    }
}

if( !function_exists('cxcore_removeXSS') ){
    function cxcore_removeXSS($val) { 
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
    // this prevents some character re-spacing such as <java\0script> 
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs 
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val); 
    // straight replacements, the user should never need these since they're normal characters 
    // this prevents like <IMG SRC=@avascript:alert('XSS')> 
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $search .= '1234567890!@#$%^&*()';
    // $search .= '~`";:?+/={}[]-_|\'\\';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
    // ;? matches the ;, which is optional
    // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
    // @ @ search for the hex values
    $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
    // @ @ 0{0,7} matches '0' zero to seven times 
    $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
    }
    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = Array( 'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);
    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
    $val_before = $val;
    for ($i = 0; $i < sizeof($ra); $i++) {
    $pattern = '/';
    for ($j = 0; $j < strlen($ra[$i]); $j++) {
    if ($j > 0) {
    $pattern .= '('; 
    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
    $pattern .= '|'; 
    $pattern .= '|(&#0{0,8}([9|10|13]);)';
    $pattern .= ')*';
    }
    $pattern .= $ra[$i][$j];
    }
    $pattern .= '/i'; 
    $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
    $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
    if ($val_before == $val) { 
    // no replacements were made, so exit the loop 
    $found = false; 
    } 
    } 
    } 
    return $val; 
    }
}


//秒數轉時分秒
if( !function_exists('get_second_to_his') ){
    function get_second_to_his( $s , $is_cht = 0 ){
        $_hr = ":";
        $_me = ":";
        $_ss = "";
        if( $is_cht == 1 ){
            $_hr = "小時 ";
            $_me = "分 ";
            $_ss = "秒";
        }
    return str_pad(floor(($s%86400)/3600),2,'0',STR_PAD_LEFT).$_hr.str_pad(floor((($s%86400)%3600)/60),2,'0',STR_PAD_LEFT).$_me.str_pad(floor((($s%86400)%3600)%60),2,'0',STR_PAD_LEFT).$_ss;
    }
}

//
if( !function_exists('cxcore_catchStr') ){
    //字串, 開頭關鍵字, 結尾關鍵字)
function cxcore_catchStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
}

if( !function_exists('cxcore_getIp') ){
function cxcore_getIp(){
    if (!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else{
        $ip = $_SERVER["REMOTE_ADDR"];
    }
         
    return $ip;
}}


function cxcore_curl( $url , $sData="" , $_type="GET" , $token ="" , $CURLOPT_USERPWD = ""){
    
    // $url = 'http://api.ll8888.info/api/dd';
    // $sData = 'myvar1=' . $myvar1 . '&myvar2=' . $myvar2;
    $ch = curl_init( $url );
    if( $_type == "POST" ){
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    }else{
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    }
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $sData);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    if( $CURLOPT_USERPWD != "" ){
        curl_setopt($ch, CURLOPT_USERPWD, $CURLOPT_USERPWD);
    }
    
    echo "tt:".$token;//exit();
    
    // 'X-XSRF-TOKEN': $('input[name="_token"]').val()
    if( $token != "" ){
        $headers[] = "Cookie: X-CSRF-Token=". $token;
        // $headers[] = "Cookie: X-CSRF-Token=$cookie";
        $headers[] = 'X-CSRF-TOKEN:' .  $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_COOKIE, "X-CSRF-Token=".$token.";");
    }
    
    $response = curl_exec( $ch );
    
    // print_r($response);exit();
    return $response;
    
}


function cxcore_intTimeToDate($int_s ){
    $r = (string)$int_s;
    return $r[0].$r[1].$r[2].$r[3]."-".$r[4].$r[5]."-".$r[6].$r[7]." ".$r[8].$r[9].":".$r[10].$r[11].":".$r[12].$r[13];
}


function cxcore_get_code( $_id ){
    $yCode_web = [
                    'A', 'B', 'C', 'D', 'E', 
                    'F', 'G', 'H', 'I', 
                    'J','K','L','M','N','O',
                    'P','Q','R','S','T','U',
                    'V','W','X','Y','Z',
                    'A', 'B', 'C', 'D', 
                    'A', 'B', 'C', 'D', 'E', 
                    'F', 'G', 'H', 'I', 
                    'J','K','L','M','N','O',
                    'P','Q','R','S','T','U',
                    'V','W','X','Y','Z',
                    'A', 'B', 'C', 'D', 'D'
                ];
    return $yCode_web[ ($_id % 60) ];          
}


function cxcore_rand(){
    //16碼
    $yCode_web = [
                    'A', 'B', 'C', 'D', 'E', 
                    'F', 'G', 'H', 'I', 
                    'J','K','L','M','N','O',
                    'P','Q','R','S','T','U',
                    'V','W','X','Y','Z',
                    'A', 'B', 'C', 'D', 
                    'A', 'B', 'C', 'D', 'E', 
                    'F', 'G', 'H', 'I', 
                    'J','K','L','M','N','O',
                    'P','Q','R','S','T','U',
                    'V','W','X','Y','Z',
                    'A', 'B', 'C', 'D', 'D'
                ];
    $orderSn = 
            $yCode_web[intval(date('s'))].
                    time().
                    sprintf('%03d%02d', rand(100, 999),rand(0,99)
                    );
    return $orderSn;
}


/**
$cxAtUrl 系統 at 服務網址
$url 目標網址
$run_time_end 目標執行時間
**/
function cxcore_AT_TOOL($cxAtUrl , $url  , $run_time_end ){
    
    // $cxBaseUrl = config("app.cxBaseUrl");
    // $cxAtUrl = config("app.cxAtUrl");
        
    // $run_time_end = $after_paybox['run_time_end'];
    // $url = "http://API.".$cxBaseUrl."/api/deposit/checkUserPay?core=cx\\&pbox_id=".$after_paybox['id'];
    
    $base64_url = base64_encode($url);
        
    
    $_BACK_DATA =  cxcore_curl( $cxAtUrl."?run_time_end=".$run_time_end."&url=".$base64_url  );
        // echo $_BACK_DATA;
        // echo "END";
}