<?php

include "controllerTrait.php";

class post extends framework{
	use controllerTrait;

	public function insertPost()
	{
		if(!isset($_SESSION['loginUser']) AND empty($_SESSION['loginUser']))
        {
        	$this->redirect();
        }
        else
        {
        	if (empty($_POST['texts']) AND empty($_FILES['image']['name']))
			{
				return MsgDialog('error','Post Create Error','Empty Post Not Upload......!<br>1 => Type your Post<br>2 => Upload Image<br>3 => Upload Video<br>4 => Upload Audio','');
			}
			else
			{
				$response=$this->mlPost->insertPost();
				if($response=='success')
				{
			        return MsgDisplay('refersh','Post Create Successfully....!','');
				}
				else if($response=='wrong_file_type')
				{
					return MsgDialog('error','Post Create Error','Post file type is invalid.....!<br> Audio Video Image file is allow','');
				}
				else
				{
					return MsgDialog('error','Post Create Error','Something was wrong please try again....!','');
				}
			}
        }
		
	}

	public function postUpdate()
	{
		if(isset($_POST['post_privacy']) AND isset($_POST['post_id']))
		{
		   $response=$this->mlPost->postUpdate();

		  if($response=='error')
		  {
		  	return MsgDialog('error','Post Privacy Error','Something was wrong please try again...!','');
		  }
		  else if($response=='success')
		  {
		  	return MsgDialog('success','Post Privacy Change','Post Privacy Change Successfully...!','');
		  }
		}
	}

	public function deletePostComment()
	{
		if(isset($_POST['comment_id']))
		{
			if(encryption('decrypt',$_POST['comment_id'])==true)
			{
				$comment_id=encryption('decrypt',$_POST['comment_id']);
			}
			else
			{
			    $explode1=@explode("9943",$_POST['comment_id']);
	            $explode2=@explode("227", $explode1[1]);
	            $comment_id=@$explode2[0];
			}
			if(isset($comment_id) AND !empty($comment_id))
			{
				$response=$this->mlPost->deleteComment($comment_id);
				if($response=='success')
				{
					return MsgDisplay('refersh','Comment Deleted Successfully.....!','');
				}
				else
				{
					return MsgDisplay('error','Comment Not Deleted Something Was Problem.....!','');
				}
			}
		}
	}

	public function postDelete()
	{
		if(isset($_POST['delete_id']))
		{
			$response=$this->mlPost->postDelete();
			sleep(1);
			if($response=='success')
			{
				return MsgDisplay('success','Your Post Deleted Successfully....!','');
			}
			else
			{
			    return MsgDisplay('error','Something Was Wrong Please Try Again....!','');
			}
		}
	}

