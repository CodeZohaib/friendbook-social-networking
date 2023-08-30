<?php

include "controllerTrait.php";

class messages extends framework{
	use controllerTrait;

	public function insertMessage()
	{
		if(!empty($_POST['user_id']) AND isset($_POST['user_id']))
		{
			if(encryption('decrypt',$_POST['user_id'])==true)
			{

				    $friendId=encryption('decrypt', $_POST['user_id']);
	    	    $friendRequest=$request=$this->checkFriendRequest($_SESSION['loginUser'][0],$_POST['user_id'],'getdata');
	    	    $friendUserData=$this->getUserInfo('id',$friendId);
	    	    if(empty($_POST['text']) AND empty($_FILES['files']['type']))
	    	    {
	    	    	return MsgDisplay('error',"Please Enter a Message.......!",'');
	    	    }


	    	    if(is_array($friendUserData))
	    	    {
	    	    	if($friendUserData['status']!='block')
	    	    	{
	    	    		if(is_array($friendRequest))
			    	    {
			    	    	if($friendRequest['request']=='friend')
			    	    	{
										$response=$this->mlMessages->insertMessage();

										if($response=='wrong_file_type')
										{
											return MsgDisplay('error',"Sending File Type Is Invalid.....!<br>Only Send Audio, Video, Image.......!",'');
										}
										else if($response=='not_upload')
										{
											return MsgDisplay('error',"Not Send File Something Was Problem.....!",'');
										}
										else if($response=='success')
										{
											return MsgDisplay('success',"success",'');
										}
			    	    	}
			    	    	else if($friendRequest['request']=='block')
			    	    	{
			    	    		return MsgDisplay('error',"User Block Your Account Cannot Send Messages.......!",'');
			    	    	}
			    	    	else if($friendRequest['request']=='blockUser')
			    	    	{
			    	    		return MsgDisplay('error',"First Unblock him and then send him a message.......!",'');
			    	    	}
			    	    }
			    	    else
			    	    {
			    	    	return MsgDisplay('error',"You are not this user friend only send message to friend.......!",'');
			    	    }
	    	    	}
	    	    	else
	    	    	{
	    	    		return MsgDisplay('error',"Cannot Send a message. Because admin block this user account.......!",'');
	    	    	}
	    	    }
	    	    else
    	    	{
    	    		return MsgDisplay('error',"Cannot Send a message. Because admin block this user account.......!",'');
    	    	}
			}
			else
			{
				return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
			}
		}
		else
		{
			return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
		}	
	}

	public function userTyping()
	{
		if(!empty($_POST['user_id']) AND isset($_POST['typing']))
		{
			if(encryption('decrypt',$_POST['user_id'])==true)
			{
				$friendId=encryption('decrypt', $_POST['user_id']);
	    	$friendRequest=$request=$this->checkFriendRequest($_SESSION['loginUser'][0],$_POST['user_id'],'getdata');
	    	$friendUserData=$this->getUserInfo('id',$friendId);
	    	if(is_array($friendUserData))
  	    {
  	    	if($friendUserData['status']!='block')
  	    	{
  	    		if(is_array($friendRequest))
	    	    {
	    	    	if($friendRequest['request']=='friend')
	    	    	{
	    	    		if($_POST['typing']=='userTyping')
	    	    		{
	    	    			$response=$this->mlMessages->userTypingInsert();;
	    	    		}
	    	    		else if($_POST['typing']=='userStopTyping')
	    	    		{
	    	    			$response=$this->mlMessages->userTypingDelete($_POST['user_id']);
	    	    		}
								
								if($response=='error')
								{
									return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
								}
								else if($response=='success')
								{
									return MsgDisplay('success',"success",'');
								}
							}
						}
					}
					else
  	    	{
  	    		return MsgDisplay('error',"Cannot Send a message. ecause admin block this user account.......!",'');
  	    	}
				}
				else
	    	{
	    		return MsgDisplay('error',"Cannot Send a message. Because admin block this user account.......!",'');
	    	}
	    }
			else
			{
				return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
			}
	  }
	  else
		{
			return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
		}
	}

	public function getAllMessagesList()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	  {
    	$response=$this->mlMessages->getAllMessagesList();
    	if(is_array($response))
    	{
    		return $this->messagesListHTML($response);
    	}
	  }

