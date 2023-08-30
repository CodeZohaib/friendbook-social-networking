<?php

include "controllerTrait.php";
include "pageLoadTrait.php";

class timeline extends framework{
	use controllerTrait,pageLoadTrait;


	public function getTimelinefriends()
	{
    $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
    $timelineFriends=$this->mlFriendRequest->getfriends($userId);

    if(isset($timelineFriends) AND is_array($timelineFriends))
    {
      $html=[];
      foreach ($timelineFriends as $key => $value) 
      {
        unset($value['password']);
        unset($value['verification_code']);
        $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['id']);

        if($value['bluetick']=='yes' AND $value['bluetick']!='NULL')
        {
          $bluetick=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
        }
        else
        {
          $bluetick='';
        }

        $profile_img= BASEURL.'/public/assets/images/users/'.$value['image'];
        $cover_img= BASEURL.'/public/assets/images/covers/'.$value['bg_image'];
        $time=TimeAgo($value['date_time'],$this->current_time(),'Message');
        $title=formatDate($value['date_time']);
        $html[].='<div class="col-md-6 col-sm-6">
                  <div class="friend-card">
                    <img src="'.$cover_img.'" alt="profile-cover" class="img-responsive cover" onclick="imageView(this)" />
                    <div class="card-info">
                      <img src="'.$profile_img.'" alt="user" class="profile-photo-lg" onclick="imageView(this)" />
                      <div class="friend-info">
                        <a href="'.$profile_id.'" class="pull-right text-green">My Friend</a>
                        <h5><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($value['name'])).'</a></h5>
                        <p title="'.$title.'" style="cursor:pointer;"">'.$time.'</p>
                      </div>
                    </div>
                  </div>
                </div>';
      }

      if(isset($html) AND is_array($html) AND !empty($html))
      {
       $val=implode(" ",$html);
       return MsgDisplay('success',$val,'');
      }
      else
      {
        return MsgDisplay('error','<br><br><div class="alert alert-danger alert-dismissable text-center">
           <a href="#" class="close" data-dismiss="alert">×</a>
         <p>Zero Friends.....!</p></div>','');
      }
    }
    else if($timelineFriends=='zeroFriends')
    {
      return MsgDisplay('error','<br><br><div class="alert alert-danger alert-dismissable text-center">
           <a href="#" class="close" data-dismiss="alert">×</a>
         <p>Zero Friends.....!</p></div>','');
    } 
	}

