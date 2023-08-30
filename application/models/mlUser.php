<?php
include "modelTrait.php";

class mlUser extends database{

	use modelTrait;

	public function createAccount(array $data)
	{
		if(is_array($data) AND !empty($data))
		{
			if($this->getUser('email',encryption('encrypt',strtolower($data['email'])))===false)
			{
				$new_data=[];
			    foreach ($data as $key => $value) 
			    {
			    	if($key=='email' or $key=='name')
			    	{
			    		$new_data[$key]=encryption('encrypt', strtolower($value));
			    	}
			    	else
			    	{
			    		$new_data[$key]=encryption('encrypt', $value);
			    	}
			       	
			    }

			    $code        =mt_rand(1111,9999);
				$allowed_ext=array('JPG','jpg','jpeg','GIF','PNG','png');;
		        $exp=explode(".", $_FILES['image']['name']);
		        $end=end($exp);
		        $image_name=mt_rand(1111,9999).'_'.preg_replace('/\s+/', '', $_FILES['image']['name']);
		        $path="../public/assets/images/users/$image_name";
		        $temp=$_FILES['image']['tmp_name'];

		        $verification_code=encryption('encrypt', $code);
		        $ipAddress=encryption('encrypt', IpAddress());
		        $status=encryption('encrypt', 'notVerify');
		        $account_type=encryption('encrypt', 'public');
		        $email_type=encryption('encrypt', 'public');
		        $image_name=encryption('encrypt', $image_name);
		        $cover_img=encryption('encrypt', 'cover.png');

		        if(in_array($end,$allowed_ext))
		        {
		          $sql="INSERT INTO `users` (`name`, `email`,`email_type`,`account_type`,`country`,`state`, `address`,`password`, `gender`, `image`,`bg_image`,`verification_code`, `ip_address`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		          $run=$this->con->prepare($sql);
		          if (is_object($run)) 
			      {
			      	$name=strtolower($data['name']);
			        $run->bindParam(1,$name,PDO::PARAM_STR);
			        $run->bindParam(2,$new_data['email'],PDO::PARAM_STR);
			        $run->bindParam(3,$email_type,PDO::PARAM_STR);
			        $run->bindParam(4,$account_type,PDO::PARAM_STR);
			        $run->bindParam(5,$new_data['country'],PDO::PARAM_STR);
			        $run->bindParam(6,$new_data['state'],PDO::PARAM_STR);
				    $run->bindParam(7,$new_data['address'],PDO::PARAM_STR);
				    $run->bindParam(8,$new_data['password'],PDO::PARAM_STR);
				    $run->bindParam(9,$new_data['gender'],PDO::PARAM_STR);
				    $run->bindParam(10,$image_name,PDO::PARAM_STR);
				    $run->bindParam(11,$cover_img,PDO::PARAM_STR);
				    $run->bindParam(12,$verification_code,PDO::PARAM_STR);
				    $run->bindParam(13,$ipAddress,PDO::PARAM_STR);
				    $run->bindParam(14,$status,PDO::PARAM_STR);
				    if($run->execute())
				    {
				       if (move_uploaded_file($temp, $path)) 
				       {
				       	 $subject='Confirmation Code';
			             $message="<p>Hello ".$data['name']."...!<br>Your Confirmation Code is:- $code</p><br><hr>
			            <p>If You Think You Did Not Make This Request, Just ignore this email</p>";
				          if (mail($data['email'], $subject, $message,"Content-type: text/html\r\n")) 
				          {
				          	$_SESSION['confirm_email']=[
				          	   $new_data['name'],
		                       $new_data['email'],
		                       $image_name,
		                    ];
				             
				          	return "success";
				          }
				       }
				    }
				    else
				    {
				    	return "account_error";
				    }
			      }
		        }
		        else
		        {
		        	return 'image_type_wrong';
		        }   
			}
			else
			{
				return 'email_exist';
			}
		}
 
	}

	public function emailConfirmation($code)
	{
		if (!empty($code)) 
		{
			$email=$_SESSION['confirm_email'][1];
			$data=$this->getUser('email',$email);

			if(is_array($data))
			{
				if($data['verification_code']===$code)
				{
					$this->loginAttemptDelete();
				  	$run=$this->con->prepare("UPDATE `users` SET `status`=? WHERE email=?");
					if(is_object($run))
					{
					  $status=encryption('encrypt','verify');
	                  $run->bindParam(1,$status,PDO::PARAM_STR);
					  $run->bindParam(2,$email,PDO::PARAM_STR);
					  if($run->execute())
					  {
					  	unset($_SESSION['confirm_email']);
					  	return 'success';
					  }
					}
				}
				else
				{
					return 'wrong_code';
				}
				
			}
		}

		return false;
	}

	public function resendEmail()
	{
		$email=$_SESSION['confirm_email'][1];
		$data=$this->getUser('email',$email);
		$code        =mt_rand(1111,9999);
		$verification_code=encryption('encrypt', $code);

		$run=$this->con->prepare("UPDATE `users` SET `verification_code`=? WHERE email=?");
		if(is_object($run))
		{
			$run->bindParam(1,$verification_code,PDO::PARAM_STR);
			$run->bindParam(2,$email,PDO::PARAM_STR);
			if($run->execute())
			{
				$subject='Confirmation Code';
			    $message="<p>Hello ".$data['name']."...!<br>Your Confirmation Code is:- $code</p><br><hr><p>If You Think You Did Not Make This Request, Just ignore this email</p>";

				if (mail($data['email'], $subject, $message,"Content-type: text/html\r\n")) 
			    {
			    	
			    	return 'success';
			    }
			}
		}

		return false;
	}

