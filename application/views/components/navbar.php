<?php
 if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
 {
  $userData2=$user->getUserInfo();

?>
<header id="header" class="lazy-load">
  <nav class="navbar navbar-default navbar-fixed-top menu">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html" style="font-size:30px">FriendBook</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right main-menu">

          <li class="dropdown"><a href="<?php echo BASEURL."/page/newsfeed"; ?>"><?php echo ucfirst($userData2['name']); ?>'s  Home</a></li>

          <li class="dropdown"><a href="<?php echo BASEURL."/page/notification"; ?>">Notification&nbsp;<span class="badge sidebar_count total_notification" ></span></a></li>
          <li class="dropdown"><a href="<?php echo BASEURL."/page/messages"; ?>">Messages&nbsp;<span class="badge sidebar_count totalMessageNotification"></span></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Newsfeed <span><img src="<?php echo BASEURL; ?>/assets/images/down-arrow.png" alt="" /></span></a>
              <ul class="dropdown-menu newsfeed-home">
                <li><a href="<?php echo BASEURL."/page/newsfeed"; ?>">All Newsfeed</a></li>
                <li><a href="<?php echo BASEURL."/page/newsfeedImages"; ?>">Newsfeed Images</a></li>
                <li><a href="<?php echo BASEURL."/page/newsfeedVideos"; ?>">Newsfeed Videos</a></li>
                <li><a href="<?php echo BASEURL."/page/newsfeedAudios"; ?>">Newsfeed Audios</a></li>
              </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">People <span><img src="<?php echo BASEURL; ?>/assets/images/down-arrow.png" alt="" /></span></a>
              <ul class="dropdown-menu newsfeed-home">
                <li><a href="<?php echo BASEURL."/page/newsfeedFriends"; ?>">My Friends &nbsp;<span class="badge sidebar_count total_friends"></span></a></li>
                <li><a href="<?php echo BASEURL."/page/newsfeedNearbyPeople"; ?>">Poeple Nearly</a></li>
                <li><a href="<?php echo BASEURL."/page/friendRequest"; ?>">Friend Request&nbsp;<span class="badge sidebar_count total_FriendRequest"></span></a></li>
                <li><a href="<?php echo BASEURL."/page/blockUser"; ?>">Block List &nbsp;<span class="badge sidebar_count total_BlockUser"></span></a></a></li>
                
              </ul>
          </li>
          <li class="dropdown"><a href="<?php echo BASEURL."/timeline/profile"; ?>">Profile</a></li>

            <li class="dropdown" data-target='.logout' data-toggle='modal'><a style="cursor: pointer;">Logout</a></li>
         
        </ul>
        <!-- <form class="navbar-form navbar-right hidden-sm">
          <div class="form-group">
            <i class="icon ion-android-search"></i>
            <input type="text" class="form-control" placeholder="Search friends, photos, videos">
          </div>
        </form>
      </div>--><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>
</header>
 <?php
    }
?>