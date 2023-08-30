<?php
class mlAdmin extends database{

	use modelTrait;


	public function getAdmin($email)
	{
		$run=$this->con->prepare('SELECT * FROM `admin` WHERE email=?');

		if(is_object($run))
		{
			$run->bindParam(1,$email,PDO::PARAM_STR);
			if($run->execute())
	   	    {
	   	    	if($run->rowCount()>0)
	   	    	{
	   	    		return $this->decryptData($run->fetch(PDO::FETCH_ASSOC));
	   	    	}
	   	    	else
	   	    	{
	   	    		return 'wrong';
	   	    	}
	   	    }
		}

		return false;
	}


	public function addNewAdmin()
	{
		if(isset($_POST))
		{
			$name=$_POST['adminName'];
			$encrypt_email=encryption('encrypt',$_POST['adminEmail']);
			$encrypt_password=encryption('encrypt',$_POST['password']);
			$getAdmin=$this->getAdmin($encrypt_email);

			if(is_array($getAdmin))
			{
				return 'emailExist';
			}
			else
			{
				$run=$this->con->prepare('INSERT INTO `admin`(`name`, `email`, `admin_password`, `added_by`) VALUES (?,?,?,?)');

				if(is_object($run))
				{
					$adminId=encryption('decrypt',$_SESSION['loginAdmin'][0]);
					$run->bindParam(1,$name,PDO::PARAM_STR);
					$run->bindParam(2,$encrypt_email,PDO::PARAM_STR);
					$run->bindParam(3,$encrypt_password,PDO::PARAM_STR);
					$run->bindParam(4,$adminId,PDO::PARAM_INT);

					if($run->execute())
					{
						return 'success';
					}
				}
			}
			
		}

		return false;
	}

	public function getTotalData()
	{
		$total=[];
		$run=$this->con->prepare('SELECT COUNT(*) as totalUser FROM `users`');

   	    if($run->execute())
   	    {
   	    	$total[]=$run->fetch(PDO::FETCH_ASSOC);
   	    }

		$run=$this->con->prepare('SELECT COUNT(*) as totalVerify FROM `users` WHERE status IN(?,?)');
   	    if(is_object($run))
   	    {
   	    	$status1=encryption('encrypt','verify');
   	    	$status2=encryption('encrypt','securityVerification');
   	    	$run->bindParam(1,$status1,PDO::PARAM_STR);
   	    	$run->bindParam(2,$status2,PDO::PARAM_STR);
   	    	if($run->execute())
   	    	{
   	    		$total[]=$run->fetch(PDO::FETCH_ASSOC);
   	    	}
   	    }

   	    $run=$this->con->prepare('SELECT COUNT(*) as totalNotVerify FROM `users` WHERE status=?');
   	    if(is_object($run))
   	    {
   	    	$status=encryption('encrypt','notVerify');
   	    	$run->bindParam(1,$status,PDO::PARAM_STR);
   	    	if($run->execute())
   	    	{
   	    		$total[]=$run->fetch(PDO::FETCH_ASSOC);
   	    	}
   	    }

   	    $run=$this->con->prepare('SELECT COUNT(*) as totalBlock FROM `users` WHERE status=?');
   	    if(is_object($run))
   	    {
   	    	$status=encryption('encrypt','block');
   	    	$run->bindParam(1,$status,PDO::PARAM_STR);
   	    	if($run->execute())
   	    	{
   	    		$total[]=$run->fetch(PDO::FETCH_ASSOC);
   	    	}
   	    }

   	    $run=$this->con->prepare('SELECT * FROM `post_complaint`  WHERE `admin_action`=? GROUP BY post_id');

   	    if(is_object($run))
   	    {
			$run->bindValue(1,"Null",PDO::PARAM_STR);

   	    	if($run->execute())
   	    	{
   	    		if($run->rowCount()>0)
   	    		{
   	    			$total[]['totalPostReport']=$run->rowCount();
   	    		}
   	    	}
   	    }

   	    $run=$this->con->prepare('SELECT * FROM `userprofile_complaint`  WHERE `admin_action`=? GROUP BY profile_user_id');
   	    if(is_object($run))
   	    {
			$run->bindValue(1,"Null",PDO::PARAM_STR);

   	    	if($run->execute())
   	    	{
   	    		if($run->rowCount()>0)
   	    		{
   	    			$total[]['totalAccountReport']=$run->rowCount();
   	    		}
   	    	}
   	    }

   	    $run=$this->con->prepare('SELECT * FROM `account_verification` WHERE verification_status=?');
   	    if(is_object($run))
   	    {
   	    	$status=encryption('encrypt','pending');
			$run->bindParam(1,$status,PDO::PARAM_STR);

   	    	if($run->execute())
   	    	{
   	    		if($run->rowCount()>0)
   	    		{
   	    			$total[]['totalAccVerification']=$run->rowCount();
   	    		}
   	    	}
   	    }

   	    return $total;  
	}

