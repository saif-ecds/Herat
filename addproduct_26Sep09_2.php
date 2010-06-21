<?php 
include("dbcon.php");
require_once 'clasess/thumbnail.class.php';

$order_id = $_REQUEST['order_id'];
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$event_name = $_REQUEST['event'];
$signup_deadline = $_REQUEST['signup_deadline'];
$product_description = $_REQUEST['product_description'];
$cost_per_item = $_REQUEST['cost_per_item'];


######## START IMAGE THUMBNAILS CREATION ########
  $thumbnail = new thumbnail;
  if (!empty($_REQUEST['submit']))
  {
  	$tmp = $_FILES['upload_pic']['tmp_name']; 
  	$org = $_FILES['upload_pic']['name'];
	$org_size = $_FILES['upload_pic']['size'];
	
	list($imageWidth, $imageHeight, $imageType, $imageAttr) = getimagesize($tmp);
 	
  	if ($tmp)
  	{
  		$directory = 'images/products'; // Upload files to here.
  		$prefix = time(); // Filename prefixes
		$smlImage = $thumbnail->generate($tmp, $org, $directory, 'thumb_'.$prefix.'_'.$org, 40);
		if($org_size > 400){
			$org_size = 400;
		}
		$bigImage = $thumbnail->generate($tmp, $org, $directory, 'big_'.$prefix.'_'.$org, $imageWidth);
		$upload_pic = $prefix.'_'.$org;
  	}
  }
######## END IMAGE THUMBNAILS CREATION ########

$quantity = $_REQUEST['quantity0'].','.$_REQUEST['quantity1'].','.$_REQUEST['quantity2'].','.$_REQUEST['quantity3'].','.$_REQUEST['quantity4'].','.$_REQUEST['quantity5'].','.$_REQUEST['quantity6'].','.$_REQUEST['quantity7'];
//die();
######## START INSERT DATA INTO THE USER TABLE ########
$insert_sql = "INSERT INTO products (id, order_id, product_id, product_description, upload_pic, quantity, cost) VALUES ('', '$order_id', '$product_id', '$product_description', '$upload_pic', '$quantity', '$cost_per_item')";
mysql_query($insert_sql);
######## END INSERT DATA INTO THE THE USER TABLE ########
?>
<?php
	include "MailAttach.php";
	
	$filename     = $upload_pic;
	$content_type = 'image/jpeg';
	
	$myFile = 'images/products/big_'.$upload_pic;
	if(isset($myFile)){
	@$fd = fopen($myFile, "r");
	@$data = fread($fd, filesize($myFile));
	@fclose($fd);
	}
	$mail = new MailAttach;
	$mail->from    = "Click2Pay@PrographicsSportswear.com";
	$mail->to      = $email;
	$mail->subject = "Your Prographics Click2Pay Ordering Link For Your Chapter";
	
	
   	//$to = $email;
	//$from = "Click2Pay@PrographicsSportswear.com";
    //$subject = "Your Prographics Click2Pay Ordering Link For Your Chapter";
	
	echo $mailurl =  "http://".$_SERVER['HTTP_HOST']."/Click2Pay/orderlink.php?order_id=".base64_encode($order_id);
	
	
	$mail->body = $name."\n\n Collect money and signups the EASY way! Here is the link to your Prographics Click2Pay Order for ".$event_name.". Please forward this link your chapter's email distribution list. \n\n".$mailurl."\n\nOnce your members receive this link, they can sign up, select their quantity and sizes, then pay with their Visa, Mastercard or Paypal Account.\n\nFor your convenience, we have created a sample email for you to copy, paste, personalize and send to your chapter.\n\n Thank you for choosing Click2Pay and Prographics, we really appreciate it!\n\n\nYour Fanatical Customer Support Team at:\nPrographicsSportswear.com\n\n .......................................................................................................................................\n\nPlease copy/ paste and personalize the email message below to send to your chapter. \n .......................................................................................................................................\n\n Subject: ".$event_name." online sign up sheet for favors,\n\nHey Everybody, \n\nI am ordering ".$event_name." Favors form PrographicsSportswear.com, and using Click2Pay (their online signup service) to collect orders and money.  Please go to this link, create an account, and sign up for your ".$event_name." Favors there. You can pay with your MasterCard, Visa or Paypal Account. \n\n The signup deadline is ".$signup_deadline."\n\nPlease go to this link as soon as you get this message. With everything else you have going on, you don't want to miss your chance to sign up because this message was buried at the bottom of 200 other emails.\n\nHere is the link:\n\n".$mailurl."\n\nThanks !\n\n".$name;
	
	
	if($filename <> "")
	{
	$mail->add_attachment($data, $filename, $content_type);
	}
	$enviado = $mail->send();
	header("Location: createorder.php?create=1");
	//header("Location: createorder.php?create=1&order_id=".$order_id);
?> 


