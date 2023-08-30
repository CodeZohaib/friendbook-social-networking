<?php
$user=new page;

$userData=$user->getUserInfo();
$allusers=$user->getUserInfo('allUsers');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>News Feed | Check what your friends are doing</title>
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
            <!-- Post Create Box End-->

            <div class="loadAjaxData">
            </div>

           <div class="error_sms"></div>
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
    <div id="dialog"></div>
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>
    
   <?php include "components/jsFiles.php" ?>
  </body>
</html>
