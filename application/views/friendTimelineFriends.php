<?php
$linkId=null;

$friendId=explode('94039',$_SERVER['REQUEST_URI']);
if(is_array($friendId) AND isset($friendId[1]))
{
  $id=encryption('decrypt', $friendId[1]);
  if($id!=false)
  {
    $linkId=$friendId[1];
    $user=new timeline;
    $userData=$user->getUserInfo('id',$id);
    $friendRequest=$user->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');
    $myData=$user->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
    if(is_array($friendRequest))
    {
      if($friendRequest['request']=='blockUser')
      {
        header("location:".BASEURL."/timeline/profile?block");
      }
      else if($friendRequest['request']=='block')
      {
        header("location:".BASEURL."/timeline/profile?user_block");
      }
    }
  }
  else
  {
     header("location:".BASEURL."/timeline/profile");
  }
}
else
{
   header("location:".BASEURL."/timeline/profile");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Friend Timeline Friends" />
    <meta name="keywords" content="Friend book, Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
    <meta name="robots" content="index, follow" />
    <title>My Timeline | Friends</title>

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
        <?php include "components/friend-profile-header.php"; ?>

        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-7">
              <div class="friend-list">
                <?php
                $account=null;
                if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
                {
                  echo "<div class='about-content-block'>
                    <center><h1>Private Account</h1></center>
                    </div><br><br>
                  ";
                  $account='private';
                }
                else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
                {
                   echo "<div class='about-content-block'>
                    <center><h1>Private Account</h1></center>
                    </div><br><br>
                  ";
                  $account='private';
                }

                if($account==null AND $account!='private')
                {
                  
               ?>
                <div class="row loadAjaxData">


                </div>
                <div class="error_sms"></div>
              </div>
            </div>

            <div class="col-md-2 static">
               <?php include "components/userActivity.php"; ?>
            </div>

          <?php } ?>

          </div>
        </div>
      </div>
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