	    return false;
	}

	public function messagesListHTML($data)
	{
		$html=[];
		$i=1;
		foreach ($data as $key => $value) 
		{
			if ($i==1) 
			{
				$class="class='active'";
			}
			else
			{
				$class='';
			}
			$model_ID="9403961".$value['id']."9943227";
			$user_id=encryption('encrypt',$value['id']);
			$profile_img= BASEURL.'/public/assets/images/users/'.$value['image'];
			$onlineUser=$this->mlUser->checkUserOnline($value['id']);
			$lastMessage=$this->mlMessages->getFriendLastMessage($value['id']);

			if(is_array($lastMessage))
			{
				$smsDate=@$lastMessage[0]['sended_at'];
		    $time=TimeAgo($smsDate,$this->current_time(),'Message');
			}
			else
			{
				$time='';
			}
			
      $totalNotification=$this->mlMessages->getFriendSmsNotification($value['id']);
	   if(!empty($lastMessage[0]['file_type']) AND !empty($lastMessage[0]['file_name']))
     {
     		$video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');
				$audio_type=array('mp3','MP3','WMA','wma');					   
				$image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');
				$exp=explode(".", $lastMessage[0]['file_name']);
	      $type=end($exp);
     }

			if(!empty($lastMessage[0]['message']))
			{
					if (strlen($lastMessage[0]['message'])>21) 
					{
						$sms=substr($lastMessage[0]['message'], 0,21)."......";
					}
					else
					{
						$sms=$lastMessage[0]['message'];
					}
			}
			else if(!empty($lastMessage[0]['file_type']) AND !empty($lastMessage[0]['file_name']) AND empty($lastMessage[0]['message']))
			{
				$path=BASEURL.'/public/assets/sendFileChat/'.$lastMessage[0]['file_name'];
				if (in_array($type,$video_type)) 
				{
					  $sms="Video Send";
					 
				}
				else if (in_array($type,$image_type)) 
				{
					  $sms="Image Send";
				}
				else if(in_array($type,$audio_type))
				{
					$sms="Audio Send";
				}
				else
				{
					$sms='No Message';
				}

			}
			else
			{
				$sms='No Message';
			}

			if(is_array($lastMessage))
			{
				if($lastMessage[0]['message_status']=='userTyping')
				{
					if($lastMessage[0]['user_id']==encryption('decrypt',$user_id))
					{
						$sms='<b style="color:blue">Typing....</b>';
					}
					else
					{
						$sms='';
					}
					
				}
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

			if($totalNotification!=false AND $totalNotification['friendSmsNotification']!=0)
			{
				$totalNotif="<div class='chat-alert' style='margin-bottom:13px'>".$totalNotification['friendSmsNotification']."</div>";
			}
			else
			{
				$totalNotif='';
			}
 
			$html[].="<li $class user_id='".$user_id."'>
                  <a href='' data-target='#".$model_ID."' data-toggle='tab'>
                    <div class='contact'>
                    	<img src='".$profile_img."' alt='Profile Image' class='profile-photo-sm pull-left' />

                    	<div class='msg-preview'>
                    		<h6>".ucfirst(htmlspecialchars($value['name']))."</h6>
                    		<p class='text-muted'>$sms</p>

                    		<button type='button' style='float:right;' data-toggle='modal' data-target='.clearChatBox' class='btn btn-default btn-xs' onclick='deleteAllChat(this)' user_id='".$user_id."'><span class='glyphicon glyphicon-trash'></<span></button>


												<small class='text-muted'><span class='text-primary'>$time</span>
												$onlineBadge
												</small><br>
												$totalNotif

                    	</div>
                    </div>
                  </a>
                </li>";

            $i++;
		}

	  if(isset($html) AND is_array($html) AND !empty($html))
    {
      $val=implode(" ",$html);
      return MsgDisplay('success',$val,'');
    }
	}



	public function selectUserMessages()
	{

		if(isset($_POST['id']) AND empty($_POST['id']))
		{
			$friendId=encryption('encrypt',$this->getMessageListFirst());
		}
		else
		{
			$friendId=$_POST['id'];
		}
		
		if(!empty($friendId))
		{
			
			  $response=$this->mlMessages->selectUserMessages(encryption('decrypt', $friendId));
		
			  if(is_array($response))
			  {
			  	return $this->getMessagesHTML($response);
			  }
			  else
			  {
			  	return MsgDisplay('error',"No Message Send.......!",'');
			  } 
  	  
		}
	}


	private function getMessagesHTML($data)
	{
		$html=[];
		if(is_array($data))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$i=1;
			foreach ($data as $key => $chat) 
			{	

				$User_ID="9403961".$chat['friend_id']."9943227";

				if ($i==1) 
				{
					$class="active";
				}
				else
				{
					$class='';
				}

				$html[].="<div class='tab-pane ".$class."' id='".$User_ID."' >
					  <div class='chat-body'>
					     <ul class='chat-message'>";

					if($chat['friend_id']!=$user_id)
					{
						$class='left';
					}
					else
					{
						$class='right';
					}
					$time=TimeAgo($chat['sended_at'],$this->current_time(),'Message');

					if($chat['seen_status']=='send') 
					{
						$seen="<small class='text-muted'>&nbsp;&nbsp;Not Seen&nbsp;&nbsp;<i class='glyphicon glyphicon-remove'></i></small>";	
					}
					else 
					{
						$seen="<small class='text-muted'>&nbsp;&nbsp;Seen&nbsp;&nbsp;<i class='glyphicon glyphicon-ok'></i></small>";
					}

         if(!empty($chat['file_type']) AND !empty($chat['file_name']))
         {
         		$video_type=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov');
						$audio_type=array('mp3','MP3','WMA','wma');					   
						$image_type=array('jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');
						$exp=explode(".", $chat['file_name']);
			      $type=end($exp);
         }

					
					if(empty($chat['file_type']) AND empty($chat['file_name']) AND !empty($chat['message']))
					{
						if(!empty($chat['message'])) 
						{
							$sms=$chat['message'];
						}
					}
					else if(!empty($chat['file_type']) AND !empty($chat['file_name']) AND empty($chat['message']))
					{
						$path=BASEURL.'/public/assets/sendFileChat/'.$chat['file_name'];
						if (in_array($type,$video_type)) 
						{
							  $sms="<center><button value='".$path."' value2='".$chat['file_type']."' type='button' class='btn btn-info btn-sm chatBoxVideo' onclick='chatBoxMedia(this)'><span class='glyphicon glyphicon-facetime-video'></span></button><center>";
							 
						}
						else if (in_array($type,$image_type)) 
						{
							  $sms='
							  <div class="img-wrapper" onclick="chatImageView(this)">
							    <img src="'.$path.'" class="img-responsive img-thumbnail select-image">
							  </div>';
						}
						else if(in_array($type,$audio_type))
						{

							$sms="<center><button value='".$path."' value2='".$chat['file_type']."' type='button' class='btn btn-info btn-sm chatBoxAudio' onclick='chatBoxMedia(this)'><span class='glyphicon glyphicon-music'></span></button><center>";
						}
						else
						{
							$sms='';
						}

					}
					else if(!empty($chat['file_type']) AND !empty($chat['file_name']) AND !empty($chat['message']))
					{
						$path=BASEURL.'/public/assets/sendFileChat/'.$chat['file_name'];
						$message=htmlspecialchars($chat['message']);

						if (in_array($type,$video_type)) 
						{
							$sms="<center><button value='".$path."' value2='".$chat['file_type']."' type='button' class='btn btn-info btn-sm chatBoxVideo' onclick='chatBoxMedia(this)'><span class='glyphicon glyphicon-facetime-video'></span></button><center><br>".$message;
						}
						else if (in_array($type,$image_type)) 
						{
							  $sms='
							  <div class="img-wrapper" onclick="chatImageView(this)">
							    <img src="'.$path.'" class="img-responsive img-thumbnail select-image" >
							  </div><br>'.$message;
						}
						else if(in_array($type,$audio_type))
						{
						$sms="<center><button value='".$path."' value2='".$chat['file_type']."' type='button' class='btn btn-info btn-sm chatBoxAudio' onclick='chatBoxMedia(this)'><span class='glyphicon glyphicon-music'></span></button><center><br>".$message;
						}
						else
						{
							$sms='';
						}
					}
					else
					{
						$sms='';
					}

					
					$profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$chat['user_id']);
					$profile_img= BASEURL.'/public/assets/images/users/'.$chat['image'];

					if($chat['message_status']=='userTyping')
					{
						if($chat['user_id']!=$user_id)
						{
							$html[].='<center><b style="color:blue;" class="userIsTyping"></b><center>';
						}
					}
					else
					{
						if($chat['user_id']==$user_id)
						{
							$userID=encryption('encrypt',$chat['user_id']);
							$model=".delete_message";
						}
						else
						{
							$userID=encryption('encrypt',$chat['user_id']);
							$model=".delete_friend_message";
						}

						$messageID=encryption('encrypt',$chat['id']);


						$html[].="<li class='".$class."'>
                <img src='".$profile_img."' alt='' class='profile-photo-sm pull-".$class."' />
                <div class='chat-item'>
                  <div class='chat-item-header'>
                    <h5><a href='".$profile_id."'>".htmlspecialchars(ucfirst($chat['name']))."</a></h5>
                    <small class='text-muted'>".$time."</small>
                  </div>
                    ".$sms."<br><br>
		                    <ul class='chat-footer list-inline' style=' border-top:1px dotted #caef8e;'>
		                 
		                 <center><li>$seen <button type='button' style='float:right;' data-toggle='modal' data-target='".$model."' class='btn btn-default btn-xs' onclick='delete_message(this)' user_id='".$userID."' id='".$messageID."'><span class='glyphicon glyphicon-trash'></<span></button></li></center>
		               </ul>
                </div>
              </li></ul></div></div><br>";
					}
					
			}
		}

	  if(isset($html) AND is_array($html) AND !empty($html))
    {
      $val=implode(" ",$html);
     
      return MsgDisplay('success',$val,'');
    }
		
	}


	public function getAllSmsNotification()
	{
		if(isset($_POST['totalSmsNotification']))
		{
			$response=$this->mlMessages->getTotalSmsNotification();
			if($response!=false)
			{
				return MsgDisplay('success',$response['totalSmsNotification'],'');
			}

			return MsgDisplay('success','','');
		}
	}


	public function userSmsSeen()
	{
		if(isset($_POST['friendID']) AND !empty($_POST['friendID']))
		{
			$friendId=$_POST['friendID'];
		}
		else
		{
			$friendId=encryption('encrypt',$this->getMessageListFirst());
		}

		if(isset($friendId) AND !empty($friendId))
		{
			$response=$this->mlMessages->userSmsSeen($friendId);
			if($response==false)
			{
				return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
			}
			else
			{
				return MsgDisplay('success','success','');
			}
		}
	}

	public function deleteAllChat()
	{
		if(isset($_POST['friendID']))
		{
			if(!empty($_POST['friendID']))
			{
				$friendId=encryption('decrypt',$_POST['friendID']);
				if($friendId!=false)
				{
					$response=$this->mlMessages->deleteAllChat();
					if($response=='success')
					{
						return MsgDisplay('success','Delete All Chat Only for you......!','');
					}
				}
			}
		}

	}


	public function deleteMessage()
	{
		if(isset($_POST['deleteType']))
		{
			if(isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id']))
			{
				$id=encryption('decrypt',$_POST['id']);
				$user_id=encryption('decrypt',$_POST['user_id']);
				if($id!=false AND $user_id!=false)
				{
					$response=$this->mlMessages->deleteMessage();

					if($_POST['deleteType']=='deleteForMe')
					{
						$msg="Message Delete For You Successfully.......!";
					}
					else
					{
						$msg="Message Delete For EveryOne  Successfully.......!";
					}


					if($response=='success')
					{
						return MsgDisplay('success',$msg,'');
					}
					else if($response=='invalidMessage')
					{
						return MsgDisplay('error',"Invalid Message.......!",'');
					}
					else if($response=='already_delete')
					{
						return MsgDisplay('error',"Message Allready Delete.......!",'');
					}
					else if($response==false)
					{
						return MsgDisplay('error',"Something Thing Was Wrong Please Refersh Your Web Page.......!",'');
					}

				}
			}
		}
		
	}



}
?>