<?php

trait modelTrait{

	public function getUser($get,$value=Null)
	{
        if($get=='id')
		{
			$run=$this->con->prepare('SELECT * FROM users WHERE id=?');
			$run->bindParam(1,$value,PDO::PARAM_INT);
		}
		else if($get=='email')
		{
			
			if(encryption('decrypt',$value)!=false)
			{
				$email=$value;	
			}
			else{
				$email=encryption('decrypt',$value);
			}


			$run=$this->con->prepare('SELECT * FROM users WHERE email=?');
			$run->bindParam(1,$email,PDO::PARAM_STR);
		}
		else if($get=='allUsers')
		{
			$allFriends=null;
	   	    $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	   	    $run=$this->con->prepare('SELECT user_id FROM `friend_request` WHERE send_user_id=?');
	   	    if(is_object($run))
	   	    {
	   	    	$run->bindParam(1,$user_id,PDO::PARAM_INT);
	   	    	if($run->execute())
	   	    	{
	   	    		if($run->rowCount()>0)
	   	    		{
	   	    		    $row=$run->fetchAll(PDO::FETCH_ASSOC);
		   	    		foreach ($row as $key => $value) 
		   	    		{
		   	    		   $allFriends.=$value['user_id'].',';	
		   	    		}
	   	    		}
	   	    	}
	   	    }
	   	    $allFriends.=$user_id;

	   	    $run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND (country=? AND state=?) ORDER BY id DESC ");


	   	    if(is_object($run))
			{
			    $data=$this->getUser('email',$_SESSION['loginUser'][1]);
				$country=encryption('encrypt',$data['country']);
			    $state=encryption('encrypt',$data['state']);

				$status1=encryption('encrypt','notVerify');
				$status2=encryption('encrypt','block');
				$run->bindParam(1,$status1,PDO::PARAM_STR);
				$run->bindParam(2,$status2,PDO::PARAM_STR);
			    $run->bindParam(3,$country,PDO::PARAM_STR);
			    $run->bindParam(4,$state,PDO::PARAM_STR);

			}
		}


		if($run->execute())
	    {
	    	if($get=='allUsers')
			{
              $row=$run->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				$row=$run->fetch(PDO::FETCH_ASSOC);
			}
			
			return $this->decryptData($row);
	    }


		return false;

	}

	public function decryptData($array)
	{
		if(!empty($array))
		{
			if (count($array) == count($array, COUNT_RECURSIVE)) 
			{
			    foreach ($array as $key => $value) 
			    {
			    	if(!empty($value))
			    	{
			    		if(encryption('decrypt', $value)!=false)
				    	{
				    		$data[$key]=encryption('decrypt', $value);
				    	}
				    	else
				    	{
				    		$data[$key]=$value;
				    	}	
			    	} 
			    	else
			    	{
			    		$data[$key]=null;
			    	}
			    }
			}
			else
			{
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
			}

		    return $data;
		}

		return false;
	}


	public function decryptDataChatBox($array)
	{
		if(!empty($array))
		{
			if (count($array) == count($array, COUNT_RECURSIVE)) 
			{
			    foreach ($array as $key => $value) 
			    {
			    	if(!empty($value))
			    	{
			    		if($key=='id')
			        	{
			        		$data[$key]=$value;
			        	}
			        	else
			        	{
				        	$encryptionKey=encryption('encrypt',$value['user_id']).encryption('encrypt',$value['friend_id']);

				        	if(encryptDecryptChat('decrypt',$value,$encryptionKey)!=false AND $key!='name' || $key!='image')
				        	{
				        		$data[$key]=encryptDecryptChat('decrypt',$value,$encryptionKey);
				        	}
				        	else
				        	{
				        		if($key=='name' || $key=='image' || $key=='seen_status' || $key=='message_status' || $key=='chatBox')
					        	{
						    		if(encryption('decrypt', $value)!=false)
							    	{
							    		$data[$key]=encryption('decrypt', $value);
							    	}
							    	else
							    	{
							    		$data[$key]=$value;
							    	}	
						    	} 
						    	else
						    	{
						    		$data[$key]=$value;
						    	}
				        	}
			        	}
			    	} 
			    	else
			    	{
			    		$data[$key]=null;
			    	}
			    }
			}
			else
			{
			    foreach ($array as $key1 => $value1) 
			    {
			    	foreach ($value1 as $key => $value) 
			        {
			           if(!empty($value))
			    	   {
				        	if($key=='id')
				        	{
				        		$data[$key1][$key]=$value;
				        	}
				        	else
				        	{
					        	$encryptionKey=encryption('encrypt',$value1['user_id']).encryption('encrypt',$value1['friend_id']);
					        	if(encryptDecryptChat('decrypt',$value,$encryptionKey)!=false AND $key!='name' || $key!='image')
					        	{
					        		$data[$key1][$key]=encryptDecryptChat('decrypt',$value,$encryptionKey);
					        	}
					        	else
					        	{
					        		if($key=='name' || $key=='image' || $key=='seen_status' || $key=='message_status' || $key=='chatBox')
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
							    		$data[$key1][$key]=$value;
							    	}
					        	}
				        	}
				        }
				        else
				    	{
				    		$data[$key1][$key]=null;
				    	}
			        }
			    }
			}

		    return $data;
		}

