<?php
$user=new page;
$allusers=$user->getUserInfo('allUsers');
$userData=$user->getUserInfo();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="FriendBook, Social Media, Make Friends, Newsfeed, Profile Page, FriendBook" />
		<meta name="robots" content="index, follow" />
		<title>Friend List | Your Friend List</title>

		<!-- Stylesheets
    ================================================= -->
		<?php include "components/cssFiles.php" ?>
	</head>
  <body>

    <!-- Header
    ================================================= -->
		<?php include "components/navbar.php"; ?>
    <!--Header End-->

    <div id="page-contents">
    	<div class="container">
    		<div class="row">

    			<!-- Newsfeed Common Side Bar Left
          ================================================= -->
    			 <?php include "components/newsfeed_sidebar_left.php"; ?>


    			<div class="col-md-7">

            <!-- Post Create Box
            ================================================= -->
             <?php include "components/post_create_box.php"; ?>
             <!-- Post Create Box End -->

            <!-- Friend List
            ================================================= -->
            <div class="friend-list">
            	<div class="row loadAjaxData">


            	</div>
              <div class="error_sms"></div>
            </div>
          </div>

    			<!-- Newsfeed Common Side Bar Right
          ================================================= -->
    			<?php include "components/newsfeed_sidebar_right.php"; ?>
    		</div>
    	</div>
    </div>

    <!-- Footer
    ================================================= -->
     <?php include "components/footer.php"; ?>
     
    
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <?php include "components/jsFiles.php" ?>
    
  </body>
</html>
