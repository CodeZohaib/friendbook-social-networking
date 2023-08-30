<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
		<meta name="robots" content="index, follow" />
		<title>FriendBook Login</title>
    <?php include "components/cssFiles.php" ?>
	</head>
	<body>
    <!-- Header
    ================================================= -->
		<?php include "components/navbar.php"; ?>
    <!--Header End-->
		<section id="banner">
			<div class="container">

        <!-- Sign Up Form
        ================================================= -->
        <div class="sign-up-form">
					<a href="index.html" style="font-size:30px">FriendBook</a>
					<h2 class="text-white">Find My Friends</h2>
					<div class="line-divider"></div>
					<div class="form-wrapper">
						<p class="signup-text">Signup now and meet awesome people around the world</p>
						<form method="POST" action="<?php echo BASEURL; ?>/users/login" class="userLogin">

							<input type="text" name="friendbook" style="visibility: hidden;">

							<fieldset class="form-group">
								<input type="email" name="email" class="form-control" placeholder="Enter Email.....!" required>
							</fieldset>

							<fieldset class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Enter a Password.....!" required>
							</fieldset>

							<p><a href="" id="forgot-password" data-toggle="modal" data-target="#send-password-link">Forgot Your Password.?</a></p>
							<div class="msg_display"></div>

							<button class="btn-secondary" type="submit">Login</button>
						</form>
					</div>
					<a class="btn btn-primary" style="background: linear-gradient(to bottom, rgba(83, 63, 117,.8), rgba(196, 59, 196) 65%);" data-toggle="modal" href='#signup'>Create a New Account</a>
					<img class="form-shadow" src="<?php echo BASEURL.'/public/assets/images/bottom-shadow.png'; ?>" alt="" />
				</div><!-- Sign Up Form End -->

       
			</div>
		</section>
    <!-- Features Section
    ================================================= -->
		<section id="features">
			<div class="container wrapper">
				<h1 class="section-title slideDown">Social Herd</h1>
				<div class="row slideUp">
					<div class="feature-item col-md-2 col-sm-6 col-xs-6 col-md-offset-2">
						<div class="feature-icon"><i class="icon ion-person-add"></i></div>
						<h3>Make Friends</h3>
					</div>
					<div class="feature-item col-md-2 col-sm-6 col-xs-6">
						<div class="feature-icon"><i class="icon ion-images"></i></div>
						<h3>Publish Posts</h3>
					</div>
					<div class="feature-item col-md-2 col-sm-6 col-xs-6">
						<div class="feature-icon"><i class="icon ion-chatbox-working"></i></div>
						<h3>Private Chats</h3>
					</div>
					<div class="feature-item col-md-2 col-sm-6 col-xs-6">
						<div class="feature-icon"><i class="icon ion-compose"></i></div>
						<h3>Create Polls</h3>
					</div>
				</div>
				<h2 class="sub-title">Find awesome people like you</h2>
			</div>
		</section>

    <!-- Footer
    ================================================= -->
		<?php include "components/footer.php"; ?>

    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!--sigin up box-->
       <div class="modal fade my-modal" id="signup" tabindex="-1" role="dialog">
       	<div class="modal-dialog modal-md" role="document">
       		<div class="modal-content">

       			<div class="modal-header">
       				<button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
       				<h4 class="modal-title">Signup for a new account</h4>
       			</div>

       			<div class="modal-body">
       				<form method="POST" action="<?php echo BASEURL; ?>/users/userRegister" class="form" enctype="multipart/form-data">

       					<div class="form-group">
       						<label for="name">Full Name</label>
       						<input type="text" name="name" class="form-control" placeholder="Enter Name.....!">
       					</div>

       					<div class="form-group">
       						<label for="email">Email Address</label>
       						<input type="email" name="email" class="form-control" placeholder="Enter Email Address....!">
       					</div>

       					<div class="form-group">
       						<label for="name">Gender</label><br>
										&nbsp;&nbsp;<span style="font-size:18px">Male</span> <input type="radio" name="gender" value="male">
									    &nbsp;&nbsp;<span style="font-size:18px">Female</span> <input type="radio" name="gender" value="female">
									</div>

       					<div class="form-group">
       						<label for="country">Country</label>
       						<select id="country" name ="country" class="form-control"></select>
       					</div>

       					<div class="form-group">
       						<label for="country">Select State</label>
       						<select id ="state" name ="state" class="form-control"><option>First Select Country</option></select>
       					</div>

       					<div class="form-group">
       						<label for="email">Current Address</label>
       						<input type="text" name="address" class="form-control" placeholder="Enter Current Address....!">
       					</div>

       					<div class="form-group">
       						<label for="password">Password</label>
       						<input type="password" name="password" class="form-control" placeholder="Enter Password....!">
       					</div>

       					<div class="form-group">
       						<label for="confrim_password">Confim Password</label>
       						<input type="password" name="cpassword" class="form-control" placeholder="Enter Again Same Password....!">
       					</div>

       					
						<div class="form-group">
							<label class="custom-file-upload" style="color:black">
								   <span class="glyphicon glyphicon-camera"></span> Upload Picture 
								   <input type="file" name="image" id="profilePic">
							</label>
							<span id="showName"></span>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary" id="signup">Sign me Up!</button>
						</div>
       				</form>
       			</div>

       			<div class="modal-footer">
							
       		  </div>
       		</div>
       	</div>
       </div>
    <!--/sigin up box-->


        <!--Reset Password box-->
       <div class="modal fade my-modal" id="send-password-link" tabindex="-1" role="dialog">
       	<div class="modal-dialog" role="document">
       		<div class="modal-content">

       			<div class="modal-header">
       				<button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
       				<h4 class="modal-title">Send Password Email Address</h4>
       			</div>

       			<div class="modal-body">
       				<form action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post" class="form">

       					<div class="form-group">
       						<label for="email">Name</label>
       						<input type="text" name="name" class="form-control" placeholder="Enter Your Account Name......!" required>
       					</div>

       					<div class="form-group">
       						<label for="email">Email Address</label>
       						<input type="email" name="forgot_password" class="form-control" placeholder="Enter Your Email......!" required>
       					</div>

       					<button type="submit" class="btn btn-primary">Send Password</button>
       				</form>
       			</div>

       			<div class="modal-footer msg_display">
       				
       			</div>
       		</div>
       	</div>
       </div>
    <!--/Reset Password box-->



    <!-- Scripts
    ================================================= -->
    <?php include "components/jsFiles.php" ?>
    <script type="text/javascript">
    		populateCountries("country", "state");
    </script>
	</body>
</html>
