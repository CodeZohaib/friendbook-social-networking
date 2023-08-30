<?php


class mlFriendRequest extends database{
	use modelTrait;


	public function sendRequest()
	{
		if(isset($_POST['request_id'])AND isset($_POST['request_class']))
		{
			
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$request_id=encryption('decrypt',$_POST['request_id']);
			$request_type=encryption('encrypt','send');
			$request_class=$_POST['request_class'];

			if($request_id!=false)
			{
				$request_user=$this->getUser('id',$request_id);
				if(is_array($request_user) AND $request_user['id']==$request_id)
				{
				   //Send the User Request
				   if ($request_class==='friend_request' OR $request_class==='friend_request_sidbar')
	               {
	                 	$data=$this->friendRequestCheck($user_id,$request_id,'getdata');
	                 	$RequestCheck=$this->friendRequestCheck($request_id,$user_id,'getdata');

	                 	if(is_array($RequestCheck) AND $RequestCheck['user_id']==$request_id AND $RequestCheck['request']==$request_type)
			            {
			            	return 'already_send_friendrequest';
			            }
			            else if(is_array($RequestCheck) AND $RequestCheck['user_id']==$request_id AND $RequestCheck['request']=='block')
			            {
			            	return 'user_block';
			            }
			            else
			            {
			            	
			            	if(is_array($data) AND $data['send_user_id']==$request_id)
				            {
				            	$run=$this->con->prepare("DELETE FROM `friend_request` WHERE `user_id`=? AND `send_user_id`=? AND request=?");
				            	if(is_object($run))
				            	{
									$run->bindParam(1,$user_id,PDO::PARAM_INT);
									$run->bindParam(2,$request_id,PDO::PARAM_INT);
									$run->bindParam(3,$request_type,PDO::PARAM_STR);


									if($run->execute())
									{
										$run->bindParam(1,$request_id,PDO::PARAM_STR);
									    $run->bindParam(2,$user_id,PDO::PARAM_STR);
									    $run->bindParam(3,$request_type,PDO::PARAM_STR);

									    $run->execute();

										if($request_type==='friend_request_sidbar')
										{
											return 'Add Friend Sidbar';
										}
										else
										{
											return 'Add Friend';
										}
									}
				            	}
				            }
				            else
				            {
				                $run=$this->con->prepare("INSERT INTO `friend_request`(`user_id`,`send_user_id`,`request`,`request_sender_id`)VALUES (?,?,?,?)");

								if(is_object($run))
								{
									$run->bindParam(1,$user_id,PDO::PARAM_INT);
									$run->bindParam(2,$request_id,PDO::PARAM_INT);
									$run->bindParam(3,$request_type,PDO::PARAM_STR);
									$run->bindParam(4,$user_id,PDO::PARAM_INT);

									if($run->execute())
									{

									  $run=$this->con->prepare("INSERT INTO `friend_request`(`user_id`,`send_user_id`,`request`)VALUES (?,?,?)");
										$run->bindParam(1,$request_id,PDO::PARAM_INT);
									    $run->bindParam(2,$user_id,PDO::PARAM_INT);
									    $run->bindParam(3,$request_type,PDO::PARAM_STR);

									    $run->execute();

										if($request_type==='friend_request_sidbar')
										{
											return 'Send Request Sidbar';
										}
										else
										{
											return 'Request Send';
										}
									}
								}
				            }
			            }
				   }//Accept the User Request
				   else if ($request_class==='accept_request' OR $request_class==='accept_request_profile') 
				   {
				   	    $data=$this->friendRequestCheck($request_id,$user_id,'getdata');
					   	if(is_array($data) AND $data['user_id']==$request_id)
				        {
				         	if($data['request']==='friend')
				         	{
				         		return 'already_friend';
				         	}
				         	else if($data['request']==='block')
				         	{
				         		return 'user_block';
				         	}
				         	else
				         	{
				         		$run=$this->con->prepare('UPDATE `friend_request` SET `request`=? WHERE `send_user_id`=? AND `user_id`=?');
				         		if(is_object($run))
				         		{
				         			$request=encryption('encrypt','friend');
				         			$run->bindParam(1,$request,PDO::PARAM_STR);
				         			$run->bindParam(2,$data['send_user_id'],PDO::PARAM_STR);
				         			$run->bindParam(3,$data['user_id'],PDO::PARAM_STR);

				         			if($run->execute())
				         			{
				         				$run->bindParam(1,$request,PDO::PARAM_STR);
				         			    $run->bindParam(2,$data['user_id'],PDO::PARAM_STR);
				         			    $run->bindParam(3,$data['send_user_id'],PDO::PARAM_STR);
				         			    $run->execute();

				         				if ($request_class==='accept_request') 
										{
											return 'Accept Request';
										}
										else
										{
											return 'Accept_request_profile';
										}
				         			}
				         		}
				         	}
				        }
				        else
						{
							return 'invalid_user_request';
						}	
				   }//Cancle Friend Request
				   else if ($request_class==='cancle_request' OR $request_class==='cancle_request_profile')
		           {

		           	    $data=$this->friendRequestCheck($request_id,$user_id,'getdata');
			           	$request_user=$this->getUser('id',$request_id);
						if(is_array($request_user) AND $request_user['id']==$request_id)
						{
			             	if(is_array($data) AND $data['user_id']==$request_id AND $data['send_user_id']==$user_id AND $data['request']=='send')
				            {
				            	$run=$this->con->prepare("DELETE FROM `friend_request` WHERE `user_id`=? AND `send_user_id`=? AND request=?");
				            	if(is_object($run))
				            	{
				            		$request=encryption('encrypt',$data['request']);

									$run->bindParam(1,$request_id,PDO::PARAM_STR);
									$run->bindParam(2,$user_id,PDO::PARAM_STR);
									$run->bindParam(3,$request,PDO::PARAM_STR);

									if($run->execute())
									{
										$run->bindParam(1,$user_id ,PDO::PARAM_STR);
									    $run->bindParam(2,$request_id,PDO::PARAM_STR);
									    $run->bindParam(3,$request,PDO::PARAM_STR);

									    $run->execute();

										if ($request_class==='cancle_request') 
										{
											return 'Cancle Request';
										}
										else
										{
											return 'Request_cancle_profile';
										}
									}
				            	}
				            }
				            else
							{
								return 'invalid_user_request';
							}	
			            }
			            else
						{
							return 'invalid_user_request';
						}	
		           }
				}
				else
				{
					return 'invalid_user_request';
				}	
			}
			else
			{
				return 'invalid_user_request';
			}
		}

		return false;
	}

