<?php
$user=new page;
$allusers=$user->getUserInfo('allUsers');
$userData=$user->getUserInfo();
$friendID=$user->getMessageListFirst();
if($friendID!=false)
{
  $friendId=encryption('encrypt',$friendID);
  $friendData=$user->getUserInfo('id',encryption('decrypt',$friendId));
}
else
{
  $friendId='empty';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="FriendBook, Social Media, Make Friends, Newsfeed, Profile Page, FriendBook" />
    <meta name="robots" content="index, follow" />
    <title>Messages | Friends Chat</title>

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

            <!-- Chat Room
            ================================================= -->
            <div class="chat-room">
              <div  class="row">
                <?php 
                  if($friendId=='empty')
                   {
                    echo "<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>Zero Friends........!</p>";
                   }
                 ?>
                <div class="col-md-6">
                  
                  
                  

                  <!-- Contact List in Left-->
                  <ul class="nav nav-tabs contact-list scrollbar-wrapper scrollbar-outer display_user_sms_bar" style="height:500px;overflow-y:scroll;">
                   
                  </ul><!--Contact List in Left End-->

                </div>

                <div class="col-md-6 chatSystem">

                  <!--Chat Messages in Right-->
                  <div class="tab-content scrollbar-wrapper wrapper scrollbar-outer send_sms_user" style="overflow-y:scroll;">

                  </div><!--Chat Messages in Right End-->
                      <?php 
                      if(isset($friendId) AND $friendId!='empty')
                      {
                    ?>
                  <div class='send-message'> 
                    <center>
                      <b style="color:blue;display:none;" class="friendTyping">
                      <?php 
                        if(is_array(($friendData)))
                        {
                          echo ucfirst($friendData['name']);
                        }
                      ?>
                    </b> <b style="color:blue" class="smsTyping"></b></center><br>

                
                    <form action="<?php echo BASEURL; ?>/messages/insertMessage" method="POST" accept-charset="utf-8" enctype="multipart/form-data" class="insert_sms"> 

                      <div class='input-group chatBox_user'>
                        <input type='text' class='form-control comment_input' id="chatBox_user" name='text' placeholder='Type your message'>

                        <input type="hidden" value="<?php if(isset($friendId) AND $friendId!='empty'){echo $friendId;}else{echo 'zeroFriend';} ?>" name='user_id' id='user_id'>

                        <input type="file" name="files" id="select_image_videos" style='display: none;'>

                        <span class='input-group-btn'>
                          <button class='btn btn-default' type='submit' id="sent_sms">Send</button>
                        </span>
                      </div><br>

                      <center>
                        <p>
                          <button type="button" title='Send Videos Audio And Images'>
                            <a href='' class="select_image_videos" style='color:white;text-decoration: none;'><i class='ion-images'></i>&nbsp;&nbsp;Send Files</i></a>
                          </button>&nbsp;&nbsp;

                        </p>

                        <span id="showName"></span>
                      </center><br>

                      <div class="error_sms"></div>
                    </form>


                      <div class="form-group">
                        <div class="progress-bar-wrapper">
                          <span class="progress-bar progress-bar-chat progress-bar-primary"><span class="percentage percentageChat"></span></span>
                        </div>
                      </div>

                  
                  </div><br>
                  <?php }?>
                </div>
                <div class="clearfix"></div>
              </div>
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
