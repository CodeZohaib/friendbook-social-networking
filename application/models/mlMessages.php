<?php

class mlMessages extends database{
	use modelTrait;

	public function insertMessagesList($friendId)
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
			if(!empty($friendId))
			{
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
				$friendRequest=$this->friendRequestCheck($user_id,$friendId,'getdata');

				$run=$this->con->prepare('SELECT * FROM `message_list` WHERE user_id=? AND friend_id=?');
				if(is_object($run))
				{
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$friendId,PDO::PARAM_INT);

					if($run->execute())
					{
						if($run->rowCount()==0)
						{
							if(is_array($friendRequest))
							{
								if($friendRequest['request']=='friend')
								{
									$run=$this->con->prepare('INSERT INTO `message_list`(`user_id`, `friend_id`) VALUES (?,?)');
									if(is_object($run))
									{
										$run->bindParam(1,$user_id,PDO::PARAM_INT);
										$run->bindParam(2,$friendId,PDO::PARAM_INT);

										if($run->execute())
										{
											$run->bindParam(1,$friendId,PDO::PARAM_INT);
										    $run->bindParam(2,$user_id,PDO::PARAM_INT);
										    $run->execute();

											return 'insert';
										}
									}
								}
								else if($friendRequest['request']=='block' OR $friendRequest['request']=='blockUser')
								{
									//$this->deleteMessagesList($friendId);
								}	
							}
						}
					}
				}
			}
		}

		return 'notInsert';
	}

	public function getAllMessagesList($type=null)
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

	    	if($type=='first')
	    	{
	    		$run=$this->con->prepare('SELECT `users`.* FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` RIGHT JOIN `message_list` ON `users`.`id`=`message_list`.`friend_id` WHERE `message_list`.`user_id`=? GROUP BY `users`.`id` ORDER BY `message_list`.id DESC LIMIT ?,?');

	    		$run->bindParam(1,$user_id,PDO::PARAM_INT);
				$run->bindValue(2,0,PDO::PARAM_INT);
				$run->bindValue(3,1,PDO::PARAM_INT);
	    	}
	    	else
	    	{
	    		$run=$this->con->prepare('SELECT `users`.* FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` RIGHT JOIN `message_list` ON `users`.`id`=`message_list`.`friend_id` WHERE `message_list`.`user_id`=? GROUP BY `users`.`id` ORDER BY `message_list`.id DESC');
	    		$run->bindParam(1,$user_id,PDO::PARAM_INT);
	    	}
			
			if($run->execute())
			{
				
				if($run->rowCount()>0)
				{
					return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
				}
				else
				{
					return 'empty';
				}
			}
			
		}

		return false;
	}

	public function checkMessagesList($friendId)
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
			$run=$this->con->prepare('SELECT * FROM `message_list` WHERE user_id=? AND friend_id=?');

			if(is_object($run))
			{
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
				$run->bindParam(1,$user_id,PDO::PARAM_INT);
				$run->bindParam(2,$friendId,PDO::PARAM_STR);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			}
		}

		return false;
	}


	public function insertMessage()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	    	$friendId=encryption('decrypt',$_POST['user_id']);
	    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	    	$key=encryption('encrypt',$user_id).encryption('encrypt',$friendId);

	        if(isset($_FILES['files']) AND !empty($_FILES['files']['type']))
			{
	   	        $file_name=mt_rand(11111,99999).'_'.preg_replace('/\s+/', '',$_FILES['files']['name']);

	   	        $file_type=$_FILES['files']['type'];

	   	        $path='../public/assets/sendFileChat/'.$file_name;

	   	        $allowed_ext=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov','mp3','MP3','WMA','wma','jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

				$exp=explode(".",$_FILES['files']['name']);
	            $end=end($exp);

	            if (!in_array($end, $allowed_ext)) 
	            {
	            	return 'wrong_file_type';
	            }

	            if (!move_uploaded_file($_FILES['files']['tmp_name'], $path)) 
	   	        {
	   	        	return 'not_upload';
	   	        }
			}
			else
			{
				$file_name='';
	   	    	$file_type='';
			}

			if(isset($_POST['text']) AND empty($_POST['text']))
			{
				$text='';
			}
			else
			{
			    $text=encryptDecryptChat('encrypt',$_POST['text'],$key);
			}

			$run=$this->con->prepare('INSERT INTO `messages`(`user_id`, `friend_id`, `message`, `file_name`, `file_type`, `seen_status`) VALUES (?,?,?,?,?,?)');

			if(is_object($run))
			{
				if($file_name!='')
				{
					$file_name=encryptDecryptChat('encrypt',$file_name,$key);
				    $file_type=encryptDecryptChat('encrypt',$file_type,$key);
				}
				
				$seen_status=encryption('encrypt','send');
				$run->bindParam(1,$user_id,PDO::PARAM_INT);
				$run->bindParam(2,$friendId,PDO::PARAM_INT);
				$run->bindParam(3,$text,PDO::PARAM_STR);
				$run->bindParam(4,$file_name,PDO::PARAM_STR);
				$run->bindParam(5,$file_type,PDO::PARAM_STR);
				$run->bindParam(6,$seen_status,PDO::PARAM_STR);

				if($run->execute())
				{
					$this->userTypingDelete($_POST['user_id']);
					if($this->checkMessagesList($friendId)==true)
					{
						$this->deleteMessagesList($friendId);
					}

					if($this->checkMessagesList($friendId)==false)
					{
						$this->insertMessagesList($friendId);
					}

					return 'success';
				}
			}
		}
	}

    public function userTypingInsert()
	{  
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	    	$friendId=encryption('decrypt',$_POST['user_id']);
	    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	    	$key=encryption('encrypt',$user_id).encryption('encrypt',$friendId);
	    	$typingCheck=$this->checkTyping($friendId);
	    	if(!is_array($typingCheck))
	    	{
		    	$run=$this->con->prepare('INSERT INTO `messages`(`user_id`, `friend_id`,`message_status`) VALUES (?,?,?)');

				if(is_object($run))
				{
					$message_status=encryption('encrypt','userTyping');
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$friendId,PDO::PARAM_INT);
					$run->bindParam(3,$message_status,PDO::PARAM_STR);

					if($run->execute())
					{
						return 'success';
					}
					else
					{

						return 'error';
					}
				}
			    
			}
	    }

	    
	}


	public function userTypingDelete($friendId=null)
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	    	$friendId=encryption('decrypt',$friendId);
	    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	    	$key=encryption('encrypt',$user_id).encryption('encrypt',$friendId);
	    	$typingCheck=$this->checkTyping($friendId);


	    	if(is_array($typingCheck))
	    	{
		    	$run=$this->con->prepare('DELETE FROM `messages` WHERE user_id=? AND friend_id=? AND `message_status`=?');

				if(is_object($run))
				{
					$message_status=encryption('encrypt','userTyping');
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$friendId,PDO::PARAM_INT);
					$run->bindParam(3,$message_status,PDO::PARAM_STR);

					if($run->execute())
					{
						return 'success';
					}
					else
					{
						return 'error';
					}
				}
		    }
	    }
	}


	public function checkTyping($friend_id)
	{
	   $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		$run=$this->con->prepare("SELECT * FROM `messages` WHERE user_id=? AND friend_id=? AND message_status=?");

		if(is_object($run))
		{
			$message_status=encryption('encrypt','userTyping');
			
			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindParam(2,$friend_id,PDO::PARAM_INT);
			$run->bindParam(3,$message_status,PDO::PARAM_STR);

			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					return $this->decryptDataChatBox($run->fetchAll(PDO::FETCH_ASSOC));
				}
			}
		}

		return false;
	}
	public function selectUserMessages($friend_id)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		$run=$this->con->prepare("SELECT `messages`.*,`users`.`name`,`users`.`image` FROM `users` RIGHT JOIN `messages` ON `users`.`id`=`messages`.`user_id` WHERE `messages`.`user_id` IN (?,?) AND `messages`.`friend_id` IN(?,?) AND chatBox NOT IN(?)  AND message_status IN(?,?,?)");

		if(is_object($run))
		{
			$userChatBox=encryption('encrypt',$user_id.'_clearChatBox');
			$message_status1=encryption('encrypt',$friend_id.'_deleteForMe');
			$message_status2=encryption('encrypt','userTyping');

			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindParam(2,$friend_id,PDO::PARAM_INT);
			$run->bindParam(3,$friend_id,PDO::PARAM_INT);
			$run->bindParam(4,$user_id,PDO::PARAM_INT);
			$run->bindParam(5,$userChatBox,PDO::PARAM_STR);
			$run->bindParam(6,$message_status1,PDO::PARAM_STR);
			$run->bindValue(7,'Null',PDO::PARAM_STR);
			$run->bindParam(8,$message_status2,PDO::PARAM_STR);

			

			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					return $this->decryptDataChatBox($run->fetchAll(PDO::FETCH_ASSOC));
				}
			}
		}

		return false;
		
	}


	public function getFriendLastMessage($friend_id)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		$run=$this->con->prepare("SELECT `messages`.*,`users`.`name`,`users`.`image` FROM `users` RIGHT JOIN `messages` ON `users`.`id`=`messages`.`user_id` WHERE `messages`.`user_id` IN (?,?) AND `messages`.`friend_id` IN(?,?) AND chatBox NOT IN(?) AND message_status IN(?,?,?) ORDER BY `messages`.id DESC LIMIT ?,?");

		if(is_object($run))
		{
			$chatbox=encryption('encrypt',$user_id.'_clearChatBox');

			$message_status1=encryption('encrypt',$friend_id.'_deleteForMe');
			$message_status2=encryption('encrypt','userTyping');


			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindParam(2,$friend_id,PDO::PARAM_INT);
			$run->bindParam(3,$friend_id,PDO::PARAM_INT);
			$run->bindParam(4,$user_id,PDO::PARAM_INT);
			$run->bindParam(5,$chatbox,PDO::PARAM_STR);
			$run->bindParam(6,$message_status1,PDO::PARAM_STR);
			$run->bindValue(7,'Null',PDO::PARAM_STR);
			$run->bindParam(8,$message_status1,PDO::PARAM_STR);
			$run->bindValue(9,0,PDO::PARAM_INT);
			$run->bindValue(10,1,PDO::PARAM_INT);

			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					return $this->decryptDataChatBox($run->fetchAll(PDO::FETCH_ASSOC));
				}
			}
		}

		return false;
		
	}


	public function getTotalSmsNotification()
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		$run=$this->con->prepare('SELECT COUNT(*) as totalSmsNotification FROM `users` RIGHT JOIN `messages` ON `users`.`id`=`messages`.`user_id` WHERE `messages`.seen_status=? AND `messages`.`friend_id`=?');

		if(is_object($run))
		{
			$seen_status=encryption('encrypt','send');

			$run->bindParam(1,$seen_status,PDO::PARAM_STR);
			$run->bindParam(2,$user_id,PDO::PARAM_INT);
			

			if($run->execute())
			{
				return $run->fetch(PDO::FETCH_ASSOC);
			}
		}

		return false;
	}


	public function getFriendSmsNotification($friend_id)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		$run=$this->con->prepare('SELECT COUNT(*) as friendSmsNotification FROM `users` RIGHT JOIN `messages` ON `users`.`id`=`messages`.`user_id` WHERE `messages`.seen_status=? AND `messages`.`user_id`=? AND `messages`.`friend_id`=?');

		if(is_object($run))
		{
			$seen_status=encryption('encrypt','send');

			$run->bindParam(1,$seen_status,PDO::PARAM_STR);
			$run->bindParam(2,$friend_id,PDO::PARAM_INT);
			$run->bindParam(3,$user_id,PDO::PARAM_INT);
			

			if($run->execute())
			{
				return $run->fetch(PDO::FETCH_ASSOC);
			}
		}

		return false;
	}

	public function userSmsSeen($friendId)
	{
		if(isset($friendId) AND !empty($friendId))
		{
			$friend_id=encryption('decrypt',$friendId);
			$seenSms=$this->getFriendSmsNotification($friend_id);

			if(is_array($seenSms))
			{
				if($seenSms['friendSmsNotification']>0)
				{
					$run=$this->con->prepare('UPDATE `messages` SET `seen_status`=? WHERE `seen_status`=? AND friend_id=? AND user_id=?');

					if(is_object($run))
					{
						$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
						$seen_status1=encryption('encrypt','seen');
						$seen_status2=encryption('encrypt','send');

						$run->bindParam(1,$seen_status1,PDO::PARAM_STR);
						$run->bindParam(2,$seen_status2,PDO::PARAM_STR);
						$run->bindParam(3,$user_id,PDO::PARAM_INT);
						$run->bindParam(4,$friend_id,PDO::PARAM_INT);
						
						if($run->execute())
						{
							return 'success';
						}
					}
				}
				else
				{
					return 'allSeen';
				}
			}
		}

		return false;
	}


	public function deleteAllChat()
	{
		if(isset($_POST['friendID']))
		{
			if(!empty($_POST['friendID']))
			{
				$friendId=encryption('decrypt',$_POST['friendID']);
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

				$run=$this->con->prepare("SELECT `messages`.*,`users`.`name`,`users`.`image` FROM `users` RIGHT JOIN `messages` ON `users`.`id`=`messages`.`user_id` WHERE `messages`.`user_id` IN (?,?) AND `messages`.`friend_id` IN(?,?) AND chatBox NOT IN(?)");

				if(is_object($run))
				{
					$chatbox=encryption('encrypt',$user_id.'_clearChatBox');
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$friendId,PDO::PARAM_INT);
					$run->bindParam(3,$friendId,PDO::PARAM_INT);
					$run->bindParam(4,$user_id,PDO::PARAM_INT);
					$run->bindParam(5,$chatbox,PDO::PARAM_STR);

					if($run->execute())
					{

						if($run->rowCount()>0)
						{
							$allData=$this->decryptDataChatBox($run->fetchAll(PDO::FETCH_ASSOC));
							$updateRun=$this->con->prepare("UPDATE `messages` SET `chatBox`=? WHERE id=?");
							$deleteRun=$this->con->prepare("DELETE FROM `messages` WHERE id=?");


							foreach ($allData as $key => $value) 
							{
								if($value['chatBox']=='Null')
								{
									$userChatBox=encryption('encrypt',$user_id.'_clearChatBox');

									$updateRun->bindParam(1,$userChatBox,PDO::PARAM_STR);
									$updateRun->bindParam(2,$value['id'],PDO::PARAM_INT);;

									if(!$updateRun->execute())
									{
										return 'error';
									}
								}
								else if($value['chatBox']==$friendId.'_clearChatBox')
								{
									$deleteRun->bindParam(1,$value['id'],PDO::PARAM_INT);
									if(!$deleteRun->execute())
									{
										return 'error';
									}
								}


							}

							return 'success';
						}
					}
				}
			}
		}

		return false;
	}


	public function deleteMessage()
	{
		if(isset($_POST['id']) AND !empty($_POST['id']))
		{
			$id=encryption('decrypt',$_POST['id']);
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

			if($id!=false)
			{
				$run=$this->con->prepare('SELECT * FROM `messages` WHERE id=?');
				if(is_object($run))
				{
					$run->bindParam(1,$id,PDO::PARAM_INT);
					if($run->execute())
					{
						if($run->rowCount()>0)
						{
							$Messagedata=$run->fetch(PDO::FETCH_ASSOC);


							if($Messagedata['message_status']=='Null' AND $Messagedata['chatBox']=='Null')
							{
								$deleteRun=$this->con->prepare('DELETE FROM `messages` WHERE id=?');
								$UpdateRun=$this->con->prepare('UPDATE `messages` SET `message_status`=? WHERE id=?');

								if($_POST['deleteType']=='deleteForEveryone' AND $Messagedata['user_id']==$user_id)
								{
									$deleteRun->bindParam(1,$id,PDO::PARAM_INT);

									if($deleteRun->execute())
									{
										return 'success';
									}
								}
								else if($_POST['deleteType']=='deleteForMe' AND $Messagedata['friend_id']==$user_id)
								{
									$message_status=encryption('encrypt',$user_id.'_deleteForMe');

									$UpdateRun->bindParam(1,$message_status,PDO::PARAM_STR);
									$UpdateRun->bindParam(2,$id,PDO::PARAM_INT);

									if($UpdateRun->execute())
									{
										return 'success';
									}
								}
								else if($_POST['deleteType']=='deleteForMe' AND ($Messagedata['user_id']==$user_id OR $Messagedata['friend_id']==$user_id) )
								{

									$message_status=encryption('encrypt',$user_id.'_deleteForMe');
									$UpdateRun->bindParam(1,$message_status,PDO::PARAM_STR);
									$UpdateRun->bindParam(2,$id,PDO::PARAM_INT);
									
									
									if($UpdateRun->execute())
									{
										return 'success';
									}
								}	
							}
							else if($Messagedata['message_status']!='Null' AND $Messagedata['chatBox']=='Null')
							{
								$message_status=encryption('decrypt',$Messagedata['message_status']);
								if($message_status==$user_id.'_deleteForMe')
								{
									return 'already_delete';
								}
								else
								{
									$deleteRun=$this->con->prepare('DELETE FROM `messages` WHERE id=?');
									$deleteRun->bindParam(1,$id,PDO::PARAM_INT);

									if($deleteRun->execute())
									{
										return 'success';
									}
								}
								
							}
							else
							{
								$chatbox=encryption('decrypt',$Messagedata['chatBox']);
								if($chatbox==$Messagedata['friend_id'].'_clearChatBox' OR $chatbox==$Messagedata['user_id'].'_clearChatBox')
								{
									$deleteRun=$this->con->prepare('DELETE FROM `messages` WHERE id=?');
									$deleteRun->bindParam(1,$id,PDO::PARAM_INT);

									if($deleteRun->execute())
									{
										return 'success';
									}
								}
							}
						}
					}
				}
			}
			else
			{
				return 'invalidMessage';
			}
		}

		return false;
	}
}

?>