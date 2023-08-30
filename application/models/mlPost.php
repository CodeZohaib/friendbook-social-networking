<?php


class mlPost extends database{

	use modelTrait;

	
	public function imgCopy($img,$path)
	{
		$imagePath = "../public/assets/$path".$img;
		$newPath = "../public/assets/user_post_files/";
		$newName  = $newPath.$img;

		$copied = copy($imagePath , $newName);
		if ((!$copied)) 
		{
		    return "NotCopied";
		}
		else
		{ 
		    return "CopiedSuccessful";
		}
	}

	public function insertNotification($type,$postId)
	{
		if(!empty($type) AND !empty($postId))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

			if(encryption('decrypt',$postId)==true)
			{
				$post_id=encryption('decrypt',$postId);
			}
			else
			{
				$post_id=$postId;
			}

			$run=$this->con->prepare("SELECT * FROM `posts` WHERE id=? AND admin_status=?");
			if(is_object($run))
			{
				$admin_status=encryption('encrypt','publish');
				$run->bindParam(1,$post_id,PDO::PARAM_INT);
				$run->bindParam(2,$admin_status,PDO::PARAM_INT);
				if($run->execute())
				{
					if($run->rowCount()==1)
			  	    {
			  	       $postDetails=$run->fetch(PDO::FETCH_ASSOC);
			  	    }
				}
			}

			if(is_array($postDetails))
			{
				$run=$this->con->prepare("INSERT INTO `notification`(`user_id`,`post_user_id`, `post_id`, `notif_type`) VALUES (?,?,?,?)");
				if(is_object($run))
				{
					
					$notif_type=encryption('encrypt',$type);
					$postId=encryption('decrypt',$postId);
					$post_user_id=$postDetails['user_id'];

					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$post_user_id,PDO::PARAM_INT);
					$run->bindParam(3,$post_id,PDO::PARAM_INT);
					$run->bindParam(4,$notif_type,PDO::PARAM_STR);

					if($run->execute())
					{
						$notif_id=$this->con->lastInsertId();
						$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		                $allFriends=$this->getAllFriends($user_id);
		                $allFollower=$this->follower('getAll',$user_id);

		                $run=$this->con->prepare("INSERT INTO `notification_pending`(`post_id`,`notif_id`, `notif_user_id`) VALUES (?,?,?)");

						if($type=='like' OR $type=='dislike' OR $type=='comment')
						{
							$run->bindParam(1,$post_id,PDO::PARAM_INT);
		                    $run->bindParam(2,$notif_id,PDO::PARAM_INT);
		                    $run->bindParam(3,$post_user_id,PDO::PARAM_INT);
		                    $run->execute();
						}
						else
						{
							$userID=encryption('decrypt',$_SESSION['loginUser'][0]);
							$decryptPost=$this->decryptData($postDetails);
							if(is_array($allFriends))
							{
							    foreach ($allFriends as $key => $value) 
			                    {
			                    	$run->bindParam(1,$post_id,PDO::PARAM_INT);
			                    	$run->bindParam(2,$notif_id,PDO::PARAM_INT);
			                    	$run->bindParam(3,$value['user_id'] ,PDO::PARAM_INT);
			                    	$run->execute();
			                    }
							}

							if(is_array($allFollower))
							{
								$userData=$this->getUser('id',$userID);
								if($userData['account_type']=='public')
								{
				                    foreach ($allFollower as $key => $value) 
				                    {
				                    	$friendData=$this->friendRequestCheck($userID,$value['user_id'],'getdata');
				                    	if($friendData==false OR $friendData['request']=='send' AND $decryptPost['post_status']=='public')
				                    	{
				                    	  $run->bindParam(1,$post_id,PDO::PARAM_INT);
				                    	  $run->bindParam(2,$notif_id,PDO::PARAM_INT);
				                    	  $run->bindParam(3,$value['user_id'],PDO::PARAM_INT);
				                    	  $run->execute();
				                       } 
				                    }
			                    }
			                }

		                    return true;
						}
					}
				}

			}

		}

		return false;
	}

	public function getPendingNotif($postID,$notifID)
	{

		if(!empty($postID) AND !empty($notifID))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$run=$this->con->prepare("SELECT * FROM `notification_pending` WHERE post_id=? AND notif_id=? AND notif_user_id=?");
		    $run->bindParam(1,$postID,PDO::PARAM_INT);
		    $run->bindParam(2,$notifID,PDO::PARAM_INT);
		    $run->bindParam(3,$user_id,PDO::PARAM_INT);

		    if($run->execute())
		    {
		    	if($run->rowCount()>0)
		    	{
		    		return $run->fetch(PDO::FETCH_ASSOC);
		    	}
		    }
		}

	    return false;
	}

	public function getAllPendingNotif()
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		$run=$this->con->prepare("SELECT * FROM `notification_pending` WHERE notif_user_id=? ORDER BY id DESC");
	    $run->bindParam(1,$user_id,PDO::PARAM_INT);

	    if($run->execute())
	    {
	    	if($run->rowCount()>0)
	    	{
	    		return $run->fetchAll(PDO::FETCH_ASSOC);
	    	}
	    }
	    return false;
	}

	public function getNotification($id)
	{
		if(!empty($id))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$run=$this->con->prepare("SELECT * FROM `notification` WHERE id=?");
		    $run->bindParam(1,$id,PDO::PARAM_INT);

		    if($run->execute())
		    {
		    	if($run->rowCount()>0)
		    	{
		    		return $run->fetch(PDO::FETCH_ASSOC);
		    	}
		    }
		}

	    return false;
	}


	public function notificationSelect($post_id,$notif_type)
	{
		if(!empty($post_id) AND !empty($notif_type))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$run=$this->con->prepare("SELECT * FROM `notification` WHERE post_id=? AND user_id=? AND notif_type=?");
		    $run->bindParam(1,$post_id,PDO::PARAM_INT);
		    $run->bindParam(2,$user_id,PDO::PARAM_INT);
		    $run->bindParam(3,$notif_type,PDO::PARAM_STR);

		    if($run->execute())
		    {
		    	if($run->rowCount()>0)
		    	{
		    		return $run->fetch(PDO::FETCH_ASSOC);
		    	}
		    }
		}

	    return false;
	}

	public function deletePendingNotif($postId=null,$notifId=null)
	{
		if($postId==null AND $notifId==null)
		{
			$postID=encryption('decrypt',$_POST['postID']);
			$notifID=encryption('decrypt',$_POST['notifID']);
		}
		else
		{
			$postID=$postId;
			$notifID=$notifId;
		}

		if(!empty($postID) AND !empty($notifID))
		{
			$pendingData=$this->getPendingNotif($postID,$notifID);

			if(is_array($pendingData))
			{
				$run=$this->con->prepare("DELETE FROM `notification_pending` WHERE post_id=? AND notif_id=? AND notif_user_id=?");
				if(is_object($run))
				{
					$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
					$run->bindParam(1,$postID,PDO::PARAM_INT);
	                $run->bindParam(2,$notifID,PDO::PARAM_INT);
	                $run->bindParam(3,$user_id,PDO::PARAM_INT);
	                if($run->execute())
	                {
	                	return true;
	                }
				}
			}
			else
			{
				return true;
			}
		}

		return false;
	}

	public function deleteAllPedingNotif()
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		$run=$this->con->prepare("SELECT * FROM `notification_pending` WHERE notif_user_id=?");
	    $run->bindParam(1,$user_id,PDO::PARAM_INT);

	    if($run->execute())
	    {
	    	if($run->rowCount()>0)
	    	{
	    		$run=$this->con->prepare("DELETE  FROM `notification_pending` WHERE notif_user_id=?");
	            $run->bindParam(1,$user_id,PDO::PARAM_INT);
	            if($run->execute())
	            {
	            	return true;
	            }
	    	}
	    	else
	    	{
	    		return 'emptyNotification';
	    	}
	    }

	    return false;
	}

	public function getActivityLog($id)
	{
		
		if(!empty($id) AND isset($_POST['rows']) AND isset($_POST['offset']))
		{
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];

			$run=$this->con->prepare('SELECT `notification`.*,`posts`.`id` AS post_id,`posts`.`user_id` AS post_user_id,`posts`.`post_file_name`,`posts`.`post_text` FROM `notification` 
				LEFT JOIN `posts` ON `notification`.`post_id`=`posts`.`id` 
				WHERE `notification`.`user_id`=? AND `posts`.`post_status` IN (?,?) AND `posts`.`admin_status`=? 
				ORDER BY `notification`.`id` DESC LIMIT ?,?');

			if(is_object($run))
			{
				$status1=encryption('encrypt','public');
				$status2=encryption('encrypt','friend');
				$admin_status=encryption('encrypt','publish');

				$run->bindParam(1,$id,PDO::PARAM_INT);
				$run->bindParam(2,$status1,PDO::PARAM_STR);
				$run->bindParam(3,$status2,PDO::PARAM_STR);
				$run->bindParam(4,$admin_status,PDO::PARAM_STR);
				$run->bindParam(5,$offset,PDO::PARAM_INT);
				$run->bindParam(6,$rows,PDO::PARAM_INT);

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
		}
	}

	public function insertPost()
	{
		$userInfo=$this->getUser('id',encryption('decrypt',$_SESSION['loginUser'][0]));

		if(isset($_FILES['profile_image']))
		{
			$notifStatus='profilePicChange';
			$image['image']=$_FILES['profile_image'];
			$text="Updated his profile photo";
			$copyImgName=$userInfo['image'];
			$copyPath="images/users/";
		}
		else if(isset($_FILES['cover_image']))
		{
			$notifStatus='coverPicChange';
			$image['image']=$_FILES['cover_image'];
			$text="Updated his cover photo";
			$copyImgName=$userInfo['bg_image'];
			$copyPath="images/covers/";
		}
		else if(isset($_FILES['image']) AND isset($_POST['texts']))
		{
			$notifStatus='insertPost';
			$image['image']=$_FILES['image'];
			$text=$_POST['texts'];
		}

        if (!empty($text) AND !empty($image['image']['name'])) 
		{
			//In this condition access to text data and file data

			$text=encryption('encrypt', $text);

			//File
			$file_name=mt_rand(11111,99999).'_'.preg_replace('/\s+/', '', $image['image']['name']);
			$file_type=$image['image']['type'];
		}
		else if (empty($text) AND !empty($image['image']['name'])) 
		{
			//In this condition access to Only file data
			//Text
			$text=NULL;

			//File
			$file_name=mt_rand(11111,99999).'_'.preg_replace('/\s+/', '', $image['image']['name']);
			$file_type=$image['image']['type'];

		}
		else if (empty($image['image']['name']) AND !empty($text))
		{
			//In this condition access to Only text data
			//Text
			$text=encryption('encrypt', $text);
			$file_name=NULL;
			$file_type=NULL;
		}

		if (!empty($file_name)) 
		{
			$allowed_ext=array('MKV','mkv','mp4','MP4','AVI','avi','MOV','mov','mp3','MP3','WMA','wma','jpeg','JPEG','jpg','JPG','gif','GIF','png','PNG','GIF','gif');

			$exp=explode(".",$file_name);
            $end=end($exp);

            if (in_array($end, $allowed_ext)) 
            {
            	$path="../public/assets/user_post_files/".$file_name;
            	if(isset($copyPath))
            	{
            		$copy=$this->imgCopy($copyImgName,$copyPath);

            		if($copy=='NotCopied')
            		{
            			return 'not_upload';
            		}
            		else if($copy=="CopiedSuccessful")
            		{
            			$file_name=encryption('encrypt',$copyImgName);
		   	        	$file_type=$image['image']['type'];
            		}
            	}
            	else
            	{
            		if (move_uploaded_file($image['image']['tmp_name'], $path)) 
		   	        {
		   	        	$file_name=encryption('encrypt', $file_name);
		   	        	$file_type=$image['image']['type'];
		   	        }
		   	        else
		   	        {
		   	        	return 'not_upload';
		   	        }
            	}
            }
            else
            {
            	return 'wrong_file_type';
            }
		}

		
		$run=$this->con->prepare("INSERT INTO `posts`(`user_id`, `post_text`, `post_file_name`, `post_file_type`,`post_status`,`admin_status`) VALUES (?,?,?,?,?,?)");

		if(is_object($run))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			if(isset($_POST['post_status']))
			{
				if($_POST['post_status']==='friend' OR $_POST['post_status']==='public' OR $_POST['post_status']==='private')
				{
					$post_status=encryption('encrypt',$_POST['post_status']);
				}
				else
				{
					$post_status=encryption('encrypt','public');
				}
			}
			else
			{
				$post_status=encryption('encrypt','public');
			}

			$admin_status=encryption('encrypt','publish');

			$run->bindParam(1,$user_id,PDO::PARAM_STR);
			$run->bindParam(2,$text,PDO::PARAM_STR);
			$run->bindParam(3,$file_name,PDO::PARAM_STR);
			$run->bindParam(4,$file_type,PDO::PARAM_STR);
			$run->bindParam(5,$post_status,PDO::PARAM_STR);
			$run->bindParam(6,$admin_status,PDO::PARAM_STR);

			if($run->execute())
			{
				$post_id=encryption('encrypt',$this->con->lastInsertId());
				$this->insertNotification($notifStatus,$post_id);
				return 'success';
			}
		}
	}

	public function deleteComment($comment_id)
	{
		$details=$this->getComment($comment_id);

		if(is_array($details))
		{
			$postId=encryption('encrypt',$details['post_id']);
			$postDetail=$this->postExist($postId,'details');
			
			$decryptPost=$this->decryptData($postDetail);
			$userid=encryption('decrypt',$_SESSION['loginUser'][0]);

			if($decryptPost['user_id']==$userid AND $decryptPost['post_delete']=='NULL' AND $details['post_id']==$decryptPost['id'] AND $details['status']=='NULL' OR $userid==$details['user_id'])
			{

				$run=$this->con->prepare('UPDATE `post_comments` SET `status`=? WHERE id=? AND post_id=?');
				if(is_object($run))
				{
					if($decryptPost['user_id']===$userid)
					{
						$status=encryption('encrypt','ownerDelete');
					}
					else
					{
						$status=encryption('encrypt','userDelete');
					}

					$run->bindParam(1,$status,PDO::PARAM_STR);
					$run->bindParam(2,$comment_id,PDO::PARAM_INT);
					$run->bindParam(3,$decryptPost['id'],PDO::PARAM_INT);

					if($run->execute())
					{
						$this->deleteNotification('comment',$details['post_id'],$postDetail['user_id']);
						return 'success';
					}
				}
			}
		}

		return false;
	}

	public function getAllPost($id)
	{
		if(isset($id) AND !empty($id))
		{
			$userid=$id;
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];
		
			$admin_status=encryption('encrypt','publish');
			$post_delete='NULL';

			$run=$this->con->prepare('SELECT `posts`.*,SUM(likes) AS likes,SUM(dislikes) AS dislikes,image,name,email,account_type FROM `posts` RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` LEFT JOIN `posts_likes` ON `posts_likes`.`post_id`=`posts`.`id` WHERE `users`.`id`=? AND  `posts`.`admin_status`=? AND `posts`.post_delete=?  GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?');

			if(is_object($run))
			{
				$run->bindParam(1,$userid,PDO::PARAM_STR);
				$run->bindParam(2,$admin_status,PDO::PARAM_STR);
				$run->bindParam(3,$post_delete,PDO::PARAM_STR);
				$run->bindParam(4,$offset,PDO::PARAM_INT);
				$run->bindParam(5,$rows,PDO::PARAM_INT);
				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						$row=$run->fetchAll(PDO::FETCH_ASSOC);
					    $response=$this->decryptData($row);
					}
				}
			}
			

			if(isset($response) AND is_array($response) )
			{
				return $response;  
			}
		}

		return false;
	}

	public function getPost($postid)
	{
		if(isset($postid) AND !empty($postid) AND encryption('decrypt',$postid)!=false)
		{
			$post_id=encryption('decrypt',$postid);
		    $admin_status=encryption('encrypt','publish');
			$post_delete='NULL';

			$run=$this->con->prepare('SELECT `posts`.*,SUM(likes) AS likes,SUM(dislikes) AS dislikes,image,name,email,account_type,bluetick FROM `posts` RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` LEFT JOIN `posts_likes` ON `posts_likes`.`post_id`=`posts`.`id` WHERE `posts`.`id`=? AND  `posts`.`admin_status`=? AND `posts`.post_delete=?  GROUP BY `posts`.`id` ORDER BY `posts`.id DESC');

			if(is_object($run))
			{
				$run->bindParam(1,$post_id,PDO::PARAM_STR);
				$run->bindParam(2,$admin_status,PDO::PARAM_STR);
				$run->bindParam(3,$post_delete,PDO::PARAM_STR);
				if($run->execute())
				{
					$row=$run->fetch(PDO::FETCH_ASSOC);
					$response=$this->decryptData($row);
				}
			}
			

			if(isset($response) AND is_array($response) )
			{
				return $response;  
			}
		}

		return false;
	}

	public function getDeletePost($postid)
	{
		if(isset($postid) AND !empty($postid))
		{
		    $admin_status=encryption('encrypt','notPublish');

			$run=$this->con->prepare('SELECT `posts`.*,SUM(likes) AS likes,SUM(dislikes) AS dislikes,image,name,email,account_type,bluetick FROM `posts` RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` LEFT JOIN `posts_likes` ON `posts_likes`.`post_id`=`posts`.`id` WHERE `posts`.`id`=? AND  `posts`.`admin_status`=? GROUP BY `posts`.`id` ORDER BY `posts`.id DESC');

			if(is_object($run))
			{
				$run->bindParam(1,$postid,PDO::PARAM_STR);
				$run->bindParam(2,$admin_status,PDO::PARAM_STR);
				if($run->execute())
				{
					$row=$run->fetch(PDO::FETCH_ASSOC);
					$response=$this->decryptData($row);
				}
			}
			

			if(isset($response) AND is_array($response) )
			{
				return $response;  
			}
		}

		return false;
	}



	public function getAudios($id)
	{
		if(isset($id) AND !empty($id))
		{
			$userid=$id;
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];
		
			$admin_status=encryption('encrypt','publish');
			$post_delete='NULL';

			$run=$this->con->prepare('SELECT `posts`.*,SUM(likes) AS likes,SUM(dislikes) AS dislikes,image,name,email,account_type FROM `posts` RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` LEFT JOIN `posts_likes` ON `posts_likes`.`post_id`=`posts`.`id` WHERE `users`.`id`=? AND  `posts`.`admin_status`=? AND `posts`.post_delete=? AND post_file_type NOT IN(?) AND post_file_type LIKE ?  GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?');

			if(is_object($run))
			{
				$run->bindParam(1,$userid,PDO::PARAM_STR);
				$run->bindParam(2,$admin_status,PDO::PARAM_STR);
				$run->bindParam(3,$post_delete,PDO::PARAM_STR);
				$run->bindValue(4,'',PDO::PARAM_STR);
				$run->bindValue(5,'audio/%',PDO::PARAM_STR);
				$run->bindParam(6,$offset,PDO::PARAM_INT);
				$run->bindParam(7,$rows,PDO::PARAM_INT);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						$row=$run->fetchAll(PDO::FETCH_ASSOC);
					    $response=$this->decryptData($row);
					}
				}
			}
			

			if(isset($response) AND is_array($response) )
			{
				return $response;  
			}
		}

		return false;
	}

	public function getAlbum($id)
	{
		if (!empty($id) AND isset($_POST['offset']) AND isset($_POST['rows'])) 
		{
			$userid=encryption('decrypt',$_SESSION['loginUser'][0]);
			$userInfo=$this->getUser('id',$id);

			if(is_array($userInfo) AND $userInfo['account_type']!='private' OR $userInfo['id']==$userid)
			{
				$run=$this->con->prepare("SELECT * FROM `posts` WHERE user_id=? AND post_file_type NOT IN(?) AND post_file_type LIKE ? AND admin_status=? AND post_delete=? ORDER BY id DESC LIMIT ?,?");

				if (is_object($run)) 
				{
					$admin_status=encryption('encrypt','publish');

					$run->bindParam(1,$id,PDO::PARAM_INT);
					$run->bindValue(2,'',PDO::PARAM_STR);
					$run->bindValue(3,'image/%',PDO::PARAM_STR);
					$run->bindParam(4,$admin_status,PDO::PARAM_STR);
					$run->bindValue(5,'NULL',PDO::PARAM_STR);
					$run->bindParam(6,$_POST['offset'],PDO::PARAM_INT);
					$run->bindParam(7,$_POST['rows'],PDO::PARAM_INT);

					if ($run->execute()) 
					{
						if ($run->rowCount()>0) 
						{
							$album=$run->fetchAll(PDO::FETCH_ASSOC);
							$decryptAlbum=$this->decryptData($album);
							return $decryptAlbum;
						}
						else
						{
							return 'empty';
						}
					}
				}
			}
		}

		return false;
	}

	public function getVideos($id)
	{
		if(!empty($id) AND isset($_POST['rows']) AND isset($_POST['offset']))
		{
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];
			$userid=encryption('decrypt',$_SESSION['loginUser'][0]);
			$userInfo=$this->getUser('id',$id);

			if(is_array($userInfo) AND $userInfo['account_type']!='private' OR $userInfo['id']==$userid)
			{
			    $run=$this->con->prepare("SELECT * FROM `posts` WHERE user_id=? AND post_file_type NOT IN(?) AND post_file_type LIKE ? AND admin_status=? AND post_delete=? ORDER BY id DESC LIMIT ?,?");

				if (is_object($run)) 
				{
					$admin_status=encryption('encrypt','publish');

					$run->bindParam(1,$id,PDO::PARAM_INT);
					$run->bindValue(2,'',PDO::PARAM_STR);
					$run->bindValue(3,'video/%',PDO::PARAM_STR);
					$run->bindParam(4,$admin_status,PDO::PARAM_STR);
					$run->bindValue(5,'NULL',PDO::PARAM_STR);
					$run->bindParam(6,$offset,PDO::PARAM_INT);
					$run->bindParam(7,$rows,PDO::PARAM_INT);

					if ($run->execute()) 
					{
						if ($run->rowCount()>0) 
						{
							$album=$run->fetchAll(PDO::FETCH_ASSOC);
							$decryptAlbum=$this->decryptData($album);
							return $decryptAlbum;
						}
						else
						{
							return 'empty';
						}
					}
				}
			}
		}

		return false;
	
	}



	public function postUpdate()
	{
		$post_status=encryption('encrypt',$_POST['post_privacy']);
		$post_id=encryption('decrypt',$_POST['post_id']);
		$userid=encryption('decrypt',$_SESSION['loginUser'][0]);

		if($this->postExist($_POST['post_id'])===true)
		{
		    if($post_id!=false)
		    {
		  	  $run=$this->con->prepare("UPDATE `posts` SET `post_status`=? WHERE id=? AND user_id=?");
		  	  if (is_object($run)) 
		  	  {
		  	  	$run->bindParam(1,$post_status,PDO::PARAM_STR);
		  	  	$run->bindParam(2,$post_id,PDO::PARAM_INT);
		  	  	$run->bindParam(3,$userid,PDO::PARAM_STR);

		  	  	if($run->execute())
		  	  	{
		  	  		return 'success';
		  	  	}
		  	  }
	     	}
	    }

	  	return 'error';
	}

	
	public function post_update_likes()
	{
		if (!empty($_POST['post_id']) AND !empty($_POST['type']) AND !empty($_POST['post_user_id'])) 
		{
			$post_user_id=encryption('decrypt',$_POST['post_user_id']);

			if($post_user_id!=false)
			{
				$post_id=encryption('decrypt',$_POST['post_id']);
			    $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
				$check_like=$this->check_likes($post_id,'check_post_like');

				if($check_like=='like' AND $_POST['type']=='like' OR $check_like=='dislike' AND $_POST['type']=='dislike')
				{
					$run=$this->con->prepare("DELETE FROM `posts_likes` WHERE `post_id`=? AND `user_id`=?");
				}
				else if ($check_like=='like' AND $_POST['type']=='dislike' OR $check_like=='dislike' AND $_POST['type']=='like') 
				{
					$run=$this->con->prepare("UPDATE `posts_likes` SET `likes`=?,`dislikes`=? WHERE `post_id`=? AND `user_id`=?");
				}
				else if ($check_like=='none' AND $_POST['type']=='like' OR $check_like=='none' AND $_POST['type']=='dislike') 
				{
					$run=$this->con->prepare("INSERT INTO `posts_likes`(`post_id`, `user_id`, `likes`, `dislikes`) VALUES (?,?,?,?)");
				}

				

				if (is_object($run)) 
				{
					if($check_like=='like' AND $_POST['type']=='like' OR $check_like=='dislike' AND $_POST['type']=='dislike')
					{
						$this->deleteNotification('like',$post_id,$post_user_id);
						$this->deleteNotification('dislike',$post_id,$post_user_id);

						$response='Delete';
						$run->bindParam(1,$post_id,PDO::PARAM_INT);
						$run->bindParam(2,$user_id,PDO::PARAM_INT);
					}
					else if ($check_like=='like' AND $_POST['type']=='dislike') 
					{
						$this->deleteNotification('like',$post_id,$post_user_id);
						$this->insertNotification('dislike',$post_id,$post_user_id);
						$response='dislike';
						$run->bindValue(1,0,PDO::PARAM_INT);
						$run->bindValue(2,1,PDO::PARAM_INT);
						$run->bindParam(3,$post_id,PDO::PARAM_INT);
						$run->bindParam(4,$user_id,PDO::PARAM_INT);
					}
					else if ($check_like=='dislike' AND $_POST['type']=='like') 
					{
						$this->deleteNotification('dislike',$post_id,$post_user_id);
						$this->insertNotification('like',$post_id,$post_user_id);

						$response='like';
						$run->bindValue(1,1,PDO::PARAM_INT);
						$run->bindValue(2,0,PDO::PARAM_INT);
						$run->bindParam(3,$post_id,PDO::PARAM_INT);
						$run->bindParam(4,$user_id,PDO::PARAM_INT);
					}
					else if ($check_like=='none' AND $_POST['type']=='like')
					{
						$this->insertNotification('like',$post_id);
						$response='like';
						$run->bindValue(1,$post_id,PDO::PARAM_INT);
						$run->bindValue(2,$user_id,PDO::PARAM_INT);
						$run->bindValue(3,1,PDO::PARAM_INT);
						$run->bindValue(4,0,PDO::PARAM_INT);

					}
					else if ($check_like=='none' AND $_POST['type']=='dislike')
					{
						$this->insertNotification('dislike',$post_id);
						$response='dislike';
						$run->bindValue(1,$post_id,PDO::PARAM_INT);
						$run->bindValue(2,$user_id,PDO::PARAM_INT);
						$run->bindValue(3,0,PDO::PARAM_INT);
						$run->bindValue(4,1,PDO::PARAM_INT);

					}

					if ($run->execute()) 
					{
						return $response;
					}
				}
					
			}
		}
		else
		{
			return "empty";
		}
	}

	public function getLikeDislike($post_id,$type)
	{
		$run=$this->con->prepare("SELECT `users`.`id`,`users`.`name`,`users`.`country`,`users`.`email`,`users`.`image`,`users`.`bluetick`, posts_likes.like_date,posts_likes.likes ,posts_likes.dislikes FROM `posts_likes` Right JOIN `users` ON `posts_likes`.`user_id`=`users`.`id` WHERE `posts_likes`.`post_id`=? AND posts_likes.likes=? AND posts_likes.dislikes=? ORDER BY `posts_likes`.`id` DESC");

    	if(is_object($run))
    	{
    		$run->bindParam(1,$post_id,PDO::PARAM_INT);

    		if($type=='view_like')
    		{
    			$run->bindValue(2,1,PDO::PARAM_INT);
    		}
    		else
    		{
    			$run->bindValue(2,0,PDO::PARAM_INT);
    		}

    		if($type=='view_dislike')
    		{
    			$run->bindValue(3,1,PDO::PARAM_INT);
    		}
    		else
    		{
    			$run->bindValue(3,0,PDO::PARAM_INT);
    		}

    		if($run->execute())
    		{
    			if ($run->rowCount()>0) 
    			{
    			    $array=$run->fetchAll(PDO::FETCH_ASSOC);
    				foreach ($array as $key1 => $value1) 
				    {
				    	foreach ($value1 as $key => $value) 
				        {
				        	if(!empty($value1))
					    	{
					    		if(encryption('decrypt', $value)!=false)
						    	{
						    		$data[$key1][$key]=encryption('decrypt', $value);
						    	}
						    	else
						    	{
						    		$data[$key1][$key]=$value;
						    	}	
					    	} 
					    	else
					    	{
					    		$data[$key1][$key]=null;
					    	}	
				        }
				    }

				    return $data;
    			}	
    		}
    	}

    	return false;
	    
	}

	public function insertComment($post_id,$comment)
	{
		if(!empty($post_id) AND !empty($comment))
		{
			$run=$this->con->prepare("INSERT INTO `post_comments`(`post_id`, `user_id`, `comment`) VALUES (?,?,?)");

	    	if(is_object($run))
	    	{
	    		$comment=encryption('encrypt',$comment);
	    		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

	    		$run->bindParam(1,$post_id,PDO::PARAM_INT);
	    		$run->bindParam(2,$user_id,PDO::PARAM_INT);
	    		$run->bindParam(3,$comment,PDO::PARAM_STR);

	    		if($run->execute())
	    		{
				    $this->insertNotification('comment',encryption('encrypt',$post_id));
	    			return 'success';
	    		}
	        }
		}

		return false;
	}

	public function getComment($comment_id)
	{
		if(!empty($comment_id))
		{
			$run=$this->con->prepare("SELECT * FROM `post_comments` WHERE id=?");
			if(is_object($run))
			{
				$run->bindParam(1,$comment_id,PDO::PARAM_INT);
				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						return $run->fetch(PDO::FETCH_ASSOC);
					}
				}
			}
		}

		return false;
	}
	
	public function getPostComment($post_id)
	{
		if(!empty($post_id))
		{
			$run=$this->con->prepare("SELECT `post_comments`.*,`users`.`image`,`users`.`name`,`users`.`bluetick` FROM `post_comments` RIGHT JOIN `users` ON `post_comments`.`user_id`=`users`.`id` WHERE `post_comments`.`post_id`=? AND `post_comments`.status=?");
			if(is_object($run))
			{
				$run->bindParam(1,$post_id,PDO::PARAM_INT);
				$run->bindValue(2,'NULL',PDO::PARAM_STR);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						return $run->fetchAll(PDO::FETCH_ASSOC);
					}
					else
					{
						return 'noComment';
					}
				}
			}
		}

		return false;
	}

	public function total_like_dislike($post_id)
	{
		
    	$run=$this->con->prepare("SELECT SUM(likes) AS likes,SUM(dislikes) AS dislikes,post_id FROM `posts_likes` WHERE post_id=?");

    	if(is_object($run))
    	{
    		$run->bindParam(1,$post_id,PDO::PARAM_INT);

    		if($run->execute())
    		{
    			if ($run->rowCount()>0) 
    			{
    				return $run->fetch(PDO::FETCH_ASSOC);
    			}	
    		}
    	}

    	return false;
	    
	}

	public function check_likes($post_id)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		if (!empty($post_id)) 
		{
			$run=$this->con->prepare("SELECT * FROM `posts_likes` WHERE post_id=? AND user_id=?");
			if (is_object($run))
			{
				$run->bindParam(1,$post_id,PDO::PARAM_INT);
				$run->bindParam(2,$user_id,PDO::PARAM_INT);

				if ($run->execute()) 
				{
					if($run->rowCount()>0)
					{
						$row=$run->fetch(PDO::FETCH_OBJ);

						if (empty($row->likes) AND empty($row->dislikes)) 
						{
							return 'none';
						}
						else if (empty($row->likes) AND !empty($row->dislikes)) 
						{
							return 'dislike';
						}
						else if (!empty($row->likes) AND empty($row->dislikes)) 
						{
							return 'like';
						}
					}
					else
					{
						return 'none';
					}
				}
			}
		}
	}


	public function ReportPost()
	{
		if(isset($_POST['complaint']) AND isset($_FILES['image']) AND !empty($_POST['complaint']) AND !empty($_FILES['image']))
		{
			$error=[];
			$name=[];
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$postDetail=$this->postExist($_POST['post_id'],'details');
	        $decryptPost=$this->decryptData($postDetail);
	        if(is_array($decryptPost))
	        {
	        	if($decryptPost['user_id']!=$user_id AND $decryptPost['admin_status']=='publish' AND$decryptPost['post_status']!='private')
	        	{	
	        		$run=$this->con->prepare("SELECT * FROM `post_complaint` WHERE complaint_user_id=? AND post_user_id=? AND post_id=? AND admin_action=? ORDER BY id DESC");


	        		if(is_object($run))
	        		{
	        			$run->bindParam(1,$user_id,PDO::PARAM_INT);
	        			$run->bindParam(2,$decryptPost['user_id'],PDO::PARAM_INT);
	        			$run->bindParam(3,$decryptPost['id'],PDO::PARAM_INT);
	        			$run->bindValue(4,"Null",PDO::PARAM_STR);
	        			if($run->execute())
	        			{
	        				
	        				if($run->rowCount()>0)
	        				{
	        					return 'already_complaint';
	        				}
	        				else
	        				{
	        					foreach ($_FILES['image']['tmp_name'] as $key => $value) 
								{
						            $file_tmpname = $_FILES['image']['tmp_name'][$key];
						            $file_name = $_FILES['image']['name'][$key];
						            $file_size = $_FILES['image']['size'][$key];
						            
						            $allowed_ext=array('MKV','mkv','mp4','MP4','jpeg','JPEG','jpg','JPG');

									$exp=explode(".",$file_name);
						            $end=end($exp);

						            if (!in_array($end, $allowed_ext)) 
						            {
						            	$error[]="(".$file_name.")";
						            }
						            else
						            {
						            	if(empty($error))
						            	{
						            		$fileName=mt_rand(11111,99999).'_'.preg_replace('/\s+/', '', $file_name);
							            	$path="../public/assets/post_report/".$fileName;
							            	if (move_uploaded_file($file_tmpname, $path)) 
								   	        {
								   	        	$name[]=$fileName."940961";
								   	        }
								   	        else
								   	        {
								   	        	return 'not_upload';
								   	        }
						            	}
						            }
						        }

						        if(is_array($name) AND !empty($name) AND empty($error))
						        {

					              $filename=encryption('encrypt',implode("",$name));

					              $run=$this->con->prepare('INSERT INTO `post_complaint`(`complaint_user_id`,`post_user_id`, `post_id`, `complaint`, `post_file_name`) VALUES (?,?,?,?,?)');

					              if(is_object($run))
					              {
					              	$complaint=encryption('encrypt',$_POST['complaint']);
					              	$run->bindParam(1,$user_id,PDO::PARAM_INT);
					              	$run->bindParam(2,$decryptPost['user_id'],PDO::PARAM_INT);
					              	$run->bindParam(3,$decryptPost['id'],PDO::PARAM_INT);
					              	$run->bindParam(4,$complaint,PDO::PARAM_STR);
					              	$run->bindParam(5,$filename,PDO::PARAM_STR);

					              	if($run->execute())
					              	{
					              		return 'success';
					              	}
					              }
						        }
						        

						        return $error;
	        				}
	        			}
	        		}
			    }
			    else
		        {
		        	return "invalid_post";
		        }
	        }
	        else
	        {
	        	return "invalid_post";
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
            		$offset=$_POST['offset'];
			        $rows=$_POST['rows'];
			        $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			        $allFriends=$this->getAllFriends($user_id);

        			$status1=encryption('encrypt','public');
			        $status2=encryption('encrypt','friend');
			        $admin_status=encryption('encrypt','publish');
			        $request=encryption('encrypt','friend');
			        $post_delete='NULL';

					if($allFriends=='zeroFriends' AND !is_array($allFriends))
					{
						$run=$this->con->prepare("SELECT `posts`.*,image,name,email,account_type FROM `posts` 
            			RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` 
            			LEFT JOIN `follower` ON `follower`.`follow_user_id`=`posts`.`user_id` 
            			WHERE  `posts`.`admin_status`=? AND `posts`.post_delete=? AND `posts`.`post_status` IN (?,?) AND `follower`.`user_id`=? AND `follower`.`date_time` < `posts`.`post_date` GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?");

				        $run->bindParam(1,$admin_status,PDO::PARAM_STR);
				        $run->bindParam(2,$post_delete,PDO::PARAM_STR);
				        $run->bindParam(3,$status1,PDO::PARAM_STR);
				        $run->bindParam(4,$status2,PDO::PARAM_STR);
				        $run->bindParam(5,$user_id,PDO::PARAM_STR);
				        $run->bindParam(6,$offset,PDO::PARAM_INT);
				        $run->bindParam(7,$rows,PDO::PARAM_INT);
            		}
            		else
            		{
            			$run=$this->con->prepare("SELECT `posts`.*,image,name,email,account_type FROM `posts` 
            			RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` 
            			LEFT JOIN `friend_request` ON `friend_request`.`user_id`=`posts`.`user_id` 
            			LEFT JOIN `follower` ON `follower`.`follow_user_id`=`posts`.`user_id` WHERE `friend_request`.request=? AND `friend_request`.`send_user_id`=? AND `posts`.`admin_status`=? AND `posts`.post_delete=? AND `posts`.`post_status` IN (?,?) AND `friend_request`.`updated_at` < `posts`.`post_date` OR `follower`.`user_id`=? AND `follower`.`date_time` < `posts`.`post_date` GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?");

            		    $run->bindParam(1,$request,PDO::PARAM_STR);
				        $run->bindParam(2,$user_id,PDO::PARAM_INT);
				        $run->bindParam(3,$admin_status,PDO::PARAM_STR);
				        $run->bindParam(4,$post_delete,PDO::PARAM_STR);
				        $run->bindParam(5,$status1,PDO::PARAM_STR);
				        $run->bindParam(6,$status2,PDO::PARAM_STR);
				        $run->bindParam(7,$user_id,PDO::PARAM_STR);
				        $run->bindParam(8,$offset,PDO::PARAM_INT);
				        $run->bindParam(9,$rows,PDO::PARAM_INT);
            		}



			        if($run->execute())
			        {
			        	if($run->rowCount()>0)
			        	{
			        	    return $this->decryptData($run->fetchAll());
			        	}
			        	
			        }
            		
            	}
            }
        }
	}



	public function notification()
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$offset=$_POST['offset'];
			$rows=$_POST['rows'];
			$allFriends=$this->getAllFriends($user_id);
			$admin_status=encryption('encrypt','publish');
			$request1=encryption('encrypt','friend');

			if($allFriends=='zeroFriends' AND !is_array($allFriends))
			{
				$run=$this->con->prepare('SELECT `notification`.*,`posts`.`id` AS post_id,`posts`.`user_id` AS postUserId,`posts`.`post_file_name`,`posts`.`post_text` FROM `notification` 
					LEFT JOIN `posts` ON `notification`.`post_id`=`posts`.`id` 
					left JOIN `follower` ON `notification`.`user_id`=`follower`.`follow_user_id` 
					WHERE `posts`.`admin_status`=? AND `notification`.`post_user_id`=? OR `follower`.follow_user_id=? AND `follower`.`date_time` < `notification`.notif_date OR  `follower`.`date_time` < `posts`.`post_date` GROUP BY `notification`.id ORDER BY `notification`.`id` DESC LIMIT ?,?');

				$run->bindParam(1,$admin_status,PDO::PARAM_STR);
				$run->bindParam(2,$user_id,PDO::PARAM_INT);
				$run->bindParam(3,$user_id,PDO::PARAM_INT);
				$run->bindParam(4,$offset,PDO::PARAM_INT);
				$run->bindParam(5,$rows ,PDO::PARAM_INT);
			}
			else
			{
				$run=$this->con->prepare('SELECT `notification`.*,`posts`.`id` AS post_id,`posts`.`user_id` AS postUserId,`posts`.`post_file_name`,`posts`.`post_text` FROM `notification` 
					LEFT JOIN `posts` ON `notification`.`post_id`=`posts`.`id` 
					left JOIN `friend_request` ON `notification`.`user_id`=`friend_request`.`send_user_id` 
					left JOIN `follower` ON `notification`.`user_id`=`follower`.`follow_user_id` 
					WHERE `posts`.`admin_status`=? AND `notification`.`post_user_id`=? OR `friend_request`.`user_id`=? AND `friend_request`.`request`=? OR `follower`.follow_user_id=? AND `friend_request`.`date_time` < `notification`.notif_date OR  `follower`.`date_time` < `posts`.`post_date` GROUP BY `notification`.id ORDER BY `notification`.`id` DESC LIMIT ?,?');



				$run->bindParam(1,$admin_status,PDO::PARAM_STR);
				$run->bindParam(2,$user_id,PDO::PARAM_INT);
				$run->bindParam(3,$user_id,PDO::PARAM_INT);
				$run->bindParam(4,$request1,PDO::PARAM_STR);
				$run->bindParam(5,$user_id,PDO::PARAM_INT);
				$run->bindParam(6,$offset,PDO::PARAM_INT);
				$run->bindParam(7,$rows ,PDO::PARAM_INT);
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


	public function getNewsfeedPost($postType)
	{
		if(isset($_POST['offset']) AND isset($_POST['rows']) AND !empty($postType))
		{
	        $offset=$_POST['offset'];
	        $rows=$_POST['rows'];
	        $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	        $allFriends=$this->getAllFriends($user_id);

			$status1=encryption('encrypt','public');
	        $status2=encryption('encrypt','friend');
	        $admin_status=encryption('encrypt','publish');
	        $request=encryption('encrypt','friend');
	        $post_delete='NULL';

			if($allFriends=='zeroFriends' AND !is_array($allFriends))
			{

    		 $run=$this->con->prepare("SELECT `posts`.*,image,name,email,account_type,bluetick FROM `posts` 
    			RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id`  
    			LEFT JOIN `follower` ON `follower`.`follow_user_id`=`posts`.`user_id` 
    			WHERE `posts`.`post_file_type` like ?  AND `posts`.`admin_status`=? AND `posts`.post_delete=? AND `posts`.`post_status` IN (?,?) AND  `follower`.`user_id`=? AND `follower`.`date_time` < `posts`.`post_date` GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?");

    			$run->bindParam(1,$postType,PDO::PARAM_STR);
		        $run->bindParam(2,$admin_status,PDO::PARAM_STR);
		        $run->bindParam(3,$post_delete,PDO::PARAM_STR);
		        $run->bindParam(4,$status1,PDO::PARAM_STR);
		        $run->bindParam(5,$status2,PDO::PARAM_STR);
		        $run->bindParam(6,$user_id,PDO::PARAM_STR);;
		        $run->bindParam(7,$offset,PDO::PARAM_INT);
		        $run->bindParam(8,$rows,PDO::PARAM_INT);
        	}
        	else
        	{
        		$run=$this->con->prepare("SELECT `posts`.*,image,name,email,account_type,bluetick FROM `posts` 
    			RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` 
    			LEFT JOIN `friend_request` ON `friend_request`.`user_id`=`posts`.`user_id` 
    			LEFT JOIN `follower` ON `follower`.`follow_user_id`=`posts`.`user_id` 
    			WHERE `posts`.`post_file_type` like ? AND `friend_request`.request=? AND `friend_request`.`send_user_id`=? AND `posts`.`admin_status`=? AND `posts`.post_delete=? AND `posts`.`post_status` IN (?,?) AND `friend_request`.`updated_at` < `posts`.`post_date` OR `follower`.`user_id`=? AND `follower`.`date_time` < `posts`.`post_date` AND `posts`.`post_file_type` like ? GROUP BY `posts`.`id` ORDER BY `posts`.id DESC LIMIT ?,?");

    			$run->bindParam(1,$postType,PDO::PARAM_STR);
		        $run->bindParam(2,$request,PDO::PARAM_STR);
		        $run->bindParam(3,$user_id,PDO::PARAM_INT);
		        $run->bindParam(4,$admin_status,PDO::PARAM_STR);
		        $run->bindParam(5,$post_delete,PDO::PARAM_STR);
		        $run->bindParam(6,$status1,PDO::PARAM_STR);
		        $run->bindParam(7,$status2,PDO::PARAM_STR);
		        $run->bindParam(8,$user_id,PDO::PARAM_STR);
		        $run->bindParam(9,$postType,PDO::PARAM_STR);
		        $run->bindParam(10,$offset,PDO::PARAM_INT);
		        $run->bindParam(11,$rows,PDO::PARAM_INT);

        	}

	        if($run->execute())
	        {
	        	if($run->rowCount()>0)
	        	{
	        	    return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
	        	}
	        	
	        }
    		
		}
	}



	public function getpostComplaint()
	{
		if(isset($_POST['post_id']))
		{
			$post_id=encryption('decrypt',$_POST['post_id']);
			if($post_id!=false)
			{
				$run=$this->con->prepare("SELECT * FROM `post_complaint` WHERE complaint_user_id=? AND post_id=? ORDER BY id DESC");

				if(is_object($run))
				{
					$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$post_id,PDO::PARAM_INT);
					if($run->execute())
					{
						if($run->rowCount()>0)
						{
							return $run->fetchAll(PDO::FETCH_ASSOC);
						}
					}
				}
			}
			else
			{
				return 'invalid_post_id';
			}
		}

		return false;
	}



}

?>