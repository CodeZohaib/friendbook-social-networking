<?php
include "controllerTrait.php";
include "pageLoadTrait.php";
class page extends framework{
	use controllerTrait,pageLoadTrait;


	public function index()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	        $data=$this->mlUser->getUser('email',$_SESSION['loginUser'][1]);

	        if($data['status']=='securityVerification')
	        {
	             $_SESSION['confirm_email']=[
	                $data['name'],
	                $data['email'],
	                $data['image'],
	              ];
	              unset($_SESSION['loginUser']);

	              $this->redirect('users/emailConfirmation');
	        }
	        else
	        {
	           $this->redirect('page/newsfeed');
	        }
	        
	    } 
	}

	public function getUserFriendRequest()
	{
		$response=$this->mlFriendRequest->getAllFriendRequest();

		return $response;
	}

	public function displayBlockUser()
	{
		$response=$this->mlFriendRequest->displayBlockUser();

		if($response!=false)
		{
			if(is_array($response) AND !empty($response))
			{
				return $response;
			}
		}
	}


	public function sidebarOnlineUser()
	{
		$response=$this->mlUser->sidebarOnlineUser();
		if(is_array($response))
		{
			$html=[];
			foreach ($response as $key => $row)
			{
				if($row['online_status']=='true')
				{
				  $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$row['user_id']);
				  $profile_img= BASEURL.'/public/assets/images/users/'.$row['image'];
				   $html[].="<li>
				          <a href='$profile_id' title='".ucwords($row['name'])."'>
				            <img src='$profile_img' alt='user' class='img-responsive profile-photo' />
				            <span class='online-dot'></span>
				          </a>
				        </li>";
				}
			}

		  if(isset($html) AND is_array($html) AND !empty($html))
	      {
	        $val=implode(" ",$html);
	        return MsgDisplay('success',$val,'');
	      }
		}
		else if($response=='empty')
		{
			return MsgDisplay('error','<b class="alert alert-danger">No User Online</b>','');
		}
	}


	public function getNotification()
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']))
		{
			$response=$this->mlPost->notification();

			if(is_array($response))
			{
				$html=[];
				foreach ($response as $key => $value) 
				{
				    $userID=encryption('decrypt',$_SESSION['loginUser'][0]); 	
					$friend=encryption('encrypt',$value['user_id']);
					$friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],$friend,'getdata');
					$followCheck=$this->GetfollowData($userID,$value['user_id'],'check');
					$userData=$this->getUserInfo('id',$value['user_id']);

					
					if(is_array($friendRequest) AND !is_array($followCheck))
					{
					    if($value['notif_date'] > $friendRequest['updated_at'])
					    {
							if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
							{
								continue;
							}
							else if($friendRequest['request']=='send' AND $userData['account_type']=='private')
							{
								continue;
							}
							else if($friendRequest['request']=='send' AND $userData['account_type']=='public')
							{
								continue;
							}
						}
						else
						{
							continue;
						}
					}
					else if(!is_array($friendRequest) AND is_array($followCheck))
					{
						$postID=encryption('encrypt',$value['post_id']);
						$postDetail=$this->decryptData($this->mlPost->postExist($postID,'details'));

						if($value['user_id']==$value['post_user_id'] OR $value['post_user_id']==$userID)
						{
							if($followCheck['date_time'] < $value['notif_date'])
							{
								if($userData['account_type']=='private')
								{
									continue;
								}
								
								if($postDetail['post_status']!='public')
								{
									continue;
								}
							}
							else
							{
								continue;
							}
					     }
					     else
					     {
					     	   continue;
					     }	
					}
					else if(is_array($friendRequest) AND is_array($followCheck))
					{
					    if($value['notif_date'] > $friendRequest['updated_at'] AND $value['notif_date'] < $followCheck['date_time'])
					    {
							continue;
						}
						else if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
						{
							continue;
						}
						else if($friendRequest['request']=='send' AND $userData['account_type']=='private')
						{
							continue;
						}
						
					}
					else
					{
						if($value['post_user_id']!=$userID)
						{
							continue;
						}
					}

					if($value['notif_type']=='comment' AND $value['user_id']==$value['post_user_id'])
					{
						continue;
					}
					else if($value['notif_type']=='profilePicChange' AND $userID==$value['post_user_id'])
					{
						continue;
					}
					else if($value['notif_type']=='coverPicChange' AND $userID==$value['post_user_id'])
					{
						continue;
					}
					else if($value['notif_type']=='insertPost' AND $userID==$value['post_user_id'])
					{
						continue;
					}


				   if (!empty($value['post_file_name'])) 
				   {
				   	 $video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');

					   $audio_type=array('mp3','MP3','WMA','wma');
															   
					   $image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

					   $exp=explode(".", $value['post_file_name']);

					   $type=end($exp);


					    
					    if (in_array($type,$video_type)) 
					    {
					   	  $text_show="Video";
					    }
					    else if (in_array($type,$image_type)) 
					    {
					   	  $text_show="Image";
					    }
					    else if(in_array($type,$audio_type))
					    {
			                  $text_show="Audio";
					    }

				    }
				    else
				    {
				    	if ($value['post_text']!='NULL') 
						{
							if (strlen($value['post_text'])>21) 
							{
								$text_show="Post <span class='text-danger'>".substr($value['post_text'], 0,21)."...</span>";
							}
							else
							{
								$text_show="Post <span class='text-danger'>".$value['post_text']."</span>";
							}
		
						}
				    }

				   if ($value['notif_type']=='comment') 
				   {
				   	 $type='Commented on your';
				   }
				   else if ($value['notif_type']=='like') 
				   {
				   	 $type='Liked on your';
				   }
				   else if ($value['notif_type']=='dislike') 
				   {
				   	 $type='Disliked on your';
				   }
				   else if($value['notif_type']=='insertPost') 
				   {

				   	 if($text_show=='Video')
				   	 {
				   	 	 $type='Upload a new';
				   	 }
				   	 else if($text_show=='Image')
				   	 {
				   	 	$type='Upload a new';
				   	 }
				   	 else if($text_show=='Audio')
				   	 {
				   	 	$type='Upload a new Audio';
				   	 }
				   	 else
				   	 {
				   	 	$type='Created ';
				   	 }
				   	
				   }
				 else if($value['notif_type']=='profilePicChange')
			   	 {
			   	 	$type='Update has ';
			   	 	$text_show='profile picture';
			   	 }
			   	 else if($value['notif_type']=='coverPicChange')
			   	 {
			   	 	$type='Update has ';
			   	 	$text_show='cover picture';
			   	 }

				  if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
		          {
		            $badge=" <span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px'></span>";
		          }
		          else
		          {
		          	$badge='';
		          }

		          $profile_img= BASEURL.'/public/assets/images/users/'.$userData['image'];
		          $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$value['user_id']);
		          $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['post_id']);
		          $data=$this->mlPost->getPendingNotif($value['post_id'],$value['id']);

		          $notification_id=encryption('encrypt',$value['id']);
		          $post_id=encryption('encrypt',$value['post_id']);

		          if(is_array($data))
		          {
		          	$class='notification_pending';
		          }
		          else
		          {
		          	$class='notification_style';
		          }

		          $time=TimeAgo($value['notif_date'],$this->current_time(),'Message');
                   $title=formatDate($value['notif_date']);

			     	$html[].="
					     <div class='$class' notification_id='$notification_id' post_id='$post_id' onclick='notifClick(this)'>
				                <div class='row'>
				                  <div class='col-md-2 col-sm-2'>
				                    <img src='$profile_img' alt='user' class='profile-photo-lg' />
				                  </div>

				                  <div class='col-md-10 col-sm-10'>
				                    <h5> <a href='$profile_id' class='profile-link'>".ucwords($userData['name'])." $badge</a></h5>
				                    <p>$type <strong style='color:red;text-shadow:2px 2px 2px #8DC63F;'>$text_show</strong></p>
				                    <p class='text-muted' title='$title'>".$time."</p>
				                  </div>

				                </div>
			               </div><br><br>";
			    }

			  if(isset($html) AND is_array($html) AND !empty($html))
		      {
		        $val=implode(" ",$html);
		        echo $val;
		      }
		      else
		      {
		      	return MsgDisplay('error','<div class="alert alert-danger"><center>Notification is Empty.....!</center></div>');
		      }

			}
			else
			{
				return MsgDisplay('error','<div class="alert alert-danger"><center>Notification is Empty.....!</center></div>');
			}

		}
	}
}

?>