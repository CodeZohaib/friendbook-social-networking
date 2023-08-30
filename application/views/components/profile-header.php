<?php 
$totalFollower=$this->followCheck($userData['id'],'total');
$accountWarning=$user->viewAccountWarning('total');

if(empty($totalFollower))
{
  $totalFollower=0;
}
?>
<div class="timeline-cover" style="background: url(<?php echo BASEURL; ?>/public/assets/images/covers/<?php if($userData['bg_image']!='cover.png' AND $userData['bg_image']!=null){ echo $userData['bg_image']; }else{ echo 'cover.png'; } ?>) no-repeat;">

  <form class="change_cover_image" method="post" action="<?php echo BASEURL."/users/userUpdate"; ?>" enctype="multipart/form-data">
      <div class="form-group" id="change_image_cover">
        <label class="custom-file-upload">
             <input type="file" name="cover_image" class="form-control">
             <span class="glyphicon glyphicon-camera"></span> <b>
              <?php 

              if($userData['bg_image']=='cover.png' OR $userData['bg_image']==null)
              { 
                echo 'Add Cover Picture'; 
              }
              else
              {
                echo 'Update Cover Picture'; 
              } 
              ?></b>
         </label>

          <?php 
            if($userData['bg_image']!='cover.png' AND $userData['bg_image']!=null)
            { 
          ?>
          <label class="custom-file-upload delete_cover_pic" style="float:right">
            <span class="glyphicon glyphicon-camera"></span> <b>Delete Cover Picture</b>
          </label>
          <?php   
              }
          ?>
      </div>
  </form>

    <!--Timeline Menu for Large Screens-->
    <div class="timeline-nav-bar hidden-sm hidden-xs">
      <div class="row">

        <div class="col-md-3">
          <div class="profile-info">
            <img  id="profile_image" title="Change Your Profile Image to Click the Profile Image" src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="" class="img-responsive profile-photo" />


            <div style="display: none;">
              <form class="change_profile_image" method="post" action="<?php echo BASEURL; ?>/users/userUpdate" enctype="multipart/form-data">

                <input type="file"  name="profile_image" id="profile_image_upload" class="form-control change_profile_image"> 

             </form>
            </div>
            

            <h3>
              <button type='button' data-toggle='modal' data-target='.edit_name' class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit" style="font-size:20px"></i></button>
              <?php 
                   echo htmlspecialchars(ucwords($userData['name']));  
                  if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                  {
                    echo " <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
                  }
              ?> 
              
              
            </h3>

            <p class="text-muted" title='Account Created Date & Time'><?php echo date('M j Y g:i A', strtotime($userData['created_at'])); ?></p>

            <?php 
              if($userData['image']!='profile.jpg')
              {
                echo '<button class="btn btn-success btn-xs delete_profile_pic">Delete Profile Picture</button>';
              }
            ?>
            <br>
            <div>
              <b>Active Status </b>
              <form class="change_data" method="post" action="<?php echo BASEURL."/users/userUpdate"; ?>" enctype="multipart/form-data">
               <div class="btn-group" id="status" data-toggle="buttons">
                <label class="btn btn-default btn-on btn-xs <?php if($userData['online_status']==='true'){echo 'active';} ?>">
                <input type="radio" value="true" name="activeStatus">ON</label>
                <label class="btn btn-default btn-off btn-xs <?php if($userData['online_status']==='false'){echo 'active';} ?>">
                <input type="radio" value="false" name="activeStatus">OFF</label>
               </div>
             </form>
            </div>

            <?php 
              if($accountWarning>0)
              {
                echo "<div style='margin-top:4px'><p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#' class='close' data-dismiss='alert' style='color:black'>&times;</a>Account Warning ".$accountWarning."/3<br><a href='' data-target='.accountWarning' data-toggle='modal' >View Detail</a></p></div>";
              }
            ?>
            
          </div>

        </div>

        <div class="col-md-9">
          <ul class="list-inline profile-menu">
            <li><a href="<?php echo BASEURL."/timeline/viewTimeline"; ?>">Timeline</a></li>
            <li><a href="<?php echo BASEURL."/timeline/timelineAlbum"; ?>">Album</a></li>
            <li><a href="<?php echo BASEURL."/timeline/timelineVideos"; ?>">Videos</a></li>
            <li><a href="<?php echo BASEURL."/timeline/timelineAudios"; ?>">Audios</a></li>
            <li><a href="<?php echo BASEURL."/timeline/timelineFriend"; ?>">Friends</a></li>
            <li><a href="<?php echo BASEURL."/timeline/profile"; ?>">About</a></li>
          </ul>
          <ul class="follow-me list-inline request_btn">
            <li><span class="followers"></span> Followed By <?php echo $totalFollower; ?> People</li>
            <li><button class='btn-primary my_follower' data-target='#follower' data-toggle='modal' >My Follower</button></li>
          </ul>
        </div>

      </div>
    </div><!--Timeline Menu for Large Screens End-->

    <!--Timeline Menu for Small Screens-->
    <div class="navbar-mobile hidden-lg hidden-md">
      <div class="profile-info">
        <img id="profile_image_sm" src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="Profile Image" class="img-responsive profile-photo" />

          <div style="display: none;">
                <form class="change_profile_image_sm" method="post" action="<?php echo BASEURL; ?>/users/userUpdate" enctype="multipart/form-data">

                  <input type="file"  name="profile_image" id="profile_image_upload_sm" class="form-control change_profile_image_sm">
                    
               </form>
          </div>
        <h4>
          <button type='button' data-toggle='modal' data-target='.edit_name' class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit" style="font-size:20px"></i></button>
          <?php 
            echo $userData['name']; 
            if($userData['bluetick']=='yes')
            {
              echo " <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
            }
          ?> 
        </h4>
        <p class="text-muted"><?php echo date('M j Y g:i A', strtotime($userData['created_at'])); ?></p>

      </div>

      <div class="mobile-menu" >
        <ul class="list-inline">
         <li><a href="<?php echo BASEURL."/timeline/viewTimeline"; ?>">Timeline</a></li>
         <li><a href="<?php echo BASEURL."/timeline/timelineAlbum"; ?>">Album</a></li>
         <li><a href="<?php echo BASEURL."/timeline/timelineVideos"; ?>">Videos</a></li>
         <li><a href="<?php echo BASEURL."/timeline/timelineAudios"; ?>">Audios</a></li>
         <li><a href="<?php echo BASEURL."/timeline/timelineFriend"; ?>">Friends</a></li>
         <li><a href="<?php echo BASEURL."/timeline/profile"; ?>">About</a></li>
        </ul>
         <ul class="follow-me list-inline request_btn">
            <li><span class="followers"></span> Followed By <?php echo $totalFollower; ?> People</li><br>
            <li><button class='btn-primary my_follower' data-target='#follower' data-toggle='modal' >My Follower</button></li>
          </ul>
       
        <?php 
              if($userData['image']!='profile.jpg')
              {
                echo "<br><button class='btn btn-success btn-xs delete_profile_pic'>Delete Profile Picture</button>";
              }
            ?>
        
      </div>

     <div>
     <b>Active Status </b>
      <form class="change_data" method="post" action="<?php echo BASEURL."/users/userUpdate"; ?>" enctype="multipart/form-data">
       <div class="btn-group" id="status" data-toggle="buttons">
        <label class="btn btn-default btn-on btn-xs <?php if($userData['online_status']==='true'){echo 'active';} ?>">
        <input type="radio" value="true" name="activeStatus">ON</label>
        <label class="btn btn-default btn-off btn-xs <?php if($userData['online_status']==='false'){echo 'active';} ?>">
        <input type="radio" value="false" name="activeStatus">OFF</label>
       </div>
     </form>
    </div>
  </div><!--Timeline Menu for Small Screens End-->
</div>