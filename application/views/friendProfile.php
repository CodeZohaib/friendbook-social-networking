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
    if($userData==false)
    {
      header("location:".BASEURL."/timeline/profile?wrong_user");
    }
    else
    {

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
  }
  else
  {
     header("location:".BASEURL."/timeline/profile?wrong_user");
  }
}
else
{
   header("location:".BASEURL."/timeline/profile?wrong_user");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>About Me | Learn Detail About Me</title>

   <?php include "components/cssFiles.php" ?>
	</head>
  <body>

    <!-- Header
    ================================================= -->
    <?php include "components/navbar.php"; ?>
    <!--Header End-->
    <div class="container">

      <!-- Timeline
      ================================================= -->
      <div class="timeline">
        <?php include "components/friend-profile-header.php"; ?>

        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <?php 
                  $account=null;
                  if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
                  {
                    echo "<br><div class='about-content-block'>
                      <center><h1>Private Account</h1></center>
                      </div>
                    ";
                    $account='private';
                  }
                  else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
                  {
                     echo "<div class='about-content-block'>
                      <center><h1>Private Account</h1></center>
                      </div>
                    ";
                    $account='private';
                  }
                ?>

              <?php if($account==null AND $account!='private'){ ?>
              <!-- About
              ================================================= -->
              <div class="about-profile">
                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-information-outline icon-in-title"></i>Personal Information</h4>
                  <div class='info_message'>

                     <?php
                        if ($userData['bio']!=null)
                        {
                          echo htmlspecialchars($userData['bio']);
                        }
                      ?>
                  </div><br>
                </div>


                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-briefcase-outline icon-in-title"></i>Work</h4>
                  <div class="organization">
                    <span class="pull-left img-org ion-ios-briefcase-outline"></span>
                    <div class="work-info">
                      
                      <div class='info_message'>
                         <?php 
                          if ($userData['work']!=null) 
                          {
                            echo "<h5>".htmlspecialchars($userData['work'])."</h5>";
                          }
                          

                          if ($userData['work_experiences']!=null) 
                          {
                             echo "<p><b>Experiences -</b> <span class='text-grey'>".htmlspecialchars($userData['work_experiences'])."</span></p>";
                          }
                          else
                          {
                            echo "<p><b>Experiences -</b> <span class='text-grey'></span></p>";
                          }

                         ?>

                      </div><br>
                    </div>
                  </div>
                </div>

                 <div class="about-content-block">
                    <h4 class="grey"><i class="ion-ios-chatbubble-outline icon-in-title"></i>Languages</h4>
                      <ul>
                        <?php 
                         if ($userData['language']!=null) 
                         {
                           echo "<li>".htmlspecialchars($userData['language'])."</li>";
                         }
                         
                        ?>
                        
                      </ul>
                      
                </div>

                  <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-flag-outline icon-in-title"></i>Country</h4><br>
                  
                   <div class="row" style="margin-left:20px">
                      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">

                      <div class="flag-wrapper">
                         <div title="<?php echo strtoupper($userData['country']); ?>" class="img-thumbnail flag flag-icon-background flag-icon-<?php echo strtolower(countryName_to_code($userData['country'])); ?>"></div>
                      </div>

                    </div><br>
                    <p><b>State :- </b> <span class='text-grey'><?php echo $userData['state']; ?></span></p>
                    
                  </div>
                </div>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-location-outline icon-in-title"></i>Address</h4>
                  <?php
                   if ($userData['address']!=null) 
                   {
                     echo "<p>".htmlspecialchars(ucfirst($userData['address']))."</p>";
                   }
                  ?>

                  
                  
                  <br><br>
                </div>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-email-outline icon-in-title"></i>Email</h4>
                  <?php 
                    if($userData['email_type']=='public')
                    {
                      echo "<p>".htmlspecialchars($userData['email'])."</p>";
                    }
                    else
                    {
                      echo "<p>Private</p>";
                    }
                  ?>
                </div>

                 <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-person-outline icon-in-title"></i>Account Verification</h4>
                  <?php
                   if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                  {
                    echo "<br><b><center class='text-primary'>Verified Account <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span></center></b>";
                  }
                  else
                  {
                  ?>
                   <b><center class='text-danger'>Account Not Verified</center></b>
                  <?php } ?>
                  <br><br>
                </div>

              </div>
            </div><br>

            <div class="col-md-2 static">
               <?php include "components/userActivity.php"; ?>
            </div>

          <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>

    <!--Persional Information Add Popup-->
    <div class="modal fade persional_info" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success"><?php if ($userData['bio']==null){echo 'Add Your Persional Information';}else{ echo 'Edit Your Persional Information';} ?></h4>
                </div>

                <div class="modal-body">
                  <form class="form" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post">

                     <textarea class="textarea" name="bio" rows="5" col="10" placeholder="Enter Your Personal Information.......!" pattren="[A-Za-z]{550}" maxlength="550" ><?php echo @$userData['bio'] ?></textarea><br><br>

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <input type="submit" name="submit" value="<?php if ($userData['bio']==null){echo 'Add Info';}else{ echo 'Update Info';} ?>" style="float:right;" class="btn btn-success"><br>
                    </form><br>
                </div>

                <div class="modal-footer server_message">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div><!--Persional Information Add Popup End-->

    <!--Work Add Popup-->
    <div class="modal fade work_info" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">
                    <?php if ($userData['work']==null){echo 'Add Your Work';}else{ echo 'Edit Your Work';} ?>
                  </h4>

                </div>

                <div class="modal-body">
                  <form class="form" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post">

                    <div class="form-group">
                      <label for="work">Work</label>
                      <input type="text" name="work" class="form-control" placeholder="Enter Your Work.....!" pattren="[A-Za-z0-9]{60}" value="<?php if($userData['work']!=null){ echo $userData['work'];} ?>" maxlength="60">
                    </div>

                    <div class="form-group">
                      <label for="work">Work Experiences</label>
                      <input type="text" name="work_experiences" class="form-control" placeholder="Enter Your Work Experiences.....!" maxlength="60" pattren="[A-Za-z0-9]{60}" value="<?php if($userData['work_experiences']!=null){ echo $userData['work_experiences']; } ?>">
                    </div>
                     

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <input type="submit" name="submit" value="<?php if($userData['work_experiences']!=null){ echo 'Update Work'; }else{ echo 'Add Work'; }?>" style="float:right;" class="btn btn-success"><br>
                    </form><br>
                </div>

                <div class="modal-footer server_message">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div><!--Work Add Popup End-->

    <!--Add User Address Popup-->
    <div class="modal fade address_info" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success"><?php if ($userData['address']==null){echo 'Add Your Address';}else{ echo 'Edit Your Address';} ?></h4>
                </div>

                <div class="modal-body">
                  <form class="form" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post">

                      <textarea class="textarea" name="address" rows="5" col="10" placeholder="Enter Your Address.......!" maxlength="80" ><?php echo $userData['address']; ?></textarea><br>

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <input type="submit" name="submit" value="<?php if ($userData['address']==null){echo 'Add Address';}else{ echo 'Update Address';} ?>" style="float:right;" class="btn btn-success" ><br>
                    </form><br>
                </div>

                <div class="modal-footer server_message">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Add User Address Popup Close-->

    <!--language Add Popup-->
    <div class="modal fade add_language" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">
                    <?php if ($userData['language']==null){echo 'Add Your Languages';}else{ echo 'Edit Your Languages';} ?>
                  </h4>

                </div>

                <div class="modal-body">
                  <form class="form" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post">

                    <div class="form-group">
                      <label for="language">Languages</label>
                      <input type="text" name="language" class="form-control" placeholder="Enter Your Languages.....!" pattren="[A-Za-z0-9]{60}" value="<?php if($userData['language']!=null){ echo $userData['language'];} ?>">
                    </div>
                     

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <input type="submit" name="submit" value="<?php if($userData['language']!=null){ echo "Update Language";}else{ echo "Add Language";} ?>" style="float:right;" class="btn btn-success"><br>
                    </form><br>
                </div>

                <div class="modal-footer">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div><!--language Add Popup End-->

    <!--Change Password box-->
     <div class="modal fade change_password" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <br>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
            <h4 class="modal-title">Change Your Password</h4>
          </div>

          <div class="modal-body bg-warning">

            <form action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post" class="form">
              <div class="form-group">
                <label for="email">Old Password</label>
                <input type="password" name="old_password" class="form-control" placeholder="Enter Your Old Password......!" required>
              </div>

              <div class="form-group">
                <label for="email">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter Your New Password......!" required>
              </div>

              <div class="form-group">
                <label for="email">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Enter Again New Password......!" required>
              </div>

              <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
          </div>

          <div class="modal-footer">
            
          </div>
        </div>
      </div>
     </div>
    <!--/Change Password box-->


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