		return false;
	}
	public function friendRequestCheck($user_id,$send_user_id,$request)
	{
		if(isset($user_id) AND isset($send_user_id))
		{
			if ($request==='send' OR $request==='friend') 
		    {
				$run=$this->con->prepare("SELECT * FROM `friend_request` WHERE user_id=? AND send_user_id=? AND request=?");

				if(is_object($run))
				{
					$run->bindParam(1,$user_id,PDO::PARAM_STR);
					$run->bindParam(2,$send_user_id,PDO::PARAM_STR);
					$run->bindParam(3,$request,PDO::PARAM_STR);
				}
			}
			else
			{
				$run=$this->con->prepare("SELECT * FROM `friend_request` WHERE user_id=? AND send_user_id=?");

				if(is_object($run))
				{

					$run->bindParam(1,$user_id,PDO::PARAM_STR);
					$run->bindParam(2,$send_user_id,PDO::PARAM_STR);
				}
			}

		    if($run->execute())
			{
				if($run->rowCount()>0)
				{
					if ($request==='getdata') 
					{
						$row=$run->fetch(PDO::FETCH_ASSOC);

						$data['id']=$row['id'];
						$data['user_id']=$row['user_id'];
						$data['send_user_id']=$row['send_user_id'];
						$data['request']=encryption('decrypt',$row['request']);
						$data['request_sender_id']=$row['request_sender_id'];
						$data['date_time']=$row['date_time'];
						$data['updated_at']=$row['updated_at'];
						
						return $data;
					}
					else if ($request==='send' OR $request==='friend' OR $request==='exist')
					{
						return true;
					}
				}
			}
		}

		return false;
	}

	public function follower($request,$user_id,$followUserId=null)
	{
	   if($followUserId==null AND $request=='getAll' OR $request=='total')
	   {
	   	 $run=$this->con->prepare("SELECT * FROM `follower` JOIN `users` ON `users`.`id`=`follower`.`user_id` WHERE `follower`.follow_user_id=? ORDER BY `follower`.id DESC");

	   	 $run->bindParam(1,$user_id,PDO::PARAM_INT);
	   }
	   else
	   {
	     $run=$this->con->prepare("SELECT * FROM `follower` WHERE `user_id`=? AND `follow_user_id`=?");
	   	 $run->bindParam(1,$user_id,PDO::PARAM_INT);
		 $run->bindParam(2,$followUserId,PDO::PARAM_INT);
	   }

		
		if($run->execute())
		{
			if($run->rowCount()>=1)
			{
				if($request=='check')
				{
					return $this->decryptData($run->fetch(PDO::FETCH_ASSOC));
				}
				else if($request=='getAll')
				{
					
					return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
				}
				else if($request=='total')
				{
					return $run->rowCount();
				}
				
			}
			else
			{
				return 'empty';
			}
		}
		


		return false;
	}

	public function getAllFriends($id)
	{
		if(!empty($id))
		{
			$run=$this->con->prepare('SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? ORDER BY `friend_request`.id DESC');

			if(is_object($run))
			{
				$request=encryption('encrypt','friend');
				$run->bindParam(1,$id,PDO::PARAM_STR);
				$run->bindParam(2,$request,PDO::PARAM_STR);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						$row=$run->fetchAll(PDO::FETCH_ASSOC);
						return $this->decryptData($row);
					}
					else
					{
						return 'zeroFriends';
					}
				}
			}
		}

		return false;
	}

	
	public function deleteNotification($type=null,$postId=null,$post_user_id=null,$action=null)
	{
		if(!empty($postId))
		{
			if($type=='postDelete')
			{
				$run=$this->con->prepare("DELETE FROM `notification` WHERE post_id=?");
			    $run->bindParam(1,$postId,PDO::PARAM_INT);
			}
			else
			{
				$run=$this->con->prepare("DELETE FROM `notification` WHERE post_id=? AND user_id=? AND notif_type=?");
			    $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			    $type=encryption('encrypt',$type);
			    $run->bindParam(1,$postId,PDO::PARAM_INT);
			    $run->bindParam(2,$user_id,PDO::PARAM_INT);
			    $run->bindParam(3,$type,PDO::PARAM_STR);

			    $notifData=$this->notificationSelect($postId,$type);
			}
			if($run->execute())
			{

				if($type=='postDelete')
				{
					if($action=='adminDeletePost')
					{
						$user_id=$post_user_id;				
					}
					else
					{
						if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser'])) 
	                    {
	                    	$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
	                    }

					}
					

	                $getFriends=$this->getAllFriends($user_id);
	                $run=$this->con->prepare("DELETE FROM `notification_pending` WHERE post_id=?");
	                $run->bindParam(1,$postId,PDO::PARAM_INT);
	                $run->execute();
				}
				else
				{
					$run=$this->con->prepare("DELETE FROM `notification_pending` WHERE post_id=? AND notif_user_id=? AND notif_id=?");
	                $run->bindParam(1,$postId,PDO::PARAM_INT);
	                $run->bindParam(2,$post_user_id,PDO::PARAM_INT);
	                $run->bindParam(3,$notifData['id'],PDO::PARAM_INT);
	                $run->execute();

				}
				
				return true;
			}
		}
	}

	public function postDelete($post_id=null)
	{
		if($post_id==null)
		{
			$postID=$_POST['delete_id'];
		}
		else
		{
			$postID=$post_id;
		}

		if(isset($postID))
		{
			$postDetail=$this->postExist($postID,'details');

			if(is_array($postDetail))
			{
				$decryptPost=$this->decryptData($postDetail);

				$postId=encryption('decrypt',$postID);

				if($post_id==null)
				{
					if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser'])) 
	                {
	                	$userId=encryption('decrypt',$_SESSION['loginUser'][0]);
	                }
				}
				else
				{

	                $userId=$decryptPost['user_id'];
					
				}
				
				
				if($postId!=false)
				{
					if($decryptPost['post_text']=='Updated his profile photo')
					{
						$run=$this->con->prepare('UPDATE `users` SET image=? WHERE id=?');
				        if (is_object($run))
				        {
				        	$image=encryption('encrypt', 'profile.jpg');
			            	$run->bindParam(1,$image,PDO::PARAM_STR);
			            	$run->bindParam(2,$userId,PDO::PARAM_STR);
			            	$run->execute();
						}
					}
					else if($decryptPost['post_text']=='Updated his cover photo')
					{
						$run=$this->con->prepare('UPDATE `users` SET bg_image=? WHERE id=?');
				        if (is_object($run))
				        {
				        	$image=encryption('encrypt', 'cover.png');
			            	$run->bindParam(1,$userId,PDO::PARAM_STR);
			            	$run->bindParam(2,$email,PDO::PARAM_STR);
			            	$run->execute();
						}
					}

					if($post_id==null)
					{
						$delete=encryption('encrypt','userDeletePost');
						$run=$this->con->prepare('UPDATE `posts` SET `post_delete`=? WHERE id=? AND user_id=?');
						if(is_object($run))
						{
							$run->bindParam(1,$delete,PDO::PARAM_STR);
							$run->bindParam(2,$postId,PDO::PARAM_INT);
							$run->bindParam(3,$userId,PDO::PARAM_STR);

							if($run->execute())
							{
								$this->deleteNotification('postDelete',$postId);
								return 'success';
							}
						}
					}
					else
					{
						$delete=encryption('encrypt','adminDeletePost');
						$adminStatus=encryption('encrypt','notPublish');
						$run=$this->con->prepare('UPDATE `posts` SET `post_delete`=?,`admin_status`=? WHERE id=? AND user_id=?');
						if(is_object($run))
						{
							$run->bindParam(1,$delete,PDO::PARAM_STR);
							$run->bindParam(2,$adminStatus,PDO::PARAM_STR);
							$run->bindParam(3,$postId,PDO::PARAM_INT);
							$run->bindParam(4,$userId,PDO::PARAM_INT);

							if($run->execute())
							{
								
								$this->deleteNotification('postDelete',$postId,$userId,'adminDeletePost');
								return 'success';
							}
						}
					}


				}
			}
		}

		return 'error';
	}

	public function postExist($postId,$type=null)
	{
		if(!empty($postId))
		{
			$post_id=encryption('decrypt',$postId);
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

			  	       if($type==null)
				       {
			  	    	  return true;
			  	       }  
			  	       else if($type='details')
					   {
						return $run->fetch(PDO::FETCH_ASSOC);
					   }
			  	    }
				}
			}
		
		}

		return false;
	}

	public function getPostComplaint($get,$id)
    {

    	if($get=='complaintID') 
    	{
    		$run=$this->con->prepare('SELECT * FROM `post_complaint` WHERE id=? AND `admin_action` NOT IN(?)');
    	}
    	else if($get=='postID') 
    	{
    		$run=$this->con->prepare('SELECT * FROM `post_complaint` WHERE post_id=? AND `admin_action` NOT IN(?) ORDER BY id DESC');
    	}
    	
    	
    	if(!empty($id))
    	{
    		if(is_object($run))
	      	{
		      	$run->bindParam(1,$id,PDO::PARAM_INT);
		      	$run->bindValue(2,"Null",PDO::PARAM_STR);
		      	if($run->execute())
		      	{
		      		if($run->rowCount()>0)
		      		{
		      			if($get=='postID') 
		      			{
		      				return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
		      			}
		      			else if($get=='complaintID') 
		      			{

		      				return $this->decryptData($run->fetch(PDO::FETCH_ASSOC));
		      			}
		      		}
		      		else
		      		{
		      			return 'not_found';
		      		}
		      	}
		    }
    	}
	    

	    return false;
    }

    public function deleteMessagesList($friendId)
	{
		if(!empty($friendId))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$friendRequest=$this->friendRequestCheck($user_id,$friendId,'friend');

			$run=$this->con->prepare('SELECT * FROM `message_list` WHERE user_id=? AND friend_id=?');
			if(is_object($run))
			{
				$run->bindParam(1,$user_id,PDO::PARAM_INT);
				$run->bindParam(2,$friendId,PDO::PARAM_INT);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						if($friendRequest==false)
						{
							$run=$this->con->prepare('DELETE FROM `message_list` WHERE user_id=? AND friend_id=?');
							if(is_object($run))
							{
								$run->bindParam(1,$user_id,PDO::PARAM_INT);
				                $run->bindParam(2,$friendId,PDO::PARAM_INT);
								if($run->execute())
								{
									$run->bindParam(1,$friendId,PDO::PARAM_INT);
				                    $run->bindParam(2,$user_id,PDO::PARAM_INT);
				                    $run->execute();

									return 'delete';
								}
							}
						}
					}
				}
			}
		}

		return 'notdelete';
	}

	public function current_time()
	{
	    //Select Current time on Database
	    $time_query="SELECT CURRENT_TIMESTAMP AS current_date_time";
	    $run=$this->con->prepare($time_query);

	    if ($run->execute()) 
	    {
	        $time_row=$run->fetch(PDO::FETCH_OBJ);
	        $current_date_time=$time_row->current_date_time;
	    }

	    return $current_date_time;

	    
	}

}

?>