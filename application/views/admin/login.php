<!DOCTYPE html>
<html lang="en">
<head>
	<title>FriendBook Admin Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
	<?php 
	   linkCSS("assets/css/bootstrap.min.css");
	   linkCSS("assets/admin/css/util.css");
     linkCSS("assets/admin/css//main.css");
	?>

	<style type="text/css">
		.forgotPassword:hover{
			color: black;
		}
	</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url(' <?php echo BASEURL."/public/assets/images/login_bg.jpg"; ?>');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Admin Login
				</span>
				<form method="POST" action="<?php echo BASEURL; ?>/admin/adminLogin" class="login100-form validate-form p-b-33 p-t-5 submit_form">

					<div class="wrap-input100 validate-input">
						<input class="input100" type="email" name="email" placeholder="Enter Email" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit">
							Login
						</button><br>

					</div><br>
					<center><a href="" class="forgotPassword" data-toggle="modal" data-target="#send-password">Forgot Your Password.?</a></center><br>
					<div class='sms_display'></div>
				</form>

			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>
<!--Reset Password box-->
     <div class="modal fade my-modal" id="send-password" tabindex="-1" role="dialog">
       	<div class="modal-dialog" role="document">
       		<div class="modal-content">

       			<div class="modal-header">
       				<button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
       				<h4 class="modal-title">Send Password Email Address</h4>
       			</div>

       			<div class="modal-body">
       				<form action="<?php echo BASEURL."/admin/forgotPassord"; ?>" method="post" class="submit_form">

       					<div class="form-group">
       						<label for="email">Name</label>
       						<input type="text" name="name" class="form-control" placeholder="Enter Your Account Name......!" required>
       					</div>

       					<div class="form-group">
       						<label for="email">Email Address</label>
       						<input type="email" name="email" class="form-control" placeholder="Enter Your Email......!" required>
       					</div>

       					<button type="submit" class="btn btn-primary">Send Password</button><br><br>

       					<div class="sms_display"></div>
       				</form>


       			</div>

       			<div class="modal-footer msg_display">
       				
       			</div>
       		</div>
       	</div>
       </div>
    <!--/Reset Password box-->
	<?php 

	  linkJS("assets/js/jquery-3.1.1.min.js");
	  linkJS("assets/js/bootstrap.min.js");
	  linkJS("assets/admin/js/main.js"); 
	  linkJS("assets/admin/js/custom.js"); 

	?>
</body>
</html>