<?php
$user=new page;
$allusers=$user->getUserInfo('allUsers');
$userData=$user->getUserInfo();
$allFriends=$user->displayBlockUser();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="This is social network html5 template available in themeforest......" />
		<meta name="keywords" content="Social Network, Social Media, Make Friends, Newsfeed, Profile Page" />
		<meta name="robots" content="index, follow" />
		<title>Nearby People | Block List</title>

    <!-- Stylesheets
    ================================================= -->
	   <?php include "components/cssFiles.php"; ?>
      
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

          <div class="people-nearby">
            <div class="nearby-user people">
              <div class="row">
                
                <div class="col-md-6 col-sm-6">
                 <form action="<?php echo BASEURL."/friendRequest/findBlockUser"; ?>" method="Post" class="search_user_update" accept-charset="utf-8">
                    <div class='input-group'>
                        <input type='text' class='form-control' name='user_search' placeholder='Search User Name' style='border-radius:3px; text-align:center;'>

                        <span class='input-group-btn'>
                          <button class='btn btn-primary' style="padding:7px" type='submit'><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>

                    </div>
                  </form><br><br>
                </div> 

                  <div class="col-md-6 ">
                      <div class="col-xs-8">
                          <div class="form-group">
                              <select name="bulk-options" class="form-control select_option">
                                  <option value="block">Block</option>
                                  <option value="unblock">UnBlock</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-xs-4">
                          <input type="submit" name="submit" class="btn btn-success block_apply" value="Apply">
                          &nbsp;&nbsp;&nbsp;
                      </div>
                  </div>

            

              </div><br><br><br>

                <div id="msg_error"></div><br>
                <div id="friend_update">
                  <?php
                 if(is_array($allFriends))
                 {
                   foreach ($allFriends as $key1 => $value1) 
                   {
                     unset($value1['password']);
                     unset($value1['verification_code']);
                    foreach ($value1 as $key2 => $value2) 
                    {
                      
                      if(encryption('decrypt',$value2)==false)
                      {
                        $data[$key1][$key2]=$value2;
                      }
                      else
                      {
                         $data[$key1][$key2]=encryption('decrypt',$value2);
                      }
                    }  
                    $users_id=encryption('encrypt',$data[$key1]['send_user_id']);    
                  ?>
                    <div class='row'>
                      <div class='col-md-2 col-sm-2'>
                        <img src='<?php echo BASEURL."/public/assets/images/users/".$data[$key1]['image']; ?>' alt='user' class='profile-photo-lg' />
                      </div>
                      <div class='col-md-7 col-sm-7'>
                        <h5><b><?php echo htmlspecialchars(ucwords($data[$key1]['name'])); ?></b></h5>

                        <p class='text-muted' title='User Account Block Date & Time'><?php echo date('M j Y g:i A', strtotime($data[$key1]['date_time'])); ?></p>
                        
                         <p style='font-size:20px;'>
                           <span title='Country Flag <?php echo $data[$key1]['country']; ?>' class='flag-icon flag-icon-<?php echo strtolower(countryName_to_code($data[$key1]['country'])); ?>' style='border:1px solid black'></span>
                         </p> 
                      </div>
                      <div class='col-md-3 col-sm-3'>
                         <input type='checkbox' class='checkboxes form-control user_checkboxes' name='checkboxes[]' value='<?php echo $users_id; ?>' >
                      </div>
                    </div><br><br>
                    <?php
                    }
                  }
                  else
                  {
                    echo '<br><br><div class="alert alert-danger alert-dismissable text-center">
                           <a href="#" class="close" data-dismiss="alert">×</a>
                         <p>No user block.....!</p></div>';
                  }
                  ?>
                  </div>

              </div><br><br>
             
            </div>
          </div>

          <!-- Newsfeed Common Side Bar Right
          ================================================= -->
    			<?php include "components/newsfeed_sidebar_right.php"; ?>

    		</div>
    	</div>
    </div>

    <div id="request_errors"></div>

      
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <?php include "components/jsFiles.php" ?>
    
  </body>
</html>