	public function postLike()
	{
		if(isset($_POST))
		{
			$post_id=encryption('decrypt',$_POST['post_id']);
			$post_user_id=encryption('decrypt',$_POST['post_user_id']);
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

			$RequestCheck=$this->mlFriendRequest->friendRequestCheck($post_user_id,$user_id,'getdata');
			$post_user=$this->mlFriendRequest->getUser('id',$post_user_id);
			$post_detail=$this->mlPost->postExist($_POST['post_id'],'details');

            if($post_detail!=false)
            {
            	if($post_detail['user_id']!=$user_id)
            	{
	            	if($RequestCheck!=false AND is_array($RequestCheck))
					{ 
						if($RequestCheck['request']=='friend' AND $post_user['account_type']=='private' OR $RequestCheck['request']=='friend' AND $post_user['account_type']=='public' OR $post_user['account_type']=='public' AND encryption('decrypt',$post_detail['post_status'])=='public' AND $RequestCheck['request']=='send')
						{		
							$response=[];
							$action=$this->mlPost->post_update_likes();
							$total=$this->mlPost->total_like_dislike($post_id);
						  
						    if(is_array($total))
						    {
						    	$response['action']=$action;
							    $response['likes']=$total['likes'];
							    $response['dislikes']=$total['dislikes'];
						    }
						    else
						    {
						    	 $response['action']=$action;
							     $response['likes']=0;
							     $response['dislikes']=0;
						    }

						    echo json_encode([
					            'success'=>'success',
					            'action'=>$response['action'],
					            'likes'=>$response['likes'],
					            'dislikes'=>$response['dislikes'],
					        ]);    
						}
						else if($RequestCheck['request']=='block')
						{
							return MsgDisplay('error','Block User Post Not Like.....!','');
						}
					}
					else if($RequestCheck==false AND $post_user['account_type']=='public' AND encryption('decrypt',$post_detail['post_status'])=='public')
					{
						    $response=[];
							$action=$this->mlPost->post_update_likes();
							$total=$this->mlPost->total_like_dislike($post_id);
							if(is_array($total))
						    {
						    	$response['action']=$action;
							    $response['likes']=$total['likes'];
							    $response['dislikes']=$total['dislikes'];
						    }
						    else
						    {
						    	 $response['action']=$action;
							     $response['likes']=0;
							     $response['dislikes']=0;
						    }

						   echo json_encode([
					            'success'=>'success',
					            'action'=>$response['action'],
					            'likes'=>$response['likes'],
					            'dislikes'=>$response['dislikes'],
					        ]);    
					}
				}
            }
			
		}
		
	}

