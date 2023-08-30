<?php 
  $name=encryption('decrypt', $_SESSION['confirm_email'][0]);
	$image=encryption('decrypt', $_SESSION['confirm_email'][2]);
	if(empty($image) AND $image==NULL)
	{
		$image='profile.jpg';
	}

?>
<!DOCTYPE html>
<html>
<head>
<title>Email Confirmation Code</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php linkCSS("/public/assets/css/bootstrap.min.css"); ?>
<!-- web font -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'><!--web font-->
<link href="//fonts.googleapis.com/css?family=Six+Caps" rel="stylesheet">
<!-- //web font -->
<?php linkCSS("/public/assets/fonts/font-awesome.min.css"); ?>
<?php linkCSS("/public/assets/css/confirm.css"); ?>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

</head>
<body style="background:url(<?php echo BASEURL; ?>/public/assets/images/bg/2.jpg) no-repeat center 0px">
	<!-- main -->
	<div style="float: right; margin-right: 40px; margin-top: 20px;">
		<a href="<?php echo BASEURL; ?>/users/logout" class="btn btn-info" class="logout">Logout</a>
	</div><br>

	<div class="w3agileits-main">
		
		<h1>Email Confirmation</h1>

		<div class="agileits-newsletter">

		<p><?php echo ucfirst($name); ?> Your Confirmation code will be send your email address please enter your confirmation code</p>
			<div class="w3ls-tabs"> 

			<img src="<?php echo BASEURL; ?>/public/assets/images/users/<?php echo $image; ?>" style="width:100%; border:3px groove white">
			   
				<form  method="POST" action="<?php echo BASEURL; ?>/users/emailConfirm" class="emailConfirmation"> 
					<input type="number" name="confirmation_code" placeholder="Enter Confirmation Code..." required>
					<input type="submit" value="Submit" name="submit">
					<div class="clearfix"></div> 
				</form><br>
				<center>
					<form method="POST" action="<?php echo BASEURL; ?>/users/resendEmail" class="resend_email">
					     <button type="submit" class="btn" name="resend_email">Resend Code</button>
				    </form>
				</center>

				<div class="msg_display"></div>
			</div>

		</div>
	</div>	
	<!-- //main -->
	<!-- copyright -->
	<div class="copyright agileinfo">
		<p>© 2021 . All rights reserved | <a href="#" target="_blank"><u>Zohaib Khan</u></a></p>
	</div>
	<!-- //copyright -->

	 <?php include "components/jsFiles.php" ?>
</body>
</html>