	public function loginUser()
	{
		if (!empty($_POST['friendbook'])) 
		{
			return "honeyPort";
		}
		else if(empty($_POST['email']))
		{
			return "emailEmpty";
		}
		else if(empty($_POST['password']))
		{
			return "passwordEmpty";
		}
		else
		{
			$email=strtolower($_POST['email']);
			$password=$_POST['password'];
			$user=$this->getUser('email',encryption('encrypt',strtolower($email)));
			if($user!=false)
			{
			    $encrypt_email=encryption('encrypt',strtolower($user['email']));

			  
				if(is_array($user) AND !empty($user))
				{
					if($user['email']===$email)
					{
						if(password_method($_POST['password'])===false)
						{
							if($user['status']==='verify')
						    {
						    	return $this->loginAttempt($encrypt_email);
						    }
						    else
						    {
						    	return 'passwordWrong';
						    }		
						}
					}

					if($user['email']===$email AND $user['password']===$password)
					{
						if($user['status']==='notVerify' OR $user['status']==='securityVerification')
						{
							$_SESSION['confirm_email']=[
					          	encryption('encrypt', $user['name']),
			                    encryption('encrypt',$user['email']),
			                    encryption('encrypt', $user['image']),
			                ];

			                if($this->resendEmail()==='success')
			                {
			                	return "emailConfirmation";
			                }
			                
						}
						else if($user['status']==='block')
						{
							return "accountBlock";
						}
						else
						{
							if($user['status']==='verify')
							{
								$_SESSION['loginUser']=[
									encryption('encrypt',$user['id']),
						          	encryption('encrypt',$user['email']),
				                ];

								$this->loginAttemptDelete();
								$this->insertIp(encryption('encrypt',$user['email']));
								return "successLogin";
							}	
						}
					}
					else
					{
						if($user['email']===$email)
						{
							if($user['password']!=$password)
							{
								if($user['status']==='verify')
							    {
							    	return $this->loginAttempt($encrypt_email);
							    }
							    else
							    {
							    	return 'passwordWrong';
							    }		
								
							}
						}
					}
				}	
			}
			else
			{
				return 'passwordWrong';
			}
		}
	}

	public function loginAttempt($value)
	{
		$userIp=encryption('encrypt',IpAddress());

		$run=$this->con->prepare("SELECT * FROM `login_attempt` WHERE email=? AND ip_address=? ");
		if(is_object($run))
		{
          $run->bindParam(1,$value,PDO::PARAM_STR);
          $run->bindParam(2,$userIp,PDO::PARAM_STR);
		  if($run->execute())
		  {
		  	if($run->rowCount()==1)
		  	{
		  	   $row=$run->fetch(PDO::FETCH_ASSOC);
		  	   $attempt_decrypt=encryption('decrypt', $row['attempt']);

		  	  
		  	   if($attempt_decrypt<=2)
		  	   {
		  	   	   $attempt_decrypt++;
			  	   $attempt_val=encryption('encrypt', $attempt_decrypt);
				   $run=$this->con->prepare("UPDATE `login_attempt` SET `attempt`=? WHERE email=? AND ip_address=?");
				   if(is_object($run))
				   {
				   	 $run->bindParam(1,$attempt_val,PDO::PARAM_STR);
				   	 $run->bindParam(2,$value,PDO::PARAM_STR);
	                 $run->bindParam(3,$userIp,PDO::PARAM_STR);

	                 if($run->execute())
	                 {
	                 	if($attempt_decrypt==3)
	                 	{
	                 		$status=encryption('encrypt', 'securityVerification');
	                 		$run=$this->con->prepare("UPDATE `users` SET `status`=? WHERE email=?");
							if(is_object($run))
						    {
							   	$run->bindParam(1,$status,PDO::PARAM_STR);
							   	$run->bindParam(2,$value,PDO::PARAM_STR);
				                if($run->execute())
				                {
				                    return strval($attempt_decrypt);
				                }
			                } 
	                 	}
	                 	else
	                 	{
	                 		return strval($attempt_decrypt);
	                 	}
	                 }
				   }
		  	   }
		  	   else
		  	   {
		  	   	 return 'passwordWrong';
		  	   }
		  	}
		  	else
	  	    {
	  	   	    $attempt=encryption('encrypt', '1');
				$run=$this->con->prepare("INSERT INTO `login_attempt`(`email`, `ip_address`, `attempt`) VALUES (?,?,?)");
				if(is_object($run))
				{
		          $run->bindParam(1,$value,PDO::PARAM_STR);
				  $run->bindParam(2,$userIp,PDO::PARAM_STR);
				  $run->bindParam(3,$attempt,PDO::PARAM_STR);

				  if($run->execute())
				  {
				  	return '1';
				  }
				}
	  	    }
		  }
		}
	}

	public function loginAttemptDelete()
	{
		$run=$this->con->prepare("SELECT * FROM `login_attempt` WHERE email=? AND ip_address=?");
		if(is_object($run))
		{
			if(isset($_SESSION['confirm_email'][1]))
			{
				$email=$_SESSION['confirm_email'][1];
			}
			else
			{
				$email=$_SESSION['loginUser'][1];
			}
			
		    $userIp=encryption('encrypt',IpAddress());
		    $run->bindParam(1,$email,PDO::PARAM_STR);
		    $run->bindParam(2,$userIp,PDO::PARAM_STR);

		    if($run->execute())
		    {
		       if($run->rowCount()==1)
			  	{
			  		$run=$this->con->prepare('DELETE FROM `login_attempt` WHERE email=? AND ip_address=?');

			  		if(is_object($run))
			  		{
			  		    $run->bindParam(1,$email,PDO::PARAM_STR);
		                $run->bindParam(2,$userIp,PDO::PARAM_STR);
		                if($run->execute())
		                {
		                	return true;
		                }
			  		}
			    }
		    }
		}

		return false;
	}

	public function checkLoginAttempt($email,$ipAddress)
	{
		$run=$this->con->prepare("SELECT * FROM `login_attempt` WHERE email=? AND ip_address=? ");
		if(is_object($run))
		{
          $run->bindParam(1,$email,PDO::PARAM_STR);
          $run->bindParam(2,$ipAddress,PDO::PARAM_STR);
		  if($run->execute())
		  {
		  	if($run->rowCount()==1)
		  	{
		  	   $row=$run->fetch(PDO::FETCH_ASSOC);
		  	   $attempt_decrypt=encryption('decrypt', $row['attempt']);

		  	   return $attempt_decrypt;
		  	}
		  }
		}

		return false;
	}