  public function getFriendTimelinefriends()
  {
    if(isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_POST['url']))
    {
      $friendId=explode('94039',$_POST['url']);
      if(is_array($friendId) AND isset($friendId[1]))
      {
        $id=encryption('decrypt', $friendId[1]);
        if($id!=false)
        {
          $user_id=$id;
          $account=null;
          $userData=$this->getUserInfo('id',$id);
          $timelineFriends=$this->mlFriendRequest->getfriends($user_id);
          $friendRequest=$this->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');

          if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
          {
            $account='private';
          }
          else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
          {
            $account='private';
          }

          if($timelineFriends=='zeroFriends')
          {
            return MsgDisplay('error','<br><br><div class="alert alert-danger alert-dismissable text-center">
                   <a href="#" class="close" data-dismiss="alert">×</a>
                 <p>Zero Friends.....!</p></div>','');
          } 

          if(isset($timelineFriends) AND $timelineFriends!='zeroFriends' AND $account==null AND $account!='private')
          {
            $html=[];
            foreach ($timelineFriends as $key => $value) 
            {
              unset($value['password']);
              unset($value['verification_code']);
              $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['id']);

              $profile_img= BASEURL.'/public/assets/images/users/'.$value['image'];
              $cover_img= BASEURL.'/public/assets/images/covers/'.$value['bg_image'];
              $time=TimeAgo($value['date_time'],$this->current_time(),'Message');
              $title=formatDate($value['date_time']);
              $html[].='<div class="col-md-6 col-sm-6">
                  <div class="friend-card">
                    <img src="'.$cover_img.'" alt="profile-cover" onclick="imageView(this)" class="img-responsive cover" />
                    <div class="card-info">
                      <img src="'.$profile_img.'" alt="user" onclick="imageView(this)" class="profile-photo-lg" />
                      <div class="friend-info">
                        <a href="'.$profile_id.'" class="pull-right text-green">My Friend</a>
                        <h5><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($value['name'])).'</a></h5>
                        <p title="'.$title.'" style="cursor:pointer;"">'.$time.'</p>
                      </div>
                    </div>
                  </div>
                </div>';
            }

            if(isset($html) AND is_array($html) AND !empty($html))
            {
             $val=implode(" ",$html);
             return MsgDisplay('success',$val,'');
            }
          }
          
        }
      }
    }
  }



	public function getTimelineFriendPost()
	{
		
		if(!isset($_SESSION['loginUser']) AND empty($_SESSION['loginUser']))
    {
    	$this->redirect();
    }

    if(isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_POST['url']))
    {
    	$friendId=explode('94039',$_POST['url']);
			if(is_array($friendId) AND isset($friendId[1]))
			{
			  $id=encryption('decrypt', $friendId[1]);
			  if($id!=false)
			  {
			  	$user_id=$id;
			  	$account=null;
			  	$userData=$this->getUserInfo('id',$id);
			  	$allPost=$this->mlPost->getAllPost($user_id);
			  	$friendRequest=$this->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');
			  	

			  	if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
          {
            $account='private';
          }
          else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
          {
            $account='private';
          }

          if(isset($allPost) AND $allPost!=false AND $account==null AND $account!='private')
          {
            $html=[];
            $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
            $myData=$this->getUserInfo('id',$userId);
            foreach ($allPost as $key => $value) 
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


            if($type1==$value['post_status'] OR $type2==$value['post_status'] OR encryption('decrypt',$_SESSION['loginUser'][0])==$value['user_id'])
            {
                if(!empty($value['post_file_name']))
                {
                    $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

                    $audio_type=array('mp3','MP3','WMA','wma');
                                     
                    $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

                    $exp=explode(".", $value['post_file_name']);
                    $type_file=end($exp);

                    $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];

                    if (in_array($type_file,$video_type)) 
                    {
                      $style='';
                      $File="<video  class='post-video stylish_player' controls style='height: 500px;'> 
                                <source src='$path' type='".$value['post_file_type']."'> 
                            </video>&nbsp;";
                    }
                    else if (in_array($type_file,$image_type)) 
                    {
                      $File="<img src='$path' alt='post-image' class='img-responsive post-image' onclick='imageView(this)' />";

                    }
                    else if(in_array($type_file,$audio_type))
                    {
                        $File="<br><audio controls style='width:100%;' class='bg-success'>
                            <source src='$path' type='".$value['post_file_type']."'> 
                         </audio>&nbsp;";
                    }
                }
                else
                {
                  $File='';
                }

                if (!empty($value['post_text'])) 
                {
                  $post= "<i class='em em-thumbsup'>Post Text:- </i><br>
                  <b class='post_span post-text'>".htmlspecialchars($value['post_text'])."</b><div class='line-divider'></div>";
                }
                else
                {
                  $post='';
                }

                $time=TimeAgo($value['post_date'],$this->current_time(),'Message');
                $post_id=encryption('encrypt',$value['id']);
                $user_id=encryption('encrypt',$value['user_id']);

                $response_likes=$this->check_like($value['id']);

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

                if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                {
                    $bluetick=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
                }
                else
                {
                  $bluetick='';
                }

                $postComments=$this->DisplayPostComment($post_id);
                $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
              
              $html[].='<div class="post-content">
                    <!--Post Date-->
                    <div class="post-date hidden-xs hidden-sm">
                      <h5>'.ucwords($userData['name']).'</h5>
                      <p class="text-grey" style="width:60%">'.formatDate($value['post_date']).'</p>
                    </div>

                    '.$File.'
                    <div class="post-container">
                      <img src="'.BASEURL.'/public/assets/images/users/'.$userData['image'].'" alt="user" class="profile-photo-md pull-left" onclick="imageView(this)" />
                      <div class="post-detail">
                        <div class="user-info">
                          <h5><a href="timeline.html" class="profile-link">'.ucwords($userData['name']).'</a>'.$bluetick.'<span class="following">';
                        
                              if($friendRequest!=false)
                              {
                                if($friendRequest['request']=='friend')
                                {
                                  $html[].="Friend";
                                }
                                else if($friendRequest['request']=='send')
                                {
                                  $html[].="Request Send";
                                }
                              }
                              else if($user_id==$_SESSION['loginUser'][0])
                              {
                                $html[].='';
                              }
                              else
                              {
                                $html[].="Add Friend";
                              }
                              
                          
                          $html[].='</span></h5>
                                     <p class="text-muted">Published a post about '. $time.'</p>
                                   <h5>';
                              
                                if(encryption('decrypt',$_SESSION['loginUser'][0])!=false)
                                {
                                  if(encryption('decrypt',$_SESSION['loginUser'][0])==$value['user_id'])
                                  {

                                   $html[].='<form class="change_data" action="'.BASEURL.'/post/postUpdate" method="Post" onchange="postUpdate(this)">
                                       <h5>
                                        <input type="text" name="post_id" value="'.
                                        $post_id.'" style="display: none">
                                         <select name="post_privacy">';
                                          
                                          if($value['post_status']==='public')
                                          {
                                            $html[].='<option value="public">Public</option>
                                            <option value="friend">Friend</option>
                                            <option value="private">Private</option>';
                                          }
                                          else if($value['post_status']==='friend')
                                          {
                                            $html[].='<option value="friend">Friend</option>
                                            <option value="public">Public</option>
                                            <option value="private">Private</option>';
                                          }
                                          else if($value['post_status']==='private')
                                          {
                                            $html[].='<option value="private">Private</option>
                                            <option value="public">Public</option>
                                            <option value="friend">Friend</option>';
                                          }
                                          
                                        $html[].="</select>&nbsp;&nbsp";
                                  }
                                  else
                                  {
                                    if($value['post_status']==='public')
                                    {
                                      $html[].="<span><b>Post Privacy : </b>Public</span>";
                                    }
                                    else if($value['post_status']==='friend')
                                    {
                                      $html[].="<span><b>Post Privacy : </b>Friend</span>";
                                    }
                                    else if($value['post_status']==='private')
                                    {
                                      $html[].="<span><b>Post Privacy : </b>Private</span>";
                                    }
                                  }
                                }
                             $html[].='&nbsp;&nbsp;</form>';

                          
                           if(encryption('decrypt',$_SESSION['loginUser'][0])==$value['user_id'])
                           {
                             $html[].="<button type='button' data-toggle='modal' data-target='.delete_post' class='btn btn-danger btn-xs delete_my_post' onclick='delete_my_post(this)' delete_id='$post_id'>Delete Post</button>";
                           }
                        
                          $html[].='<button type="button" data-toggle="modal" data-target=".post_report" class="btn btn-danger btn-xs report_post" onclick="reportPost(this)" post_id="'.$post_id.'">Report Post</button>

                         <button type="button" class="btn btn-info btn-xs copyLink" link="'.$link.'" onclick="copyLink(this)">Link Copy</button>
                        </div>

                        <div class="reaction">
                              &nbsp;&nbsp;&nbsp;
                              <a class="btn '.$like_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsup(this)"><i class="icon ion-thumbsup"></i>';


                            if(empty($value['likes']))
                            {
                               $html[].="0"; 
                            }
                             else
                            {
                               $html[].=$value['likes']; 
                            }


                           $html[].='</a>
                               &nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn '.$dislike_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsdown(this)"><i class="fa fa-thumbs-down" ></i>';

                            if(empty($value['dislikes']))
                            {
                              $html[].="0"; 
                            }
                            else
                            {
                              $html[].=$value['dislikes']; 
                            }; 

                          $html[].="</a><br>

                          <button type='button' data-target='#all_like' data-toggle='modal' class='btn btn-info btn-xs view_like' post_id='".$post_id."' u_id='".$user_id."' onclick='viewlike(this)'>View Likes</button> 

                             <button type='button' data-target='#all_dislike' data-toggle='modal' class='btn btn-danger btn-xs view_dislike' post_id='".$post_id."' u_id='".$user_id."' onclick='viewdislike(this)'>View Dislikes</button>
                        </div>
                        
                          <div class='line-divider'></div>".$post."<div class='all_comments_show'>";

                              $msg='';
                              if(is_array($postComments))
                              {
                                foreach ($postComments as $data) 
                                {
                                  $delete_id=encryption('encrypt',$data['id']);

                                  $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$data['user_id']);
                                  $image=BASEURL.'/public/assets/images/users/'.encryption('decrypt',$data['image']);
                                  $comments=htmlspecialchars(encryption('decrypt',$data['comment']));

                                  if($data['user_id']==$userId)
                                  {
                                    $delBtn="&nbsp;&nbsp;
                                     <button type='button' title='Delete this Comment' data-toggle='modal' data-target='.delete_comment' class='btn btn-default btn-xs' onclick='delete_comment_myPost(this)' delete_id='$delete_id'><span class='glyphicon glyphicon-trash'></<span></button>";
                                  }
                                  else
                                  {
                                    $delBtn='';
                                  }

                              $html[].="
                                    <div class='post-comment'>
                                      <img src='$image' alt='profile_image' onclick='imageView(this)' class='profile-photo-sm' />
                                      <p><a href='".$profile_id."' class='profile-link'>". htmlspecialchars(ucwords($data['name']))."</a>
                                        $comments

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
                              else
                              {
                                $msg='<div class="alert alert-danger alert-dismissable text-center">
                                   <a href="#" class="close" data-dismiss="alert">×</a>
                                   <p>'.$postComments.'</p></div>';
                              }
                              

                              $html[].="<br><div class='comment_errors'>".$msg."</div>
                              </div>
                              <div class='post-comment'>
                                  <img src='".BASEURL.'/public/assets/images/users/'.$myData['image']."' alt='' class='profile-photo-sm' onclick='imageView(this)' />

                                  <div class='input-group' style='width:100%;'>
                                    <input type='text' name='comment' class='form-control comment_input' placeholder='Post a comment' onmouseenter='emoji()'>

                                    <input type='hidden' name='post_id' value='".$post_id."' class='form-control post_id' placeholder='Post a comment'>

                                  <span class='input-group-btn'>
                                   <button class='btn btn-info btn-sm comment_insert' onclick='comment_insert(this)'>Comment</button>
                                  </span>
                                  </div>
                                  </form>
                                  
                                </div>

                            </div>
                          </div>
                        </div>";
            }
           }

           if(isset($html) AND is_array($html) AND !empty($html))
            {
             $val=implode(" ",$html);
             return MsgDisplay('success',$val,'');
            }
            else
            {
              return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>No Post Available.......!</p>",'');
            }
          }
          else
          {
            if($account==null AND $account!='private')
            {

              return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>No Post Available.......!</p>",'');
            } 
          }
			  }
			}
		}
	}

	public function getTimelinePost()
	{
		if(!isset($_SESSION['loginUser']) AND empty($_SESSION['loginUser']))
    {
    	$this->redirect();
    }

    if(isset($_POST['offset']) AND isset($_POST['rows']))
    {
    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
      $checkUrl = explode('/', $_POST['url']);
      if(end($checkUrl)=='timelineAudios')
      {
        $allPost=$this->mlPost->getAudios($user_id);
      }
      else
      {
        $allPost=$this->mlPost->getAllPost($user_id);
      }
	    
	    
      if(is_array($allPost))
	    {
	    	  if(isset($allPost) AND $allPost!=false)
          {
          	$html=[];
            foreach ($allPost as $key => $value) 
            {
              if(!empty($value['post_file_name']))
              {
                  $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

                  $audio_type=array('mp3','MP3','WMA','wma');
                                   
                  $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

                  $exp=explode(".", $value['post_file_name']);
                  $type_file=end($exp);

                  $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
            
                  if (in_array($type_file,$video_type)) 
                  {
                    $style='';
                    $File="<video  class='post-video stylish_player' controls style='height: 500px;'> 
                              <source src='$path' type='".$value['post_file_type']."'> 
                          </video>&nbsp;";
                  }
                  else if (in_array($type_file,$image_type)) 
                  {
                    $File="<img src='$path' alt='post-image' class='img-responsive post-image' onclick='imageView(this)' />";

                  }
                  else if(in_array($type_file,$audio_type))
                  {
                      $File="<br><audio controls style='width:100%;' class='bg-success'>
                          <source src='$path' type='".$value['post_file_type']."'> 
                       </audio>&nbsp;";
                  }
              }
              else
              {
                $File='';
              }

              if (!empty($value['post_text'])) 
              {
                
                $post= "<i class='em em-thumbsup'>Post Text:- </i><br>
                <b class='post_span post-text'><p>".htmlspecialchars($value['post_text'])."</p></b><div class='line-divider'></div>";
              }
              else
              {
                $post='';
              }

              $response_likes=$this->check_like($value['id']);

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


              $time=TimeAgo($value['post_date'],$this->current_time(),'Message');
              $post_id=encryption('encrypt',$value['id']);
              $user_id=encryption('encrypt',$value['user_id']);

              $postComments=$this->DisplayPostComment($post_id);
              $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
              $userData=$this->getUserInfo('id',encryption('decrypt',$_SESSION['loginUser'][0]));

              if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
              {
                  $bluetick=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
              }
              else
              {
                $bluetick='';
              }
             
             $html[].='<div class="post-content">

            <!--Post Date-->
            <div class="post-date hidden-xs hidden-sm">
              <h5>'.ucwords($userData['name']).'</h5>
              <p class="text-grey" style="width:60%">'.formatDate($value['post_date']).'</p>
            </div>

            '.$File.'
            <div class="post-container">
              <img src="'.BASEURL.'/public/assets/images/users/'.$userData['image'].'" alt="user" class="profile-photo-md pull-left" onclick="imageView(this)" />
              <div class="post-detail">
                <div class="user-info">
                  <h5><a href="timeline.html" class="profile-link">'.ucwords($userData['name']).'</a>'.$bluetick.'</h5>
                  <p class="text-muted">Published a post about '.$time.'</p>

                  <form action="'.BASEURL.'/post/postUpdate'.'" method="Post" onchange="postUpdate(this)">
                     <h5>
                      <input type="text" name="post_id" value="'.$post_id.'" style="display: none">
                      <select name="post_privacy">';
                     
                        if($value['post_status']==='public')
                        {
                          
                          $html[].='<option value="public">Public</option>
                          <option value="friend">Friend</option>
                          <option value="private">Private</option>';
                        
                        }
                        else if($value['post_status']==='friend')
                        {
                         
                          $html[].='<option value="friend">Friend</option>
                          <option value="public">Public</option>
                          <option value="private">Private</option>';
                       
                        }
                        else if($value['post_status']==='private')
                        {
                          
                          $html[].='<option value="private">Private</option>
                          <option value="public">Public</option>
                          <option value="friend">Friend</option>';
                        
                        }
                        
                        

                      $html[].="</select>&nbsp;&nbsp;

                      <button type='button' data-toggle='modal' data-target='.delete_post' class='btn btn-danger btn-xs delete_my_post' delete_id='".$post_id."' onclick='delete_my_post(this)'>Delete Post</button>";

                      
                        if($userData['id']!=$value['user_id'])
                        {
                          $html[].="<button type='button' data-toggle='modal' data-target='.post_report' class='btn btn-danger btn-xs'  post_id='".$post_id."'>Report Post</button>";
                        }
                    
                      

                      $html[].="<button type='button' class='btn btn-info btn-xs' onclick='copyLink(this)' link='".$link."'>Link Copy</button>";
                      
                   $html[].='</h5>
                  </form>
                </div>
                <div class="reaction">
                  &nbsp;&nbsp;&nbsp;
                  <a class="btn '.$like_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsup(this)"><i class="icon ion-thumbsup"></i>';


                if(empty($value['likes']))
                {
                   $html[].="0"; 
                }
                 else
                {
                   $html[].=$value['likes']; 
                }


               $html[].='</a>
                   &nbsp;&nbsp;&nbsp;&nbsp;
                  <a class="btn '.$dislike_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsdown(this)"><i class="fa fa-thumbs-down" ></i>';

                if(empty($value['dislikes']))
                {
                  $html[].="0"; 
                }
                else
                {
                  $html[].=$value['dislikes']; 
                }; 

              $html[].="</a><br>
                  <button type='button' data-target='#all_like' data-toggle='modal' class='btn btn-info btn-xs view_like' post_id='".$post_id."' u_id='".$user_id."' onclick='viewlike(this)'>View Likes</button> 

                     <button type='button' data-target='#all_dislike' data-toggle='modal' class='btn btn-danger btn-xs view_dislike' post_id='".$post_id."' u_id='".$user_id."' onclick='viewdislike(this)'>View Dislikes</button>
                </div>
                <div class='line-divider'></div>".$post."
                <div class='all_comments_show'>";

                  $msg='';
                  if(is_array($postComments))
                  {
                    foreach ($postComments as $data) 
                    {
                      $delete_id=encryption('encrypt',$data['id']);

                      $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$data['user_id']);
                      $image=BASEURL.'/public/assets/images/users/'.encryption('decrypt',$data['image']);
                      $comments=htmlspecialchars(encryption('decrypt',$data['comment']));
                      $html[].="
                        <div class='post-comment'>
                          <img src='$image' alt='profile_image' class='profile-photo-sm' onclick='imageView(this)' />
                          <p><a href='".$profile_id."' class='profile-link'>". ucwords(htmlspecialchars($data['name']))."</a>
                            $comments

                            &nbsp;&nbsp;
                            <button type='button' title='Delete this Comment' data-toggle='modal' data-target='.delete_comment' class='btn btn-default btn-xs' onclick='delete_comment_myPost(this)' delete_id='$delete_id'><span class='glyphicon glyphicon-trash'></<span></button>
                       </div>";
                    }
                  }
                  else if($postComments=='emptyComment')
                  {
                    $html[].='<div class="alert alert-danger alert-dismissable text-center">
                       <a href="#" class="close" data-dismiss="alert">×</a>
                       <p>Comment is Empty</p></div>';
                  }
                  else if($postComments=='error')
                  {
                    $html[].='<div class="alert alert-danger alert-dismissable text-center">
                       <a href="#" class="close" data-dismiss="alert">×</a>
                       <p>Something was wrong please refersh web page....!</p></div>';
                  }
                  else
                  {
                    $html[].='<div class="alert alert-danger alert-dismissable text-center">
                       <a href="#" class="close" data-dismiss="alert">×</a>
                       <p>'.$postComments.'</p></div>';
                  }

                  

                 $html[].="<br><div class='comment_errors'>".$msg."</div>
                </div>
                <div class='post-comment'>
                    <img src='".BASEURL.'/public/assets/images/users/'.$userData['image']."' onclick='imageView(this)' alt='' class='profile-photo-sm' />

                    <div class='input-group' style='width:100%;'>
                      <input type='text' name='comment' class='form-control comment_input' onmouseenter='emoji()' placeholder='Post a comment'>

                      <input type='hidden' name='post_id' value='".$post_id."' class='form-control post_id' placeholder='Post a comment'>

                    <span class='input-group-btn'>
                     <button class='btn btn-info btn-sm comment_insert' onclick='comment_insert(this)'>Comment</button>
                    </span>
                    </div>
                    </form>
                    
                  </div>

              </div>
            </div>
            </div>";
           }
          }
          else
          {
            return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>No Post Create.....!</p>",'');
          }

        if(isset($html) AND is_array($html) AND !empty($html))
				{
	       $val=implode(" ",$html);
	       return MsgDisplay('success',$val,'');
				}
        else
        {
           if(end($checkUrl)=='timelineAudios')
           {
            return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Your Not Upload Any Audio.....!</p>",'');
           }
           else
           {
            return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>No Post Create.....!</p>",'');
           }
        }
	    }
	    else
	    {
	    	if(end($checkUrl)=='timelineAudios')
        {
          return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Your Not Upload Any Audio.....!</p>",'');
         }
         else
         {
          return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>No Post Create.....!</p>",'');
         }
	    }

		  return false;
    }
	}

	public function getTimelineVideos()
	{
		$id=encryption('decrypt',$_SESSION['loginUser'][0]);
		$allVideos=$this->mlPost->getVideos($id);
    if(isset($allVideos) AND is_array($allVideos))
    {
      $html=[];
      foreach ($allVideos as $key => $value) 
      {
        $id=md5(random_bytes(8));
        $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
        $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];

          $html[].="<li title='Click And View the Post' onclick='viewVideo(this)' post_link='$post_id'>
                <div class='img-wrapper' >
                  <video style='border:2px solid black'> 
                        <source src='$path' type='".$value['post_file_type']."'> 
                    </video>
                </div>
              </li>";
      }

      if(isset($html) AND is_array($html) AND !empty($html))
      {
       $val=implode(" ",$html);
       return MsgDisplay('success',$val,'');
      }
      else
      {
        return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Your Not Upload Any Videos.....!</p>",'');
      }
    }
    else
    {
      return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Your Not Upload Any Videos.....!</p>",'');
    }

	}

  public function getTimelineFriendAudios()
  {
    $account=null;
    $friendId=explode('94039',$_POST['url']);
    $userData=$this->getUserInfo('id',encryption('decrypt', $friendId[1]));
    $friendRequest=$this->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');
    if(is_array($friendId) AND isset($friendId[1]))
    {
      $id=encryption('decrypt',$friendId[1]);
      if($id!=false)
      {
          $html=[];
          $allAudios=$this->mlPost->getAudios($id);
          $id=encryption('decrypt',$friendId[1]);

          if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
          {
            $account='private';
          }
          else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
          {
            $account='private';
          }


          if(isset($allAudios) AND $allAudios!=false AND $allAudios!='empty' AND $account==null AND $account!='private')
          {
            foreach ($allAudios as $key => $value) 
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

              if($type1==$value['post_status'] OR $type2==$value['post_status'] OR encryption('decrypt',$_SESSION['loginUser'][0])==$value['user_id'])
              {
                      $id=md5(random_bytes(8));
                      $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
                      $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
                      if(!empty($value['post_file_name']))
                      {
                          $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

                          $audio_type=array('mp3','MP3','WMA','wma');
                                           
                          $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

                          $exp=explode(".", $value['post_file_name']);
                          $type_file=end($exp);

                          $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
                    
                          if (in_array($type_file,$video_type)) 
                          {
                            continue;
                          }
                          else if (in_array($type_file,$image_type)) 
                          {
                            continue;
                          }
                          else if(in_array($type_file,$audio_type))
                          {

                              $File="<br><audio controls style='width:100%;' class='bg-success'>
                                  <source src='$path' type='".$value['post_file_type']."'> 
                               </audio>&nbsp;";
                          }
                      }
                      else
                      {
                        $File='';
                      }

                      if (!empty($value['post_text'])) 
                      {
                        
                        $post= "<i class='em em-thumbsup'>Post Text:- </i><br>
                        <b class='post_span post-text'><p>".htmlspecialchars($value['post_text'])."</p></b><div class='line-divider'></div>";
                      }
                      else
                      {
                        $post='';
                      }

                      $response_likes=$this->check_like($value['id']);

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


                      $time=TimeAgo($value['post_date'],$this->current_time(),'Message');
                      $post_id=encryption('encrypt',$value['id']);
                      $user_id=encryption('encrypt',$value['user_id']);

                      $postComments=$this->DisplayPostComment($post_id);
                      $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
                      $userData=$this->getUserInfo('id',encryption('decrypt', $friendId[1]));
                      if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
                      {
                          $bluetick=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
                      }
                      else
                      {
                        $bluetick='';
                      }
                     
                     $html[].='<div class="post-content">

                        <!--Post Date-->
                        <div class="post-date hidden-xs hidden-sm">
                          <h5>'.ucwords($userData['name']).'</h5>
                          <p class="text-grey" style="width:60%">'.formatDate($value['post_date']).'</p>
                        </div>

                        '.$File.'
                        <div class="post-container">
                          <img src="'.BASEURL.'/public/assets/images/users/'.$userData['image'].'" alt="user" class="profile-photo-md pull-left" onclick="imageView(this)" />
                          <div class="post-detail">
                            <div class="user-info">
                              <h5><a href="timeline.html" class="profile-link">'.ucwords($userData['name']).'</a>'.$bluetick.'</h5>
                              <p class="text-muted">Published a post about '.$time.'</p>';

                                  if(encryption('decrypt',$_SESSION['loginUser'][0])!=false)
                                  {
                                    if(encryption('decrypt',$_SESSION['loginUser'][0])==$value['user_id'])
                                    {

                                     $html[].='<form class="change_data" action="'.BASEURL.'/post/postUpdate" method="Post" onchange="postUpdate(this)">
                                         <h5>
                                          <input type="text" name="post_id" value="'.
                                          $post_id.'" style="display: none">
                                           <select name="post_privacy">';
                                            
                                            if($value['post_status']==='public')
                                            {
                                              $html[].='<option value="public">Public</option>
                                              <option value="friend">Friend</option>
                                              <option value="private">Private</option>';
                                            }
                                            else if($value['post_status']==='friend')
                                            {
                                              $html[].='<option value="friend">Friend</option>
                                              <option value="public">Public</option>
                                              <option value="private">Private</option>';
                                            }
                                            else if($value['post_status']==='private')
                                            {
                                              $html[].='<option value="private">Private</option>
                                              <option value="public">Public</option>
                                              <option value="friend">Friend</option>';
                                            }
                                            
                                          $html[].="</select>&nbsp;&nbsp";
                                    }
                                    else
                                    {
                                      if($value['post_status']==='public')
                                      {
                                        $html[].="<span><b>Post Privacy : </b>Public</span>";
                                      }
                                      else if($value['post_status']==='friend')
                                      {
                                        $html[].="<span><b>Post Privacy : </b>Friend</span>";
                                      }
                                      else if($value['post_status']==='private')
                                      {
                                        $html[].="<span><b>Post Privacy : </b>Private</span>";
                                      }
                                    }
                                  }

                                    if(encryption('decrypt',$_SESSION['loginUser'][0])!=$value['user_id'])
                                    {

                                      $html[].='<button type="button" data-toggle="modal" data-target=".post_report" class="btn btn-danger btn-xs report_post" onclick="reportPost(this)" post_id="'.$post_id.'">Report Post</button>';
                                    }
                                    else
                                    {
                                      $html[].="&nbsp;&nbsp;
                                       <button type='button' data-toggle='modal' data-target='.delete_post' class='btn btn-danger btn-xs delete_my_post' delete_id='".$post_id."' onclick='delete_my_post(this)'>Delete Post</button>";
                                    }
                                
                                  

                                  $html[].="<button type='button' class='btn btn-info btn-xs' onclick='copyLink(this)' link='".$link."'>Link Copy</button>";
                                  
                               $html[].='</h5>
                              </form>
                            </div>
                            <div class="reaction">
                              &nbsp;&nbsp;&nbsp;
                              <a class="btn '.$like_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsup(this)"><i class="icon ion-thumbsup"></i>';


                            if(empty($value['likes']))
                            {
                               $html[].="0"; 
                            }
                             else
                            {
                               $html[].=$value['likes']; 
                            }


                           $html[].='</a>
                               &nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn '.$dislike_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsdown(this)"><i class="fa fa-thumbs-down" ></i>';

                            if(empty($value['dislikes']))
                            {
                              $html[].="0"; 
                            }
                            else
                            {
                              $html[].=$value['dislikes']; 
                            }; 

                          $html[].="</a><br>
                              <button type='button' data-target='#all_like' data-toggle='modal' class='btn btn-info btn-xs view_like' post_id='".$post_id."' u_id='".$user_id."' onclick='viewlike(this)'>View Likes</button> 

                                 <button type='button' data-target='#all_dislike' data-toggle='modal' class='btn btn-danger btn-xs view_dislike' post_id='".$post_id."' u_id='".$user_id."' onclick='viewdislike(this)'>View Dislikes</button>
                            </div>
                            <div class='line-divider'></div>".$post."
                            <div class='all_comments_show'>";

                              $msg='';
                              if(is_array($postComments))
                              {
                                $user=$this->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
                                foreach ($postComments as $data) 
                                {
                                  $delete_id=encryption('encrypt',$data['id']);

                                  $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$data['user_id']);
                                  $image=BASEURL.'/public/assets/images/users/'.encryption('decrypt',$data['image']);
                                  $comments=htmlspecialchars(encryption('decrypt',$data['comment']));
                                  $userId=encryption('decrypt', $_SESSION['loginUser'][0]);

                                  if($data['user_id']==$userId)
                                  {
                                    $delBtn="&nbsp;&nbsp;
                                     <button type='button' title='Delete this Comment' data-toggle='modal' data-target='.delete_comment' class='btn btn-default btn-xs' onclick='delete_comment_myPost(this)' delete_id='$delete_id'><span class='glyphicon glyphicon-trash'></<span></button>";
                                  }
                                  else
                                  {
                                    $delBtn='';
                                  }

                                  $html[].="
                                    <div class='post-comment'>
                                      <img src='$image' alt='profile_image' class='profile-photo-sm' onclick='imageView(this)'' />
                                      <p><a href='".$profile_id."' class='profile-link'>". ucwords(htmlspecialchars($data['name']))."</a>
                                        $comments

                                        $delBtn
                                   </div>";
                                }
                              }
                              else if($postComments=='emptyComment')
                              {
                                $html[].='<div class="alert alert-danger alert-dismissable text-center">
                                   <a href="#" class="close" data-dismiss="alert">×</a>
                                   <p>Comment is Empty</p></div>';
                              }
                              else if($postComments=='error')
                              {
                                $html[].='<div class="alert alert-danger alert-dismissable text-center">
                                   <a href="#" class="close" data-dismiss="alert">×</a>
                                   <p>Something was wrong please refersh web page....!</p></div>';
                              }
                              else
                              {
                                $html[].='<div class="alert alert-danger alert-dismissable text-center">
                                   <a href="#" class="close" data-dismiss="alert">×</a>
                                   <p>'.$postComments.'</p></div>';
                              }

                              

                             $html[].="<br><div class='comment_errors'>".$msg."</div>
                            </div>
                            <div class='post-comment'>
                                <img src='".BASEURL.'/public/assets/images/users/'.$user['image']."' alt='' class='profile-photo-sm' onclick='imageView(this)' />

                                <div class='input-group' style='width:100%;'>
                                  <input type='text' name='comment' class='form-control comment_input' onmouseenter='emoji()' placeholder='Post a comment'>

                                  <input type='hidden' name='post_id' value='".$post_id."' class='form-control post_id' placeholder='Post a comment'>

                                <span class='input-group-btn'>
                                 <button class='btn btn-info btn-sm comment_insert' onclick='comment_insert(this)'>Comment</button>
                                </span>
                                </div>
                                 </form>
                                
                              </div>

                          </div>
                        </div>
                        </div>";
                   }

              }
            }

            if(isset($html) AND is_array($html) AND !empty($html))
            {
             $val=implode(" ",$html);
             return MsgDisplay('success',$val,'');
            }
            else
            {
                return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Not Upload Any Audios.....!</p>",'');
            }
          }
      }
  }
  

  public function getTimelineFriendVideos()
  {
    $account=null;
    $friendId=explode('94039',$_POST['url']);
    $userData=$this->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
    $friendRequest=$this->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');

    if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
    {
      $account='private';
    }
    else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
    {
      $account='private';
    }


    if($_SESSION['loginUser'][0]===$friendId[1])
    {
      return $this->getTimelineVideos();
    }

    
    if(is_array($friendId) AND isset($friendId[1]))
    {
      $id=encryption('decrypt',$friendId[1]);
      if($id!=false)
      {
        $allVideos=$this->mlPost->getVideos($id);

        if(isset($allVideos) AND $allVideos!=false AND $allVideos!='empty' AND $account==null AND $account!='private' )
        {
          $html=[];
          foreach ($allVideos as $key => $value) 
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
            if($type1==$value['post_status'] OR $type2==$value['post_status'])
            {
              $id=md5(random_bytes(8));
              $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
              $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
              $html[].="<li title='Click And View the Post'>
                    <div class='img-wrapper' data-toggle='modal' data-target='.$id' >
                      <video style='border:2px solid black'> 
                            <source src='$path' type='".$value['post_file_type']."'> 
                        </video>
                    </div>

                   <div class='modal fade $id' tabindex='-1' role='dialog' aria-hidden='true'>
                      <div class='modal-dialog modal-lg timeline_ablum'>
                      <a href='".$post_id."' type='button' class='btn btn-default btn-lg btn-block' style='background-color:black;color:white'>View Post</a>
                        <div class='modal-content'>
                          <video  class='post-video stylish_player' controls style='height: 500px'> 
                             <source src='$path' type='".$value['post_file_type']."'> 
                        </video>

                        </div>
                      </div>
                    </div>
                  </li>";
            }
          }

          if(isset($html) AND is_array($html) AND !empty($html))
          {
           $val=implode(" ",$html);
           return MsgDisplay('success',$val,'');
          }
          else
          {
            return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Not Upload Any Videos.....!</p>",'');
          }
        }
        else
        {
          return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Not Upload Any Videos.....!</p>",'');
        }
      }
    }

  }

  public function getTimelineAlbumFriend()
  {

    $account=null;
    $userData=$this->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
    $friendId=explode('94039',$_POST['url']);
    if(is_array($friendId) AND isset($friendId[1]))
    {
      $id=encryption('decrypt', $friendId[1]);
      if($id!=false)
      {
         $friendRequest=$this->checkFriendRequest($friendId[1],$_SESSION['loginUser'][0],'getdata');
         $allPicture=$this->mlPost->getAlbum($id);
      }
    }

    if($allPicture=='empty')
    {
     return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#' class='close' data-dismiss='alert' style='color:black'>&times;</a>Album is Empty.....!</p>",'');
    }

    if ($userData['account_type']=='private' AND !is_array($friendRequest) ) 
    {
      $account='private';
    }
    else if($userData['account_type']=='private' AND $friendRequest['request']=='send')
    {
      $account='private';
    }

    if(isset($allPicture) AND $allPicture!=false AND $account==null AND $account!='private')
    {
      $html=[];
      foreach ($allPicture as $key => $value) 
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


        if($type1==$value['post_status'] OR $type2==$value['post_status'])
        {
          $id=md5(random_bytes(8));
          $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
          $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
          $html[].="<li>
                <div class='img-wrapper' data-toggle='modal' data-target='.$id'>
                  <img src='$path' style='border:2px solid black'  alt='photo' />
                </div>
                <div class='modal fade $id' tabindex='-1' role='dialog' aria-hidden='true'>
                  <div class='modal-dialog modal-lg timeline_ablum'>
                    <div class='modal-content'>
                      <a href='$post_id'> <img src='$path' class='img-thumbnail' alt='photo' /></a>
                    </div>
                  </div>
                </div>
              </li>";
        }
      }

      if(isset($html) AND is_array($html) AND !empty($html))
      {
       $val=implode(" ",$html);
       return MsgDisplay('success',$val,'');
      }
      else
      {
         return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#' class='close' data-dismiss='alert' style='color:black'>&times;</a>Album is Empty.....!</p>",'');
      }
    }
  }


	public function getTimelineAlbum()
	{
    $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		$allPicture=$this->mlPost->getAlbum($user_id);


    if($allPicture=='empty')
    {
     return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#' class='close' data-dismiss='alert' style='color:black'>&times;</a>Album is Empty.....!</p>",'');
    }

    if(isset($allPicture) AND is_array($allPicture))
    {
      $html=[];
      foreach ($allPicture as $key => $value) 
      {
        $id=md5(random_bytes(8));
        $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);

        $path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
          $html[].="<li title='Click And View the Post'>
                <div class='img-wrapper' data-toggle='modal' data-target='.$id' >
                  <img src='$path' style='border:2px solid black'  alt='photo' />
                </div>
                <div class='modal fade $id' tabindex='-1' role='dialog' aria-hidden='true'>
                  <div class='modal-dialog modal-lg timeline_ablum'>
                    <div class='modal-content'>
                     <a href='$post_id'><img src='$path' class='img-thumbnail' alt='photo'  /></a>
                    </div>
                  </div>
                </div>
              </li>";
      }
    }

    if(isset($html) AND is_array($html) AND !empty($html))
    {
     $val=implode(" ",$html);
     return MsgDisplay('success',$val,'');
    }
    
	}

	public function insertNotification($type,$postId)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		return $this->mlPost->notification($type,$postId);
	}


	public function getComments()
	{
		if(isset($_POST['post_id']))
		{
			$post_id=encryption('decrypt',$_POST['post_id']);
			if($post_id!=false)
			{
				$postComments=$this->DisplayPostComment($_POST['post_id']);
				$post_detail=$this->mlPost->postExist($_POST['post_id'],'details');
				$msg='';
        if(is_array($postComments))
        {
        	$userId=encryption('decrypt',$_SESSION['loginUser'][0]);
          foreach ($postComments as $data) 
          {
          	if($data['user_id']==$userId OR $post_detail['user_id']==$userId)
          	{
          		$delete_id=encryption('encrypt',$data['id']);

          		$delBtn="&nbsp;&nbsp;
              <button type='button' title='Delete this Comment' data-toggle='modal' data-target='.delete_comment' class='btn btn-default btn-xs' onclick='delete_comment_myPost(this)' delete_id='$delete_id'><span class='glyphicon glyphicon-trash'></<span></button>
               ";
          	}
          	else
          	{
          		$delBtn='';
          	}

            $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$data['user_id']);
            $image=BASEURL.'/public/assets/images/users/'.encryption('decrypt',$data['image']);
            $comments=htmlspecialchars(encryption('decrypt',$data['comment']));


            $html[]="
              <div class='post-comment'>
                <img src='$image' alt='profile_image' onclick='imageView(this)' class='profile-photo-sm' />
                <p><a href='".$profile_id."' class='profile-link'>". ucwords(htmlspecialchars($data['name']))."</a>
                  $comments
                  $delBtn
             </div>";
          }
        }
        else if($postComments=='error')
        {
          $msg='<div class="alert alert-danger alert-dismissable text-center">
             <a href="#" class="close" data-dismiss="alert">×</a>
             <p>Something was wrong please refersh web page....!</p></div>';
        }
        else
        {
          $msg=='<div class="alert alert-danger alert-dismissable text-center">
           <a href="#" class="close" data-dismiss="alert">×</a>
           <p>'.$postComments.'</p></div>';
        }

        $html[]="<br><div class='comment_errors'>".$msg."</div>";

        return MsgDisplay('success',$html,'');
			}
		}
	}


  public function verificationHistory()
  {
    if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
    {
      return $this->mlUser->verificationHistory();
    }
  }

	public function getActivity()
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_POST['url']))
		{
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];
			$friendId=explode('94039',$_POST['url']);
			if(is_array($friendId) AND isset($friendId[1]))
			{
			  $id=encryption('decrypt', $friendId[1]);
			  if($id!=false)
			  {
			  	$user_id=$id;
			  }
			}
			else
			{
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			}

		if(isset($user_id))
		{
			$response=$this->mlPost->getActivityLog($user_id);

			if($user_id==encryption('decrypt',$_SESSION['loginUser'][0]))
			{
				if(is_array($response))
			  {
			  	$data=$response;
			  }
			  else
			  {
			  	return MsgDisplay('error','<center><b>Activity is Empty....!</b></center>','');
			  }
			}
			else
			{
				if(is_array($response))
				{

					foreach ($response as $key => $value) 
					{
						$user_id=encryption('encrypt',$value['user_id']);
						$post_user_id=encryption('encrypt',$value['post_user_id']);

						$friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],$post_user_id,'getdata');

						$post_id=encryption('encrypt',$value['post_id']);
						$post_detail=$this->mlPost->postExist($post_id,'details');
						$decryptPost=$this->mlPost->decryptData($post_detail);

						$userData=$this->getUserInfo('id',encryption('decrypt',$_SESSION['loginUser'][0]));
						$postUserData=$this->getUserInfo('id',encryption('decrypt',$post_user_id));

				   	$checkfriend=$this->checkFriendRequest($user_id,$post_user_id,'getdata');
             


						if(is_array($friendRequest) AND is_array($post_detail))
						{
							if($friendRequest['request']=='friend' AND $decryptPost['post_status']=='public' OR $decryptPost['post_status']=='friend')
							{
								$data[]=$value;
							}
							else if ($decryptPost['post_status']=='public' AND $friendRequest['request']=='send' AND $postUserData['account_type']!='private')
							{
								$data[]=$value;
							}
							else if(is_array($checkfriend))
							{
								if($checkfriend['request']=='friend' AND $friendRequest['request']=='friend')
								{
										$data[]=$value;
								}
							}

						}
						else
						{
							if($decryptPost['post_status']=='public' AND $postUserData['account_type']!='private')
							{
								$data[]=$value;
							}
						}
					}
				}
				else
				{
					return MsgDisplay('error','<center><b>Activity is Empty....!</b></center>','');
				}
		  }
			


			if(isset($data) AND is_array($data))
			{
				$html=[];
				foreach ($data as $key => $value) 
			  {
			  	$userData=$this->getUserInfo('id',$value['user_id']);
			    $friend=encryption('encrypt',$value['post_user_id']);
			    $friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],$friend,'getdata');
			      if(is_array($friendRequest))
			      {
			        if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
			        {
			           continue;
			        }
			      }


			      $postUserInfo=$this->getUserInfo('id',$value['post_user_id']);
			      $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['user_id']);
			      $post_id=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['post_id']);
			      $time=TimeAgo($value['notif_date'],$this->current_time(),'Message');


			      if($value['notif_type']=='comment' OR $value['notif_type']=='like' OR $value['notif_type']=='dislike')
			      {
			        $text="post";
			      }
			      else if(!empty($value['post_file_name']))
			      {
		          if($value['notif_type']=='coverPicChange')
		          {
		            $text="coverPicChange";
		          }
		          else if($value['notif_type']=='profilePicChange')
		          {
		            $text="profilePicChange";
		          }
		          else
		          {
		            if(!empty($value['post_file_name']))
		            {
		              $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');
		              $audio_type=array('mp3','MP3','WMA','wma');             
		              $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');
		              $exp=explode(".", $value['post_file_name']);
		              $type_file=end($exp);

		              if (in_array($type_file,$video_type)) 
		              {
		                $text="video";
		              }
		              else if (in_array($type_file,$image_type)) 
		              {
		                $text="image";
		              }
		              else if(in_array($type_file,$audio_type))
		              {
		                $text="audio";
		              }
		            }
		          }
			      }
			      else if(!empty($value['post_text']) AND empty($value['post_file_name']) AND $value['notif_type']=='insertPost')
			      {
			        $text="post";
			      }

			      if(isset($text))
			      {
			        $html[].='<div class="feed-item">
			              <div class="live-activity">';
			        if($value['user_id']==$value['post_user_id'])
			        {
			          if($text=='coverPicChange')
			          {
			            $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> change has <a href="'.$post_id.'" class="profile-link">cover picture</a></p>';
			          }
			          else if($text=='profilePicChange')
			          {
			            $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> change has <a href="'.$post_id.'" class="profile-link">profile picture</a></p>';
			          }
			          else if($text=='post')
			          {
			            if($value['notif_type']=='insertPost' AND !empty($value['post_file_name']))
			            {
			              $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> added a new <a href="'.$post_id.'" class="profile-link">'.$text.'</a></p>';
			            }
			            else if($value['notif_type']=='insertPost' AND empty($value['post_file_name']))
			            {
			              $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> create a <a href="'.$post_id.'" class="profile-link">new post</a></p>';
			            }
			            else if($value['notif_type']=='comment')
			            {
			              $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> comment on a <a href="'.$post_id.'" class="profile-link">post</a></p>';
			            }
			          }
			          else if($text=='image' OR $text=='video' OR $text=='audio')
			          {
			            $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).' </a> added a new <a href="'.$post_id.'" class="profile-link">'.$text.'</a></p>';
			          }
			          
			        }
			        else if($value['user_id']!=$value['post_user_id'])
			        {
			          $friend_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$postUserInfo['id']);
			          $html[].='<p><a href="'.$profile_id.'" class="profile-link">'.ucwords(htmlspecialchars($userData['name'])).'</a> '.$value['notif_type'].' on '.'<a href="'.$friend_id.'" class="profile-link">'.ucwords(htmlspecialchars($postUserInfo['name'])).'</a> <a href="'.$post_id.'" class="profile-link"> '.$text.'</a></p>';
			        }
			        $html[].=' <p class="text-muted">'.$time.'</p></div></div>';

			        $text='';
			      }
			    }
				}

				if(isset($html) AND is_array($html) AND !empty($html))
				{
	       $val=implode(" ",$html);
	       return MsgDisplay('success',$val,'');
				}
        else
        {
          return MsgDisplay('error','<center><b>Activity is Empty....!</b></center>','');
        }
			}
		}	
				
	}


  public function viewAccountWarning($type=null)
  {
    if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
    {
      $response=$this->mlUser->getAccountWarning();

      if($type=='total' AND $response!=false)
      {
        return sizeof($response);
      }
      else
      {
        if(is_array($response))
        {
          $html=[];
          $total=count($response);

          $html[].='<div class="complaintHistory">
                <br><br><center><h3 class="heading">Account Warning Details</h3></center><br>
                <div class="panel-group" id="accordion1">';

          foreach ($response as $key => $value) 
          {

            if($value['complaint_type']=='postComplaint')
            {
              $getPostID=$this->mlUser->getPostComplaint('complaintID',$value['complaint_id']);


              if(is_array($getPostID))
              {
                $complaintData=$this->mlUser->getPostComplaint('postID',$getPostID['post_id']);
                $postData=$this->mlPost->getDeletePost($getPostID['post_id']);
                $complaint="POST COMPLAINT";

                if(is_array($postData))
                {
                  if(!empty($postData['post_file_name']))
                  {
                      $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

                      $audio_type=array('mp3','MP3','WMA','wma');
                                       
                      $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

                      $exp=explode(".", $postData['post_file_name']);
                      $type_file=end($exp);

                      if(in_array($type_file,$video_type)) 
                      {
                        $File="<p>Upload Video</p>";
                      }
                      else if (in_array($type_file,$image_type)) 
                      {
                        $File="<p>Upload Image</p>";
                      }
                      else if(in_array($type_file,$audio_type))
                      {
                          $File="<p>Upload Audio</p>";
                      }
                  }
                  else
                  {
                    $File='';
                  }

                  if (!empty($value['post_text'])) 
                  {
                    $post= "<p><i class='em em-thumbsup'>Post Text:- </i><br>
                    <b class='post_span post-text'>".htmlspecialchars($postData['post_text'])."</b></p>";
                  }
                  else
                  {
                    $post='';
                  }

                  $time="<b>Post Date </b><br>".formatDate($postData['post_date']);

                  $postDetail="<b>Post Detail</b><br>".$File.$post.$time;
                }
              }
              
            }
            else if($value['complaint_type']=='profileComplaint')
            {
              $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
              $complaintData=$this->mlUser->getProfileComplaint('usereID',$userId);
              $complaint="ACCOUNT COMPLAINT";
              $postDetail='';
            }


            if($complaintData[0]['admin_action']=='deletePost')
            {
                $badge="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
            }
            else if($complaintData[0]['admin_action']=='reject')
            {
                $badge="<span class='badge' style='background:#9097c4'>Reject Complaint</span>";
            }
            else if($complaintData[0]['admin_action']=='Null')
            {
                $badge="<span class='badge' style='background:#FF33FC'>Pending Complaint</span>";
            }
            else if($complaintData[0]['admin_action']=='warning')
            {
                $badge="<span class='badge' style='background:#FF9C33'>Warning</span>";
            }
            else if($complaintData[0]['admin_action']=='securityVerification')
            {
                $badge="<span class='badge' style='background:#464a53'>Security Verification</span>";
            }


            $target="#".$total;

              $html[].='
               <div class="panel panel">
                 <div class="panel-heading">
                   <h4 class="panel-title">
                     <a href="'.$target.'" data-parent="#accordion1" data-toggle="collapse"><h4>Complaint No '.$total.' &nbsp;&nbsp;&nbsp;&nbsp;'.$badge.'</h4></a>
                   </h4>
                 </div>

                 <div id="'.$total.'" class="panel-collapse collapse">
                 <div class="container-fluid">
                    <center><h3>'.$complaint.'</h3></center>
                    <b>User Complaints</b><br><br>';
                  foreach ($complaintData as $key => $data) 
                  {       
                     if(isset($data['post_file_name']))
                     {
                      $adminMsg=ucfirst(htmlspecialchars($data['adminMsg']));
                     }
                     else
                     {
                        $adminMsg=ucfirst(htmlspecialchars($data['admin_msg'])); 
                     }

                    $no=(int)$key+1;
                    $html[].='<p><b>User No '.$no.'&nbsp;&nbsp;</b> :- '.ucfirst(htmlspecialchars($data['complaint'])).'</p>';
                  }

                  $html[].=$postDetail.'<br><b>Admin Reply:- </b><br><p>'.$adminMsg.'</p>
                </div><hr>
               </div>
            </div>
          </div>
         </div>';

              $total--;
              
          }
           if(isset($html) AND is_array($html) AND !empty($html))
           {
             $val=implode(" ",$html);
             return $val;
           }
         }
      }
    }

    return false;
  }



}

?>