<?php
$user=new timeline;
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
		<title>My Timeline | This is My Coolest Profile</title>

   <?php include "components/cssFiles.php" ?>
	</head>
  <body>

    <!-- Header
    ================================================= -->
		<?php include "components/navbar.php"; ?>

    <div class="container">

      <!-- Timeline
      ================================================= -->
      <div class="timeline">
        <?php include "components/profile-header.php"; ?>

        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-7">

              <!-- Post Create Box
              ================================================= -->
              <?php include "components/post_create_box.php"; ?>
              <!-- Post Content
              ================================================= -->

              <div class="loadAjaxData">
                
              </div>
              
              <div class="error_sms"></div>
            </div>
            <div class="col-md-2 static">
               <?php include "components/userActivity.php"; ?>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Footer
    ================================================= -->
    <?php include "components/footer.php"; ?>

         <div class="modal fade accountWarning" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">Account Warning Details</h4>
                </div>

                <div class="modal-body accountWarningData">

                  <?php 
                  if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
                  {
                    $response=$user->viewAccountWarning(); 
                    if($response!=false)
                    {
                      echo $response;
                    }
                  }
                  ?>
                </div>

                <div class="modal-footer">
                 
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <?php include "components/jsFiles.php" ?>

  </body>
</html>
