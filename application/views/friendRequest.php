<?php
$user=new page;
$userData=$user->getUserInfo();
$allusers=$user->getUserInfo('allUsers');
$friendRequest=$user->getUserFriendRequest();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="This is social network html5 template available in themeforest......" />
		<meta name="keywords" content="Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
		<meta name="robots" content="index, follow" />
		<title>Nearby People | Find Local People</title>

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

            <?php 
              if($friendRequest!=false)
              {
                foreach ($friendRequest as $key => $value) 
                {
                  $user_id=encryption('encrypt',$value['user_id']);
                  ?>
                    <div class="people-nearby">
                      <div class="nearby-user friend_requests" style="border: none;">
                        <div class='row user'>
                          <div class='col-md-2 col-sm-2'>
                            <a href='<?php echo BASEURL."/timeline/friendProfile/94039$user_id"; ?>' class='profile-link'><img src="<?php  echo BASEURL.'/public/assets/images/users/'.$value['image']; ?>" alt='user' class='profile-photo-lg' /></a>
                          </div>
                          <div class='col-md-7 col-sm-7'>
                            <h5>
                              <a href='<?php echo BASEURL."/timeline/friendProfile/94039$user_id"; ?>' class='profile-link'><?php echo htmlspecialchars(ucfirst($value['name'])); ?> 
                              </a>
                              <?php 
                              if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                              {
                                echo " <span class='glyphicon glyphicon-ok-sign text-green' title='Admin'></span></a>";
                              }
                              ?>
                              
                            </h5>
                            <p class='text-muted' title='User Account Created Date & Time'>
                              <?php echo formatDate($value['date_time']); ?> </p>

                             <div class="flag-wrapper" style="width:10%">
                               <div title="<?php echo strtoupper($value['country']); ?>" class="img-thumbnail flag flag-icon-background flag-icon-<?php echo strtolower(countryName_to_code($value['country'])); ?>"></div>
                            </div>

                          </div>
                          <div class='col-md-3 col-sm-3 request_btn'>
                            <button class='btn btn-success pull-right accept_request' friend_request='<?php echo $user_id; ?>'>Accept Request</button><br><br><br>

                            <button class='btn btn-warning pull-right cancle_request' friend_request='<?php echo $user_id; ?>'>Cancle Request</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                }
              }
              else
              {
                ?>
                <p class="alert alert-danger text-center alert-dismissable" style="color:black"><a href="#" '="" class="close" data-dismiss="alert" style="color:black">×</a>Friend Request is Empty...!</p>
                <?php
              }
            ?>
          </div>

          <!-- Newsfeed Common Side Bar Right
          ================================================= -->
    			<?php include "components/newsfeed_sidebar_right.php"; ?>

    		</div>
    	</div>
    </div>

    <div id="request_errors"></div>

    <!-- Footer
    ================================================= -->
    <?php include "components/footer.php"; ?>

    <?php include "components/jsFiles.php" ?>
    
  </body>
</html>
