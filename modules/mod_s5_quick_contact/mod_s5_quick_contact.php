<?php
/**
@version 1.0: mod_s5_quick contact
Author: Shape 5 - Professional Template Community
Available for download at www.shape5.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$spamtext_s5_qc		= $params->get( 'spamtext' );
$pretext_s5_qc		= $params->get( 'pretext' );
$email_address = $params->get( 'adminemail' );
$subject_prefix = $params->get( 'subjectprefix' );
$nametext_s5_qc = $params->get( 'nametext' );
$emailtext_s5_qc = $params->get( 'emailtext' );
$subjecttext_s5_qc = $params->get( 'subjecttext' );
$subjectspacer = " ";
$bodytext_s5_qc = $params->get( 'bodytext' );
$sendtext_s5_qc = $params->get( 'sendtext' );
$width_s5_qc = $params->get( 'width' );
$height_s5_qc = $params->get( 'height' );
$thankyou_s5_qc = $params->get( 'thankyou' );
$emailerror_s5_qc = $params->get( 'emailerror' );
$spamerror_s5_qc = $params->get( 'spamerror' );
$notcomplete_s5_qc = $params->get( 'notcomplete' );
$ex1 = $params->get( 'ex1', 's5_qc_null');
$ex2 = $params->get( 'ex2', 's5_qc_null');
$ex3 = $params->get( 'ex3', 's5_qc_null');
$ex4 = $params->get( 'ex4', 's5_qc_null');
$ex5 = $params->get( 'ex5', 's5_qc_null');
$ex6 = $params->get( 'ex6', 's5_qc_null');
$ex7 = $params->get( 'ex7', 's5_qc_null');
$ex8 = $params->get( 'ex8', 's5_qc_null');
$ex9 = $params->get( 'ex9', 's5_qc_null');
$ex10 = $params->get( 'ex10', 's5_qc_null');
$ex11 = $params->get( 'ex11', 's5_qc_null');
$ex12 = $params->get( 'ex12', 's5_qc_null');
$ex13 = $params->get( 'ex13', 's5_qc_null');
$ex14 = $params->get( 'ex14', 's5_qc_null');
$ex15 = $params->get( 'ex15', 's5_qc_null');
$ex16 = $params->get( 'ex16', 's5_qc_null');
$ex17 = $params->get( 'ex17', 's5_qc_null');
$ex18 = $params->get( 'ex18', 's5_qc_null');
$ex19 = $params->get( 'ex19', 's5_qc_null');
$ex20 = $params->get( 'ex20', 's5_qc_null');
$ex21 = $params->get( 'ex21', 's5_qc_null');
$ex22 = $params->get( 'ex22', 's5_qc_null');
$ex23 = $params->get( 'ex23', 's5_qc_null');
$ex24 = $params->get( 'ex24', 's5_qc_null');
$ex25 = $params->get( 'ex25', 's5_qc_null');
$ex26 = $params->get( 'ex26', 's5_qc_null');
$ex27 = $params->get( 'ex27', 's5_qc_null');
$ex28 = $params->get( 'ex28', 's5_qc_null');
$ex29 = $params->get( 'ex29', 's5_qc_null');
$ex30 = $params->get( 'ex30', 's5_qc_null');

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['message'])) {
    $message = $_POST['message'];
}
if (isset($_POST['subject'])) {
    $subject = $subject_prefix . $subjectspacer . $_POST['subject'];
}
if (isset($_POST['verif_box'])) {
	$verif_box = (md5($_POST["verif_box"]).'a4xn');
}

$ran_num = rand(0,9999);

$exclude_check = "valid";


// Detects mail headers to prevent spammers.

	if (isset($_POST['name'])) {
	if ($name != "" && $name != " ") {
	   $from = urldecode($email);

	   
	   $message2 = "1".$message;
	   
	   if (strrpos($message2,$ex1) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex2) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex3) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex4) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex5) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex6) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex7) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex8) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex9) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex10) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex11) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex12) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex13) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex14) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex15) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex16) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex17) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex18) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex19) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex20) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex21) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex22) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex23) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex24) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex25) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex26) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex27) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex28) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex29) > 0) {
			$exclude_check = "invalid";
	   }
	   if (strrpos($message2,$ex30) > 0) {
			$exclude_check = "invalid";
	   }
	   
	   
	   if ($exclude_check == "valid") {
	   
			if($verif_box == $_COOKIE['s5_qc']){
				mail($_POST['email_address'], $subject, $message, "From: $name <$email>");
				setcookie('s5_qc','');
			} 
			
			else if(isset($message) and $message!=""){
				exit;
			} 
		
		}
		
	}
	}

	

?>

<?php if ($pretext_s5_qc != "") { ?>
<?php echo $pretext_s5_qc ?>
<br /><br />
<?php } ?>

<form name="s5_quick_contact" method="post" action="">


<input class="inputbox" id="namebox" onclick="s5_qc_clearname()" onfocus="s5_qc_clearname()" style="font-size:11px; font-family:arial; width:<?php echo $width_s5_qc ?>" type="text" value="<?php echo $nametext_s5_qc ?>" name="name"></input><br />
<input class="inputbox" id="emailbox" onclick="s5_qc_clearemail()" onfocus="s5_qc_clearemail()" style="font-size:11px; font-family:arial; width:<?php echo $width_s5_qc ?>" type="text" value="<?php echo $emailtext_s5_qc ?>" name="email"></input><br />
<input class="inputbox" id="subjectbox" onclick="s5_qc_clearsubject()" onfocus="s5_qc_clearsubject()" style="font-size:11px; font-family:arial; width:<?php echo $width_s5_qc ?>" type="text" value="<?php echo $subjecttext_s5_qc ?>" name="subject"></input><br />
<textarea id="messagebox" rows="" cols="" class="inputbox textarea" onclick="s5_qc_clearbody()" onfocus="s5_qc_clearbody()" style="font-size:11px; font-family:arial; overflow:auto;width:<?php echo $width_s5_qc ?>; height:<?php echo $height_s5_qc ?>" name="message"><?php echo $bodytext_s5_qc ?></textarea><br />
<input class="inputbox" id="spambox" onclick="s5_qc_clearspam()" onfocus="s5_qc_clearspam()" style="font-weight:bold; font-size:11px; font-family:arial; width:<?php echo $width_s5_qc ?>" type="text" value="<?php echo $spamtext_s5_qc ?> <?php echo $ran_num ?>" name="verif_box"></input><br />


<input id="email_address" type="hidden" value="" name="email_address"></input>

<input class="button" type="button" onclick="s5_qc_submit()" value="<?php echo $sendtext_s5_qc ?>" ></input>
</form>

<?php setcookie("s5_qc",(md5($ran_num).'a4xn')) ?>

<script language="javascript" type="text/javascript">
// <![CDATA[

var s5_qc_spam_text = document.getElementById("spambox").value;

function s5_qc_clearbody() {
if (document.getElementById("messagebox").value == "<?php echo $bodytext_s5_qc ?>") {
document.getElementById("messagebox").value="";
}
if (document.getElementById("namebox").value.length < 1) {
document.getElementById("namebox").value = "<?php echo $nametext_s5_qc ?>";
}
if (document.getElementById("emailbox").value.length < 1) {
document.getElementById("emailbox").value = "<?php echo $emailtext_s5_qc ?>";
}
if (document.getElementById("subjectbox").value.length < 1) {
document.getElementById("subjectbox").value = "<?php echo $subjecttext_s5_qc ?>";
}
if (document.getElementById("spambox").value.length < 1) {
document.getElementById("spambox").value = s5_qc_spam_text;
}
}

function s5_qc_clearname() {
if (document.getElementById("namebox").value == "<?php echo $nametext_s5_qc ?>") {
document.getElementById("namebox").value="";
}
if (document.getElementById("messagebox").value.length < 1) {
document.getElementById("messagebox").value = "<?php echo $bodytext_s5_qc ?>";
}
if (document.getElementById("emailbox").value.length < 1) {
document.getElementById("emailbox").value = "<?php echo $emailtext_s5_qc ?>";
}
if (document.getElementById("subjectbox").value.length < 1) {
document.getElementById("subjectbox").value = "<?php echo $subjecttext_s5_qc ?>";
}
if (document.getElementById("spambox").value.length < 1) {
document.getElementById("spambox").value = s5_qc_spam_text;
}
}

function s5_qc_clearemail() {
if (document.getElementById("emailbox").value == "<?php echo $emailtext_s5_qc ?>") {
document.getElementById("emailbox").value="";
}
if (document.getElementById("namebox").value.length < 1) {
document.getElementById("namebox").value = "<?php echo $nametext_s5_qc ?>";
}
if (document.getElementById("messagebox").value.length < 1) {
document.getElementById("messagebox").value = "<?php echo $bodytext_s5_qc ?>";
}
if (document.getElementById("subjectbox").value.length < 1) {
document.getElementById("subjectbox").value = "<?php echo $subjecttext_s5_qc ?>";
}
if (document.getElementById("spambox").value.length < 1) {
document.getElementById("spambox").value = s5_qc_spam_text;
}
}

function s5_qc_clearsubject() {
if (document.getElementById("subjectbox").value == "<?php echo $subjecttext_s5_qc ?>") {
document.getElementById("subjectbox").value="";
}
if (document.getElementById("namebox").value.length < 1) {
document.getElementById("namebox").value = "<?php echo $nametext_s5_qc ?>";
}
if (document.getElementById("emailbox").value.length < 1) {
document.getElementById("emailbox").value = "<?php echo $emailtext_s5_qc ?>";
}
if (document.getElementById("messagebox").value.length < 1) {
document.getElementById("messagebox").value = "<?php echo $bodytext_s5_qc ?>";
}
if (document.getElementById("spambox").value.length < 1) {
document.getElementById("spambox").value = s5_qc_spam_text;
}
}

function s5_qc_clearspam() {
if (document.getElementById("spambox").value == s5_qc_spam_text) {
document.getElementById("spambox").value="";
}
if (document.getElementById("namebox").value.length < 1) {
document.getElementById("namebox").value = "<?php echo $nametext_s5_qc ?>";
}
if (document.getElementById("emailbox").value.length < 1) {
document.getElementById("emailbox").value = "<?php echo $emailtext_s5_qc ?>";
}
if (document.getElementById("messagebox").value.length < 1) {
document.getElementById("messagebox").value = "<?php echo $bodytext_s5_qc ?>";
}
if (document.getElementById("subjectbox").value.length < 1) {
document.getElementById("subjectbox").value = "<?php echo $subjecttext_s5_qc ?>";
}
}


function s5_qc_isValidEmail(str_email) {
   if (str_email.indexOf(".") > 2 && str_email.indexOf("@") > 0) {
   alert('<?php echo $thankyou_s5_qc ?>');
   document.s5_quick_contact.submit();
   }
   else {
   alert('<?php echo $emailerror_s5_qc ?>');
   }
}

function s5_qc_submit() {

if (document.getElementById("spambox").value == s5_qc_spam_text || document.getElementById("subjectbox").value == "<?php echo $subjecttext_s5_qc ?>" || document.getElementById("namebox").value == "<?php echo $nametext_s5_qc ?>" || document.getElementById("emailbox").value == "<?php echo $emailtext_s5_qc ?>" || document.getElementById("messagebox").value == "<?php echo $bodytext_s5_qc ?>") {
alert('<?php echo $notcomplete_s5_qc ?>');
return false;
}

if (document.getElementById("spambox").value != "<?php echo $ran_num ?>") {
alert('<?php echo $spamerror_s5_qc ?>');
return false;
}

var s5_message_holder = document.getElementById("messagebox").value;
var s5_first_message_char = s5_message_holder.charAt(0);
var s5_second_message_char = s5_message_holder.charAt(1);
var s5_third_message_char = s5_message_holder.charAt(2);
var s5_fourth_message_char = s5_message_holder.charAt(3);

if (s5_first_message_char == "<") {
return false;
}

if (s5_first_message_char == "w" && s5_second_message_char == "w" && s5_third_message_char == "w") {
return false;
}

if (s5_first_message_char == "h" && s5_second_message_char == "t" && s5_third_message_char == "t") {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex1 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex2 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex3 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex4 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex4 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex5 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex6 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex7 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex8 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex9 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex10 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex11 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex12 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex13 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex14 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex15 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex16 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex17 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex18 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex19 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex20 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex21 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex22 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex23 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex24 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex25 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex26 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex27 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex28 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex29 ?>") >= 0) {
return false;
}

if (s5_message_holder.indexOf("<?php echo $ex30 ?>") >= 0) {
return false;
}

else {
document.getElementById("email_address").value = "<?php echo $email_address ?>";
var email_str = document.getElementById("emailbox").value;
s5_qc_isValidEmail(email_str);
}
}

// ]]>
</script>