	public function getAllFriendRequest()
	{
		$run=$this->con->prepare('SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? AND `users`.`status` IN(?,?) AND `friend_request`.`request_sender_id` NOT IN(?) ORDER BY `friend_request`.id DESC');

		if(is_object($run))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$request=encryption('encrypt','send');
			$status1=encryption('encrypt','verify');
			$status2=encryption('encrypt','securityVerification');

			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindParam(2,$request,PDO::PARAM_STR);
			$run->bindParam(3,$status1,PDO::PARAM_STR);
			$run->bindParam(4,$status2,PDO::PARAM_STR);
			$run->bindParam(5,$user_id,PDO::PARAM_INT);

			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					$row=$run->fetchAll(PDO::FETCH_ASSOC);
					return $this->decryptData($row);
				}
			}
		}

		return false;
	}

	public function getfriends($id)
	{
		if(!empty($id) AND isset($_POST['rows']) AND isset($_POST['offset']))
		{
			$rows=$_POST['rows'];
			$offset=$_POST['offset'];

			$run=$this->con->prepare('SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? ORDER BY `friend_request`.id DESC LIMIT ?,?');

			if(is_object($run))
			{
				$request=encryption('encrypt','friend');
				$run->bindParam(1,$id,PDO::PARAM_STR);
				$run->bindParam(2,$request,PDO::PARAM_STR);
				$run->bindParam(3,$offset,PDO::PARAM_INT);
				$run->bindParam(4,$rows,PDO::PARAM_INT);

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

	public function displayBlockUser()
	{
		$run=$this->con->prepare("SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`send_user_id`=`users`.`id` WHERE `friend_request`.`user_id`=? AND `friend_request`.`request`=? AND `users`.`status` IN(?,?) ORDER BY `users`.id DESC");

		if (is_object($run)) 
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$request=encryption('encrypt','blockUser');
			$status1=encryption('encrypt','verify');
			$status2=encryption('encrypt','securityVerification');


			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindValue(2,$request,PDO::PARAM_STR);
			$run->bindValue(3,$status1,PDO::PARAM_STR);
            $run->bindValue(4,$status2,PDO::PARAM_STR);

			if ($run->execute()) 
			{
				if ($run->rowCount()>0) 
				{
					return $run->fetchAll(PDO::FETCH_ASSOC);
				}
				else
				{
					return false;
				}
			}
		}

	}

	public function findBlockUser()
	{
		$run=$this->con->prepare("SELECT * FROM `users` WHERE `name` LIKE ? AND status IN (?,?) AND id NOT IN(?) ORDER BY id DESC");

		if(is_object($run))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$status1=encryption('encrypt','verify');
			$status2=encryption('encrypt','securityVerification');
			$name="%".$_POST['user_search']."%";

			$run->bindParam(1,$name,PDO::PARAM_STR);
			$run->bindValue(2,$status1,PDO::PARAM_STR);
			$run->bindValue(3,$status2,PDO::PARAM_STR);
			$run->bindValue(4,$user_id,PDO::PARAM_INT);

			if($run->execute())
			{
                if ($run->rowCount()>0) 
				{
					$data=$run->fetchAll(PDO::FETCH_ASSOC);

					return $this->decryptData($data);
				}
				else
				{
					return 'not_found';
				}
			}

		}

		return false;
	}


	public function blockUnblockUser()
	{

		if(isset($_POST))
		{
			$data=[];
			$blockName=[];
			$unblockName=[];
			$alreayBlockName=[];
			$alreayUnBlockName=[];

			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			foreach ($_POST['user_id'] as $value) 
			{
				$friend_id=encryption('decrypt',$value);
				if($friend_id==true)
				{
					$Userdata=$this->getUser('id',$friend_id);

					if(!is_array($Userdata))
					{
						return 'invalidUser';
					}
					else
					{
						$friendData=$this->friendRequestCheck($user_id,$friend_id,'getdata');
						
						if($_POST['bulk_options']=='unblock')
						{
							if(is_array($friendData))
							{
								if($friendData['request']=='blockUser')
								{
									$run=$this->con->prepare('DELETE FROM `friend_request` WHERE user_id=? AND send_user_id=?');
									if(is_object($run))
									{
										$run->bindParam(1,$user_id,PDO::PARAM_INT);
										$run->bindParam(2,$friend_id,PDO::PARAM_INT);
										if($run->execute())
										{
											$run->bindParam(1,$friend_id,PDO::PARAM_INT);
										    $run->bindParam(2,$user_id,PDO::PARAM_INT);
										    $run->execute();
											$unblockName[]=$Userdata['name'];
										}
									}
								}
							}
							else
							{
								$alreayUnBlockName[]=$Userdata['name'];
							}
						}
						else if($_POST['bulk_options']=='block')
						{

							if(is_array($friendData))
							{
								if($friendData['request']=='blockUser')
								{
									$alreayBlockName[]=$Userdata['name'];
								}
								else if($friendData['request']=='friend' OR $friendData['request']=='send')
								{
									$run=$this->con->prepare('UPDATE `friend_request` SET `request`=? WHERE `user_id`=? AND send_user_id=?');
								
									if(is_object($run))
									{
										$request=encryption('encrypt','blockUser');
										$run->bindParam(1,$request,PDO::PARAM_STR);
										$run->bindParam(2,$user_id,PDO::PARAM_INT);
										$run->bindParam(3,$friend_id,PDO::PARAM_INT);

										if($run->execute())
										{
											$request2=encryption('encrypt','block');
											$run->bindParam(1,$request2,PDO::PARAM_STR);
										    $run->bindParam(2,$friend_id ,PDO::PARAM_INT);
										    $run->bindParam(3,$user_id,PDO::PARAM_INT);
										    $run->execute();
											$blockName[]=$Userdata['name'];
										}	
									}
								}
							}
							else
							{

								$run=$this->con->prepare('INSERT INTO `friend_request`(`user_id`, `send_user_id`,`request`) VALUES (?,?,?)');
								
								if(is_object($run))
								{
									$request=encryption('encrypt','blockUser');
									$run->bindParam(1,$user_id,PDO::PARAM_INT);
									$run->bindParam(2,$friend_id,PDO::PARAM_INT);
									$run->bindParam(3,$request,PDO::PARAM_STR);

									if($run->execute())
									{
										
										$request2=encryption('encrypt','block');
									    $run->bindParam(1,$friend_id ,PDO::PARAM_INT);
									    $run->bindParam(2,$user_id,PDO::PARAM_INT);
									    $run->bindParam(3,$request2,PDO::PARAM_STR);

									    $run->execute();

										$blockName[]=$Userdata['name'];
									}
								}
							}
							$checkMyfollwer=$this->follower('check',$user_id,$friend_id);
						    $checkMyfriend=$this->follower('check',$friend_id,$user_id);

						    if(is_array($checkMyfollwer))
						    {
						    	$run=$this->con->prepare("DELETE FROM `follower` WHERE user_id=? AND follow_user_id=?");
								if(is_object($run))
								{
									$run->bindParam(1,$user_id,PDO::PARAM_INT);
									$run->bindParam(2,$friend_id,PDO::PARAM_INT);
									$run->execute();
								}
						    }

						    if(is_array($checkMyfriend))
						    {
						    	$run=$this->con->prepare("DELETE FROM `follower` WHERE user_id=? AND follow_user_id=?");
								if(is_object($run))
								{
									$run->bindParam(1,$friend_id,PDO::PARAM_INT);
									$run->bindParam(2,$user_id,PDO::PARAM_INT);
									$run->execute();
								}
						    }
						}	
					}
				}
				else
				{
					return 'invalidUser';
				}
			}

			if(!empty($blockName))
			{
				$data['blockUser']=$blockName;
			}
			if(!empty($unblockName))
			{
				$data['unblockUser']=$unblockName;
			}
			if(!empty($alreayBlockName))
			{
				$data['alreayBlockUser']=$alreayBlockName;
			}

			if(!empty($alreayUnBlockName))
			{
				$data['alreayUnBlockName']=$alreayUnBlockName;
			}

			return $data;
		}
		
	}




	public function followUser($id)
	{
		 
		if(isset($id) AND !empty($id))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$check=$this->follower('check',$user_id,$id);
			if(is_array($check))
			{
				return 'already_follow';
			}
			else if($check=='empty')
			{
				$run=$this->con->prepare('INSERT INTO `follower`(`user_id`, `follow_user_id`) VALUES (?,?)');
				if(is_object($run))
				{
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$id,PDO::PARAM_INT);

					if($run->execute())
					{
						return 'success';
					}
				}
			}
		}
	}

	public function unfollowUser($id)
	{
		if(isset($id) AND !empty($id))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$check=$this->follower('check',$user_id,$id);
			if(is_array($check))
			{
				$run=$this->con->prepare("DELETE FROM `follower` WHERE user_id=? AND follow_user_id=?");
				if(is_object($run))
				{
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$id,PDO::PARAM_INT);
					if($run->execute())
					{
						return 'success';
					}
				}
			}
		}

		return false;
	}

	public function unfriendUser($id)
	{
		$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
		$friendData=$this->friendRequestCheck($user_id,$id,'getdata');
		if(is_array($friendData))
		{
			if($friendData['request']=='friend')
			{
				$run=$this->con->prepare('DELETE FROM `friend_request` WHERE user_id=? AND send_user_id=?');
				if(is_object($run))
				{
					$run->bindParam(1,$user_id,PDO::PARAM_INT);
					$run->bindParam(2,$id,PDO::PARAM_INT);
					if($run->execute())
					{
						$run->bindParam(1,$id,PDO::PARAM_INT);
					    $run->bindParam(2,$user_id,PDO::PARAM_INT);
					    if($run->execute())
					    {
					    	return 'success';
					    }
					}
				}
			}
		}
	}


	public function getTotalfriends()
	{
		if(isset($_POST['totalFriends']))
		{

			$run=$this->con->prepare('SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=?');

			if(is_object($run))
			{
				$userID=encryption('decrypt',$_SESSION['loginUser'][0]);
				$request=encryption('encrypt','friend');
				$run->bindParam(1,$userID,PDO::PARAM_INT);
				$run->bindParam(2,$request,PDO::PARAM_STR);
				if($run->execute())
				{

					if($run->rowCount()>0)
					{
						return $run->rowCount();
					}
				}
			}
		}

		return false;
	}


	public function getTotalFriendRequest()
	{
		if(isset($_POST['totalFriendRequest']))
		{

			$run=$this->con->prepare('SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? AND `users`.`status` IN(?,?) AND `friend_request`.`request_sender_id` NOT IN(?)');

			if(is_object($run))
			{
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
				$request=encryption('encrypt','send');
				$status1=encryption('encrypt','verify');
				$status2=encryption('encrypt','securityVerification');

				$run->bindParam(1,$user_id,PDO::PARAM_INT);
				$run->bindParam(2,$request,PDO::PARAM_STR);
				$run->bindParam(3,$status1,PDO::PARAM_STR);
				$run->bindParam(4,$status2,PDO::PARAM_STR);
				$run->bindParam(5,$user_id,PDO::PARAM_INT);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						return $run->rowCount();
					}
				}
			}
		}

		return false;
	}


	public function getTotalBlockUser()
	{
		$run=$this->con->prepare("SELECT * FROM `friend_request` RIGHT JOIN `users` ON `friend_request`.`send_user_id`=`users`.`id` WHERE `friend_request`.`user_id`=? AND `friend_request`.`request`=? AND `users`.`status` IN(?,?) ORDER BY `users`.id DESC");

		if (is_object($run)) 
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$request=encryption('encrypt','blockUser');
			$status1=encryption('encrypt','verify');
			$status2=encryption('encrypt','securityVerification');


			$run->bindParam(1,$user_id,PDO::PARAM_INT);
			$run->bindValue(2,$request,PDO::PARAM_STR);
			$run->bindValue(3,$status1,PDO::PARAM_STR);
            $run->bindValue(4,$status2,PDO::PARAM_STR);

			if ($run->execute()) 
			{
				if ($run->rowCount()>0) 
				{
					return $run->rowCount();
				}
			}
		}


		return false;
	}

}

?>