	public function displayLikesDislikes()
	{
		if(isset($_POST['post_id']) AND isset($_POST['post_user_id']))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$post_id=encryption('decrypt',$_POST['post_id']);
			$post_user_id=encryption('decrypt',$_POST['post_user_id']);
			$post_user=$this->mlFriendRequest->getUser('id',$post_user_id);
			$post_detail=$this->mlPost->postExist($_POST['post_id'],'details');

			
			if($post_detail!=false)
			{
				if($post_detail['user_id']==$user_id)
				{
					$response=$this->mlPost->getLikeDislike($post_id,$_POST['type']);
				}
				else
				{
				   $RequestCheck=$this->mlFriendRequest->friendRequestCheck($post_user_id,$user_id,'getdata');

				    if($post_detail!=false)
		            {
		            	if($RequestCheck!=false AND is_array($RequestCheck))
						{
							if($RequestCheck['request']=='friend' AND $post_user['account_type']=='private' OR $RequestCheck['request']=='friend' AND $post_user['account_type']=='public' OR $RequestCheck['request']=='send' AND $post_user['account_type']=='public')
							{
								$response=$this->mlPost->getLikeDislike($post_id,$_POST['type']);
							}
							else if($RequestCheck['request']=='block')
							{
								return MsgDisplay('error','Block User Post Not Like.....!','');
							}
						}
						else if($RequestCheck==false AND $post_user['account_type']=='public' AND encryption('decrypt',$post_detail['post_status'])=='public')
						{
							  $response=$this->mlPost->getLikeDislike($post_id,$_POST['type']);
						}
						else
						{
							$msg="<p class='alert alert-danger text-center'>Private Account Not View Any Details.....!</p>";
						}
					}
				}

				if(isset($response) AND $response!=false AND is_array($response) AND !isset($msg))
				{
					foreach ($response as $key => $value) 
					{
						
						if ($value['bluetick']=='yes') 
						{
							$badge=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
						}
						else
						{
							$badge='';
						}

				    	$flag=strtolower(countryName_to_code($value['country']));

				    	$profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['id']);

				    	$image=BASEURL."/public/assets/images/users/".$value['image'];
						echo "<div style='margin-bottom:20px'>
					            <a href='$profile_id' class='profile-link'>
					              <img src='$image' alt='user' class='profile-photo-sm' onclick='imageView(this)' />
					            </a>

					             <a href='$profile_id' class='profile-link'>".htmlspecialchars(ucfirst($value['name']))."$badge</a>

					            <span title='".strtolower($value['country'])."' class='flag-icon flag-icon-$flag' style='border:1px solid black;float:right;margin-top:10px'></span>
					          </div>
					    ";
					}
				}
				else
				{
					if(!isset($msg))
					{
						if($_POST['type']=='view_like')
			    		{
			    			echo "<p class='alert alert-danger text-center'>Zero Like</p>";
			    		}
			    		else
			    		{
			    			echo "<p class='alert alert-danger text-center'>Zero Dislike</p>";
			    		}
					}
					else
					{
						echo $msg;
					}
					
				}
			}
		}
	}


	public function insertPostComment()
	{
		if(!empty($_POST['post_id']))
		{
			if(!empty($_POST['comment']))
			{
				$post_id=encryption('decrypt',$_POST['post_id']);
			    $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

			    $post_detail=$this->mlPost->postExist($_POST['post_id'],'details');
			   
				if($post_id!=false AND $post_detail!=false)
				{
					$RequestCheck=$this->mlFriendRequest->friendRequestCheck($post_detail['user_id'],$user_id,'getdata');

			        $post_user=$this->mlFriendRequest->getUser('id',$post_detail['user_id']);

	            	if($RequestCheck!=false AND is_array($RequestCheck))
					{
						if($RequestCheck['request']=='friend' AND $post_user['account_type']=='private' OR $RequestCheck['request']=='friend' AND $post_user['account_type']=='public')
						{
							$response=$this->mlPost->insertComment($post_id,$_POST['comment']);
						}
						else if($RequestCheck['request']=='block')
						{
							return MsgDisplay('error','Not allow to block user post comment.....!','');
						}
					}
					else if($RequestCheck==false AND $post_user['account_type']=='public' AND encryption('decrypt',$post_detail['post_status'])=='public'  OR $post_user['id']==$user_id)
					{
						    $response=$this->mlPost->insertComment($post_id,$_POST['comment']);
					}
					else
					{
						return MsgDisplay('error','Sorry Not allow to Comment this is Private Post....!','');
					}



					if(isset($response))
					{
						if($response=='success')
						{
							echo json_encode([
			                     'success'=>'success',
			                 ]);
						}
					}
				}
				else
				{

					return MsgDisplay('error','Something Was Wrong Please Try Again....!','');
				}
			}
			else
			{
				return MsgDisplay('error','Please Enter Your Comment','');
			}

		}
		else
		{
			return MsgDisplay('error','Something Was Wrong Please Try Again....!','');
		}
	}


	public function postReport()
	{
		if(isset($_POST['complaint']) AND isset($_FILES['image']) AND !empty($_POST['complaint']) AND !empty($_FILES['image']))
		{
			if(encryption('decrypt',$_POST['post_id'])==true)
			{
				$response=$this->mlPost->ReportPost();

				if(is_array($response) AND !empty($response))
				{
					return MsgDisplay('error',implode(" and ",$response)." File Not Upload...!",'');
				}
				else if($response=='success')
				{
					return MsgDisplay('success',"Post Complaint Added Successfully.....!",'');
				}
				else if ($response=='invalid_post') 
				{
			        return MsgDisplay('error','Invalid Post Complaint....!','');
				}
				else if ($response=='already_complaint') 
				{
					return MsgDisplay('error','Complaint already sent to admin please wait for action....!','');
				}
			}
			else
			{
				return MsgDisplay('error','Something Was Wrong Please Try Again....!','');
			}
		}
	}	

	public function deletePendingNotif()
	{
		if(isset($_POST['class']) AND isset($_POST['postID']) AND isset($_POST['notifID']))
		{
			$response=$this->mlPost->deletePendingNotif();

			if($response==true)
			{
				$link=BASEURL."/timeline/viewPost/94039".$_POST['postID'];
				return MsgDisplay('success',"$link");
			}
			else
			{
				return MsgDisplay('error',"error");
			}
		}
	}


	public function getPendidnggNotif()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
			$response=$this->mlPost->getAllPendingNotif();
			$notificationCount='';
			if(is_array($response))
			{
				
				foreach ($response as $key => $value) 
				{
					$postID=encryption('encrypt',$value['post_id']);
					$postDetail=$this->decryptData($this->mlPost->postExist($postID,'details'));
				    $userID=encryption('decrypt',$_SESSION['loginUser'][0]); 	
					$friend=encryption('encrypt',$postDetail['user_id']);
					$friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],$friend,'getdata');
					$notificationData=$this->mlPost->getNotification($value['notif_id']);
					$postUserData=$this->getUserInfo('id',$postDetail['user_id']);
					$checkFollow=$this->followCheck($postDetail['user_id'],'check');
					$userData=$this->getUserInfo('id',$postDetail['user_id']);

					if(is_array($notificationData))
					{
						$notif_type=encryption('decrypt',$notificationData['notif_type']);
					}
					else
					{
						$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
						continue;
					}	


					if(is_array($friendRequest) AND !is_array($checkFollow))
					{
						if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='send' AND $postUserData['account_type']=='private' AND !is_array($checkFollow))
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='send' AND $userData['account_type']=='private' AND is_array($checkFollow))
						{

							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['updated_at'] > $value['date'])
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						
					}
					else if(!is_array($friendRequest) AND is_array($checkFollow))
					{
                        if($checkFollow['date_time'] > $value['date'])
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						
					}
					else if(is_array($friendRequest) AND is_array($checkFollow))
					{
						if($value['date'] > $friendRequest['updated_at'] AND $value['date'] < $checkFollow['date_time'])
					    {
					    	$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='send' AND $userData['account_type']=='private')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='send' AND $postUserData['account_type']=='private' AND !is_array($checkFollow))
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($friendRequest['request']=='send' AND $userData['account_type']=='private' AND is_array($checkFollow))
						{

							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						
					}
					else
					{

						if($postUserData['account_type']=='private')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($postUserData['account_type']=='private' AND is_array($checkFollow))
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($postUserData['account_type']=='private' AND !is_array($checkFollow))
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($postUserData['account_type']=='public' AND !is_array($checkFollow) AND $value['notif_user_id']!=$userID)
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if($postDetail['post_status']!='public')
						{
							$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							continue;
						}
						else if (is_array($checkFollow)) 
						{
							if($checkFollow['date_time'] > $value['date'])
							{
								$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
							    continue;
							}
							
						}
					}
					
								
					if($value['notif_user_id']==$userID AND $postDetail['user_id']==$userID AND isset($notif_type) AND $notif_type=='insertPost')
					{
						$this->mlPost->deletePendingNotif($value['post_id'],$value['notif_id']);
						continue;
					}

					/*if($value['notif_id']!=92 AND $value['notif_id']!=103 AND $value['notif_id']!=104 AND $value['notif_id']!=105 AND $value['notif_id']!=106 AND $value['notif_id']!=107 AND $value['notif_id']!=110)
					{
						echo $value['notif_id']."<br>";
					}*/
					
	                $notificationCount++;
				}
			}


             return MsgDisplay('success',$notificationCount);
			
		}
	}

	public function deleteAllPedingNotif()
	{
	  if(isset($_POST['url']))
	  {
	  	  $checkUrl = explode('/', $_POST['url']);
	      if(end($checkUrl)=='notification')
	      {
	      	$response=$this->mlPost->deleteAllPedingNotif();
	      	if($response==true)
	      	{
	      		return MsgDisplay('success','success');
	      	}
	      	else if($response=='emptyNotification') 
	      	{
	      		return MsgDialog('error','Pending Notification','Pending Notification is already Empty.....!','');
	      	}
	      	else if ($response==false) 
	      	{
	      		return MsgDialog('error','Pending Notification Error','Something was wrong please refersh your web page....!','');
	      	}
	      }
	  }
	}

	public function allFriendPost()
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_POST['url']))
		{
			$url=explode('/',$_POST['url']);

            if(is_array($url) AND isset($url))
            {
            	if(end($url)=='newsfeed')
            	{
            	   $allPost=$this->mlPost->allFriendPost();
            	}
            	else if(end($url)=='newsfeedAudios')
            	{
            		$allPost=$this->mlPost->getNewsfeedPost('audio/%');
            	}
            	   //check($allPost);
               if(isset($allPost) AND is_array($allPost) AND $allPost!=false)
	           {
	            $html=[];
	            $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
	            $myData=$this->getUserInfo('id',$userId);
	            foreach ($allPost as $key => $value) 
	            {
	               $userData=$this->getUserInfo('id',$value['user_id']);

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
	                $friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],encryption('encrypt',$value['user_id']),'getdata');

	                $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['user_id']);
	                $onlineUser=$this->mlUser->checkUserOnline($value['user_id']);
	                $checkFollow=$this->followCheck($value['user_id'],'check');

	                if(is_array($onlineUser))
					{
					   if($onlineUser['online_status']=='true')
			               {
					      $onlineBadge="<span class='dot'></span>";
					   }
					   else
					   {
					      $onlineBadge='';
					   }

					}
					else
					{
					  $onlineBadge='';
					}

				 if(!is_array($friendRequest))
				 {
				 	if(is_array($checkFollow) AND $value['post_status']==='friend')
				 	{
				 		continue;
				 	}
				 }

				 if(is_array($friendRequest))
				 {
				 	if(is_array($checkFollow) AND $friendRequest['request']=='send' AND $value['post_status']==='friend')
				 	{
				 		continue;
				 	}
				 }			

	              $html[].='<div class="post-content">
	                    '.$File.'
	                    <div class="post-container">
	                      <img src="'.BASEURL.'/public/assets/images/users/'.$userData['image'].'" onclick="imageView(this)" alt="user" class="profile-photo-md pull-left" onclick="imageView(this)" />
	                      
	                      <div class="post-detail">
	                        <div class="user-info">
	                          <h5><a href="'.$profile_id.'" class="profile-link">'.ucwords($userData['name']).' '.$onlineBadge.' </a> '.$bluetick.' <span class="following">';
	                        
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
	                                $html[].="following";
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
	                                      <img src='$image' alt='profile_image' class='profile-photo-sm'onclick='imageView(this)' />
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
	                                  <img src='".BASEURL.'/public/assets/images/users/'.$myData['image']."' onclick='imageView(this)' class='profile-photo-sm' />

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
	              return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Friends Post.......!</p>",'');
	          }
            	
            }
		}
	}


	public function getNewsfeedPost()
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_POST['url']))
		{
			$url=explode('/',$_POST['url']);
            if(is_array($url) AND isset($url))
            {
            	if(end($url)=='newsfeedImages')
            	{
            		$type='image/%';
            	}
            	else if(end($url)=='newsfeedVideos')
            	{
            		$type='video/%';
            	}
            	else
            	{
            		$this->redirect('page/newsfeed');
            	}

            	if(isset($type) AND !empty($type))
            	{
            		$response=$this->mlPost->getNewsfeedPost($type);
            		//check($response);
					if(is_array($response))
					{
						$html=[];
						$user_id=$_SESSION['loginUser'][0];
			            $myData=$this->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
						foreach ($response as $key => $value) 
						{
							$response_likes=$this->check_like($value['id']);
							$LikeDislike=$this->mlPost->total_like_dislike($value['id']);
							
							$path= BASEURL.'/public/assets/user_post_files/'.$value['post_file_name'];
							$post_id=encryption('encrypt',$value['id']);
							$profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['user_id']);
							$postLink=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);
							$onlineUser=$this->mlUser->checkUserOnline($value['user_id']);
							$friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],encryption('encrypt',$value['user_id']),'getdata');
                            $checkFollow=$this->followCheck($value['user_id'],'check');

							if(end($url)=='newsfeedImages')
			            	{
			            		$post='<a href="'.$postLink.'" class="postImg"><img src="'.$path.'" alt="" class="img-responsive post-image" /></a>';
			            	}
			            	else if(end($url)=='newsfeedVideos')
			            	{
			            		$post='<video controls class="video">
		                         <source src="'.$path.'" type="'.$value['post_file_type'].'">
		                        </video>';
			            	}
			            	else
			            	{
			            		$this->redirect('page/newsfeed');
			            	}


			            	if ($value['bluetick']=='yes') 
							{
								$badge=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
							}
							else
							{
								$badge='';
							}

			                if(is_array($onlineUser))
							{
							   if($onlineUser['online_status']=='true')
					               {
							      $onlineBadge="<span class='dot'></span>";
							   }
							   else
							   {
							      $onlineBadge='';
							   }

							}
							else
							{
							  $onlineBadge='';
							}

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

				             if(!is_array($friendRequest))
							 {
							 	if(is_array($checkFollow) AND $value['post_status']==='friend')
							 	{
							 		continue;
							 	}
							 }	

							 if(is_array($friendRequest))
							 {
							 	if(is_array($checkFollow) AND $friendRequest['request']=='send' AND $value['post_status']==='friend')
							 	{
							 		continue;
							 	}
							 }	


							$html[].='<div class="grid-item col-md-6 col-sm-6">
					              <div class="media-grid">
					                <div class="img-wrapper" postLink="'.$postLink.'" onclick="postSelect(this)">
					                  '.$post.'
					                </div>
					                <div class="media-info">
					                 <div class="reaction">
			                              &nbsp;&nbsp;&nbsp;
			                              <a class="btn '.$like_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsup(this)"><i class="icon ion-thumbsup"></i>';


			                            if(empty($LikeDislike['likes']))
			                            {
			                               $html[].="0"; 
			                            }
			                             else
			                            {
			                               $html[].=$LikeDislike['likes']; 
			                            }


			                           $html[].='</a>
			                               &nbsp;&nbsp;&nbsp;&nbsp;
			                              <a class="btn '.$dislike_color.'" post_id="'.$post_id.'" u_id="'.$user_id.'" onclick="thumbsdown(this)"><i class="fa fa-thumbs-down" ></i>';

			                            if(empty($LikeDislike['dislikes']))
			                            {
			                              $html[].="0"; 
			                            }
			                            else
			                            {
			                              $html[].=$LikeDislike['dislikes']; 
			                            }; 

			                          $html[].="</a><br>

			                          <button type='button' data-target='#all_like' data-toggle='modal' class='btn btn-info btn-xs view_like' post_id='".$post_id."' u_id='".$user_id."' onclick='viewlike(this)'>View Likes</button> 

			                             <button type='button' data-target='#all_dislike' data-toggle='modal' class='btn btn-danger btn-xs view_dislike' post_id='".$post_id."' u_id='".$user_id."' onclick='viewdislike(this)'>View Dislikes</button>
			                        </div>";

			                        $image=BASEURL."/public/assets/images/users/".$value['image'];

					            $html[].='<div class="user-info">
					                    <a href="user_profile.php?profile_id='.$profile_id.'" class="profile-link">
					                        <img src="'.$image.'" alt="" class="profile-photo-sm pull-left" onclick="imageView(this)" />
					                    </a>

					                    <div class="user">
					                      <h6><a href="'.$profile_id.'" class="profile-link">'.ucwords($value['name']).'&nbsp&nbsp'.$onlineBadge.'&nbsp&nbsp'.$badge.'</a></h6>
					                      <b class="text-green">'.formatDate($value['post_date']).'</b>
					                    </div>
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
			            	if(end($url)=='newsfeedImages')
			            	{
			            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Image Post.......!</p>",'');
			            	}
			            	else if(end($url)=='newsfeedVideos')
			            	{
			            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Video Post.......!</p>",'');
			            	}
			            	else if(end($url)=='newsfeedAudios')
			            	{
			            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Audio Post.......!</p>",'');
			            	}
			            }
					}
					else
					{
						if(end($url)=='newsfeedImages')
		            	{
		            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Image Post.......!</p>",'');
		            	}
		            	else if(end($url)=='newsfeedVideos')
		            	{
		            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Video Post.......!</p>",'');
		            	}
		            	else if(end($url)=='newsfeedAudios')
		            	{
		            		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Zero Audio Post.......!</p>",'');
		            	}
					}
            	}
            }
	    }

	    return false;
	}


	public function getpostComplaint()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
			if (isset($_POST['post_id'])) 
			{
				$response=$this->mlPost->getpostComplaint();
				if($response==false)
				{
					return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Something Thing Was Wrong Please Try Again.......!</p>",'');
				}
				else if ($response=='invalid_post_id') 
				{
					return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Invalid Post.......!</p>",'');
				}
				else if (is_array($response)) 
				{
					$decryptData=$this->decryptData($response);
					$html=[];
					$total=count($response);
					$html[].='<center><h3 class="heading">Complaint History</h3></center><br><div class="panel-group" id="accordion1">';
					foreach ($decryptData as $key => $value) 
					{
						if($value['admin_action']=='deletePost')
                        {
                        	$class="panel";
                            $badge="<span class='badge' style='background:#ff5e5e'>Delete Post</span>";
                        }
                        else if($value['admin_action']=='reject')
                        {
                        	$class="panel";
                            $badge="<span class='badge' style='background:#464a53'>Reject Complaint</span>";
                        }
                        else if($value['admin_action']=='Null')
                        {
                        	$class="panel-success";
                            $badge="<span class='badge bg-primary'>Pending Complaint</span>";
                        }

                        if(!empty($value['adminMsg']))
                        {
                        	$adminMsg=$value['adminMsg'];
                        }
                        else
                        {
                        	$adminMsg="Please Wait For Admin Action.....";
                        }

                      $target="#".$total;
					  $html[].='
	                    
	                       <div class="panel '.$class.'">
	                         <div class="panel-heading">
	                           <h4 class="panel-title">
	                             <a href="'.$target.'" data-parent="#accordion1" data-toggle="collapse"><h4>Complaint No '.$total.' &nbsp;&nbsp;&nbsp;&nbsp;'.$badge.'</h4></a>
	                           </h4>
	                         </div>

	                         <div id="'.$total.'" class="panel-collapse collapse">
	                            <div class="container-fluid">
	                            <b>Your Message:- </b><p>'.$value['complaint'].'</p>
	                            <b>Your Screenshoot</b><br>
	                        ';
		                        $img_name=explode('940961',$value['post_file_name']);
					  	  	    foreach ($img_name as $key => $image) 
					  	  	    {
					  	  	    	  if(!empty($image))
					  	  	    	  {
					  	  	    	  	$path=BASEURL."/public/assets/post_report/".$image;
					  	  	    		  $html[].='<img src="'.$path.'" width="200px" class="img img-thumbnail image_style" onclick="imageView(this)">';
					  	  	    	  } 
					  	  	    }
	                           $html[].=' <br><br><b>Admin Reply</b>
	                            <p>'.$adminMsg.'</p>
	                          </div><hr>
	                         </div>';

	                    $total--;
	                }
	                $html[].="</div>";
	                if(isset($html) AND is_array($html) AND !empty($html))
		            {
		             $val=implode(" ",$html);
		             return MsgDisplay('success',$val,'');
		            }
		            else
		            {
		              return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Something Thing Was Wrong Please Try Again.......!</p>",'');
		            }

				}
			}
		}
	}

}