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
		    <meta name="description" content="This is Social Networking Website Like Facebook......" />
    <meta name="keywords" content="Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
		<meta name="robots" content="index, follow" />
		<title>News Feed | Check what your friends are doing</title>

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
            <!-- Post Create Box End-->
            
          <div class="people-nearby">
              <div class="nearby-user people">
                    <center>
                    	<button class="btn btn-danger delete_all_notific" type="button">Read All Notification <span class="glyphicon glyphicon-trash"></span></button>
                    </center>
                <br>
                 <div class="error_sms"></div>
                <div class="loadAjaxData scrollbarLoadData"   style="height:1000px;overflow-y:scroll;">
                  
                </div>

              </div>
            </div>
          </div>
          <!-- Newsfeed Common Side Bar Right
          ================================================= -->
    			<?php include "components/newsfeed_sidebar_right.php"; ?>

    		</div>
    	</div>
    </div>

    <div id="post_errors"></div>

    <!--Popup-->
      <div class="modal fade modal-1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content notification_data">
            
          </div>
        </div>
      </div>
    <!--Popup End-->

     <div class="modal fade my-modal delete_post" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
              <h4 class="modal-title text-danger">Delete Post</h4>
            </div>

            <div class="modal-body  bg-info">
              <h4 class='text-info'>Are You Sure You Want to Delete Your Post.?</h4>

               <div class="text-center">
                 <button type="button" class="btn btn-success btn-sm yes_delete">Yes</button>
                 <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>
           

            <div class="modal-footer show_error_myPost">
              
            </div>
        </div>
       </div>
     </div>


     <div class="modal fade my-modal delete_comment" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
              <h4 class="modal-title" style='color:yellow;'>Delete Comment</h4>
            </div>

            <div class="modal-body  bg-warning">
              <h4 class='text-info'>Are You Sure You Want to Delete this Comment.?</h4>

               <div class="text-center">
                 <button type="button" class="btn btn-success btn-sm yes_delete_comment">Yes</button>
                 <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>
           

            <div class="modal-footer comment_del_error">
              
            </div>
        </div>
       </div>
     </div>

     <div id="notification_errors"></div>
    
    <!-- Footer
    ================================================= -->
  <?php include "components/footer.php"; ?>

  <?php include "components/jsFiles.php" ?>
   
  </body>
</html>
