<?php
$followUser=$this->followCheck($id,'check');


$totalFollower=$this->followCheck($id,'total');

if(empty($totalFollower))
{
  $totalFollower=0;
}

if(is_array($friendRequest) AND $friendRequest!=false AND $userData['account_type']!='private')
{
  if(is_array($followUser))
  {
    $btn1="Unfollow";
    $class1='btn btn-success unfollow';
  }
  else
  {

    $btn1="Follow";
    $class1='btn btn-success follow';
  }
    
  if($friendRequest['request']=='send')
  {
    $btn2='Cancle Request';
    $class2='btn btn-primary1 cancle_request_profile';
  }
  else if ($friendRequest['request']=='friend') 
  {
    
    $btn2='Unfriend';
    $class2='btn btn-danger unfriend';
  }
}
else if(is_array($friendRequest) AND $friendRequest!=false AND $userData['account_type']=='private')
{
  if(is_array($followUser))
  {
    $btn1="Unfollow";
    $class1='btn btn-success unfollow';

    if($friendRequest['request']=='send')
    {
      $btn2='Cancle Request';
      $class2='btn btn-primary1 cancle_request_profile';
    }
  }
  else
  {
    if($friendRequest['request']=='friend')
    {
      $btn1="Follow";
      $class1='btn btn-success follow';
    }
    else if($friendRequest['request']=='send')
    {
      $btn1='Cancle Request';
      $class1='btn btn-primary1 cancle_request_profile';
    }
  }

  if ($friendRequest['request']=='friend') 
  {
    
    $btn2='Unfriend';
    $class2='btn btn-danger unfriend';
  }
}
else
{
  if($id!=encryption('decrypt',$_SESSION['loginUser'][0]))
  {
    if(is_array($followUser))
    {
      $btn2='Add Friend';
      $class2='btn-primary add_friend';

      $btn1="Unfollow";
      $class1='btn btn-success unfollow';
    }
    else
    {
      $btn2='Add Friend';
      $class2='btn-primary add_friend';

      $btn1="Follow";
      $class1='btn btn-success follow';
    }
  }
  else
  {
    $btn1='my_follower';
  }
}
?>
<div class="timeline-cover" style="background: url(<?php echo BASEURL; ?>/public/assets/images/covers/<?php if($userData['bg_image']!='cover.png' AND $userData['bg_image']!=null){ echo $userData['bg_image']; }else{ echo 'cover.png'; } ?>) no-repeat;">



    <!--Timeline Menu for Large Screens-->
    <div class="timeline-nav-bar hidden-sm hidden-xs">
      <div class="row">

        <div class="col-md-3">
          <div class="profile-info">
            <img  id="profile_image" title="Change Your Profile Image to Click the Profile Image" src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" onclick="imageView(this)" class="img-responsive profile-photo" />

            <h3>
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
                $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
                if($userData['id']!=$user_id)
                {
                
              ?> 
               <button type="button" data-toggle="modal" data-target="#accountReport"  class='btn btn-danger accountReport' user_id='<?php echo $friendId[1]; ?>' onclick="reportUser(this)">Account Report</button>
               <br><br> 
               <?php } ?>  
          </div>
        </div>

        <div class="col-md-9">
          <ul class="list-inline profile-menu">
            <li><a href="<?php echo BASEURL."/timeline/friendTimeline/94039$linkId"; ?>">Timeline</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineAlbum/94039$linkId"; ?>">Album</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineVideos/94039$linkId"; ?>">Videos</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineAudios/94039$linkId"; ?>">Audios</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineFriends/94039$linkId"; ?>">Friends</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendProfile/94039$linkId"; ?>">About</a></li>
          </ul>
          <ul class="follow-me list-inline request_btn">
           
            <?php 
              if($userData['account_type']!='private' AND !is_array($friendRequest) OR $userData['account_type']=='private' AND is_array($friendRequest) AND $friendRequest['request']=='friend' OR $userData['account_type']=='public') 
              {
                ?>
                <span class="followers"></span><a href="" class='my_follower'  data-target='#follower' data-toggle='modal'>Follower <span id="totalFollower"><?php echo $totalFollower; ?></span> Pepole</a>
                <?php
              }

              if(isset($btn1) AND isset($class1) AND isset($btn2) AND isset($class2))
              {

                ?>
                <li><button class='<?php echo $class1; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn1; ?></button> &nbsp;<button class='<?php echo $class2; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn2; ?></button></li>

                 
                <?php
              }
              else
              {
                if(isset($btn1) AND $btn1=='my_follower')
                {
                ?>
                 <li><button class='btn-primary my_follower' data-target='#follower' data-toggle='modal' >My Follower</button></li>
                <?php 
                }
                else
                {
                  if(isset($btn1) AND isset($class1))
                  {
                  ?>
                  <li><button class='<?php echo $class1; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn1; ?></button></li>
                  <?php
                  }
                }
              }
            ?>
            
          </ul>
        </div>

      </div>
    </div><!--Timeline Menu for Large Screens End-->

    <!--Timeline Menu for Small Screens-->
    <div class="navbar-mobile hidden-lg hidden-md">
      <div class="profile-info">
        <img id="profile_image_sm" src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="Profile Image" class="img-responsive profile-photo" />

        <h4>
          <?php 
            echo htmlspecialchars(ucfirst($userData['name'])); 
            if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
            {
              echo " <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
            }
          ?> 
        </h4>
        <p class="text-muted"><?php echo date('M j Y g:i A', strtotime($userData['created_at'])); ?></p> 
      </div>
      <div class="mobile-menu">
        <ul class="list-inline">
         <li><a href="<?php echo BASEURL."/timeline/friendTimeline/94039$linkId"; ?>">Timeline</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineAlbum/94039$linkId"; ?>">Album</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineVideos/94039$linkId"; ?>">Videos</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendTimelineFriends/94039$linkId"; ?>">Friends</a></li>
            <li><a href="<?php echo BASEURL."/timeline/friendProfile/94039$linkId"; ?>">About</a></li>
        </ul>

        <ul class="follow-me list-inline request_btn">
           
            <?php 
              if($userData['account_type']!='private' AND !is_array($friendRequest) OR $userData['account_type']=='private' AND is_array($friendRequest) AND $friendRequest['request']=='friend' OR $userData['account_type']=='public') 
              {
                ?>
                <span class="followers"></span><a href="" class='my_follower'  data-target='#follower' data-toggle='modal'>Follower <span id="totalFollower"><?php echo $totalFollower; ?></span> Pepole</a><br><br>
                <?php
              }

              if(isset($btn1) AND isset($class1) AND isset($btn2) AND isset($class2))
              {

                ?>
                <li><button class='<?php echo $class1; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn1; ?></button> &nbsp;<button class='<?php echo $class2; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn2; ?></button></li>
                 <li> <button type="button" data-toggle="modal" data-target="#accountReport"  class='btn btn-danger accountReport' user_id='<?php echo $friendId[1]; ?>' onclick="reportUser(this)">Account Report</button></li>

                 
                <?php
              }
              else
              {
                if(isset($btn1) AND $btn1=='my_follower')
                {
                ?>
                 <li><button class='btn-primary my_follower' data-target='#follower' data-toggle='modal' >My Follower</button></li>
                <?php 
                }
                else
                {
                  if(isset($btn1) AND isset($class1))
                  {
                  ?>
                  <li><button class='<?php echo $class1; ?>' friend_request='<?php echo $friendId[1]; ?>'><?php echo $btn1; ?></button></li>
                  <?php
                  }
                }
              }
            ?>
            
          </ul>
      </div>
    </div><!--Timeline Menu for Small Screens End-->
</div>