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
		<meta name="description" content="This is social network html5 template available in themeforest......" />
		<meta name="keywords" content="Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
		<meta name="robots" content="index, follow" />
		<title>Images | Cool Images</title>

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

            <!-- Media
            ================================================= -->
            <div class="media">
            	<div class="row js-masonry loadAjaxData" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": ".grid-sizer", "percentPosition": true }'>

            </div>

            <div class="error_sms"></div>
            
          </div>
            <!--Popup-->
                <div class="modal fade modal-1" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-xs">
                    <div class="modal-content postData">
                      <video controls="">
                             <source src="http://localhost/project/public/assets/user_post_files/96848_1.mp4" type="video/mp4">
                            </video>
                    </div>
                  </div>
                </div>
            <!--Popup End-->
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