	public function insertIp($email)
	{
		if($this->getUser('email',$email)!=false)
		{
			$run=$this->con->prepare("SELECT * FROM `ip_address` WHERE email=?");
			if(is_object($run))
			{
				$run->bindParam(1,$email,PDO::PARAM_STR);
				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						$run=$this->con->prepare("DELETE FROM `ip_address` WHERE email=?");
						$run->bindParam(1,$email,PDO::PARAM_STR);
						$run->execute();	
					}
					
					$userIp=encryption('encrypt', IpAddress());
					$run=$this->con->prepare("INSERT INTO `ip_address`(`email`, `ip_address`) VALUES (?,?)");
					if(is_object($run))
					{
			          $run->bindParam(1,$email,PDO::PARAM_STR);
					  $run->bindParam(2,$userIp,PDO::PARAM_STR);

					  if($run->execute())
					  {
					  	return true;
					  }
					}	

				}
			}
		}
	}

	public function checkLoginIp()
	{
		
		$run=$this->con->prepare("SELECT * FROM `ip_address` WHERE email=?");
		if(is_object($run))
		{
		  $email=@$_SESSION['loginUser'][1];
		  $userIp=encryption('encrypt',IpAddress());
          $run->bindParam(1,$email,PDO::PARAM_STR);
		  if($run->execute())
		  {
		  	if($run->rowCount()>0)
		  	{
		  		$run=$this->con->prepare("SELECT * FROM `ip_address` WHERE email=? AND ip_address=?");
				if(is_object($run))
				{
		          $run->bindParam(1,$email,PDO::PARAM_STR);
		          $run->bindParam(2,$userIp,PDO::PARAM_STR);

				  if($run->execute())
				  {
				  	if($run->rowCount()>0)
		  	        {
		  	        	return false;
		  	        }
		  	        else
		  	        {
		  	        	return 'LoginAnthorDevice';
		  	        }
		  	        
				  }
				}
		  	}
		  	else
		  	{
		  		return 'logoutID';
		  	}
		  }
		}
	}

	public function deleteIp()
	{
		$email=@$_SESSION['loginUser'][1];
		$userIp=encryption('encrypt',IpAddress());
		$run=$this->con->prepare("DELETE FROM `ip_address` WHERE email=? AND ip_address=?");
		$run->bindParam(1,$email,PDO::PARAM_STR);
		$run->bindParam(2,$userIp,PDO::PARAM_STR);
		$run->execute();
	}

	public function accountReport($id)
	{
		if(isset($_POST['complaint']) AND isset($_FILES['image']) AND !empty($_POST['complaint']) AND !empty($_FILES['image']))
		{
			$error=[];
			$name=[];
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$userData=$this->getUser('id',$id);

	        if(is_array($userData))
	        {
	        	if($userData['id']!=$user_id)
	        	{	
	        		$run=$this->con->prepare("SELECT * FROM `userprofile_complaint` WHERE complaint_user_id=? AND profile_user_id=? AND `admin_action`=? ORDER BY id DESC");

	        		if(is_object($run))
	        		{
	        			$run->bindParam(1,$user_id,PDO::PARAM_STR);
	        			$run->bindParam(2,$userData['id'],PDO::PARAM_STR);
	        			$run->bindValue(3,"Null",PDO::PARAM_STR);
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
							            	$path="../public/assets/account_report/".$fileName;
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

					              $run=$this->con->prepare('INSERT INTO `userprofile_complaint`(`complaint_user_id`, `profile_user_id`, `complaint`, `upload_file_name`) VALUES (?,?,?,?)');

					              if(is_object($run))
					              {
					              	$complaint=encryption('encrypt',$_POST['complaint']);
					              	$run->bindParam(1,$user_id,PDO::PARAM_STR);
					              	$run->bindParam(2,$userData['id'],PDO::PARAM_STR);
					              	$run->bindParam(3,$complaint,PDO::PARAM_STR);
					              	$run->bindParam(4,$filename,PDO::PARAM_STR);

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
		        	return "invalid_user";
		        }
	        }
	        else
	        {
	        	return "invalid_user";
	        }
	    }
	}

	public function verificationHistory()
	{
		$run=$this->con->prepare("SELECT * FROM `account_verification` WHERE user_id=? ORDER BY id DESC");

		if(is_object($run))
		{
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$run->bindParam(1,$user_id,PDO::PARAM_STR);
			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					$data=$run->fetchALL(PDO::FETCH_ASSOC);
					return $this->decryptData($data);
				}
				else
				{
					return 'not_apply';
				}
			}
		}

		return false;
	}

	public function accountVerification()
	{
		if(isset($_FILES['image']) AND !empty($_FILES['image']))
		{
			$error=[];
			$name=[];
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
			$userData=$this->getUser('id',$user_id);

	        if(is_array($userData))
	        {
	        	if($userData['id']==$user_id)
	        	{	
	        		$run=$this->con->prepare("SELECT * FROM `account_verification` WHERE user_id=? ORDER BY id DESC");

	        		if(is_object($run))
	        		{
	        			$run->bindParam(1,$user_id,PDO::PARAM_STR);
	        			if($run->execute())
	        			{
	        				
	        				if($run->rowCount()>0)
	        				{
	        					$data=$run->fetch(PDO::FETCH_ASSOC);
	        					$decryptStatus=encryption('decrypt',$data['verification_status']);
	        					if($decryptStatus=='pending')
	        					{
	        						return 'verification_pending';
	        					}
	        					else if($decryptStatus=='verify')
	        					{
	        						return 'account_already_verify';
	        					}
	        				}
	        				
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
						            	$path="../public/assets/account_verification/".$fileName;
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

				              $run=$this->con->prepare('INSERT INTO `account_verification`(`user_id`, `verification_status`, `upload_file_name`) VALUES (?,?,?)');

				              if(is_object($run))
				              {
				              	$verificationStatus=encryption('encrypt','pending');
				              	$run->bindParam(1,$user_id,PDO::PARAM_INT);
				              	$run->bindParam(2,$verificationStatus,PDO::PARAM_STR);
				              	$run->bindParam(3,$filename,PDO::PARAM_STR);

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
			    else
		        {
		        	return "invalid_user";
		        }
	        }
	        else
	        {
	        	return "invalid_user";
	        }
	    }
	}


	public function profileUpdate()
	{
		if(isset($_SESSION['loginUser']) OR !empty($_SESSION['loginUser']))
		{
			$email=$_SESSION['loginUser'][1];
			if(isset($_POST['bio']))
			{   //Persional Information Update
				$bio=encryption('encrypt', $_POST['bio']);
				$run=$this->con->prepare("UPDATE `users` SET `bio`=? WHERE email=?");
				$run->bindParam(1,$bio,PDO::PARAM_STR);
				$run->bindParam(2,$email,PDO::PARAM_STR);
			}
			else if(isset($_POST['work_experiences']) AND isset($_POST['work']))
			{   //Work And Work Experiences Update
				$work=encryption('encrypt', $_POST['work']);
				$work_experiences=encryption('encrypt', $_POST['work_experiences']);
				$run=$this->con->prepare("UPDATE `users` SET `work`=?,`work_experiences`=? WHERE email=?");
				$run->bindParam(1,$work,PDO::PARAM_STR);
				$run->bindParam(2,$work_experiences,PDO::PARAM_STR);
				$run->bindParam(3,$email,PDO::PARAM_STR);
			}
			else if(isset($_POST['address']))
			{
				//Address Update
				$address=encryption('encrypt', $_POST['address']);
				$run=$this->con->prepare("UPDATE `users` SET `address`=? WHERE email=?");
				$run->bindParam(1,$address,PDO::PARAM_STR);
				$run->bindParam(2,$email,PDO::PARAM_STR);
			}
			else if(isset($_POST['language']))
			{
				//Language Update
				$language=encryption('encrypt', $_POST['language']);
				$run=$this->con->prepare("UPDATE `users` SET `language`=? WHERE email=?");
				$run->bindParam(1,$language,PDO::PARAM_STR);
				$run->bindParam(2,$email,PDO::PARAM_STR);
			}
			else if(isset($_POST['old_password']) AND isset($_POST['new_password']) AND isset($_POST['confirm_password']))
			{   //Password Change

				$user=$this->getUser('email',$email);
	        	if(is_array($user) AND $user!=false)
	        	{
	        		if(password_method($_POST['old_password'])===false)
					{
						return 'Old Password Wrong.....!';
					}
					else if($_POST['new_password']!=$_POST['confirm_password'])
					{
						return 'Missmatch Password AND Confirm Password....!';
					}
	                else if($user['password']===$_POST['old_password'])
	        		{
	        			if(password_method($_POST['new_password'])!=false)
	        			{
							$new_password=encryption('encrypt', $_POST['new_password']);

							$run=$this->con->prepare("UPDATE `users` SET `password`=? WHERE email=?");
							$run->bindParam(1,$new_password,PDO::PARAM_STR);
							$run->bindParam(2,$email,PDO::PARAM_STR);
	        			}
	        			else
	        			{
	        				return 'New Password Required<br><br> 1=Minimum 8 characters<br> 2=One uppercase letter<br> 3=One lowercase letter,<br> 4=One number,';
	        			}
	        		}
	        		else
	        		{
	        			return 'Old Password Wrong.....!';
	        		}
	        	}
			}
			else if(isset($_POST['country']) AND $_POST['country']!=-1 AND isset($_POST['state']) AND !empty($_POST['state']))
			{
				//Country Flag Update
				$country=encryption('encrypt', $_POST['country']);
				$state=encryption('encrypt', $_POST['state']);
				$run=$this->con->prepare("UPDATE `users` SET `country`=?,`state`=? WHERE email=?");
				$run->bindParam(1,$country,PDO::PARAM_STR);
				$run->bindParam(2,$state,PDO::PARAM_STR);
				$run->bindParam(3,$email,PDO::PARAM_STR);
			}
			else if(isset($_POST['email_type']) AND !empty($_POST['email_type']))
			{
				//Email Privacy Change
				$email_type=strtolower($_POST['email_type']);
				if($email_type==='private' OR $email_type==='public')
				{
					$email_type=encryption('encrypt', $email_type);
				    $run=$this->con->prepare("UPDATE `users` SET `email_type`=? WHERE email=?");
				    $run->bindParam(1,$email_type,PDO::PARAM_STR);
				    $run->bindParam(2,$email,PDO::PARAM_STR);
				}
				else
				{
					return false;
				}
			}
			else if(isset($_POST['account_type']) AND !empty($_POST['account_type']))
			{
				//Account Privacy Change
				$account_type=strtolower($_POST['account_type']);
				if($account_type==='private' OR $account_type==='public')
				{
					$account_type=encryption('encrypt', $account_type);
				    $run=$this->con->prepare("UPDATE `users` SET `account_type`=? WHERE email=?");
				    $run->bindParam(1,$account_type,PDO::PARAM_STR);
				    $run->bindParam(2,$email,PDO::PARAM_STR);
				}
				else
				{
					return false;
				}
			}
			else if(isset($_FILES['profile_image']))
			{
				$image_name=$_FILES['profile_image']['name'];
			    $image_tmp_name=$_FILES['profile_image']['tmp_name'];
			    $allowed_ext=array('JPG','jpg','jpeg','GIF','PNG','png');;
		        $exp=explode(".", $image_name);
		        $end=end($exp);
		        $image_name=mt_rand(1111,9999).'_'.preg_replace('/\s+/', '', $image_name);
		        $path="../public/assets/images/users/$image_name";
			    if(in_array($end, $allowed_ext))
			    {
			    	$image_name=encryption('encrypt', $image_name);
			        $run=$this->con->prepare('UPDATE `users` SET image=? WHERE email=?');
			        if (is_object($run))
			        {
			        	@move_uploaded_file($image_tmp_name, $path);
		            	$run->bindParam(1,$image_name,PDO::PARAM_STR);
		            	$run->bindParam(2,$email,PDO::PARAM_STR);
					}
				}
				else
				{
					return 'image_type_wrong';
				}
			}
			else if(isset($_FILES['cover_image']))
			{
				$image_name=$_FILES['cover_image']['name'];
			    $image_tmp_name=$_FILES['cover_image']['tmp_name'];
			    $allowed_ext=array('JPG','jpg','jpeg','GIF','PNG','png');;
		        $exp=explode(".", $image_name);
		        $end=end($exp);
		        $image_name=mt_rand(1111,9999).'_'.preg_replace('/\s+/', '', $image_name);
		        $path="../public/assets/images/covers/$image_name";
			    if(in_array($end, $allowed_ext))
			    {
			    	$image_name=encryption('encrypt', $image_name);
			        $run=$this->con->prepare('UPDATE `users` SET bg_image=? WHERE email=?');
			        if (is_object($run))
			        {

			        	@move_uploaded_file($image_tmp_name, $path);
			        	resize_image($path,$end);
		            	$run->bindParam(1,$image_name,PDO::PARAM_STR);
		            	$run->bindParam(2,$email,PDO::PARAM_STR);
					}
				}
				else
				{
					return 'image_type_wrong';
				}
			}
			else if(isset($_POST['data']))
			{

		        $data=$this->getUser('email',$_SESSION['loginUser'][1]);
		        
				if($_POST['data']==='delete_profile_pic')
				{
					$img_name=encryption('encrypt',$data['image']);
					$run=$this->con->prepare('UPDATE `users` SET image=? WHERE email=?');
			        if (is_object($run))
			        {
			        	$image=encryption('encrypt', 'profile.jpg');
		            	$run->bindParam(1,$image,PDO::PARAM_STR);
		            	$run->bindParam(2,$email,PDO::PARAM_STR);
					}
				}

				if($_POST['data']==='delete_cover_pic')
				{
					$img_name=encryption('encrypt',$data['bg_image']);
					$run=$this->con->prepare('UPDATE `users` SET bg_image=? WHERE email=?');
			        if (is_object($run))
			        {
			        	$image=encryption('encrypt', 'cover.png');
		            	$run->bindParam(1,$image,PDO::PARAM_STR);
		            	$run->bindParam(2,$email,PDO::PARAM_STR);
					}
				}

				//DELETE Profile Cover Post
				$query=$this->con->prepare('SELECT * from `posts` WHERE post_file_name=? AND user_id=?');
				if(is_object($query))
				{
					$query->bindParam(1,$img_name,PDO::PARAM_STR);
					$query->bindParam(2,$data['id'],PDO::PARAM_INT);
					if($query->execute());
					{
						if($query->rowCount()>0)
						{
							$postData=$query->fetch(PDO::FETCH_ASSOC);
						}
					}
				}

				$query=$this->con->prepare('UPDATE `posts` SET `post_delete`=? WHERE post_file_name=? AND user_id=?');
				if(is_object($run))
				{
					$delete=encryption('encrypt','userDeletePost');
					$query->bindParam(1,$delete,PDO::PARAM_STR);
					$query->bindParam(2,$img_name,PDO::PARAM_STR);
					$query->bindParam(3,$data['id'],PDO::PARAM_INT);
					$query->execute();

					$this->deleteNotification('postDelete',$postData['id']);
				}
				
			}
			else if(isset($_POST['new_name']) AND isset($_POST['password']))
			{
				if(!empty($_POST['new_name']) AND !empty($_POST['password']))
				{
					$name=encryption('encrypt', $_POST['new_name']);
					$password=encryption('encrypt', $_POST['password']);
					$email=$_SESSION['loginUser'][1];
					$ipAddress=encryption('encrypt', IpAddress());

		            $data=$this->getUser('email',$email);

		            if($data['status']=='securityVerification')
		            {
		            	$_SESSION['confirm_email']=[
				          	encryption('encrypt',$data['name']),
		                    encryption('encrypt',$data['email']),
		                   encryption('encrypt', $data['image']),
		                ];

		                $this->resendEmail();

		            	return 'securityVerification';
		            }
		            else
		            {
			            if($password==encryption('encrypt', $data['password']))
			            {

			            	$this->loginAttemptDelete();
	                 		$uId=$_SESSION['loginUser'][0];
	                 		$ipAddress=encryption('encrypt', IpAddress());
			            	$run=$this->con->prepare('SELECT * FROM `update_profile_name` WHERE user_id=?');
		            		$run->bindParam(1,$uId,PDO::PARAM_STR);

					        if($run->execute())
					        {
					        	if($run->rowCount()==0)
					        	{
					        		$old_name=encryption('encrypt',$data['name']);
							        $run=$this->con->prepare('INSERT INTO `update_profile_name`( `user_id`, `name`, `ip_address`) VALUES (?,?,?)');
				            		$run->bindParam(1,$uId,PDO::PARAM_STR);
							        $run->bindParam(2,$old_name,PDO::PARAM_STR);
							        $run->bindParam(3,$ipAddress,PDO::PARAM_STR);

							        if($run->execute())
							        {
							        	$run->bindParam(1,$uId,PDO::PARAM_STR);
							            $run->bindParam(2,$name,PDO::PARAM_STR);
							            $run->bindParam(3,$ipAddress,PDO::PARAM_STR);

							            if($run->execute())
							            {
							            	$run=$this->con->prepare("UPDATE `users` SET `name`=? WHERE email=?");
								            $run->bindParam(1,$_POST['new_name'],PDO::PARAM_STR);
								            $run->bindParam(2,$email,PDO::PARAM_STR);

								            if($run->execute())
								            {
								            	return 'success';
								            }
							            }
							        }

					        	}
					        	else if($run->rowCount()==4)
					        	{
					        		return 'update_3_time';
					        	}
					        	else
					        	{
					        		
							        $run=$this->con->prepare('INSERT INTO `update_profile_name`( `user_id`, `name`, `ip_address`) VALUES (?,?,?)');

							        if(is_object($run))
							        {
							        	$run->bindParam(1,$uId,PDO::PARAM_STR);
							            $run->bindParam(2,$name,PDO::PARAM_STR);
							            $run->bindParam(3,$ipAddress,PDO::PARAM_STR);

							            if($run->execute())
							            {
							            	$run=$this->con->prepare("UPDATE `users` SET `name`=? WHERE email=?");
								            $run->bindParam(1,$_POST['new_name'],PDO::PARAM_STR);
								            $run->bindParam(2,$email,PDO::PARAM_STR);

								            if($run->execute())
								            {
								            	return 'success';
								            }
							            }
							        }
					        	}
					        }
		                 	
			            }
			            else
			            {
			            	$val=$this->loginAttempt($email);
			            	if($val==3)
			            	{
			            		$_SESSION['confirm_email']=[
				          	      encryption('encrypt',$data['name']),
		                          encryption('encrypt',$data['email']),
		                          encryption('encrypt', $data['image']),
		                        ];

		                        $this->resendEmail();
			            	}

			            	return 'Login Attempt '.$val.'/3';
			            }
			        }
				}
				else
				{
					return false;
				}
			}
			else if(isset($_POST['code']) AND isset($_POST['new_email'])  AND isset($_POST['password']))
			{
				if(!empty($_POST['code']) AND !empty($_POST['new_email']) AND !empty($_POST['password']))
				{
					$userData=$this->getUser('email',$_SESSION['loginUser'][1]);
					if(encryption('decrypt',$_SESSION['loginUser'][1])!=strtolower($_POST['new_email']))
					{
						if($_POST['password']==$userData['password'])
						{
						   if($_POST['code']==$userData['verification_code'])
						   {
							    $this->loginAttemptDelete();
		                 		$uId=$_SESSION['loginUser'][0];
		                 		$ipAddress=encryption('encrypt', IpAddress());
				            	$run=$this->con->prepare('SELECT * FROM `update_profile_email` WHERE user_id=?');
			            		$run->bindParam(1,$uId,PDO::PARAM_STR);

						        if($run->execute())
						        {
						        	$old_email=encryption('encrypt',$userData['email']);
						        	$new_email=encryption('encrypt',strtolower($_POST['new_email']));

						        	if($run->rowCount()==0)
						        	{
						        		$run=$this->con->prepare('INSERT INTO `update_profile_email`( `user_id`, `email`, `ip_address`) VALUES (?,?,?)');
					            		$run->bindParam(1,$uId,PDO::PARAM_STR);
								        $run->bindParam(2,$old_email,PDO::PARAM_STR);
								        $run->bindParam(3,$ipAddress,PDO::PARAM_STR);
								        $run->execute();
						        	}

						        	if($run->rowCount()==4)
						        	{
						        		return 'update_3_time';
						        	}
						        	else if($run->rowCount()<4)
						        	{
						        		
								        $run=$this->con->prepare('INSERT INTO `update_profile_email`( `user_id`, `email`, `ip_address`) VALUES (?,?,?)');
					            		$run->bindParam(1,$uId,PDO::PARAM_STR);
								        $run->bindParam(2,$new_email,PDO::PARAM_STR);
								        $run->bindParam(3,$ipAddress,PDO::PARAM_STR);


								        if($run->execute())
								        {
								        	$code        =mt_rand(1111,9999);
					                        $verification_code=encryption('encrypt', $code);

							            	$run=$this->con->prepare("UPDATE `users` SET `email`=?,`verification_code`=? WHERE id=?");
								            $run->bindParam(1,$new_email,PDO::PARAM_STR);
								            $run->bindParam(2,$verification_code,PDO::PARAM_STR);
								            $run->bindParam(3,$userData['id'],PDO::PARAM_INT);

								            if($run->execute())
								            {
								            	$run=$this->con->prepare("UPDATE `ip_address` SET `email`=? WHERE email=?");
								                $run->bindParam(1,$new_email,PDO::PARAM_STR);
								                $run->bindParam(2,$old_email,PDO::PARAM_STR);
								                if($run->execute())
								                {
								                	$run=$this->con->prepare("UPDATE `login_attempt` SET `email`=? WHERE email=?");
								                    $run->bindParam(1,$new_email,PDO::PARAM_STR);
								                    $run->bindParam(2,$old_email,PDO::PARAM_STR);
								                    if($run->execute())
								                    {
								                    	unset($_SESSION['loginUser']);
								                    	$_SESSION['loginUser']=[
															encryption('encrypt',$userData['id']),
												          	$new_email,
										                ];

								                    	return 'success';
								                    }	
								                }
								            }

									        return 'success';
								        }
						        	}
						        	
						        }
					       }
					       else
					       {
					       	 return 'code_wrong';
					       }
						}
						else
						{
							$val=$this->loginAttempt($email);
			            	if($val==3)
			            	{
			            		$_SESSION['confirm_email']=[
				          	      encryption('encrypt',$userData['name']),
		                          encryption('encrypt',$userData['email']),
		                          encryption('encrypt', $userData['image']),
		                        ];

		                        $this->resendEmail();
			            	}

			            	return 'Login Attempt '.$val.'/3';
						}
				    }
				    else
				    {
				    	return 'typeOldEmail';
				    }
				}
			}
			else if(isset($_POST['newEmail']))
			{
				$email=$_SESSION['loginUser'][1];

				if(encryption('decrypt',$email)!=strtolower($_POST['newEmail']))
				{
					$data=$this->getUser('email',$email);
					$code        =mt_rand(1111,9999);
					$verification_code=encryption('encrypt', $code);

					$run=$this->con->prepare("UPDATE `users` SET `verification_code`=? WHERE email=?");
					if(is_object($run))
					{
						$run->bindParam(1,$verification_code,PDO::PARAM_STR);
						$run->bindParam(2,$email,PDO::PARAM_STR);
						if($run->execute())
						{
							$subject='Confirmation Code';
						    $message="<p>Hello ".$data['name']."...!<br>Your Confirmation Code is:- $code</p><br><hr><p>If You Think You Did Not Make This Request, Just ignore this email</p>";

							if (mail(strtolower($_POST['newEmail']), $subject, $message,"Content-type: text/html\r\n")) 
						    {
						    	return 'success';
						    }
						}
					}
				}
				else
				{
					return 'typeOldEmail';
				}

				return false;
			}
			else if(isset($_POST['activeStatus']))
			{
				$run=$this->con->prepare('UPDATE `users` SET online_status=? WHERE email=?');
		        if (is_object($run))
		        {
		        	if($_POST['activeStatus']=='true')
		        	{
		        		$activeStatus=encryption('encrypt','true');
		        	}
		        	else if($_POST['activeStatus']=='false')
		        	{
		        		$activeStatus=encryption('encrypt','false');
		        	}
		        	else
		        	{
		        		return false;
		        	}

		        	$email=$_SESSION['loginUser'][1];
	            	$run->bindParam(1,$activeStatus,PDO::PARAM_STR);
	            	$run->bindParam(2,$email,PDO::PARAM_STR);
	            	if($run->execute())
	            	{
	            		return 'success';
	            	}
				}

				return false;
			}
			else
			{
				return false;
			}
				
			if($run->execute())
			{

				return 'success';
			}
		}

        if(isset($_POST['forgot_password']) AND isset($_POST['name']))
		{
			if(!empty($_POST['forgot_password']))
			{
				$email=$_POST['forgot_password'];
				$userData=$this->getUser('email', encryption('encrypt',strtolower($email)));

				if(!empty($_POST['name']))
				{
					if(is_array($userData))
					{
						if(strtolower($_POST['name'])==$userData['name'])
					    {
							 $password=$userData['password'];
							 $subject='Confirmation Code';
				             $message="<p>Hello ".$userData['name']."...!<br>Your Password is:- $password</p><br><hr>
				            <p>If You Think You Did Not Make This Request, Just ignore this email</p>";
					          if (mail($userData['email'], $subject, $message,"Content-type: text/html\r\n")) 
					          {  
					          	return "success";
					          }
					    }
					    else
					    {
					    	return 'invalid_name';
						}
					}
					else
					{
						return 'invalid_email';
					}
				}
				else
				{
					return 'name_empty';
				}
			}
			else
			{
				return 'email_empty';
			}
		}
		return false;
	}


	public function onlineUserInsert()
	{
		if(isset($_POST['onlineUserInsert']))
		{
			$userId=encryption('decrypt', $_SESSION['loginUser'][0]);
			$data=$this->getUser('email',$_SESSION['loginUser'][1]);
			$status=encryption('encrypt', $data['online_status']);

			$run=$this->con->prepare('SELECT * FROM `online_users` WHERE activite_user_id=?');
			if(is_object($run))
			{
				$run->bindParam(1,$userId,PDO::PARAM_INT);
				if($run->execute())
				{

					if($run->rowCount()>0)
					{

						$run=$this->con->prepare('UPDATE `online_users` SET `current_date_time`=NOW(), status=? WHERE activite_user_id=?');

						if(is_object($run))
						{
							$run->bindParam(1,$status,PDO::PARAM_STR);
							$run->bindParam(2,$userId,PDO::PARAM_INT);
							
							if($run->execute())
							{
								return 'success';
							}
						}
					}
					else
					{

						$run=$this->con->prepare('INSERT INTO `online_users`(`activite_user_id`, `status`) VALUES (?,?)');
						if(is_object($run))
						{
							$run->bindParam(1,$userId,PDO::PARAM_INT);
							$run->bindParam(2,$status,PDO::PARAM_STR);
							if($run->execute())
							{
								
								return 'success';
							}
						}
					}
				}
			}

		}
	}


	public function sidebarOnlineUser()
	{
		if(isset($_SESSION['loginUser']) OR !empty($_SESSION['loginUser']))
		{
			$query=$this->con->prepare('SELECT * FROM `friend_request` LEFT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` JOIN `online_users` ON `users`.`id`=`online_users`.`activite_user_id` WHERE `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? AND `online_users`.`current_date_time` > DATE_SUB(NOW(),INTERVAL 5 SECOND) AND `online_users`.`status`=? ORDER BY `online_users`.id DESC ');

			if (is_object($query)) 
			{
				$request=encryption('encrypt','friend'); 
				$status=encryption('encrypt','true'); 
				$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);
				$query->bindParam(1,$user_id,PDO::PARAM_INT);
				$query->bindParam(2,$request,PDO::PARAM_STR);
				$query->bindValue(3,$status,PDO::PARAM_STR);

				if($query->execute())
				{
					if ($query->rowCount()>0) 
					{
						$data=$this->decryptData($query->fetchAll(PDO::FETCH_ASSOC));
						return $data;
						
					}
					else
					{
						return 'empty';
					}
				}
			}
	    }	 
	}


	public function checkUserOnline($friendId)
	{
		$query=$this->con->prepare('SELECT * FROM `friend_request` LEFT JOIN `users` ON `friend_request`.`user_id`=`users`.`id` JOIN `online_users` ON `users`.`id`=`online_users`.`activite_user_id` WHERE `friend_request`.`user_id`=? AND `friend_request`.`send_user_id`=? AND `friend_request`.`request`=? AND `online_users`.`current_date_time` > DATE_SUB(NOW(),INTERVAL 5 SECOND) AND `online_users`.`status`=?');

		if (is_object($query)) 
		{
			$request=encryption('encrypt','friend'); 
			$status=encryption('encrypt','true'); 
			$user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

			$query->bindParam(1,$friendId,PDO::PARAM_INT);
			$query->bindParam(2,$user_id,PDO::PARAM_INT);
			$query->bindParam(3,$request,PDO::PARAM_STR);
			$query->bindValue(4,$status,PDO::PARAM_STR);

			if($query->execute())
			{
				if ($query->rowCount()>0) 
				{
					$data=$this->decryptData($query->fetch(PDO::FETCH_ASSOC));
					unset($data['password']);
					return $data;
					
				}
			}
		}

		return false;	 
	}

	protected function getAllFriendRequestData()
	{
		//Get All type of Data (block friend send) from friend_request table
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

   	    return $allFriends;
	}


	public function searchUser()
	{
	   if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	   {
	   	    $allFriends=$this->getAllFriendRequestData();

	   	    $status1=encryption('encrypt','notVerify');
	   	    $status2=encryption('encrypt','block');

	   	     if(!empty($_POST['searchUser']) AND $_POST['country']==-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
				if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND name like ? ");
					$searchtype="%".strtolower($_POST['searchUser'])."%";
				}

			
			    $run->bindParam(1,$status1,PDO::PARAM_STR);
			    $run->bindParam(2,$status2,PDO::PARAM_STR);
			    $run->bindParam(3,$searchtype,PDO::PARAM_STR);
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
					$run->bindParam(1,$status1,PDO::PARAM_STR);
			        $run->bindParam(2,$status2,PDO::PARAM_STR);
			        $run->bindParam(3,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND name like ? AND country=? ");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);

					$run->bindParam(1,$status1,PDO::PARAM_STR);
			        $run->bindParam(2,$status2,PDO::PARAM_STR);
			        $run->bindParam(3,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(4,$country,PDO::PARAM_STR);
				}
			   
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
					$run->bindParam(1,$status1,PDO::PARAM_STR);
			        $run->bindParam(2,$status2,PDO::PARAM_STR);
			        $run->bindParam(3,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND name like ? AND country=? AND state=?");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);
					$state=encryption('encrypt',$_POST['state']);

					$run->bindParam(1,$status1,PDO::PARAM_STR);
			        $run->bindParam(2,$status2,PDO::PARAM_STR);
			        $run->bindParam(3,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(4,$country,PDO::PARAM_STR);
			        $run->bindParam(5,$state,PDO::PARAM_STR);
				}
			   
	  	   	 }
	  	   	if($run->execute())
		    {
		    	if($run->rowCount()>0)
		    	{
		    		$row=$run->fetchALL(PDO::FETCH_ASSOC);
		    		return $this->decryptData($row);
		    	}
		    	else
		    	{
		    		return 'notFound';
		    	}
		    }
		    else
		    {
		    	return false;
		    }
		}
	}

	public function getNewsfeedPeople($country=null,$state=null)
	{
       if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	   {
	   	    $allFriends=$this->getAllFriendRequestData();

	   	    $status1=encryption('encrypt','notVerify');
	   	    $status2=encryption('encrypt','block');

			if($country!=null AND $state!=null)
			{
				$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND (country=? AND state=?) ORDER BY id DESC");

				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);
			    $run->bindParam(1,$status1,PDO::PARAM_STR);
			    $run->bindParam(2,$status2,PDO::PARAM_STR);
			    $run->bindParam(3,$country,PDO::PARAM_STR);
			    $run->bindParam(4,$state,PDO::PARAM_STR);
			}
			else if($country!=null AND $state==null)
			{
				$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND country=? ORDER BY id DESC");

				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);
			    $run->bindParam(1,$status1,PDO::PARAM_STR);
			    $run->bindParam(2,$status2,PDO::PARAM_STR);
			    $run->bindParam(3,$country,PDO::PARAM_STR);
			}
			else
			{
				$run=$this->con->prepare("SELECT * FROM users WHERE status NOT IN(?,?) AND id NOT IN($allFriends) AND (country=? OR state=?) ORDER BY id DESC LIMIT ?,?");

				$email=$_SESSION['loginUser'][1];
			    $data=$this->getUser('email',$email);
				$country=encryption('encrypt',$data['country']);
			    $state=encryption('encrypt',$data['state']);

			    $offset=$_POST['offset'];
				$rows=$_POST['rows'];

				$run->bindParam(1,$status1,PDO::PARAM_STR);
				$run->bindParam(2,$status2,PDO::PARAM_STR);
			    $run->bindParam(3,$country,PDO::PARAM_STR);
			    $run->bindParam(4,$state,PDO::PARAM_STR);
			    $run->bindParam(5,$offset,PDO::PARAM_INT);
			    $run->bindParam(6,$rows,PDO::PARAM_INT);
			}
			
		    if($run->execute())
		    {
		    	if($run->rowCount()>0)
		    	{
		    		$row=$run->fetchALL(PDO::FETCH_ASSOC);
		    		return $this->decryptData($row);
		    	}
		    	else
		    	{
		    		return 'zero';
		    	}
		    }
		
	   }

	   return false;
	}

	public function getProfileComplaint($type,$id)
	{
	   if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	   {
	   	  if($type=='complaintID')
	   	  {
	   	  	$run=$this->con->prepare('SELECT * FROM `userprofile_complaint` WHERE id=?  AND `admin_action` NOT IN(?,?)');
	   	  }
	   	  else if($type=='usereID')
	   	  {
	   	  	$run=$this->con->prepare('SELECT * FROM `userprofile_complaint` WHERE profile_user_id=?  AND `admin_action` NOT IN(?,?)');
	   	  }
	   	
	   	  if(is_object($run))
	   	  {
	   	  	$CAction=encryption('encrypt','securityVerification');
	   	  	$run->bindParam(1,$id,PDO::PARAM_INT);
	   	  	$run->bindValue(2,"Null",PDO::PARAM_STR);
	   	  	$run->bindParam(3,$CAction,PDO::PARAM_STR);
	   	  	

	   	  	if($run->execute())
	   	  	{
	   	  		if($run->rowCount()>0)
	   	  		{
	   	  			return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
	   	  		}
	   	  		else
	   	  		{
	   	  			return 0;
	   	  		}
	   	  	}
	   	  }
	   }

	   return false;
	}


	public function getAccountWarning()
	{
	   if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	   {
	   	  $run=$this->con->prepare('SELECT * FROM `account_warning` WHERE user_id=?');
	   	  if(is_object($run))
	   	  {
	   	  	$userId=encryption('decrypt', $_SESSION['loginUser'][0]);
	   	  	$run->bindParam(1,$userId,PDO::PARAM_INT);

	   	  	if($run->execute())
	   	  	{
	   	  		if($run->rowCount()>0)
	   	  		{
	   	  			return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
	   	  		}
	   	  		else
	   	  		{
	   	  			return 0;
	   	  		}
	   	  	}
	   	  }
	   }

	   return false;
	}



}

?>