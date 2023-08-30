<?php
$user=new timeline;
$userData=$user->getUserInfo();
$verificationHistory=$user->verificationHistory();

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
        <?php include "components/profile-header.php"; ?>

        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <!-- About
              ================================================= -->
              <div class="about-profile">
                <?php
                  if ($userData['bio']==null)
                  {
                    $info='Add Your Personal Information......!';
                    $info_btn="Add Info";
                  }
                  else
                  {
                    $info=$userData['bio'];
                    $info_btn="Edit Info";
                  }
                ?>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-information-outline icon-in-title"></i>Personal Information</h4>
                  <div class='info_message'>

                      <?php echo htmlspecialchars($info);  ?>

                      <br><br><button type='button' data-target='.persional_info' data-toggle='modal' class='btn btn-success btn-xs profile_update' style='float:right;' Pass_value='persional_information'><?php echo $info_btn; ?></button><br>

                  </div><br>
                </div>


                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-briefcase-outline icon-in-title"></i>Work</h4>
                  <div class="organization">
                    <span class="pull-left img-org ion-ios-briefcase-outline"></span>
                    <div class="work-info">
                      
                      <div class='info_message'>
                         <?php 
                          if ($userData['work']==null)
                          {
                            $work_btn="Add Work";
                          }
                          else
                          {
                            $work_btn="Edit Work";
                          }

                          if ($userData['work']!=null) 
                          {
                            echo "<h5>".htmlspecialchars($userData['work'])."</h5>";
                          }
                          else
                          {
                            echo "<h5>Add Work</h5>";
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

                         <br><button type='button' data-toggle='modal' data-target='.work_info' class='btn btn-success btn-xs profile_update' style='float:right;' Pass_value='add_work'><?php echo $work_btn; ?></button><br>

                      </div><br>
                    </div>
                  </div>
                </div>

                 <div class="about-content-block">
                    <?php
                      if ($userData['language']!=null) 
                      {
                        $language_btn="Edit Languages";
                      }
                      else
                      {
                        $language_btn="Add Languages";
                      }
                    ?>
                    
                    <h4 class="grey"><i class="ion-ios-chatbubble-outline icon-in-title"></i>Languages</h4>
                      <ul>
                        <?php 
                         if ($userData['language']!=null) 
                         {
                           echo "<li>".htmlspecialchars($userData['language'])."</li>";
                         }
                         else
                         {
                          echo "<li>Add Languages....!</li>";
                         }
                        ?>
                        
                      </ul>
                      <br><button type='button' data-toggle='modal' data-target='.add_language' class='btn btn-success btn-xs profile_update' style='float:right;' Pass_value='add_work'><?php echo $language_btn; ?></button><br><br>
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
                  <button type='button' data-toggle='modal' data-target='.update_country' class='btn btn-success btn-xs profile_update' style='float:right;'>Update Country</button><br><br>
                </div>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-location-outline icon-in-title"></i>Address</h4>
                  <?php
                    if ($userData['address']!=null)
                    {
                      $address_btn="Edit Address";
                    }
                    else
                    {
                      $address_btn="Add Address";
                    }


                   if ($userData['address']!=null) 
                   {
                     echo "<p>".htmlspecialchars(ucfirst($userData['address']))."</p>";
                   }
                   else
                   {
                    echo "<p>Add Your Address......!</p>";
                   }
                  ?>

                  
                  <button type='button' data-toggle='modal' data-target='.address_info' class='btn btn-success btn-xs profile_update' style='float:right;'><?php echo $address_btn; ?></button>
                  <br><br>
                </div>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-email-outline icon-in-title"></i>Email</h4>
                  <p><?php echo htmlspecialchars($userData['email']); ?></p>

                 <button type='button' data-toggle='modal' data-target='.update_email' class='btn btn-success btn-xs' style='float:right;'>Update Email</button> <br><br>
                  <form class="change_data" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="Post" style='float:right;'>
                   <select class="form-control" name="email_type" title="Email Showing Type" >
                    <?php
                     if ($userData['email_type']=='public') {
                       echo '<option value="public">Public</option>';
                       echo '<option value="private">Private</option>';
                     }
                     else if ($userData['email_type']=='private') {
                       echo '<option value="private">Private</option>';
                       echo '<option value="public">Public</option>';
                     }
                    ?>
                  </select>
                  </form>

                  <br><br>
                </div>

                 <div class="about-content-block">
                  
                  <h4 class="grey"><i class="ion-ios-chatbubble-outline icon-in-title"></i>Change Password</h4>
                    <br><button type='button' data-toggle='modal' data-target='.change_password' class='btn btn-success btn-xs' style='float:right;'>Change Password</button><br><br>
                </div>

                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-person-outline icon-in-title"></i>Account</h4>
                  <p><?php echo ucfirst($userData['account_type']); ?></p>

                  <form class="change_data" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="Post" style='float:right;'>
                   <select class="form-control" name="account_type" title="Account Showing Type" >
                    <?php
                     if ($userData['account_type']=='public') {
                       echo '<option value="public">Public</option>';
                       echo '<option value="private">Private</option>';
                     }
                     else if ($userData['account_type']=='private') {
                       echo '<option value="private">Private</option>';
                       echo '<option value="public">Public</option>';
                     }
                    ?>
                  </select>
                  </form>
                  <br><br>
                </div>


                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-person-outline icon-in-title"></i>Account Verification</h4>
                  <?php
                   if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                  {
                    echo "<br><b><center class='text-primary'>Verified Account <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span></center></b><br><br><button type='button' data-toggle='modal' data-target='#verificationHistory'  class='btn btn-danger btn-xs' style='float:right;'>Verification History</button>";
                  }
                  else
                  {
                    if(is_array($verificationHistory))
                    {
                      if($verificationHistory[0]['verification_status']=='pending' AND empty($verificationHistory[0]['admin_reply']))
                      {
                        echo "<center><b>Verification is Submitted to Admin Please Wait for reply.....!</b><br><br>
                        <button type='button' data-toggle='modal' data-target='#verificationHistory'  class='btn btn-danger btn-xs'>Verification History</button>
                        </center>";
                      }
                      else if($verificationHistory[0]['verification_status']=='reject')
                      {
                        echo "<p>Request a verified badge</p>
                                 <button type='button' data-toggle='modal' data-target='#accountVerification'  class='btn btn-success btn-xs' style='float:right;'>Verification</button><br><br><button type='button' data-toggle='modal' data-target='#verificationHistory'  class='btn btn-danger btn-xs' style='float:right;'>Verification History</button>";
                      }
                      else if($verificationHistory[0]['verification_status']=='verify')
                      {
                        echo "<br><b><center class='text-primary'>Verified Account <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span></center></b><br><br><button type='button' data-toggle='modal' data-target='#verificationHistory'  class='btn btn-danger btn-xs' style='float:right;'>Verification History</button>";
                      }
                    }
                    else
                    {

                  ?>
                   <p>Request a verified badge</p>
                   <button type="button" data-toggle="modal" data-target="#accountVerification"  class='btn btn-success btn-xs' style='float:right;'>Verification</button>
                  <?php }} ?>
                  <br><br>
                </div>



              </div>
            </div><br>

            <div class="col-md-3 static">
               <?php include "components/userActivity.php"; ?>
            </div>

            
          </div>
        </div>
      </div>
    </div>

    <!--Persional Information Add Popup-->
    <div class="modal fade  persional_info" tabindex="-1" role="dialog" aria-hidden="true">
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
                      <input type="text" name="work_experiences" class="form-control emoji" placeholder="Enter Your Work Experiences.....!" maxlength="60" pattren="[A-Za-z0-9]{60}" value="<?php if($userData['work_experiences']!=null){ echo $userData['work_experiences']; } ?>">
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

    <!--Country Add Popup-->
    <div class="modal fade update_country" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">
                    Edit Your Country And State
                  </h4>

                </div>

                <div class="modal-body">
                  <form class="form" action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post">

                    <div class="form-group">
                     <select id="country" name ="country" class="form-control"></select><br>
                      <select id="state" name ="state" class="form-control">
                        <option value="">Select State</option>
                        <option value="">Please Select First Country</option>
                      </select>
                    </div>
                     

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <input type="submit" name="submit" value="Update" style="float:right;" class="btn btn-success"><br>
                    </form><br>
                </div>

                <div class="modal-footer">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div><!--Country Add Popup End-->

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
                <label for="old Password">Old Password</label>
                <input type="password" name="old_password" class="form-control" placeholder="Enter Your Old Password......!" required>
              </div>

              <div class="form-group">
                <label for="New Password">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter Your New Password......!" required>
              </div>

              <div class="form-group">
                <label for="Confirm Password">Confirm Password</label>
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

  <!--/Update Email box-->
     <div class="modal fade update_email" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <br>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
            <h4 class="modal-title">Update Email</h4>
          </div>

          <div class="modal-body bg-warning">
            <form action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post" class="form">

              <div class="form-group">
                <label for="New Email">New Email</label>
                <input type="email" name="new_email" id="new_email" class="form-control" placeholder="Enter Your New Email......!" required>
              </div>

              <div class="form-group">
                <label for="confirmation code">Confirmation Code</label>
                <div class="input-group">
                  <input type="text" name="code" class="form-control" placeholder="Enter Your Confirmation Code......!" required>
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" id="newEmail">Send Code</button>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Your Password......!" required>
              </div>
              
              <button type="submit" class="btn btn-success" >Update Email</button>
            </form><br>
          </div>

          <div class="modal-footer msg_display">
            
          </div>
        </div>
      </div>
     </div>
    
    <!--/Update Email box-->

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
     <script type="text/javascript">
        populateCountries("country", "state");
    </script>
  </body>
</html>
