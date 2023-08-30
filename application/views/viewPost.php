<?php

$linkId=null;

$postId=explode('94039',$_SERVER['REQUEST_URI']);
if(is_array($postId) AND isset($postId[1]))
{
  $id=encryption('decrypt', $postId[1]);
  if($id!=false)
  {
    $user=new timeline;
    $linkId=$postId[1];
    $userData=$user->getUserInfo();
    $allusers=$user->getUserInfo('allUsers');
    $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
    $myData=$user->getUserInfo('id',$userId);
    $postData=$user->getPost($postId[1]);
    if(is_array($postData))
    {
      $post_user_id=encryption('encrypt',$postData['user_id']);
      $friendRequest=$user->checkFriendRequest($post_user_id,$_SESSION['loginUser'][0],'getdata');
    }
    else
    {
      header("location:".BASEURL."/timeline/profile");
    }
    

    if($_SESSION['loginUser'][0]!=$post_user_id)
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
        else if($postData['post_status']=='private')
        {
          header("location:".BASEURL."/timeline/profile?postStatusPrivate");
        }
      }
      else
      {
        if($postData['post_status']=='friend')
        {
          header("location:".BASEURL."/timeline/profile?postStatusFriend");
        }
        else if($postData['post_status']=='private')
        {
          header("location:".BASEURL."/timeline/profile?postStatusPrivate");
        }
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
		<title>News Feed | Check what your friends are doing</title>

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
            <!-- Post Create Box End-->

            <?php 

              $account=null;

              if($postData['user_id']!=$userId)
              {
                if ($postData['account_type']=='private' AND !is_array($friendRequest) ) 
                {
                  echo "<div class='about-content-block'>
                    <center><h1>Private Account</h1></center>
                    </div><br><br>
                  ";
                  $account='private';
                }
                else if($postData['account_type']=='private' AND $friendRequest['request']=='send')
                {
                   echo "<div class='about-content-block'>
                    <center><h1>Private Account</h1></center>
                    </div><br><br>
                  ";
                  $account='private';
                }
              }
              else
              {
                $account==null;
              }
              

              if(isset($postData) AND $postData!=false AND $account==null AND $account!='private' OR $postData['user_id']==$userId)
              {  
                $type1=null;
                $type2=null;

                if(!is_array($friendRequest))
                {
                  $type1='public';
                  $type2=null;
                }
                else if(is_array($friendRequest) AND $friendRequest['request']=='friend')
                {
                  $type1='friend';
                  $type2='public';
                }
                else if(is_array($friendRequest) AND $friendRequest['request']=='send')
                {
                  $type1='public';
                  $type2=null;

                }

                if($type1==$postData['post_status'] OR $type2==$postData['post_status'] OR $_SESSION['loginUser'][0]==$post_user_id)
                {
                    if(!empty($postData['post_file_name']))
                    {
                        $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

                        $audio_type=array('mp3','MP3','WMA','wma');
                                         
                        $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

                        $exp=explode(".", $postData['post_file_name']);
                        $type_file=end($exp);

                        $path= BASEURL.'/public/assets/user_post_files/'.$postData['post_file_name'];

                        if (in_array($type_file,$video_type)) 
                        {
                          $style='';
                          $File="<video  class='post-video stylish_player' controls style='height: 500px;'> 
                                    <source src='$path' type='".$postData['post_file_type']."'> 
                                </video>&nbsp;";
                        }
                        else if (in_array($type_file,$image_type)) 
                        {
                          $File="<img src='$path' alt='post-image' class='img-responsive post-image' />";

                        }
                        else if(in_array($type_file,$audio_type))
                        {
                            $File="<br><audio controls style='width:100%;' class='bg-success'>
                                <source src='$path' type='".$postData['post_file_type']."'> 
                             </audio>&nbsp;";
                        }
                    }
                    else
                    {
                      $File='';
                    }

                    if ($postData['post_text']!=null) 
                    {
                      $post= "<i class='em em-thumbsup'>Post Text:- </i><br>
                      <b class='post_span'>".htmlspecialchars($postData['post_text'])."</b><div class='line-divider'></div>";
                    }
                    else
                    {
                      $post='';
                    }

                    if($postData['bluetick']=='yes' AND $postData['bluetick']!='NULL')
                    {
                      $bluetick=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
                    }
                    else
                    {
                      $bluetick='';
                    }

                    $time=TimeAgo($postData['post_date'],$user->current_time(),'Message');
                    $post_id=encryption('encrypt',$postData['id']);
                    $user_id=encryption('encrypt',$postData['user_id']);

                    $response_likes=$user->check_like($postData['id']);

                    //Manage to like and dislike Color
                    if ($response_likes==='none') {
                      $like_color='text-green';
                      $dislike_color='text-red';
                    }
                    else if ($response_likes==='like') {
                      $like_color='';
                      $dislike_color='text-red';
                    }
                    else if ($response_likes==='dislike') {
                      $like_color='text-green';
                      $dislike_color='';
                    }

                    if($friendRequest!=false)
                    {
                      if($friendRequest['request']=='friend')
                      {
                        $btn="Friend";
                      }
                      else if($friendRequest['request']=='send')
                      {
                        $btn="Request Send";
                      }
                    }
                    else if($user_id==$_SESSION['loginUser'][0])
                    {
                      $btn='';
                    }
                    else
                    {
                      $btn="Add Friend";
                    }

                    $postComments=$user->DisplayPostComment($post_id);
                    $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$postData['user_id']);
                    $time=TimeAgo($postData['post_date'],$user->current_time(),'Message');
                ?>


            <!-- Post Content
            ================================================= -->
            <div class="post-content">
              <?php echo $File; ?>
              <div class="post-container">
                <img src="<?php echo BASEURL.'/public/assets/images/users/'.$postData['image']; ?>" alt="user" class="profile-photo-md pull-left" />
                <div class="post-detail">
                  <div class="user-info">
                    <h5><a href="<?php echo $profile_id; ?>" class="profile-link"><?php echo ucfirst(htmlspecialchars($postData['name']))." ".$bluetick; ?></a> <span class="following"><?php echo $btn; ?></span></h5>
                    <p class="text-muted">Published a post about <?php echo $time; ?></p>

                    <?php
                      $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$postData['id']);

                      if($userId!=$postData['user_id'])
                      {
                        echo '<button type="button" data-toggle="modal" data-target=".post_report" class="btn btn-danger btn-xs report_post" onclick="reportPost(this)" post_id="'.$post_id.'">Report Post</button>';
                      }
                      else
                      {

                        ?>
                        <form action="<?php echo BASEURL.'/post/postUpdate'; ?>" method="Post" onchange="postUpdate(this)">
                     <h5>
                      <input type="text" name="post_id" value="<?php echo $post_id; ?>" style="display: none">
                      <select name="post_privacy">';
                     <?php
                      if($postData['post_status']==='public')
                      {
                          echo '<option value="public">Public</option>
                          <option value="friend">Friend</option>
                          <option value="private">Private</option>';
                        
                        }
                        else if($postData['post_status']==='friend')
                        {
                         
                          echo '<option value="friend">Friend</option>
                          <option value="public">Public</option>
                          <option value="private">Private</option>';
                       
                        }
                        else if($postData['post_status']==='private')
                        {
                          
                          echo '<option value="private">Private</option>
                          <option value="public">Public</option>
                          <option value="friend">Friend</option>';
                        
                        }
                        ?>
                      </select>&nbsp;&nbsp;

                       <?php
                         if($userId==$postData['user_id'])
                          {
                            echo "<button type='button' data-toggle='modal' data-target='.delete_post' class='btn btn-danger btn-xs delete_my_post' delete_id='".$post_id."' onclick='delete_my_post(this)'>Delete Post</button>";
                          }
                       ?>
                     
                        
                      </h5>
                    </form>
                    <?php
                      }
                    ?>
                     <button type='button' class='btn btn-info btn-xs' onclick='copyLink(this)' link='<?php echo $link; ?>'>Link Copy</button>
                  </div>

                  <div class='reaction'>
                    &nbsp;&nbsp;&nbsp;

                    <a class='btn <?php echo $like_color; ?>' post_id="<?php echo $post_id; ?>" u_id="<?php echo $user_id; ?>" onclick="thumbsup(this)"><i class='icon ion-thumbsup'></i> 
                     <?php if(empty($postData['likes'])){echo "0"; }else{echo $postData['likes']; }; ?>
                    </a> &nbsp;&nbsp;&nbsp;&nbsp;

                    <a class='btn <?php echo $dislike_color; ?>' post_id="<?php echo $post_id; ?>" u_id="<?php echo $user_id; ?>" onclick="thumbsdown(this)"><i class='fa fa-thumbs-down'></i> 
                       <?php if(empty($postData['dislikes'])){echo "0"; }else{echo $postData['dislikes']; }; ?>
                    </a><br>

                    <button type='button' data-target='#all_like' data-toggle='modal' class='btn btn-info btn-xs view_like' post_id="<?php echo $post_id; ?>" u_id="<?php echo $user_id; ?>" onclick="viewlike(this)">View Likes</button> 

                     <button type='button' data-target='#all_dislike' data-toggle='modal' class='btn btn-danger btn-xs view_dislike' post_id="<?php echo $post_id; ?>" u_id="<?php echo $user_id; ?>" onclick="viewdislike(this)">View Dislikes</button>

                  </div><br><br>
                  <div class="line-divider"></div>

                  <?php
                    if(isset($post))
                    {
                      echo $post;
                    }
                  ?>
                  
                  
                   <div class='all_comments_show'>

                      <?php 
                        $msg='';
                        if(is_array($postComments))
                        {
                          foreach ($postComments as $data) 
                          {
                            $delete_id=encryption('encrypt',$data['id']);

                            $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$data['user_id']);

                            if($data['user_id']==$userId OR $userId==$postData['user_id'])
                            {
                              $delBtn="<button type='button' title='Delete this Comment' data-toggle='modal' data-target='.delete_comment' class='btn btn-default btn-xs delete_comment_myPost' delete_id='$delete_id'><span class='glyphicon glyphicon-trash'></<span></button>";
                            }
                            else
                            {
                              $delBtn='';
                            }
                            $image=BASEURL.'/public/assets/images/users/'.encryption('decrypt',$data['image']);
                            $comments=htmlspecialchars(encryption('decrypt',$data['comment']));
                            echo "
                              <div class='post-comment'>
                                <img src='$image' alt='profile_image' class='profile-photo-sm' />
                                <p><a href='".$profile_id."' class='profile-link'>". ucfirst(htmlspecialchars($data['name']))."</a>
                                  $comments

                                  &nbsp;&nbsp;

                                  $delBtn
                             </div>";
                          }
                        }
                        else if($postComments=='emptyComment')
                        {
                          $msg='<div class="alert alert-danger alert-dismissable text-center">
                             <a href="#" class="close" data-dismiss="alert">×</a>
                             <p>Comment is Empty</p></div>';
                        }
                        else if($postComments=='error')
                        {
                          $msg='<div class="alert alert-danger alert-dismissable text-center">
                             <a href="#" class="close" data-dismiss="alert">×</a>
                             <p>Something was wrong please refersh web page....!</p></div>';
                        }
                        ?>

                        <br><div class='comment_errors'><?php echo $msg; ?></div>
                      </div>

                  
                  <div class='post-comment'>

                    <img src="<?php echo BASEURL.'/public/assets/images/users/'.$userData['image']; ?>" alt='' class='profile-photo-sm' />

                   
                    <div class='input-group' style="width:100%;">
                      <input type='text' name='comment' class='form-control comment_input' placeholder='Post a comment'>

                      <input type='hidden' name='post_id' value='<?php echo $post_id; ?>' class='form-control post_id'>

                    <span class='input-group-btn'>
                     <button class='btn btn-info btn-sm' type='submit' onclick='comment_insert(this)'>Comment</button>
                    </span>
                    </div>
                  
                    
                  </div>

                </div>
              </div>
            </div>

            <?php 
               }
                }
                else
                {
                  echo '<div class="alert alert-danger alert-dismissable text-center">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <p>Can Not View Private Account Post.....!</p></div>';

                }
          ?>

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
    <div id="dialog"></div>
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>
    
   <?php include "components/jsFiles.php"; ?>
  </body>
</html>
