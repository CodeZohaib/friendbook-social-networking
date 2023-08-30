<?php

$totalFollower=$this->followCheck($userData['id'],'total');

if(empty($totalFollower))
{
  $totalFollower=0;
}
?>
<div class="col-md-3 static">
  <div class="profile-card">
  	<img src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="user" class="profile-photo" />
  	<h5><a href="<?php echo BASEURL."/timeline/profile"; ?>" class="text-white"><?php echo ucwords($userData['name']); ?></a></h5>
    <a href="#"  data-target='#follower' data-toggle='modal'  class="text-white my_follower"><i class="ion ion-android-person-add"></i> <?php echo $totalFollower; ?> Followers</a>
  </div><!--profile card ends-->
  <ul class="nav-news-feed">

     <li><i class="icon ion-ios-paper"></i><div><a href="<?php echo BASEURL."/page/notification"; ?>">
      Notification <span class="badge sidebar_count total_notification"></span></a></div>
    </li>

    <li><i class="icon ion-ios-paper"></i><div><a href="<?php echo BASEURL."/page/newsfeed"; ?>">My Newsfeed</a></div></li>
    <li><i class="icon ion-ios-people"></i><div><a href="<?php echo BASEURL."/page/newsfeedNearbyPeople"; ?>">People</a></div></li>
    <li><i class="icon ion-chatboxes"></i><div><a href="<?php echo BASEURL."/page/messages"; ?>">Messages <span class="badge sidebar_count totalMessageNotification"></span></a></div></li>
    <li><i class="icon ion-images"></i><div><a href="<?php echo BASEURL."/page/newsfeedImages"; ?>">Images</a></div></li>
    <li><i class="icon ion-ios-videocam"></i><div><a href="<?php echo BASEURL."/page/newsfeedVideos"; ?>">Videos</a></div></li>
    <li><i class="glyphicon glyphicon-music"></i><div><a href="<?php echo BASEURL."/page/newsfeedAudios"; ?>">Audios</a></div></li>
    <li><i class="icon ion-ios-people-outline"></i><div><a href="<?php echo BASEURL."/page/newsfeedFriends"; ?>">
         Friends <span class="badge sidebar_count total_friends"></span></a></div>
    </li>

    <li><i class="icon ion-ios-people-outline"></i><div><a href="<?php echo BASEURL."/page/friendRequest"; ?>">
      Friend Request <span class="badge sidebar_count total_FriendRequest"></span></a></div>
    </li>
    <li><i class="icon ion-ios-people-outline"></i><div><a href="<?php echo BASEURL."/page/blockUser"; ?>">
      Block List <span class="badge sidebar_count total_BlockUser"></a></div></li>
  </ul><!--news-feed links ends-->
  
  <div id="chat-block">
    <div class="title">Chat online</div>
    <ul class="online-users list-inline" id="onlineUsers">
      
    </ul>
  </div><!--chat block ends-->
</div>