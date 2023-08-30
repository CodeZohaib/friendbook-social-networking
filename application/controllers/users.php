<?php

include "controllerTrait.php";

class users extends framework{
	use controllerTrait;
	

	public function index()
	{
        if(isset($_SESSION['confirm_email']) AND !empty($_SESSION['confirm_email']))
        {
        	$this->redirect('users/emailConfirmation');
        }
        else if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
        	$data=$this->mlUser->getUser('email',$_SESSION['loginUser'][1]);
	        if($data['status']=='securityVerification')
	        {
	             $_SESSION['confirm_email']=[
	                encryption('encrypt',$data['name']),
	                encryption('encrypt',$data['email']),
	                encryption('encrypt',$data['image']),
	              ];

	             unset($_SESSION['loginUser']);
	             $this->redirect('users/emailConfirmation');
	        }
	        else
	        {
	        	$this->redirect('timeline/profile');
	        }
        }
        else
        {
        	$this->view('index');
        }
        
	}

	public function userRegister()
	{
		if (isset($_POST)) 
		{
			if (empty($_POST['name'])) 
			{
				return MsgDisplay('error','Please Enter Your Name....!');
			}
			else if (!preg_match('/^[a-zA-Z ]+$/',$_POST['name'])) 
			{
	          return MsgDisplay('error','Name Must be Character....!');
	        }
			else if(empty($_POST['country']))
			{
				return MsgDisplay('error','Please Select Your Country....!');
			}
			else if(empty($_POST['address']))
			{
				return MsgDisplay('error','Please Enter Your Address....!');
			}
			else if(empty($_POST['password']))
			{
				return MsgDisplay('error','Please Enter Your Password....!');
			}
			else if(empty($_POST['cpassword']))
			{
				return MsgDisplay('error','Please Enter Your Confirm Password....!');
			}
			else if(empty($_POST['gender']))
			{
				return MsgDisplay('error','Please Select Your Gender....!');
			}
			else if($_POST['password'] != $_POST['cpassword'])
			{
				return MsgDisplay('error','Missmatch Password AND Confirm Password....!');
			}
			else if (empty($_FILES['image']['name']))
			{
				return MsgDisplay('error','Please Select Your Profile Picture....!');
			}
			else if(password_method($_POST['password'])===false)
			{
				return MsgDisplay('error','Password Required<br><br> 1=Minimum 8 characters<br> 2=One uppercase letter<br> 3=One lowercase letter,<br> 4=One number,');
			}
			else
			{
			    $response=$this->mlUser->createAccount($_POST);
			    if($response=='image_type_wrong')
			    {
			    	return MsgDisplay('error','Your Image Type is Invalid Only Allowed this Types <br>=> JPG,JPEG,GIF,PNG....!');
			    }
			    else if($response=='success')
			    {
			    	$url=BASEURL."/users/emailConfirmation";
			    	return MsgDisplay('success','Your Account Successfully Created....!','',$url);

			    }
			    else if($response=='account_error')
			    {
			    	return MsgDisplay('error','Account Not Created Try Again....!');
			    }
			    else if($response=='email_exist')
			    {
			    	return MsgDisplay('error','Email Address Already Use Please Try Anthor One....!');
			    }  
			}
		}
	}

	public function login()
	{

		if(empty($_POST['friendbook']))
		{
			$response=$this->mlUser->loginUser();
			if($response==='honeyPort')
			{
				return MsgDisplay('error','Something Was Wrong Please Try Again....!');
			}
			else if($response==='emailEmpty')
			{
				return MsgDisplay('error','Please Enter Email Address.....!');
			}
			else if($response==='passwordEmpty')
			{
				return MsgDisplay('error','Please Enter Password....!');
			}
			else if($response==='passwordWrong')
			{
				return MsgDisplay('error','Invalid Email And Password....!');
			}
			else if($response==='accountBlock')
			{
				return MsgDisplay('error','Your Account is Block Contact Admin....!');
			}
			else if($response==='emailConfirmation')
			{
				$url=BASEURL."/users/emailConfirmation";
			    return MsgDisplay('success','Please Verfiy Your Email Address....!','',$url);
			}
			else if($response==='successLogin')
			{
				$url=BASEURL."/timeline/profile";
			    return MsgDisplay('success','Successfully Login....!','',$url);
			}
			else if($response==1 OR $response==2 OR $response==3)
			{
				return MsgDisplay('error','Invalid Email And Password <br> Login Attempt '.$response.'/3....!');
			}
		}
		else
		{
			return MsgDisplay('error','Something Was Wrong Please Try Again....!');
		}
	}


	public function checkLoginIp()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
        	$response=$this->mlUser->checkLoginIp();


        	if($response=='LoginAnthorDevice' OR $response=='logoutID')
        	{
	        	if($response=='LoginAnthorDevice')
	        	{
	        		return MsgDialog('error','ID Login','Your ID is login Anthor Device','');
	        	}
	        	else if($response=='logoutID')
	        	{
	        		return MsgDialog('error','ID LogOut','Your ID is Logout Anthor Brower With Same Device','');
	        	}
	        }
	        else
	        {
	        	return MsgDisplay('success','success');
	        }
        }
	}

	public function emailConfirmation()
	{

		if(isset($_SESSION['confirm_email']) AND !empty($_SESSION['confirm_email']))
        {
        	$response=$this->mlUser->getUser('email',$_SESSION['confirm_email'][1]);
        	if(is_array($response))
        	{
        		if($response['status']==='notVerify' OR $response['status']==='securityVerification')
	        	{
	        		$this->view('emailConfirmation');
	        	}
	        	else if($response['status']==='block')
	        	{
	        		$this->logout();
	        	}
        	}	
        	
		}
		else
		{
			$this->redirect();
		}
	}

	public function emailConfirm()
	{
		if (isset($_POST['confirmation_code'])) 
		{
			if(empty($_POST['confirmation_code']))
		    {
		    	return MsgDisplay('error','Please Enter Your Confirmation Code.....!');
		    }
		    else
		    {
		    	$confirmation_code=$_POST['confirmation_code'];
			    $response=$this->mlUser->emailConfirmation($confirmation_code);

			    if($response=='success')
			    {
			    	$url=BASEURL."/users/index";
			    	session_destroy();
			    	return MsgDisplay('success','Your Email Address is Verfiy Please login....!','',$url);
			    }
			    else if($response=='wrong_code')
			    {
			    	return MsgDisplay('error','Confirmation Code is Wrong...!');
			    }
		    }
		}
	}

	public function resendEmail()
	{
		$response=$this->mlUser->resendEmail();
		if($response=='success')
		{
			return MsgDisplay('success','Confirmation Code Send Your Email Address....!');
		}
	}


	public function userUpdate()
	{
		if(isset($_POST) OR isset($_FILES['profile_image']))
		{
			$response=$this->mlUser->profileUpdate();

			if(isset($_POST['bio']) AND $response=='success')
			{
				$msg='Your Personal Information is Added Successfully....!';
			}
			else if(isset($_POST['work_experiences']) AND isset($_POST['work']) AND $response=='success')
			{
				$msg='Work Detail Added Successfully....!';
			}
			else if(isset($_POST['address']))
			{
				$msg='Address is Added Successfully....!';
			}
			else if(isset($_POST['language']))
			{
				$msg='Language Added Successfully....!';
			}
			else if(isset($_POST['old_password']) AND isset($_POST['new_password']) AND isset($_POST['confirm_password']))
			{
				if($response!='success')
				{
					return MsgDisplay('error',$response);
				}
				else
				{
					$msg="Password Change Successfully.......!";
				}
			}
			else if(isset($_POST['country']) AND isset($_POST['state']))
			{
				if($_POST['country']==-1)
				{
					return MsgDisplay('error','Please Select Country.....!');
				}
				else if(empty($_POST['state']))
				{
					return MsgDisplay('error','Please Select State.....!');
				}
				else
				{
					if($response==='success')
					{
						$msg='Country State Change Successfully......!';
					}
					else
					{
						return MsgDisplay('error','Something Was Wrong Please Try Again.....!');
					}
				}	
			}
			else if(isset($_POST['email_type']) AND !empty($_POST['email_type']))
			{
				if($response==='success')
				{
					return MsgDisplay('email_type_change','');
				}
				else
				{
					return MsgDisplay('email_type_error','');
				}
			}
			else if(isset($_POST['account_type']) AND !empty($_POST['account_type']))
			{
				if($response==='success')
				{
					return MsgDisplay('account_type_change','');
				}
				else
				{
					return MsgDisplay('account_type_error','');
				}
			}
			else if(isset($_FILES['profile_image']))
			{	
				if($response=='image_type_wrong')
				{
					return MsgDialog('error','Profile Image Error','Your Image Type is Invalid Only Allowed this Types <br>=> JPG,JPEG,GIF,PNG....!','');
				}
				else if($response=='success')
				{
					$this->mlPost->insertPost();
					return MsgDialog('success','Profile Image Change','Profile Image Updated Successfully....!','');
				}
			}
			else if(isset($_FILES['cover_image']))
			{	
				if($response=='image_type_wrong')
				{
					return MsgDialog('error','Cover Image Error','Your Image Type is Invalid Only Allowed this Types <br>=> JPG,JPEG,GIF,PNG....!','');
				}
				else if($response=='success')
				{
					$this->mlPost->insertPost();
					return MsgDialog('success','Cover Image Change','Cover Image Change Successfully....!','');
				}
			}
			else if(isset($_POST['data']))
			{
				
				if($_POST['data']==='delete_profile_pic')
				{
					return MsgDialog('success','Profile Image Delete','Profile Image Deleted Successfully....!','');
				}

				if($_POST['data']==='delete_cover_pic')
				{
					return MsgDialog('success','Cover Image Delete','Cover Image Deleted Successfully....!','');
				}
			}
			else if(isset($_POST['new_name']) AND isset($_POST['password']))
			{
				if($response=='passwordWrong')
				{
					return MsgDisplay('error','Password is Incorrect.....!');
				}
				else if($response=='emailWrong')
				{
					return MsgDisplay('error','Email is Incorrect.....!');
				}
				else if($response=='securityVerification')
				{
					$url=BASEURL."/users/emailConfirmation";

					unset($_SESSION['loginUser']);
					return MsgDisplay('securityVerification','Invalid Password Attempt 3 Time<br> Please Verfiy Your Email Address.....!','',$url);
				}
				else if ($response=='Login Attempt 1/3' OR $response=='Login Attempt 2/3' OR $response=='Login Attempt 3/3') 
				{
					if($response=='Login Attempt 3/3')
					{
						$url=BASEURL."/users/emailConfirmation";
					    unset($_SESSION['loginUser']);
						return MsgDisplay('securityVerification','Invalid Password Attempt 3 Time<br> Please Verfiy Your Email Address.....!','',$url);
					}
					else
					{
						return MsgDisplay('error','Invalid Password<br>'.$response);
					}
					
				}
				else if($response=='update_3_time')
				{
					return MsgDisplay('error','Name Not Update Any More Because You Already Update 3 Times.....!');
				}
				else if($response=='success')
				{
					$msg="Name Updated Successfully.....!";
				}
			}
			else if(isset($_POST['code']) AND isset($_POST['new_email'])  AND isset($_POST['password']))
			{
				if ($response=='Login Attempt 1/3' OR $response=='Login Attempt 2/3' OR $response=='Login Attempt 3/3') 
				{
					if($response=='Login Attempt 3/3')
					{
						$url=BASEURL."/users/emailConfirmation";
					    unset($_SESSION['loginUser']);
						return MsgDisplay('securityVerification','Invalid Email & Password Attempt 3 Time<br> Please Verfiy Your Email Address.....!','',$url);
					}
					else
					{
						return MsgDisplay('error','Invalid Password<br>'.$response);
					}
					
				}
				else if($response=='update_3_time')
				{
					return MsgDisplay('error','Email Not Update Any More Because You Already Update 3 Times.....!');
				}
				else if($response=='code_wrong')
				{
					return MsgDisplay('error','Confirmation Code is Wrong.....!');
				}
				else if($response=='typeOldEmail')
				{
					return MsgDisplay('error','Please Enter Your New Email Address.....!');
				}
				else if($response=='success')
				{
					$msg='Email Address is Successfully Updated.....!';
				}
			}
			else if(isset($_POST['newEmail']))
			{
				if($response==='typeOldEmail')
				{
					return MsgDisplay('error','Please Enter Your New Email Address.....!');
				}
				else
				{
					return MsgDisplay('success','Confirmation Code Send Your Email Address Check Email.....!');
				}
				
			}
			else if(isset($_POST['forgot_password']) AND isset($_POST['name']))
			{
				if($response=='name_empty')
				{
					return MsgDisplay('error','Please Enter Your Account Name.....!');
				}
				else if($response=='email_empty')
				{
					return MsgDisplay('error','Please Enter Your Email.....!');
				}
				else if($response=='invalid_name')
				{
					return MsgDisplay('error','Invalid Account Name.....!');
				}
				else if($response=='invalid_email')
				{
					return MsgDisplay('error','Invalid Email Address.....!');
				}
				else if($response=='success')
				{
					$msg='Your Password send you email address please check your email.....!';
				}
			}
			else if(isset($_POST['activeStatus']))
			{
				if($response==='success')
				{
					return MsgDisplay('success','');
					
				}
				else
				{
					return MsgDialog('error','Active Status Error','Something was wrong please refersh web page....!','');
				}
			}
			
			if($response=='success')
			{
				$url=BASEURL."/timeline/profile";
				if(isset($msg))
				{
					return MsgDisplay('success',$msg,'',$url);
				}
				else
				{
					return MsgDisplay('error','Something Was Wrong Please Try Again.....!');
				}
				
			}
			else
			{
				return MsgDisplay('error','Something Was Wrong Please Try Again.....!');
			}
		}

	}

	public function userReport()
	{
		if(isset($_POST['user_id']))
		{
			$friendId=explode('94039',$_POST['user_id']);

			if(is_array($friendId) AND isset($friendId[0]))
			{
			  $id=encryption('decrypt', $friendId[0]);
			  if($id!=false)
			  {
			  	if(isset($_POST['complaint']) AND isset($_FILES['image']) AND !empty($_POST['complaint']) AND !empty($_FILES['image']))
				{
					$response=$this->mlUser->accountReport($id);

					if(is_array($response) AND !empty($response))
					{
						return MsgDisplay('error',implode(" and ",$response)." File Not Upload...!",'');
					}
					else if($response=='success')
					{
						return MsgDisplay('success',"Complaint Added Successfully.....!",'');
					}
					else if($response=='invalid_user')
					{
						return MsgDisplay('error','Invalid User Profile Complaint....!','');
					}
					else if ($response=='already_complaint') 
					{
						return MsgDisplay('error','Complaint already sent to admin please wait for action....!','');
					}
					
				}
			  }
			  else
			  {
				return MsgDisplay('error','Invalid User Profile Complaint....!','');
			  }
			}
			else
		    {
			 return MsgDisplay('error','Invalid User Profile Complaint....!','');
		    }
	   }
	   else
	   {
		return MsgDisplay('error','Invalid User Profile Complaint....!','');
	   }
	
	}


	public function accountVerification()
	{
		if(isset($_FILES['image']) AND !empty($_FILES['image']) AND is_array($_FILES['image']))
		{
			$response=$this->mlUser->accountVerification();
			if(is_array($response) AND !empty($response))
			{
				return MsgDisplay('error',implode(" and ",$response)." File Not Upload...!",'');
			}
			else if($response=='success')
			{
				return MsgDisplay('success',"Account Verification Submit Successfully.....!",'');
			}
			else if($response=='invalid_user')
			{
				return MsgDisplay('error','Invalid User....!','');
			}
			else if ($response=='verification_pending') 
			{
				return MsgDisplay('error','Please wait Verification is already submitted wait for reply ....!','');
			}
			else if ($response=='account_already_verify') 
			{
				return MsgDisplay('success','Account is already Verfied Thank You 🙂 ....!','');
			}
			
		}
		else
		{
			return MsgDisplay('error','Please upload any government Proof to confirm your identity....!','');
		}
	}



	public function onlineUserInsert()
	{
		if(isset($_POST['onlineUserInsert']) AND isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
		{
          $this->mlUser->onlineUserInsert();
		}
	}

	public function getNewsfeedPeople()
	{
	  if(isset($_POST['url']) AND isset($_POST['offset']) AND isset($_POST['rows']) AND isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	  {
	  	  $people=[];
	  	  $checkUrl = explode('/', $_POST['url']);
	      if(end($checkUrl)=='newsfeedNearbyPeople')
	      {
	      	$response=$this->mlUser->getNewsfeedPeople();

	      	if($response=='zero')
	      	{
	      		$email=$_SESSION['loginUser'][1];
			      $data=$this->mlUser->getUser('email',$email);
				    $country=$data['country'];

				    return MsgDisplay('error','<br><br><div class="alert alert-danger alert-dismissable text-center">
                     <a href="#" class="close" data-dismiss="alert">×</a>
                   <p><strong>'.$country.'</strong> User Not Create Account....!</p></div>'); 

	      	}
	      	else if($response==false)
	      	{
	      		return MsgDisplay('error','Something Was Problem Please Refersh Your Web Page....!');
	      	}
	      	else
	      	{
	      		return $this->newsfeedPeople($response);
	      	}
	      }
	  }
	}


	public function searchUser()
	{
	  if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	  {
	  	if(isset($_POST) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		$response=$this->mlUser->getNewsfeedPeople($_POST['country']);
		  	if($response=='zero')
	      	{
	      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country<strong></strong> Users Not Create Account....!");
	      	}
	      	else if($response==false)
	      	{
	      		return MsgDisplay('error','Something Was Problem Please Refersh Your Web Page....!');
	      	}
	      	else
	      	{
	      		return $this->newsfeedPeople($response);
	      	}
	  	}
	  	else if(isset($_POST) AND $_POST['country']==-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		return MsgDisplay('error','Please Select Country....!');
	  	}
	  	else if(isset($_POST) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		$response=$this->mlUser->getNewsfeedPeople($_POST['country'],$_POST['state']);
		  	if($response=='zero')
	      	{
	      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country and State <strong>".$_POST['state']."</strong> Users Not Create Account....!");
	      	}
	      	else if($response==false)
	      	{
	      		return MsgDisplay('error','Something Was Problem Please Refersh Your Web Page....!');
	      	}
	      	else
	      	{
	      		return $this->newsfeedPeople($response);
	      	}
	  	}
	  	else
	  	{
	  	   if(empty($_POST['searchUser']) AND $_POST['country']==-1 AND $_POST['state']=='First Select Country')
	  	   {
	  	   	 return MsgDisplay('error','Please Enter Email OR Name........');
	  	   }
	  	   else
	  	   {
	  	   	  $response=$this->mlUser->searchUser();
	  	   	  if($response=='notFound')
	  	   	  {
	  	   	  	return MsgDisplay('error','Not Found User........');
	  	   	  }
	  	   	  else if($response==false)
	  	   	  {
	  	   	  	return MsgDisplay('error','Something Was Wrong Please Refersh Your Web Page........');
	  	   	  }
	  	   	  else
	  	   	  {
	  	   	  	return $this->newsfeedPeople($response);
	  	   	  }
	  	   }
	  	}
	  }
	}

	public function newsfeedPeople($response)
	{
		if(is_array($response))
	  	{
	  		$html=[];
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

	         $html[].="<div class='nearby-user'><div class='row'>
	          <div class='col-md-2 col-sm-2'>
	            
	            <img src='".$image."'  alt='user' class='profile-photo-lg' onclick='imageView(this)' />
	          </div>
	          <div class='col-md-7 col-sm-7'>
	            <h5><a href='".$profile_id."' class='profile-link'>".ucwords($value['name'])." $badge</a></h5>

	            <p class='text-muted' title='User Account Created Date & Time'>".date('M j Y g:i A', strtotime($value['created_at']))."</p>
	            
	             <p style='font-size:20px;'>
	               <span title='Country Flag (".strtoupper($value['country']).")' class='flag-icon flag-icon-".$flag."' style='border:1px solid black'></span>
	             </p>
	            
	            
	          </div>
	          <div class='col-md-3 col-sm-3 request_btn' onclick='request_btn(this)'>
	            <button class='btn btn-primary pull-right add_friend' friend_request='".encryption('encrypt',$value['id'])."' >Add Friend</button>
	          </div>
	        </div></div><br><br>";
		    }

	    	if(isset($html) AND is_array($html) AND !empty($html))
	      {
	        $val=implode(" ",$html);
	        return MsgDisplay('success',$val,'');
	      }
	  	}
	}


	public function logout()
	{
		$this->mlUser->deleteIp();
		if(isset($_SESSION['loginUser']))
		{
			unset($_SESSION['loginUser']);
		}
		else
		{
			unset($_SESSION['confirm_email']);
		}
		
		$this->redirect();
	}


	public function sessionLogout()
	{
		unset($_SESSION['loginUser']);

		$this->redirect();
	}
}


?>