	public function totalAccountReport($userID)
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
        	$run=$this->con->prepare('SELECT * FROM `userprofile_complaint`  WHERE `admin_action`=? AND profile_user_id=?');
	   	    if(is_object($run))
	   	    {
				$run->bindValue(1,"Null",PDO::PARAM_STR);
				$run->bindParam(2,$userID,PDO::PARAM_INT);

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

	public function totalPostReport($postId)
    {
    	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
           $run=$this->con->prepare('SELECT * FROM `post_complaint` WHERE `admin_action`=? AND post_id=?');
    		if(is_object($run))
	      	{
	      		$run->bindValue(1,"Null",PDO::PARAM_STR);
		      	$run->bindParam(2,$postId,PDO::PARAM_INT);
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


	public function forgotPassord()
	{
		if(isset($_POST['name']) AND isset($_POST['email']))
		{
			$run=$this->con->prepare("SELECT * FROM `admin` WHERE name=? AND email=?");

			if(is_object($run))
			{
				$encrypt_email=encryption('encrypt',$_POST['email']);
				$run->bindParam(1,$_POST['name'],PDO::PARAM_STR);
				$run->bindParam(2,$encrypt_email,PDO::PARAM_STR);
				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						$data=$run->fetch(PDO::FETCH_ASSOC);
						$password=encryption('decrypt',$data['admin_password']);
						$subject='FriendBook Admin Password';
					    $message="<p>Hello ".$data['name']."...!<br>Your FriendBook Admin Password is:- $password</p><br><hr><p>If You Think You Did Not Make This Request, Just ignore this email</p>";

						if (mail($data['email'], $subject, $message,"Content-type: text/html\r\n")) 
					    {
					    	return 'success';
					    }
					}
					else
					{
						return 'wrong';
					}	
				}
			}
		}

		return false;
	}



	public function getAllUsers($offset,$limit)
	{
		$run=$this->con->prepare('SELECT * FROM `users` ORDER BY id DESC LIMIT ?,?');

		if(is_object($run))
		{
		    $run->bindParam(1,$offset,PDO::PARAM_INT);
		    $run->bindParam(2,$limit,PDO::PARAM_INT);

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

   	    return false;
	}


	public function getProfileReports($offset,$limit)
	{

		$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `userprofile_complaint`.`admin_action`=? AND `users`.`status` IN(?,?) GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC LIMIT ?,?');

		if(is_object($run))
		{
			$status1=encryption('encrypt','verify');
			$status2=encryption('encrypt','securityVerification');

			$run->bindValue(1,'Null',PDO::PARAM_STR);
		    $run->bindParam(2,$status1,PDO::PARAM_STR);
		    $run->bindParam(3,$status2,PDO::PARAM_STR);
		    $run->bindParam(4,$offset,PDO::PARAM_INT);
		    $run->bindParam(5,$limit,PDO::PARAM_INT);
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

   	    return false;
	}


	public function getPostReports($offset,$limit)
	{
        $run=$this->con->prepare('SELECT `post_complaint`.* FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` WHERE `post_complaint`.`admin_action`=? AND `posts`.admin_status=? AND `posts`.post_delete=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC LIMIT ?,?');
        if(is_object($run))
        {
        	$adminStatus=encryption('encrypt','publish');
			$run->bindValue(1,"Null",PDO::PARAM_STR);
			$run->bindParam(2,$adminStatus,PDO::PARAM_STR);
			$run->bindValue(3,"NULL",PDO::PARAM_STR);
			$run->bindParam(4,$offset,PDO::PARAM_INT);
			$run->bindParam(5,$limit,PDO::PARAM_INT);
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

   	    return false;
	}

	public function getPostComment($post_id)
	{
		if(!empty($post_id))
		{
			$run=$this->con->prepare("SELECT `post_comments`.*,`users`.`image`,`users`.`name`,`users`.`bluetick` FROM `post_comments` RIGHT JOIN `users` ON `post_comments`.`user_id`=`users`.`id` WHERE `post_comments`.`post_id`=?");
			if(is_object($run))
			{
				$run->bindParam(1,$post_id,PDO::PARAM_INT);

				if($run->execute())
				{
					if($run->rowCount()>0)
					{
						return $run->fetchAll(PDO::FETCH_ASSOC);
					}
					else
					{
						return 'emptyComment';
					}
				}
			}
		}
		else
		{
			return 'error';
		}

		return false;
	}



	public function getOnlineUser($friendId)
	{
		$query=$this->con->prepare('SELECT * FROM `users` 
			JOIN `online_users` ON `users`.`id`=`online_users`.`activite_user_id` 
			WHERE `users`.id=? AND `online_users`.`current_date_time` > DATE_SUB(NOW(),INTERVAL 5 SECOND) AND `online_users`.`status`=?');

		if (is_object($query)) 
		{
			$status=encryption('encrypt','true'); 

			$query->bindParam(1,$friendId,PDO::PARAM_INT);
			$query->bindParam(2,$status,PDO::PARAM_STR);

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



	public function statusUpdate()
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
        	$wrongID=[];
	    	$option=encryption('encrypt',$_POST['select_type']);
	    	$run=$this->con->prepare('UPDATE `users` SET `status`=? WHERE id=?');
	    	foreach ($_POST['checkboxes'] as $key => $value) 
	    	{
	    		$userId=encryption('decrypt',$value);
	    		if($userId!=false)
	    		{
                    $userData=$this->getUser('id',$userId);
                    if(is_array($userData))
                    {
                    	$run->bindParam(1,$option,PDO::PARAM_STR);
                    	$run->bindParam(2,$userData['id'],PDO::PARAM_STR);
                    	$run->execute();
                    }
                    else
                    {
                    	$wrongID[]=$key+1;
                    }
	    		}
	    		else
	    		{
	    			$wrongID[]=$key+1;
	    		}
	    	}

	    	if(is_array($wrongID) AND !empty($wrongID))
	    	{
	    		return $wrongID;
	    	}
	    	else
	    	{
	    		return 'success';
	    	}
        }

        return false;
	}


	public function getPost($postId)
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {

		    $run=$this->con->prepare('SELECT `posts`.*,SUM(likes) AS likes,SUM(dislikes) AS dislikes,image,name,email,account_type,bluetick FROM `posts` RIGHT JOIN `users` ON `posts`.`user_id`=`users`.`id` LEFT JOIN `posts_likes` ON `posts_likes`.`post_id`=`posts`.`id` WHERE `posts`.`id`=?  GROUP BY `posts`.`id`');

	      	if(is_object($run))
	      	{
		      	$run->bindParam(1,$postId,PDO::PARAM_INT);
		      	if($run->execute())
		      	{
		      		if($run->rowCount()>0)
		      		{
		      			return $this->decryptData($run->fetch(PDO::FETCH_ASSOC));
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

    public function getComplaintPost($get,$id)
    {

    	if($get=='complaintID') 
    	{
    		$run=$this->con->prepare('SELECT * FROM `post_complaint` WHERE id=?');
    	}
    	else if($get=='postID') 
    	{
    		$run=$this->con->prepare('SELECT * FROM `post_complaint` WHERE post_id=? ORDER BY id DESC');
    	}
    	
    	
    	if(!empty($id))
    	{
    		if(is_object($run))
	      	{
		      	$run->bindParam(1,$id,PDO::PARAM_INT);

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


    public function actionPostComplaint()
    {
    	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
        	$adminId=encryption('decrypt',$_SESSION['loginAdmin'][0]);

	    	if(isset($_POST['complaintType']) AND $_POST['complaintType']=='postComplaint')
	    	{
	    		$postID=encryption('decrypt',$_POST['postID']);
	    		$getComplaint=$this->getComplaintPost('postID',$postID);

	    		if($postID!=false AND is_array($getComplaint))
	    		{
	    			$action=$_POST['action'];

	    			if($getComplaint[0]['admin_action']=='reject')
	    			{
	    				return 'already_reject_admin';
	    			}
	    			else if($getComplaint[0]['admin_action']=='deletePost')
	    			{
	    				return 'already_delete_admin';
	    			}


	    			if($action=='complaint_reject')
	    			{
	    				$CAction=encryption('encrypt','reject');
	    			}
	    			else if($action=='delete_post')
	    			{
	    				$data=$this->postDelete($_POST['postID']);
	    				if($data=='error')
	    				{
	    					return 'invalid_Post_id';
	    				}

	    				$CAction=encryption('encrypt','deletePost');
	    			}

	    			$run=$this->con->prepare("UPDATE `post_complaint` SET `admin_id`=?,`admin_action`=?,`adminMsg`=? WHERE post_id=? AND admin_action=?");
	    			if(is_object($run))
	    			{
	    				$adminMsg=encryption('encrypt',$_POST['adminMsg']);
	    				
	    				$run->bindParam(1,$adminId,PDO::PARAM_INT);
	    				$run->bindParam(2,$CAction,PDO::PARAM_STR);
	    				$run->bindParam(3,$adminMsg,PDO::PARAM_STR);
	    				$run->bindParam(4,$postID,PDO::PARAM_INT);
	    				$run->bindValue(5,'Null',PDO::PARAM_STR);
	    				$run->execute();
				    			
	    				if($run->execute())
	    				{
	    					if($action=='delete_post')
	    					{
	    						$run=$this->con->prepare('INSERT INTO `account_warning`( `user_id`, `complaint_id`, `complaint_type`) VALUES (?,?,?)');

			    				if(is_object($run))
			    				{
			    					$complaintID=$getComplaint[0]['id'];
			    					$complaintType=encryption('encrypt','postComplaint');

			    					$run->bindParam(1,$getComplaint[0]['post_user_id'],PDO::PARAM_INT);
			    					$run->bindParam(2,$complaintID,PDO::PARAM_INT);
			    					$run->bindParam(3,$complaintType,PDO::PARAM_STR);
			    					if($run->execute())
			    					{
			    						$total=$this->getAccountWarning($getComplaint[0]['post_user_id'],'total');

					    				if($total>=3)
					    				{
						    				$run=$this->con->prepare("UPDATE `users` SET status=? WHERE id=?");
							    			if(is_object($run))
							    			{
							    				$status=encryption('encrypt','block');
							    				$run->bindParam(1,$status,PDO::PARAM_STR);
							    				$run->bindParam(2,$getComplaint[0]['post_user_id'],PDO::PARAM_INT);
							    				if($run->execute())
							    				{
							    					return 'accountBlock';
							    				}
							    			}
					    				}
					    				
					    				return $this->getAccountWarning($getComplaint[0]['post_user_id'],'total');
			    					}
			    				}
	    					}
	    					return 'success';
	    				}
	    			}

	    		}
	    		else
	    		{
	    			return 'invalid_Complaint_ID';
	    		}
	    	}
	    	else if(isset($_POST['complaintType'])=='profileComplaint' AND isset($_POST['profileUserID']))
	    	{
	    		$userID=encryption('decrypt',$_POST['profileUserID']);
	    		$getComplaint=$this->allProfileReports($userID);

	    		if(is_array($getComplaint))
	    		{
	    			$action=$_POST['action'];

	    			if($getComplaint[0]['admin_action']=='reject')
	    			{
	    				return 'already_reject';
	    			}
	    			else if($getComplaint[0]['admin_action']=='warning')
	    			{
	    				return 'already_warning';
	    			}
	    			else if($getComplaint[0]['admin_action']=='securityVerification')
	    			{
	    				return 'already_securityVerification';
	    			}

	    			if($action=='complaint_reject')
	    			{
	    				$CAction=encryption('encrypt','reject');
	    			}
	    			else if($action=='securityVerification')
	    			{

	    				$CAction=encryption('encrypt','securityVerification');
	    			}
	    			else if($action=='warning')
	    			{
	    				$CAction=encryption('encrypt','warning');
	    			}

	    			$run=$this->con->prepare("UPDATE `userprofile_complaint` SET `admin_id`=?,`admin_action`=?,`admin_msg`=? WHERE profile_user_id=? AND admin_action=?");
	    			if(is_object($run))
	    			{
	    				$adminMsg=encryption('encrypt',$_POST['adminMsg']);
	    				
	    				$run->bindParam(1,$adminId,PDO::PARAM_INT);
	    				$run->bindParam(2,$CAction,PDO::PARAM_STR);
	    				$run->bindParam(3,$adminMsg,PDO::PARAM_STR);
	    				$run->bindParam(4,$userID,PDO::PARAM_INT);
	    				$run->bindValue(5,'Null',PDO::PARAM_STR);
	    				$run->execute();

	    				if($run->execute())
	    				{
	    					if($action=='warning')
			    			{

			    				$run=$this->con->prepare('INSERT INTO `account_warning`( `user_id`, `complaint_id`, `complaint_type`) VALUES (?,?,?)');

			    				if(is_object($run))
			    				{
			    					$complaintID=$getComplaint[0]['id'];
			    					$complaintType=encryption('encrypt','profileComplaint');
			    					$run->bindParam(1,$userID,PDO::PARAM_INT);
			    					$run->bindParam(2,$complaintID,PDO::PARAM_INT);
			    					$run->bindParam(3,$complaintType,PDO::PARAM_STR);
			    					if($run->execute())
			    					{
			    						$total=$this->getAccountWarning($userID,'total');
					    				if($total>=3)
					    				{
						    				$run=$this->con->prepare("UPDATE `users` SET status=? WHERE id=?");
							    			if(is_object($run))
							    			{
							    				$status=encryption('encrypt','block');
							    				$run->bindParam(1,$status,PDO::PARAM_STR);
							    				$run->bindParam(2,$userID,PDO::PARAM_INT);
							    				if($run->execute())
							    				{
							    					return 'accountBlock';
							    				}
							    			}
					    				}
					    				
					    				return $this->getAccountWarning($userID,'total');
			    					}
			    				}
			    			}
			    			else if($action=='securityVerification')
			    			{
			    				$run=$this->con->prepare("UPDATE `users` SET status=? WHERE id=?");
				    			if(is_object($run))
				    			{
				    				$run->bindParam(1,$CAction,PDO::PARAM_STR);
				    				$run->bindParam(2,$userID,PDO::PARAM_INT);
				    				if($run->execute())
				    				{
				    					return 'success';
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

    public function getAccountWarning($userID,$get)
    {
    	if(!empty($userID))
    	{
    		$run=$this->con->prepare("SELECT * FROM `account_warning` WHERE user_id=?");
    		if(is_object($run))
    		{
    			$run->bindParam(1,$userID,PDO::PARAM_INT);
    			if($run->execute())
    			{
    				if($run->rowCount()>0)
    				{
    					if($get=='total')
    					{
    						return $run->rowCount();
    					}
    					else if($get=='allWarning')
    					{
    						return $run->fetchAll(PDO::FETCH_ASSOC);
    					}
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


    public function allProfileReports($userId)
    {
    	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
        	$run=$this->con->prepare('SELECT * FROM `userprofile_complaint` WHERE profile_user_id=? ORDER BY id DESC');
        	if(is_object($run))
        	{
        		$run->bindParam(1,$userId,PDO::PARAM_INT);
        		if($run->execute())
        		{
        			if($run->rowCount()>0)
        			{
        				return $this->decryptData($run->fetchAll(PDO::FETCH_ASSOC));
        			}
        		}
        	}
        }

        return false;
    }

    public function getUserCountryState($country=null,$state=null)
	{
       if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
			if($country!=null AND $state!=null)
			{
				$run=$this->con->prepare("SELECT * FROM users WHERE (country=? AND state=?) ORDER BY id DESC");

				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
			    $run->bindParam(2,$state,PDO::PARAM_STR);
			}
			else if($country!=null AND $state==null)
			{
				$run=$this->con->prepare("SELECT * FROM users WHERE country=? ORDER BY id DESC");

				$country=encryption('encrypt',$country);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
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

	public function getReportedAccount($country=null,$state=null)
	{
       if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
			if($country!=null AND $state!=null)
			{
				$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE (`users`.country=? AND `users`.state=?)  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
			    $run->bindParam(2,$state,PDO::PARAM_STR);
			}
			else if($country!=null AND $state==null)
			{
				$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.country=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

				$country=encryption('encrypt',$country);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
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

	public function getReportedPost($country=null,$state=null)
	{
       if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
			if($country!=null AND $state!=null)
			{
				$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.country=? AND `users`.state=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);

			    $run->bindParam(1,$country,PDO::PARAM_STR);
			    $run->bindParam(2,$state,PDO::PARAM_STR);
			}
			else if($country!=null AND $state==null)
			{
				$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.country=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

				$country=encryption('encrypt',$country);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
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

	public function searchUser()
	{
	   if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
       {

	   	     if(!empty($_POST['searchUser']) AND $_POST['country']==-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
				if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE name like ? ");
					$searchtype="%".strtolower($_POST['searchUser'])."%";
				}

			    $run->bindParam(1,$searchtype,PDO::PARAM_STR);
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE  email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE name like ? AND country=? ");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
				}
			   
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE email=?");
					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare("SELECT * FROM users WHERE name like ? AND country=? AND state=?");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);
					$state=encryption('encrypt',$_POST['state']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
			        $run->bindParam(3,$state,PDO::PARAM_STR);
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

	public function searchReportAcc()
	{
	   if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
       {
       	    $status1=encryption('encrypt','verify');
		    $status2=encryption('encrypt','securityVerification');

	   	     if(!empty($_POST['searchUser']) AND $_POST['country']==-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
				if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.email=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));

				}
				else
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.name like ? GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

					$searchtype="%".strtolower($_POST['searchUser'])."%";
				}


			    $run->bindParam(1,$searchtype,PDO::PARAM_STR);
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.email=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.name like ? AND country=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');


					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
				}
			   
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.email=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare('SELECT `userprofile_complaint`.* FROM `userprofile_complaint` JOIN `users` ON `userprofile_complaint`.`profile_user_id`=`users`.`id` WHERE `users`.name like ? AND country=? AND state=?  GROUP BY `userprofile_complaint`.`profile_user_id` ORDER BY `userprofile_complaint`.`id` DESC');

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);
					$state=encryption('encrypt',$_POST['state']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
			        $run->bindParam(3,$state,PDO::PARAM_STR);
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

	public function searchReportPost()
	{
	   if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
       {
	   	    if(!empty($_POST['searchUser']) AND $_POST['country']==-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	{
				if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.email=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
				}
				else
				{
					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.name like ? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
				}

			    $run->bindParam(1,$searchtype,PDO::PARAM_STR);
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{
					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.email=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{
					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.name like ? AND `users`.country=?  GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
				}
			   
	  	   	 }
	  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country'))
	  	   	 {
	  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
				{

					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.email=? GROUP BY `posts`.`id` ORDER BY `post_complaint`.`id` DESC");

					$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
				}
				else
				{

					$run=$this->con->prepare("SELECT `post_complaint`.*,`users`.`name` FROM `post_complaint` JOIN `posts` ON `post_complaint`.`post_id`=`posts`.`id` JOIN `users` ON `post_complaint`.`post_user_id`=`users`.`id` WHERE `users`.name like ? AND `users`.country=? AND `users`.state=? ORDER BY `post_complaint`.`id` DESC");

					$searchtype="%".strtolower($_POST['searchUser'])."%";
					$country=encryption('encrypt',$_POST['country']);
					$state=encryption('encrypt',$_POST['state']);

			        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
			        $run->bindParam(2,$country,PDO::PARAM_STR);
			        $run->bindParam(3,$state,PDO::PARAM_STR);
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

	public function getAccVerification($offset,$limit)
	{
	   if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
       {
       	 $run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `account_verification`.verification_status=? AND `users`.status NOT IN(?) GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC  LIMIT ?,?');

       	 if(is_object($run))
       	 {
       	 	$status=encryption('encrypt','pending');
       	 	$userStatus=encryption('encrypt','block');
       	 	$run->bindParam(1,$status,PDO::PARAM_STR);
       	 	$run->bindParam(2,$userStatus,PDO::PARAM_STR);
       	 	$run->bindParam(3,$offset,PDO::PARAM_INT);
		    $run->bindParam(4,$limit,PDO::PARAM_INT);

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


	public function getVerification($id,$type)
	{
		if($type=='verificationID')
		{
			$run=$this->con->prepare("SELECT * FROM `account_verification` WHERE id=? ORDER BY id DESC");
		}
		else if($type=='userID')
		{
			$run=$this->con->prepare("SELECT * FROM `account_verification` WHERE user_id=? ORDER BY id DESC");
		}
		

		if(is_object($run))
		{
			$run->bindParam(1,$id,PDO::PARAM_INT);
			if($run->execute())
			{
				if($run->rowCount()>0)
				{
					$data=$run->fetchALL(PDO::FETCH_ASSOC);
					return $this->decryptData($data);
				}
				else
				{
					return 0;
				}
			}
		}

		return false;
	}

	public function actionVerification()
	{
		$status=encryption('encrypt',$_POST['actionType']);
		$verificationId=encryption('decrypt',$_POST['verificationId']);
		$data=$this->getVerification($verificationId,'verificationID');

		if(is_array($data))
		{
			if($data[0]['verification_status']=='pending')
			{
		        if($_POST['actionType']=='reject' AND !empty($_POST['adminMsg']))
			 	{
			 		$run=$this->con->prepare('UPDATE `account_verification` SET `verification_status`=?,`admin_reply`=? WHERE id=?');
			 		$msg=encryption('encrypt',$_POST['adminMsg']);
			 		
			 		$run->bindParam(1,$status,PDO::PARAM_STR);
			 		$run->bindParam(2,$msg,PDO::PARAM_STR);
			 		$run->bindParam(3,$verificationId,PDO::PARAM_INT);
			 	}
			 	else if($_POST['actionType']=='verify')
			 	{
			 		$run=$this->con->prepare('UPDATE `account_verification` SET `verification_status`=? WHERE id=?');
			 		$run->bindParam(1,$status,PDO::PARAM_STR);
			 		$run->bindParam(2,$verificationId,PDO::PARAM_INT);
			 	}


			 	if($run->execute())
			 	{
			 		if($_POST['actionType']=='verify')
			 		{
			 			$run=$this->con->prepare('UPDATE `users` SET `bluetick`=? WHERE id=?');
			 			$status=encryption('encrypt','yes');

			 			$run->bindParam(1,$status,PDO::PARAM_STR);
			 		    $run->bindParam(2,$data[0]['user_id'],PDO::PARAM_STR);

			 		    if($run->execute())
			 		    {
			 		    	return 'success';
			 		    }
			 		}

			 		return 'success';
			 	}
			}
			else if($data[0]['verification_status']=='reject')
			{
				return 'already_reject';
			}
			else if($data[0]['verification_status']=='verify')
			{
				return 'account_verify';
			}
		}
		else
		{
			return 'invalidUser';
		}

	 	return false;
	}

	public function getVerifiCountryState($country=null,$state=null)
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
        	$status=encryption('encrypt','pending');

			if($country!=null AND $state!=null)
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE (`users`.country=? AND `users`.state=?) AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');


       	 	    $userStatus=encryption('encrypt','block');
				$country=encryption('encrypt',$country);
			    $state=encryption('encrypt',$state);

			    $run->bindParam(1,$country,PDO::PARAM_STR);
			    $run->bindParam(2,$state,PDO::PARAM_STR);
			    $run->bindParam(3,$status,PDO::PARAM_STR);
			}
			else if($country!=null AND $state==null)
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.country=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$country=encryption('encrypt',$country);
			    $run->bindParam(1,$country,PDO::PARAM_STR);
			    $run->bindParam(2,$status,PDO::PARAM_STR);
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

	public function searchAccVerification()
	{
		$status=encryption('encrypt','pending');

		if(!empty($_POST['searchUser']) AND $_POST['country']==-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
  	   	{
			if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.email=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
			}
			else
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.name like ? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype="%".strtolower($_POST['searchUser'])."%";
			}

		    $run->bindParam(1,$searchtype,PDO::PARAM_STR);
		    $run->bindParam(2,$status,PDO::PARAM_STR);
  	   	 }
  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country'))
  	   	 {

  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.email=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));

		        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
		        $run->bindParam(2,$status,PDO::PARAM_STR);
			}
			else
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.name like ? AND `users`.country=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype="%".strtolower($_POST['searchUser'])."%";
				$country=encryption('encrypt',$_POST['country']);

		        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
		        $run->bindParam(2,$country,PDO::PARAM_STR);
		        $run->bindParam(3,$status,PDO::PARAM_STR);
			}
		   
  	   	 }
  	   	 else if(!empty($_POST['searchUser']) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country'))
  	   	 {
  	   	 	if(filter_var($_POST['searchUser'], FILTER_VALIDATE_EMAIL)) 
			{
				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.email=? AND `users`.country=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype=encryption('encrypt',strtolower($_POST['searchUser']));
		        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
		        $run->bindParam(2,$status,PDO::PARAM_STR);
			}
			else
			{

				$run=$this->con->prepare('SELECT `account_verification`.*,`users`.`name`,`users`.`gender`,`users`.`country`,`users`.`email`,`users`.`image` FROM `account_verification` JOIN `users` ON `account_verification`.`user_id`=`users`.`id` WHERE `users`.name like ? AND `users`.country=? AND `users`.state=? AND `account_verification`.verification_status=? GROUP BY `account_verification`.`user_id` ORDER BY `account_verification`.`id` DESC');

				$searchtype="%".strtolower($_POST['searchUser'])."%";
				$country=encryption('encrypt',$_POST['country']);
				$state=encryption('encrypt',$_POST['state']);

		        $run->bindParam(1,$searchtype,PDO::PARAM_STR);
		        $run->bindParam(2,$country,PDO::PARAM_STR);
		        $run->bindParam(3,$state,PDO::PARAM_STR);
		        $run->bindParam(4,$status,PDO::PARAM_STR);
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



	public function changePassord()
	{
		if(isset($_POST['oldPass']) AND isset($_POST['newPass']) AND isset($_POST['confirmPass']))
	  	{
	  		if(!empty($_POST['oldPass']) AND !empty($_POST['newPass']) AND !empty($_POST['confirmPass']))
		  	{
		  		$run=$this->con->prepare("UPDATE `admin` SET `admin_password`=? WHERE id=?");

		  		if(is_object($run))
		  		{
		  			$encryptPass=encryption('encrypt',$_POST['confirmPass']);
		  			$adminId=encryption('decrypt',$_SESSION['loginAdmin'][0]);

		  			$run->bindParam(1,$encryptPass,PDO::PARAM_STR);
		  			$run->bindParam(2,$adminId,PDO::PARAM_INT);

		  			if($run->execute())
		  			{
		  				return 'success';
		  			}
		  		}
		  	}
		}

		return false;
	}
}

?>