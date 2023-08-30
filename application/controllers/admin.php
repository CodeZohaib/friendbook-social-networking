<?php 
include "controllerTrait.php";

class admin extends framework{
	use controllerTrait;

	public function index()
	{
      if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
      {
      	$this->view('admin/index');
      }
      else
      {
      	$this->view('admin/login');
      } 
	}

	public function dashboard()
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
    	$this->view('admin/index');
    }
    else
    {
    	$this->view('admin/login');
    }

	}

	public function allUsers()
	{
      if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
      {
      	$this->view('admin/allUsers');
      }
      else
      {
      	$this->view('admin/login');
      } 
	}

	public function allPostReport()
	{
      if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
      {
      	$this->view('admin/allPostReport');
      }
      else
      {
      	$this->view('admin/login');
      } 
	}

	public function allAccountReport()
	{
      if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
      {
      	$this->view('admin/allAccountReport');
      }
      else
      {
      	$this->view('admin/login');
      } 
	}

	public function accountVerification()
	{
      if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
      {
      	$this->view('admin/accountVerification');
      }
      else
      {
      	$this->view('admin/login');
      } 
	}

	public function getTotalUser()
	{
		return $this->mlAdmin->getTotalData();
	}

	public function adminLogin()
	{
		if(isset($_POST['email']) AND isset($_POST['pass']))
		{
		  $email=encryption('encrypt',$_POST['email']);
		  $data=$this->mlAdmin->getAdmin($email);
		  sleep(1);
		 
		  if(is_array($data))
		  {
		  	if($data['admin_password']===$_POST['pass'])
		  	{
		  		$_SESSION['loginAdmin']=[
				  encryption('encrypt',$data['id']),
				  encryption('encrypt',$data['email']),
                ];

            $url=BASEURL."/admin/dashboard";
            return MsgDisplay('success','Login Successfully....!','',$url);
		  	}
		  	else
		  	{
		  		return MsgDisplay('error','Invalid Password....!');
		  	}
		  }
		  else if ($data=='wrong') 
		  {
		  	return MsgDisplay('error','Invalid Email And Password....!');
		  }
		}
		else
		{
			return MsgDisplay('error','Please Enter Email AND Password....!');
		}
	}

	public function getAdminDetail()
	{
		
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
		{
			return $this->mlAdmin->getAdmin($_SESSION['loginAdmin'][1]);
		}
	}


	public function forgotPassord()
	{
		if(isset($_POST['name']) AND isset($_POST['email']))
		{
			$response=$this->mlAdmin->forgotPassord();

			if($response=='success')
			{
	    	return MsgDisplay('success','Password Will be Send Your Email Address. Please Check Your Email....!');
			}
			else if ($response=='wrong') 
			{
				return MsgDisplay('error','Invalid Name AND Email.....!');
			}
			else
			{
				return MsgDisplay('error','Something Thing Was Wrong Please Try Again.....!');
			}
		}
	}

	public function getDashboardData()
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
			$data=[];

			$data['totalUsers']=$this->mlAdmin->getTotalData();
			$data['recentJoin']=$this->mlAdmin->getAllUsers(0,10);
			$data['profileReports']=$this->mlAdmin->getProfileReports(0,10);
			$data['postReports']=$this->mlAdmin->getPostReports(0,10);
			
			return $data;
		}
		else
		{
			$this->redirect();
		}
	}

	public function totalPostComplaint($postId)
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
			$response=$this->mlAdmin->totalPostReport($postId);
			if($response==false)
			{
				return 0;
			}
			else
			{
				return $response;
			}
	  }
	}

	public function totalAccountComplaint($userID)
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
        {
			$response=$this->mlAdmin->totalAccountReport($userID);
			if($response==false)
			{
				return 0;
			}
			else
			{
				return $response;
			}
	    }
	}

	public function getPostData($postId)
	{
		if(!empty($postId))
		{
			if(encryption('decrypt',$postId))
			{
				$post_detail=$this->mlAdmin->getPost(encryption('decrypt',$postId));

				if(is_array($post_detail))
				{
					return $post_detail;
				}
			}
		}

		return false;
	}

	public function viewProfile()
	{
		if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
			if(isset($_POST['user_id']))
			{
				$id=encryption('decrypt',$_POST['user_id']);

				if($id!=false)
				{
					$data=$this->mlAdmin->getUser('id',$id);
					$id=encryption('encrypt',$data['id']);
					$profileImage=BASEURL."/public/assets/images/users/".$data['image'];

					if($data['bg_image']!='cover.png' AND $data['bg_image']!=null)
					{ 
						$coverImage=BASEURL."/public/assets/images/covers/".$data['bg_image']; 
					}
					else
					{ 
						$coverImage=BASEURL."/public/assets/images/covers/cover.png";
					}

				    if($data['status']=='notVerify')
		         {
		            $status="<span class='badge' style='background:#9097c4'>Not Verify</span>";
		         }
		         else if($data['status']=='verify')
		         {
		            $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
		         }
		         else if($data['status']=='block')
		         {
		            $status="<span class='badge' style='background:#ff5e5e'>Block</span>";
		         }
		         else if($data['status']=='securityVerification')
		         {
		            $status="<span class='badge' style='background:#464a53'>Security Verification</span>";
		         }


					$html='<table class="table table-bordered table-responsive row">

			        <tr>
			          <td class="col-md-4"><b>Name*</b></td>
			          <td class="col-md-4">
			             '.ucfirst($data['name']).'
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Email*</b></td>
			          <td class="col-md-4">'.$data['email'].'</td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Email Privacy</b></td>
			          <td class="col-md-4">'.ucfirst($data['email_type']).'
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Contary*</b></td>
			          <td class="col-md-4">
			              <b>'.ucfirst($data['country']).'</b>
			              <h1 title="Country Flag ('.strtoupper(countryName_to_code($data['country'])).')" class="flag-icon flag-icon-'.strtolower(countryName_to_code($data['country'])).'" style="border:1px solid black"></h1>
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>State*</b></td>
			          <td class="col-md-4">
			            <b>'.ucfirst($data['state']).'</b>
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Gender*</b></td>
			          <td class="col-md-4">
			             '.ucfirst($data['gender']).'
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Address*</b></td>
			          <td class="col-md-4">'.ucfirst($data['address']).'</td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Bio</b></td>
			          <td class="col-md-4">'.$data['bio'].'</td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Work Info</b></td>
			          <td class="col-md-4">
			            '.$data['work'].'<br>
			            '.$data['work_experiences'].'
			          </td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Languages</b></td>
			          <td class="col-md-4">'.$data['language'].'</td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Status</b></td>
			          <td class="col-md-4">'.$status.'</td>
			        </tr>

			        <tr>
			          <td class="col-md-4"><b>Account Privacy</b></td>
			          <td class="col-md-4">'.ucfirst($data['account_type']).'
			          </td>
			        </tr>
			      </table><br>

			      <b>Profile Image</b><br>
			      <center><img src="'.$profileImage.'" style="width:500px;height:500px" class="img img-responsive img-thumbnail"></center><br><br>

			       <b>Cover Image</b><br>
			       <center><img src="'.$coverImage.'" class="img img-responsive img-thumbnail"></center>

			      ';

			       return MsgDisplay('success',$html);
				}	
			}
		}
		else
		{
		  $this->redirect();
	  }
  }

  
  public function viewPost()
  {
  	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
  	{
  	 	$postId=encryption('decrypt',$_POST['post_id']);
  	 	if(isset($_POST['post_id']) AND $postId!=false) 
  	 	{
  	 		$value=$this->mlAdmin->getPost($postId);

  	 	 if(isset($value) AND is_array($value) AND $value!=false)
		   {
			   $html=[];
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
	             $File="<center><video  class='post-video stylish_player' style='height:650px' controls> 
	                       <source src='$path' type='".$value['post_file_type']."'> 
	                   </video></center>&nbsp;";
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
	         $post= "<i class='em em-thumbsup'>Post Text:- </i>
	         <b class='post_span post-text'>".htmlspecialchars($value['post_text'])."</b><div class='line-divider'></div>";
	       }
	       else
	       {
	         $post='';
	       }

	       $time=TimeAgo($value['post_date'],$this->mlUser->current_time(),'Message');
	       $post_id=encryption('encrypt',$value['id']);
	       $user_id=encryption('encrypt',$value['user_id']);

	       if($userData['bluetick']=='yes' AND $userData['bluetick']!='NULL')
	       {
	           $bluetick=" <span class='glyphicon glyphicon-ok-sign text-success' style='font-size:15px'></span>";
	       }
	       else
	       {
	         $bluetick='';
	       }
	      
	       //$postComments=$this->mlAdmin->getPostComment($value['id']);

	       $link=BASEURL."/timeline/viewPost/94039".encryption('encrypt',$value['id']);

	       $onlineUser=$this->mlAdmin->getOnlineUser($value['user_id']);

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

		      $html[].='<div class="post-content">
		        '.$File.'
		        <div class="post-container" style="margin:20px">
		          <img src="'.BASEURL.'/public/assets/images/users/'.$userData['image'].'" onclick="imageView(this)" alt="user" class="profile-photo-md pull-left" onclick="imageView(this)" />
		          <div class="post-detail">
		            <div class="user-info">
		              <h5><a href="#" class="profile-link" onclick="viewUserProfile(this)" user_id="'.encryption('encrypt',$userData['id']).'" data-target=".view_Profile" data-toggle="modal">'.ucwords($userData['name']).' '.$onlineBadge.' </a> '.$bluetick.' <span class="following">';
		                  
		              
		              $html[].='</span></h5>
		                         <p class="text-muted">Published a post about '. $time.'</p>
		                       <h5>';
		                  
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
		            
		              $html[].='

		             <button type="button" class="btn btn-success btn-xs copyLink" link="'.$link.'" onclick="copyLink(this)">Link Copy</button>
		            </div>';

		              $html[].="
		            
		              <div class='line-divider'></div>".$post."
		              <br>
		              <div class='msgDisplay'></div>
		              
		            </div>
		         </div>";
			            
		            

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

  public function viewPostComplaint()
  {
 	  if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
	  {
	  	if(isset($_POST['postId']) AND !empty($_POST['postId'])) 
	  	{
	  		$html=[];
	  		$postId=encryption('decrypt',$_POST['postId']);
	  		if($postId!=false)
	  		{
	  		 	$allComplaint=$this->mlAdmin->getComplaintPost('postID',$postId);
	  		 	if(is_array($allComplaint))
	  		 	{
	  		 		if($allComplaint[0]['admin_action']=='Null')
	  	      {
		  	      $value="submitComplaint('postComplaint')";

	  	  	    $html[].='
	                   <br><br>
	                   <textarea class="textarea form-control" id="postAdminMsg" name="adminMsg" rows="5" col="10" placeholder="Enter Message About Complaint .....!" pattren="[A-Za-z]{550}" maxlength="550" required></textarea><br><br>
	                      <b>Action</b><select name="select_type" class="form-control" id="complaintActionType">
	                          <option value="">Select Option</option>
	                            <option value="complaint_reject">Reject Complaint</option>  
	                            <option value="delete_post">Post Delete</option>
	                        </select><br><br>
	                        <input type="text" value="'.$_POST['postId'].'" disabled hidden id="postID">
	                       <div class="displayError"></div>
	                      <button type="button" data-dismiss="modal" style="float:right;margin-left:6px" class="btn btn-danger">Close</button>
	                      <input type="button" value="Submit" style="float:right;" class="btn btn-success" onclick="'.$value.'"><br><br>';
	          }
	          else
	          {
	          	$html[].='';
	          }

	          if(is_array($allComplaint))
            {
            	$response=$this->getAllComplaint($allComplaint);
            	if(is_array($response))
            	{
            		$html=array_merge($html,$response);
            	}
	          }
	        }
	  	
		  		if(isset($html) AND is_array($html) AND !empty($html))
	        {
	         $val=implode(" ",$html);
	         return MsgDisplay('success',$val,'');
	        }
  	  	}
  	  }
    }
  }

   public function viewAllPostComplaint()
   {
   	 if(isset($_POST['postID']))
   	 {
   	 	 $postID=encryption('decrypt',$_POST['postID']);
   	 	 if($postID!=false)
   	 	 {
   	 	 	 $allComplaint=$this->mlAdmin->getComplaintPost('postID',$postID);
   	 	 	 if(is_array($allComplaint))
	   	 	 {
	   	 	    $html=$this->getAllComplaint($allComplaint);
            if(is_array($html))
          	{
          		if(isset($html) AND is_array($html) AND !empty($html))
		          {
		           $val=implode(" ",$html);
		           return MsgDisplay('success',$val,'');
		          }
          	}
	   	 	 }
   	 	 }
   	 }
   }


 public function viewAllAccountComplaint()
 {
 	 if(isset($_POST['userID']))
 	 {
 	 	 $userID=encryption('decrypt',$_POST['userID']);
 	 	 if($userID!=false)
 	 	 {
 	 	 	 $allComplaint=$this->mlAdmin->allProfileReports($userID);

 	 	 	 if(is_array($allComplaint))
   	 	 {
   	 	    $html=$this->getAllComplaint($allComplaint);
          if(is_array($html))
        	{
        		if(isset($html) AND is_array($html) AND !empty($html))
	          {
	           $val=implode(" ",$html);
	           return MsgDisplay('success',$val,'');
	          }
        	}
   	 	 }
 	 	 }
 	 }
 }

   public function getAllComplaint($allComplaint)
   {
   	//Complaint Array Convert to accordion
   	if(is_array($allComplaint))
   	{
   		$html=[];
   		$total=count($allComplaint);
			if($total>0)
			{
				$html[].='<div class="complaintHistory">
				<center><h3 class="heading">All Complaint</h3></center><br>
				<div class="panel-group" id="accordion1">';
				foreach($allComplaint as $key => $value) 
				{
					$complaintUser=$this->getUserInfo('id',$value['complaint_user_id']);

					if($value['admin_action']=='deletePost')
	        {
	            $badge="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
	        }
	        else if($value['admin_action']=='reject')
	        {
	            $badge="<span class='badge' style='background:#9097c4'>Reject Complaint</span>";
	        }
	        else if($value['admin_action']=='Null')
	        {
	            $badge="<span class='badge' style='background:#FF33FC'>Pending Complaint</span>";
	        }
	        else if($value['admin_action']=='warning')
	        {
	            $badge="<span class='badge' style='background:#FF9C33'>Warning</span>";
	        }
	        else if($value['admin_action']=='securityVerification')
	        {
	            $badge="<span class='badge' style='background:#464a53'>Security Verification</span>";
	        }

	        
	        $path=BASEURL."/public/assets/images/users/".$complaintUser['image'];
	        $complaintUserID=encryption('encrypt',$value['complaint_user_id']);
	        $target="#".$total;
				  $html[].='
	         <div class="panel panel">
	           <div class="panel-heading">
	             <h4 class="panel-title">
	               <a href="'.$target.'" data-parent="#accordion1" data-toggle="collapse"><h4>Complaint No '.$total.' &nbsp;&nbsp;&nbsp;&nbsp;'.$badge.'</h4></a>
	             </h4>
	           </div>

	           <div id="'.$total.'" class="panel-collapse collapse">
	              <div class="container-fluid">
	              <img src="'.$path.'" width="30px" class="profile-photo-md image_style" data-toggle="modal" data-target=".imageBigView" onclick="imageModel(this)"> <b><a href="" user_id="'.$complaintUserID.'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)">'.ucfirst($complaintUser['name']).'</a></b><br><br>
	              <b>Complaint:- </b><p>'.$value['complaint'].'</p>
	              <b>Screenshoot</b><br>
	          ';

	           if(isset($value['post_file_name']))
	           {
	           	  $img_Path=BASEURL."/public/assets/post_report/";
	           	  $img_name=explode('940961',$value['post_file_name']);
		           	if(!empty($value['adminMsg']))
				        {
				        	$adminMsg=ucfirst(htmlspecialchars($value['adminMsg']));
				        }
				        else
				        {
				        	$adminMsg="Complaint is Pending";
				        }
	           }
	           else
	           {
		           	$img_Path=BASEURL."/public/assets/account_report/";
		           	$img_name=explode('940961',$value['upload_file_name']);
		           	if(!empty($value['admin_msg']))
				        {
				        	$adminMsg=ucfirst(htmlspecialchars($value['admin_msg']));
				        }
				        else
				        {
				        	$adminMsg="Complaint is Pending";
				        }
	           }
	            

	  	  	    foreach ($img_name as $key => $image) 
	  	  	    {
	  	  	    	  if(!empty($image))
	  	  	    	  {
	  	  	    	  	$path=$img_Path.$image;
	  	  	    		  $html[].='<img src="'.$path.'" width="200px" width="200px" class="img img-thumbnail image_style" data-toggle="modal" data-target=".imageBigView" onclick="imageModel(this)">';
	  	  	    	  } 
	  	  	    }
	             $html[].=' <br><br><b>Admin Reply</b>
	              <p>'.$adminMsg.'</p>
	            </div><hr>
	           </div>
	          </div>';
	        $total--;
	      }
	      $html[].="</div>";
	    }

	    return $html;
   	}

   	return false;
   }

   public function actionComplaint()
   {
   	 if(isset($_POST))
   	 {
   	 	 if(isset($_POST['action']) AND empty($_POST['action']))
   	 	 {
   	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Select Option.......!</p>",'');
   	 	 }
   	 	 else if(isset($_POST['adminMsg']) AND empty($_POST['adminMsg']))
   	 	 {
   	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Enter Message About Complaint.......!</p>",'');
   	 	 }
   	 	 else
   	 	 {

	 	 	 	if(isset($_POST['complaintType'])=='postComplaint' AND isset($_POST['postID']))
 	 	 	  {
   	 	 	 	$postID=encryption('decrypt',$_POST['postID']);
	   	 	 	if($postID!=false)
	   	 	 	{
	   	 	 	 	$response=$this->mlAdmin->actionPostComplaint();
	   	 	 	 	$action=$_POST['action'];
	   	 	 	 	if($response=='success')
	   	 	 	 	{
	   	 	 	 	 	  if($action=='complaint_reject')
			    			{
			    				$msg="Complaint Reject Successfully....!";
			    			}
			    			else if($action=='delete_post')
			    			{
			    				$msg="Post Deleted Successfully....!";
			    			}
			    			else if($action=='accountblock')
			    			{
			    				$msg="User Account Block Successfully....!";
			    			}
			    			else if($action=='securityVerification')
			    			{
			    				$msg="User Account Security Verification Status Successfully....!";
			    			}
			    			else
			    			{
			    				return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Refersh Your Web Page Something Was Problem......!</p>",'');
			    			}

			    			if(isset($msg))
			    			{
			    				return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>".$msg."</p>",'');
			    			}
	   	 	 	 	}
	   	 	 	 	else if($response=='accountBlock')
			    	{
			    		return MsgDisplay('success',"accountBlock",'');
			    	}
	   	 	 	 	else if($response=='already_reject_admin')
	   	 	 	 	{
	   	 	 	 	 		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Complaint is already reject by admin......!</p>",'');
	   	 	 	 	}
	   	 	 	 	else if($response=='already_delete_admin')
	   	 	 	 	{
	   	 	 	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Post is already Delete by admin......!</p>",'');
	   	 	 	 	}
	   	 	 	 	else if(is_int($response))
			    	{
			    		return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Account Warning Alert Number (".$response.") Added Successfully....!</p>",'');
			    	}
   	 	 	  }
 	 	 	  }
 	 	 	  else if(isset($_POST['complaintType'])=='profileComplaint' AND isset($_POST['profileUserID']))
 	 	 	  {

 	 	 	  	$profileUserID=encryption('decrypt',$_POST['profileUserID']);


	   	 	 	if($profileUserID!=false)
	   	 	 	{
	   	 	 		$response=$this->mlAdmin->actionPostComplaint();
	   	 	   	$action=$_POST['action'];

	   	 	   	if($response=='success')
	   	 	 	 	{
	   	 	 	 	 	  if($action=='complaint_reject')
			    			{
			    				$msg="Complaint Reject Successfully....!";
			    			}
			    			else if($action=='securityVerification')
			    			{
			    				$msg="Account Security Verification Status Updated Successfully....!";
			    			}
			    			else
			    			{
			    				return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Refersh Your Web Page Something Was Problem......!</p>",'');
			    			}

			    			if(isset($msg))
			    			{
			    				return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>".$msg."</p>",'');
			    			}

			    	}
			    	else if($response=='accountBlock')
			    	{
			    		return MsgDisplay('success',"accountBlock",'');
			    	}
			    	else if($response=='already_reject')
			    	{
			    		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Complaint is already reject by admin......!</p>",'');
			    	}
			    	else if($response=='already_warning')
			    	{
			    		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Complaint is already Done by admin and already warning alert ......!</p>",'');
			    	}
			    	else if($response=='already_securityVerification')
			    	{
			    		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Complaint is already Done by admin and already Account Security Verification Status ......!</p>",'');
			    	}
			    	else if(is_int($response))
			    	{
			    		return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Account Warning Alert Number (".$response.") Added Successfully....!</p>",'');
			    	}
	   	 	 	}
 	 	 	  }
 	 	 	  else
 	 	 	  {
 	 	 	  		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Refersh Your Web Page Something Was Problem......!</p>",'');
 	 	 	  }
   	 	 }
   	 }
   }

   public function getAllUsers($offset,$total)
   {
   	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
	   	 $response=$this->mlAdmin->getAllUsers($offset,$total);
	   	 if(is_array($response))
	   	 {
	   	 	 $html=[];

	   	 	 $html[].='<table class="table table-bordered table-striped table-hover">
	          <thead>
	              <tr>
	                  <th>No #</th>
	                  <th>Image</th>
	                  <th>Name</th>
	                  <th>Email</th>
	                  <th>Country</th>
	                  <th>State</th>
	                  <th>Address</th>
	                  <th>Status</th>
	                  <th>Date</th>
	              </tr>
	          </thead>
	           <tbody>';

	           if($offset==0)
	           {
	           	$i=1;
	           }
	           else
	           {
	           	$i=$offset+1;
	           }
	           
	           foreach ($response as $key => $value) 
	           {
	               if($value['status']=='notVerify')
	               {
	                  $status="<span class='badge' style='background:#9097c4'>Not Verify</span>";
	               }
	               else if($value['status']=='verify')
	               {
	                  $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
	               }
	               else if($value['status']=='block')
	               {
	                  $status="<span class='badge' style='background:#ff5e5e'>Block</span>";
	               }
	               else if($value['status']=='securityVerification')
	               {
	                  $status="<span class='badge' style='background:#464a53'>Security Verification</span>";
	               }
	               $id=encryption('encrypt',$value['id']);
	               $imgPath= BASEURL.'/public/assets/images/users/'.$value['image'];
	               $html[].= "<tr>
	                      <td>".$i++."</td>
	                      <td><img src='". $imgPath."' width='30px' class='profile-photo-md image_style' onclick='imageView(this)'></td>
	                      <td><a href='' user_id='".encryption('encrypt',$value['id'])."' data-target='.view_Profile' data-toggle='modal' onclick='viewUserProfile(this)'>".ucfirst($value['name'])."</a></td>
	                      <td>".$value['email']."</td>
	                      <td class='flag-wrapper' style='width:70px;height:40px'><p title='".strtoupper(countryName_to_code($value['country']))."' class='flag flag-icon-background flag-icon-".strtolower(countryName_to_code($value['country']))."' ></p>
	                      </td>

	                     <td>".$value['state']."</td>
	                     <td>".$value['address']."</td>
	                     <td>$status</td>
	                     <td>".date('M j Y g:i A', strtotime($value['created_at']))."</td>
	                    
	                  </tr>";
	           }
	       
	        $html[].='</tbody></table>';

	   	 }

	   	 if(isset($html) AND is_array($html) AND !empty($html))
	     {
	       $val=implode(" ",$html);
	       return $val;
	     }
    }
   }

   public function getAllPostReport($offset,$total)
   {
	   	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
	    {
	   	  $response=$this->mlAdmin->getPostReports($offset,$total);

	   	  if(is_array($response))
	   	  {
	   	  	$html=[];
	   	  	$html[].='<table class="table">
	          <thead>
	              <tr>
	                  <th>No #</th>
	                  <th>Complaint On</th>
	                  <th>View Post</th>
	                  <th>View Complaint</th>
	                  <th>Pending Report</th>
	                  <th>Post Status</th>
	                  <th>Complaint Date</th>

	              </tr>
	          </thead>
	          <tbody>';
	            if($offset==0)
		          {
		           $i=1;
		          }
		          else
		          {
		           	$i=$offset+1;
		          }
	             foreach ($response as $key => $value) 
	             {
	                $getPost=$this->getPostData(encryption('encrypt',$value['post_id']));
	                $complaintUser=$this->getUserInfo('id',$value['post_user_id']);
	                $status='';
	                 if(!empty($value['admin_action']))
	                 {
	                    if($value['admin_action']=='deletePost' AND $getPost['post_delete']=='adminDeletePost')
	                    {
	                        $status="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
	                    }
	                    else if($value['admin_action']=='reject' AND $getPost['post_delete']=='NULL')
	                    {
	                        $status="<span class='badge' style='background:#9097c4'>Reject Complaint</span>";
	                    }
	                 }

	                if($getPost['post_delete']!='NULL' OR $status=='' AND $value['admin_action']=='NULL')
	                {
	                    if($getPost['post_delete']=='adminDeletePost') 
	                    {
	                        $status="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
	                    }
	                    else if($getPost['post_delete']=='userDeletePost')
	                    {   
	                        $status="<span class='badge' style='background:#464a53'>User Delete</span>";
	                    }
	                }
	                else
	                {
	                    if($status=='')
	                    {
	                        $status="<span class='badge' style='background:#6fd96f'>Publish</span>";
	                    }
	                }

	              $totalComplaint=$this->totalPostComplaint($value['post_id']);

	              if($totalComplaint>=4)
                {
                    $total_Complaint='<span class="badge" style="background:#464a53">'.$totalComplaint.'</span>';
                }
                else if($totalComplaint>=10) 
                {
                    $total_Complaint='<span class="badge" style="background:#ff5e5e">'.$totalComplaint.'</span>';
                }
                else
                {
                    $total_Complaint='<span class="badge">'.$totalComplaint.'</span>';
                }
                                 


	              $html[].='<tr>
	                  <td>'.$i++.'</td>
	                  <td><a href="" user_id="'.encryption('encrypt',$complaintUser['id']).'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)"">'.ucfirst($complaintUser['name']).'</a></td>
	                  <td><button type="button" class="btn btn-sm btn-success" onclick="viewPost(this)" value="'.encryption('encrypt',$value['post_id']).'">Post</button></td>
	                  <td><button type="button" class="btn btn-sm btn-danger" onclick="postComplaint(this)"  class="btn btn-danger btn-xs" value="'.encryption('encrypt',$value['post_id']).'">Complaint</button></td>
	                  <td>'.$total_Complaint.'</td>
	                  <td>'.$status.'</td>
	                  <td>'.date('M j Y g:i A', strtotime($value['complaint_date'])).'</td>
	              </tr>';
	            
	             }
	             
	           $html[].="</tbody></table>";
	   	  }

	   	  if(isset($html) AND is_array($html) AND !empty($html))
		     {
		       $val=implode(" ",$html);
		       return $val;
		     }
	   	}
   }

   public function viewProfileComplaint()
   {
   	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
   	{
   		if(isset($_POST) AND isset($_POST['userId']))
   		{
   			$userID=encryption('decrypt',$_POST['userId']);
   			if($userID!=false)
   			{
   				$html=[];
   				$allComplaint=$this->mlAdmin->allProfileReports($userID);
	  		 	if(is_array($allComplaint))
	  		 	{
  	  	    $value="submitComplaint('profileComplaint')";
  	  	    if($allComplaint[0]['admin_action']=='Null')
  	  	    {
	  	  	    $html[].='<br><br>
	             <textarea class="textarea form-control" id="postAdminMsg" name="adminMsg" rows="5" col="10" placeholder="Enter Message About Complaint .....!" pattren="[A-Za-z]{550}" maxlength="550" required></textarea><br><br>
	                <b>Action</b><select name="select_type" class="form-control" id="complaintActionType">
	                    <option value="">Select Option</option>
	                      <option value="complaint_reject">Reject Complaint</option>  
	                      <option value="warning">Account Warning</option>
	                      <option value="securityVerification">Verify Account</option>
	                  </select><br><br>
	                  <input type="text" value="'.$_POST['userId'].'" disabled hidden id="profileUserID">
	                 <div class="displayError"></div>
	                <button type="button" data-dismiss="modal" style="float:right;margin-left:6px" class="btn btn-danger">Close</button>
	                <input type="button" value="Submit" style="float:right;" class="btn btn-success" onclick="'.$value.'"><br><br>';
	          }
	          else
	          {
	          	$html[].='';
	          }

            if(is_array($allComplaint))
            {
            	$response=$this->allProfileComplaint($allComplaint);
            	if(is_array($response))
            	{
            		$html=array_merge($html,$response);
            	}
	          }
          }
        }
  	  		
  	  		if(isset($html) AND is_array($html) AND !empty($html))
          {
           $val=implode(" ",$html);
           return MsgDisplay('success',$val,'');
          }

   			}
   			
   		}
   	}

   public function getAllAccountReport($offset,$total)
   {
	   	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
	    {
	   	  $response=$this->mlAdmin->getProfileReports($offset,$total);
	   	  if(is_array($response))
	   	  {
	   	  	$html=[];
	   	  	$html[].='<table class="table">
	          <thead>
	              <tr>
	                  <th>No #</th>
                    <th>Complaint On</th>
                    <th>View Complaint</th>
                    <th>Pending Report</th>
                    <th>Account Status</th>
                    <th>Complaint Date</th>
	              </tr>
	          </thead>
	          <tbody>';
	            if($offset==0)
		          {
		           $i=1;
		          }
		          else
		          {
		           	$i=$offset+1;
		          }
	             foreach ($response as $key => $value) 
               {
                  $complaintOn=$this->getUserInfo('id',$value['profile_user_id']);
                  $profile_id=encryption('encrypt',$value['profile_user_id']);
                  $totalReport=$this->totalAccountComplaint($value['profile_user_id']);


                   if($complaintOn['status']=='notVerify')
                   {
                      $status="<span class='badge' style='background:#9097c4'>Not Verify</span>";
                   }
                   else if($complaintOn['status']=='verify')
                   {
                      $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
                   }
                   else if($complaintOn['status']=='block')
                   {
                      $status="<span class='badge' style='background:#ff5e5e'>Block</span>";
                   }
                   else if($complaintOn['status']=='securityVerification')
                   {
                      $status="<span class='badge' style='background:#464a53'>Security Verification</span>";
                   }

		              if($totalReport>=4)
	                {
	                    $total_Complaint='<span class="badge" style="background:#464a53">'.$totalReport.'</span>';
	                }
	                else if($totalReport>=10) 
	                {
	                    $total_Complaint='<span class="badge" style="background:#ff5e5e">'.$totalReport.'</span>';
	                }
	                else
	                {
	                    $total_Complaint='<span class="badge">'.$totalReport.'</span>';
	                }
                                 


	              $html[].=' <tr>
                    <td>'.$i++.'</td>
                    <td>
                     <a href="" user_id="'.encryption('encrypt',$complaintOn['id']).'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)">'.ucfirst($complaintOn['name']).'</a> 
                    </td>
                    <td><button class="btn btn-sm btn-danger" onclick="accountComplaint(this)" value="'.encryption('encrypt',$value['profile_user_id']).'">Complaint</button></td>
                    <td>'.$total_Complaint.'</td>
                    <td>'.$status.'</td>
                    <td>'.date('M j Y g:i A', strtotime($value['complaint_date'])).'</td>
                </tr>';
	            
	             }
	             
	           $html[].="</tbody></table>";
	   	  }

	   	  if(isset($html) AND is_array($html) AND !empty($html))
		     {
		       $val=implode(" ",$html);
		       return $val;
		     }
	   	}
   }

  public function allProfileComplaint($allComplaint)
  {
   	//Complaint Array Convert to accordion
   	if(is_array($allComplaint))
   	{
   		$html=[];
   		$total=count($allComplaint);
			if($total>0)
			{
				$html[].='<div class="complaintHistory">
				<center><h3 class="heading">All Complaint</h3></center><br>
				<div class="panel-group" id="accordion1">';
				foreach($allComplaint as $key => $value) 
				{
					$complaintUser=$this->getUserInfo('id',$value['complaint_user_id']);

					if($value['admin_action']=='block')
	        {
	            $badge="<span class='badge' style='background:#ff5e5e'>Account Block</span>";
	        }
	        else if($value['admin_action']=='reject')
	        {
	            $badge="<span class='badge' style='background:#9097c4'>Reject Complaint</span>";
	        }
	        else if($value['admin_action']=='securityVerification')
	        {
	            $badge="<span class='badge' style='background:#464a53'>Security Verification</span>";
	        }
	        else if($value['admin_action']=='warning')
	        {
	            $badge="<span class='badge' style='background:#FF9C33'>Warning</span>";
	        }
	        else if($value['admin_action']=='Null')
	        {
	            $badge="<span class='badge' style='background:#FF33FC'>Pending Complaint</span>";
	        }

	        if(!empty($value['admin_msg']))
	        {
	        	$adminMsg=$value['admin_msg'];
	        }
	        else
	        {
	        	$adminMsg="Complaint is Pending";
	        }

	        $path=BASEURL."/public/assets/images/users/".$complaintUser['image'];
	        $complaintUserID=encryption('encrypt',$value['complaint_user_id']);
	        $target="#".$total;
				  $html[].='
	         <div class="panel panel">
	           <div class="panel-heading">
	             <h4 class="panel-title">
	               <a href="'.$target.'" data-parent="#accordion1" data-toggle="collapse"><h4>Complaint No '.$total.' &nbsp;&nbsp;&nbsp;&nbsp;'.$badge.'</h4></a>
	             </h4>
	           </div>

	           <div id="'.$total.'" class="panel-collapse collapse">
	              <div class="container-fluid">
	              <img src="'.$path.'" width="30px" class="profile-photo-md image_style" data-toggle="modal" data-target=".imageBigView" onclick="imageModel(this)"> <b><a href="" user_id="'.$complaintUserID.'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)">'.ucfirst($complaintUser['name']).'</a></b><br><br>
	              <b>Complaint:- </b><p>'.$value['complaint'].'</p>
	              <b>Screenshoot</b><br>
	          ';
	            $img_name=explode('940961',$value['upload_file_name']);
	  	  	    foreach ($img_name as $key => $image) 
	  	  	    {
	  	  	    	  if(!empty($image))
	  	  	    	  {
	  	  	    	  	$path=BASEURL."/public/assets/account_report/".$image;
	  	  	    		  $html[].='<img src="'.$path.'" width="200px" width="200px" class="img img-thumbnail image_style" data-toggle="modal" data-target=".imageBigView" onclick="imageModel(this)">';
	  	  	    	  } 
	  	  	    }
	             $html[].=' <br><br><b>Admin Reply</b>
	              <p>'.$adminMsg.'</p>
	            </div><hr>
	           </div>
	          </div>';
	        $total--;
	      }
	      $html[].="</div>";
	    }

	    return $html;
   	}

   	return false;
   }

	 public function viewAccountVerification()
	 {
	 	 if(isset($_POST['verificationId']))
	 	 {
	 	 	 $verificationId=encryption('decrypt',$_POST['verificationId']);
	 	 	 $html=[];
	 	 	 if($verificationId!=false)
	 	 	 {
		 	 	 	$verificationCheck=$this->mlAdmin->getVerification($verificationId,'verificationID');

		 	 	  if($verificationCheck[0]['verification_status']=='pending')
		      {

		  	    $html[].='
	                    <b>Action</b><select name="select_type" class="form-control" onchange="verificationOption(event)" id="verificationActionType">
	                        <option value="">Select Option</option>
	                          <option value="reject">Reject</option>  
	                          <option value="verify">Verify</option>
	                      </select><br><br>
	                      <input type="text" value="'.$_POST['verificationId'].'" disabled hidden id="verificationId">
	                      <div class="verificationTextarea">
	                 
	                     </div>
	                     <div class="displayError"></div>
	                    <button type="button" data-dismiss="modal" style="float:right;margin-left:6px" class="btn btn-danger">Close</button>
	                    <input type="button" value="Submit" style="float:right;" class="btn btn-success" onclick="submitVerification()"><br><br>';
	        }
	        else
	        {
	        	$html[].='';
	        }

	       $response=$this->mlAdmin->getVerification($verificationCheck[0]['user_id'],'userID');

	 	 	 	 if(is_array($response))
	 	 	 	 {
	 	 	 	 	$allVerification=$this->getAllVerification($response);
	 	 	 	 	if(is_array($allVerification))
	      	{
	      		$html=array_merge($html,$allVerification);
	      	}
	 	 	 	 }
	 	 	 }

	 	 	if(isset($html) AND is_array($html) AND !empty($html))
      {
       $val=implode(" ",$html);
       return MsgDisplay('success',$val,'');
      }
	 	 }
	 }

	 public function actionVerification()
	 {
	 	 if(isset($_POST))
	 	 {
	 	 	 if(isset($_POST['verificationId']) AND empty($_POST['verificationId']))
	 	 	 {
	 	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Refersh Your Web Page Something Was Problem.......!</p>");
	 	 	 }
	 	 	 else if(isset($_POST['actionType']) AND empty($_POST['actionType']))
	 	 	 {
	 	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Select Option.......!</p>");
	 	 	 }
	 	 	 else
	 	 	 {
	 	 	 	 if($_POST['actionType']=='reject' AND empty($_POST['adminMsg']))
	 	 	 	 {
	 	 	 	 	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Enter Message About Reject Reason Account Verification.......!</p>");
	 	 	 	 }
	 	 	 	 else
	 	 	 	 {
	 	 	 	 	  $response=$this->mlAdmin->actionVerification();
	 	 	 	 	  
	 	 	 	 	  if($response=='success' AND $_POST['actionType']=='reject')
	 	 	 	 	  {
	 	 	 	 	  	return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Account Verification Reject Successfully.......!</p>");
	 	 	 	 	  }
	 	 	 	 	  else if($response=='success' AND $_POST['actionType']=='verify')
	 	 	 	 	  {
	 	 	 	 	  	return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Account Verify Successfully.......!</p>");
	 	 	 	 	  }
	 	 	 	 	  else if($response=='invalidUser' AND $response=='false')
	 	 	 	 	  {
	 	 	 	 	  	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Please Refersh Your Web Page Something Was Problem.......!</p>");
	 	 	 	 	  }
	 	 	 	 	  else if($response=='already_reject')
	 	 	 	 	  {
	 	 	 	 	  	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Verification Request Already Reject By Admin.......!</p>");
	 	 	 	 	  }
	 	 	 	 	  else if($response=='account_verify')
	 	 	 	 	  {
	 	 	 	 	  	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Verification Request Already Verify By Admin.......!</p>");
	 	 	 	 	  }
	 	 	 	 }
	 	 	 }
	 	 }
	 }

	 public function getModelAllVerification()
	 {
	 	 if(isset($_POST['verificationId']))
	 	 {
	 	 	 $verificationId=encryption('decrypt',$_POST['verificationId']);
	 	 	 if($verificationId!=false)
	 	 	 {
		 	 	 	$verificationCheck=$this->mlAdmin->getVerification($verificationId,'verificationID');
		 	 	 	if(is_array($verificationCheck))
		 	 	 	{
		 	 	 		$response=$this->mlAdmin->getVerification($verificationCheck[0]['user_id'],'userID');
		 	 	 	}
		 	 	 	
		 	 	 	 if(is_array($response))
		 	 	 	 {
		 	 	 	 	$allVerification=$this->getAllVerification($response);
		 	 	 	 	if(is_array($allVerification))
		 	 	 	 	{
		 	 	 	 		$val=implode(" ",$allVerification);
		          return MsgDisplay('success',$val,'');
		 	 	 	 	}
		 	 	 	 }
		 	 }
	 	 }
	 }

	 public function getAllVerification($allVerification)
   {
   	//Verification Array Convert to accordion
   	if(is_array($allVerification))
   	{
   		$html=[];
   		$total=count($allVerification);
			if($total>0)
			{
				$html[].='<div class="allVerification">
				<center><h3 class="heading">All Verification</h3></center><br>
				<div class="panel-group" id="accordion1">';
				foreach($allVerification as $key => $value) 
				{
					$userData=$this->getUserInfo('id',$value['user_id']);

				 if($value['verification_status']=='reject')
         {
            $badge="<span class='badge' style='background:#9097c4'>Reject</span>";
         }
         else if($value['verification_status']=='verify')
         {
            $badge="<span class='badge' style='background:#6fd96f'>Verify</span>";
         }
         else if($value['verification_status']=='pending')
         {
            $badge="<span class='badge' style='background:#FF33FC'>Pending</span>";
         }

	        
	        $path=BASEURL."/public/assets/images/users/".$userData['image'];
	        $target="#".$total;
				  $html[].='
	         <div class="panel panel">
	           <div class="panel-heading">
	             <h4 class="panel-title">
	               <a href="'.$target.'" data-parent="#accordion1" data-toggle="collapse"><h4>Request No '.$total.' &nbsp;&nbsp;&nbsp;&nbsp;'.$badge.'</h4></a>
	             </h4>
	           </div>

	           <div id="'.$total.'" class="panel-collapse collapse">
	              <div class="container-fluid">
	              <img src="'.$path.'" width="30px" class="profile-photo-md image_style" data-toggle="modal" data-target=".imageBigView" onclick="imageModel(this)"> <b><a href="" user_id="'.encryption('encrypt',$value['user_id']).'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)">'.ucfirst($userData['name']).'</a></b><br><br>
	              <b>Images</b><br>
	          ';

            $img_Path=BASEURL."/public/assets/account_verification/";
         	  $img_name=explode('940961',$value['upload_file_name']);
           	if(!empty($value['admin_reply']) AND $value['verification_status']=='reject')
		        {
		        	$adminMsg=ucfirst(htmlspecialchars($value['admin_reply']));
		        }
		        else if(empty($value['admin_reply']) AND $value['verification_status']=='verify')
		        {
		        	$adminMsg="Verification Request is Valid User Account Verify";
		        }
		        else
		        {
		        	$adminMsg='Verification is Pending';
		        }
	           

  	  	    foreach ($img_name as $key => $image) 
  	  	    {
  	  	    	  if(!empty($image))
  	  	    	  {
  	  	    	  	$path=$img_Path.$image;
  	  	    		  $html[].='<img src="'.$path.'" width="200px" width="200px" class="img img-thumbnail image_style"  onclick="imageSmallView(this)">';
  	  	    	  } 
  	  	    }
             $html[].=' <br><br><b>Admin Reply</b>
              <p>'.$adminMsg.'</p>
            </div><hr>
           </div>
          </div>';

	        $total--;
	      }
	      $html[].="</div>";
	    }

	    return $html;
   	}

   	return false;
   }

  public function getAccountVerification($offset,$total)
  {
  	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
    	$response=$this->mlAdmin->getAccVerification($offset,$total);
    	if(is_array($response))
    	{
    		$data=$this->accountVerificationHtml($response);
    		if($data!=false)
    		{
    			return $data;
    		}
    	}	
    	else if($response==0)
    	{
    		return "<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>User Verification is Empty.......!</p>";
    	}
    }
  }

  public function accountVerificationHtml($response)
	{
		if(is_array($response))
	 	 {
	 	 	 $html=[];
	 	 	 $html[].='<table class="table table-bordered table-striped table-hover">
	        <thead>
	            <tr>
	                <th>No #</th>
	                <th>Image</th>
	                <th>Name</th>
	                <th>Email</th>
	                <th>Country</th>
	                <th>Gender</th>
	                <th>View Verification</th>
	                <th>Verification Status</th>
	                <th>Date</th>
	            </tr>
	        </thead>
	         <tbody>';


	        $i=1;
	         
	         foreach ($response as $key => $value) 
	         {
               if($value['verification_status']=='reject')
	             {
	                $status="<span class='badge' style='background:#9097c4'>Reject</span>";
	             }
	             else if($value['verification_status']=='verify')
	             {
	                $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
	             }
	             else if($value['verification_status']=='pending')
	             {
	                $status="<span class='badge' style='background:#FF33FC'>Pending</span>";
	             }

	             $id=encryption('encrypt',$value['user_id']);
	             $imgPath= BASEURL.'/public/assets/images/users/'.$value['image'];

	             $html[].= "<tr>
	                    <td>".$i."</td>
	                    <td><img src='". $imgPath."' width='30px' class='profile-photo-md image_style' onclick='imageView(this)'></td>
	                    <td><a href='' user_id='".$id."' data-target='.view_Profile' data-toggle='modal' onclick='viewUserProfile(this)'>".ucfirst($value['name'])."</a></td>
	                    <td>".$value['email']."</td>
	                    <td class='flag-wrapper' style='width:70px;height:40px'><p title='".strtoupper(countryName_to_code($value['country']))."' class='flag flag-icon-background flag-icon-".strtolower(countryName_to_code($value['country']))."' ></p>
	                    </td>
	                    <td>".ucfirst($value['gender'])."</td>
	                    <td><button class='btn btn-sm btn-danger' onclick='accountVerification(this)' value='".encryption('encrypt',$value['id'])."'>View</button></td>
	                   <td>$status</td>
	                   <td>".date('M j Y g:i A', strtotime($value['date']))."</td>
	                  
	                </tr>";

	                $i++;
	         }
	     
	      $html[].='</tbody></table>';

	 	 }


	 	 if(isset($html) AND is_array($html) AND !empty($html))
	   {
	     $val=implode(" ",$html);
	     return $val;
	     //return MsgDisplay('success',$val,'');
	   }

	   return false;
	}

  public function searchUser()
	{
   	if(isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin'])) 
    {
	  	if(isset($_POST) AND $_POST['country']!=-1 AND (empty($_POST['state']) OR $_POST['state']=='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		if(isset($_POST['reportedAccount']))
	      {
	  	  	$response=$this->mlAdmin->getReportedAccount($_POST['country']);
	  	  }
	  	  else if(isset($_POST['reportedPost']))
	      {
	      	$response=$this->mlAdmin->getReportedPost($_POST['country']);
	      }
	      else if(isset($_POST['accountVerification']))
	      {
	      	$response=$this->mlAdmin->getVerifiCountryState($_POST['country']);
	      }
	  	  else
	  	  {
	  	  	$response=$this->mlAdmin->getUserCountryState($_POST['country']);
	  	  }

		  	if($response=='zero' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country Users Not Create Account....!");
      	}
      	else if($response=='zero' AND isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country Users Not Found Account Complaint");
      	}
      	else if($response=='zero' AND !isset($_POST['reportedAccount']) AND isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country Users Not Found Post Complaint");
      	}
      	else if($response=='zero' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country Users Not Found Account Verification");
      	}
      	else if($response==false)
      	{
      		return MsgDisplay('error','Something Was Problem Please Refersh Your Web Page....!');
      	}
      	else
      	{
      		if(isset($_POST['reportedAccount']))
      		{
      			return $this->searchReportAccHtml($response);
      		}
      		else if(isset($_POST['reportedPost']))
      		{
      			return $this->searchReportPostHtml($response);
      		}
      		else if(isset($_POST['accountVerification']))
      		{
      			$val=$this->accountVerificationHtml($response);
      			return MsgDisplay('success',$val,'');
      		}
      		else
      		{
      			return $this->searchUserHtml($response);
      		}
      	}
	  	}
	  	else if(isset($_POST) AND $_POST['country']==-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		return MsgDisplay('error','Please Select Country....!');
	  	}
	  	else if(isset($_POST) AND $_POST['country']!=-1 AND (!empty($_POST['state']) OR $_POST['state']!='First Select Country') AND empty($_POST['searchUser']))
	  	{
	  		if(isset($_POST['reportedAccount']))
	      {
	      	$response=$this->mlAdmin->getReportedAccount($_POST['country'],$_POST['state']);
	  	  }
	  	  else if(isset($_POST['reportedPost']))
	      {
	      	$response=$this->mlAdmin->getReportedPost($_POST['country'],$_POST['state']);
	      }
	      else if(isset($_POST['accountVerification']))
	      {
	      	$response=$this->mlAdmin->getVerifiCountryState($_POST['country'],$_POST['state']);
	      }
	  	  else
	  	  {
	  	  	$response=$this->mlAdmin->getUserCountryState($_POST['country'],$_POST['state']);
	  	  }

		  	if($response=='zero' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country and State <strong>".$_POST['state']."</strong> Users Not Create Account....!");
      	}
      	else if($response=='zero' AND isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country and State <strong>".$_POST['state']."</strong> Users Not Found Account Complaint....!");
      	}
      	else if($response=='zero' AND !isset($_POST['reportedAccount']) AND isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country and State <strong>".$_POST['state']."</strong> Users Not Found Post Complaint....!");
      	}
      	else if($response=='zero' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND isset($_POST['accountVerification']))
      	{
      		return MsgDisplay("error","<strong>".$_POST['country']."</strong> Country and State <strong>".$_POST['state']."</strong> Users Not Found Account Verification....!");
      	}
      	else if($response==false)
      	{
      		return MsgDisplay('error','Something Was Problem Please Refersh Your Web Page....!');
      	}
      	else
      	{
      		if(isset($_POST['reportedAccount']))
      		{
      			return $this->searchReportAccHtml($response);
      		}
      		else if(isset($_POST['reportedPost']))
      		{
      			return $this->searchReportPostHtml($response);
      		}
      		else if(isset($_POST['accountVerification']))
      		{
      			$val=$this->accountVerificationHtml($response);
      			return MsgDisplay('success',$val,'');
      		}
      		else
      		{
      			return $this->searchUserHtml($response);
      		}
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
	  	   	  if(isset($_POST['reportedAccount']))
			      {
			      	$response=$this->mlAdmin->searchReportAcc();
			  	  }
			  	  else if(isset($_POST['reportedPost']))
			  	  {
			  	  	$response=$this->mlAdmin->searchReportPost();
			  	  }
			  	  else if(isset($_POST['accountVerification']))
			      {
			      	$response=$this->mlAdmin->searchAccVerification();
			      }
			  	  else
			  	  {
			  	  	$response=$this->mlAdmin->searchUser();
			  	  }

	  	   	  if($response=='notFound' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
	  	   	  {
	  	   	  	return MsgDisplay('error','Not Found User........');
	  	   	  }
	  	   	  else if($response=='notFound' AND isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
	  	   	  {
	  	   	  	return MsgDisplay('error','Not Found Account Complaint........');
	  	   	  }
	  	   	  else if($response=='notFound' AND !isset($_POST['reportedAccount']) AND isset($_POST['reportedPost']) AND !isset($_POST['accountVerification']))
	  	   	  {
	  	   	  	return MsgDisplay('error','Not Found Post Complaint........');
	  	   	  }
	  	   	  else if($response=='notFound' AND !isset($_POST['reportedAccount']) AND !isset($_POST['reportedPost']) AND isset($_POST['accountVerification']))
	  	   	  {
	  	   	  	return MsgDisplay('error','Not Found Verification Request........');
	  	   	  }
	  	   	  else if($response==false)
	  	   	  {
	  	   	  	return MsgDisplay('error','Something Was Wrong Please Refersh Your Web Page........');
	  	   	  }
	  	   	  else
	  	   	  {
	  	   	  	if(isset($_POST['reportedAccount']))
		      		{
		      			return $this->searchReportAccHtml($response);
		      		}
		      		else if(isset($_POST['reportedPost']))
		      		{
		      			return $this->searchReportPostHtml($response);
		      		}
		      		else if(isset($_POST['accountVerification']))
		      		{
		      			$val=$this->accountVerificationHtml($response);
		      			return MsgDisplay('success',$val,'');
		      		}
		      		else
		      		{
		      			return $this->searchUserHtml($response);
		      		}
	  	   	  }
	  	   }
	  	}
	  }
	}


	public function searchUserHtml($response)
	{

		if(is_array($response))
	 	 {
	 	 	 $html=[];
	 	 	 $html[].='<table class="table table-bordered table-striped table-hover">
	        <thead>
	            <tr>
	                <th>No #</th>
	                <th>Image</th>
	                <th>Name</th>
	                <th>Email</th>
	                <th>Country</th>
	                <th>State</th>
	                <th>Address</th>
	                <th>Status</th>
	                <th>Date</th>
	            </tr>
	        </thead>
	         <tbody>';


	        $i=1;
	         
	         foreach ($response as $key => $value) 
	         {
	             if($value['status']=='notVerify')
	             {
	                $status="<span class='badge' style='background:#9097c4'>Not Verify</span>";
	             }
	             else if($value['status']=='verify')
	             {
	                $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
	             }
	             else if($value['status']=='block')
	             {
	                $status="<span class='badge' style='background:#ff5e5e'>Block</span>";
	             }
	             else if($value['status']=='securityVerification')
	             {
	                $status="<span class='badge' style='background:#464a53'>Security Verification</span>";
	             }
	             $id=encryption('encrypt',$value['id']);
	             $imgPath= BASEURL.'/public/assets/images/users/'.$value['image'];
	             $html[].= "<tr>
	                    <td>".$i."</td>
	                    <td><img src='". $imgPath."' width='30px' class='profile-photo-md image_style' onclick='imageView(this)'></td>
	                    <td><a href='' user_id='".encryption('encrypt',$value['id'])."' data-target='.view_Profile' data-toggle='modal' onclick='viewUserProfile(this)'>".ucfirst($value['name'])."</a></td>
	                    <td>".$value['email']."</td>
	                    <td class='flag-wrapper' style='width:70px;height:40px'><p title='".strtoupper(countryName_to_code($value['country']))."' class='flag flag-icon-background flag-icon-".strtolower(countryName_to_code($value['country']))."' ></p>
	                    </td>

	                   <td>".$value['state']."</td>
	                   <td>".$value['address']."</td>
	                   <td>$status</td>
	                   <td>".date('M j Y g:i A', strtotime($value['created_at']))."</td>
	                  
	                </tr>";

	                $i++;
	         }
	     
	      $html[].='</tbody></table>';

	 	 }

	 	 if(isset($html) AND is_array($html) AND !empty($html))
	   {
	     $val=implode(" ",$html);
	     return MsgDisplay('success',$val,'');
	   }
	}


	public function searchReportAccHtml($response)
	{
	  if(is_array($response))
 	  {
 	  	$i=1;
 	 	  $html=[];
 	 	  $html[].='<table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No #</th>
                <th>Complaint On</th>
                <th>View Complaint</th>
                <th>Pending Report</th>
                <th>Account Status</th>
                <th>Complaint Date</th>
            </tr>
        </thead>
         <tbody>';

	    foreach ($response as $key => $value) 
	    {
	      $complaintOn=$this->getUserInfo('id',$value['profile_user_id']);
	      $profile_id=encryption('encrypt',$value['profile_user_id']);
	      $totalReport=$this->totalAccountComplaint($value['profile_user_id']);

	       if($complaintOn['status']=='notVerify')
	       {
	          $status="<span class='badge' style='background:#9097c4'>Not Verify</span>";
	       }
	       else if($complaintOn['status']=='verify')
	       {
	          $status="<span class='badge' style='background:#6fd96f'>Verify</span>";
	       }
	       else if($complaintOn['status']=='block')
	       {
	          $status="<span class='badge' style='background:#ff5e5e'>Block</span>";
	       }
	       else if($complaintOn['status']=='securityVerification')
	       {
	          $status="<span class='badge' style='background:#464a53'>Security Verification</span>";
	       }

	      if($totalReport>=4)
	      {
	          $total_Complaint='<span class="badge" style="background:#464a53">'.$totalReport.'</span>';
	      }
	      else if($totalReport>=10) 
	      {
	          $total_Complaint='<span class="badge" style="background:#ff5e5e">'.$totalReport.'</span>';
	      }
	      else
	      {
	          $total_Complaint='<span class="badge">'.$totalReport.'</span>';
	      }


	      $html[].='<tr>
              <td>'.$i++.'</td>
             
              <td>

               <a href="" user_id="'.encryption('encrypt',$complaintOn['id']).'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)"">'.ucfirst($complaintOn['name']).'</a>
              </td>
              <td><button class="btn btn-sm btn-danger" onclick="accountComplaint(this)" value="'.encryption('encrypt',$value['profile_user_id']).'">Complaint</button></td>
              <td>'.$total_Complaint.'</td>
              <td>'.$status.'</td>
              <td>'.date('M j Y g:i A', strtotime($value['complaint_date'])).'</td>
          </tr>';
	    }

	    $html[].='</tbody></table>';

	   if(isset($html) AND is_array($html) AND !empty($html))
	   {
	     $val=implode(" ",$html);
	     return MsgDisplay('success',$val,'');
	   }
    }
	}


	public function searchReportPostHtml($response)
	{

	  if(is_array($response))
 	  {
 	  	$i=1;
 	 	  $html=[];

 	 	  $html[].='<table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No #</th>
                <th>Complaint On</th>
                <th>View Post</th>
                <th>View Complaint</th>
                <th>Pending Report</th>
                <th>Post Status</th>
                <th>Complaint Date</th>
            </tr>
        </thead>
         <tbody>';

       foreach ($response as $key => $value) 
       {
       	  $status='';

          $getPost=$this->getPostData(encryption('encrypt',$value['post_id']));
          $totalComplaint=$this->totalPostComplaint($value['post_id']);
          $complaintUser=$this->getUserInfo('id',$value['post_user_id']);
          
           if(!empty($value['admin_action']))
           {
              if($value['admin_action']=='deletePost' AND $getPost['post_delete']=='adminDeletePost')
              {
                  $status="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
              }
              else if($value['admin_action']=='reject' AND $getPost['post_delete']=='NULL')
              {
                  $status="<span class='badge' style='background:#9097c4'>Reject Complaint</span>";
              }
           }

          if($getPost['post_delete']!='NULL' OR $status=='' AND $value['admin_action']=='NULL')
          {
              if($getPost['post_delete']=='adminDeletePost') 
              {
                  $status="<span class='badge' style='background:#ff5e5e'>Admin Delete</span>";
              }
              else if($getPost['post_delete']=='userDeletePost')
              {   
                  $status="<span class='badge' style='background:#464a53'>User Delete</span>";
              }
          }
          else
          {
              if($status=='')
              {
                  $status="<span class='badge' style='background:#6fd96f'>Publish</span>";
              }
          }

          if($totalComplaint>=4)
          {
              $total_Complaint='<span class="badge" style="background:#464a53">'.$totalComplaint.'</span>';
          }
          else if($totalComplaint>=10) 
          {
              $total_Complaint='<span class="badge" style="background:#ff5e5e">'.$totalComplaint.'</span>';
          }
          else
          {
              $total_Complaint='<span class="badge">'.$totalComplaint.'</span>';
          }
		      $html[].='
		          <tr>
	              <td>'.$i++.'</td>
	              <td>
	               <a href="" user_id="'.encryption('encrypt',$complaintUser['id']).'" data-target=".view_Profile" data-toggle="modal" onclick="viewUserProfile(this)">'.ucfirst($complaintUser['name']).'</a>
	              </td>
	              <td><button type="button" class="btn btn-sm btn-success" onclick="viewPost(this)" value="'.encryption('encrypt',$value['post_id']).'">Post</button></td>
	              <td><button type="button" class="btn btn-sm btn-danger" onclick="postComplaint(this)"  class="btn btn-danger btn-xs" value="'.encryption('encrypt',$value['post_id']).'">Complaint</button></td>
	              <td>'.$total_Complaint.'</td>
	              <td>'.$status.'</td>
	              <td>'.date('M j Y g:i A', strtotime($value['complaint_date'])).'</td>
	          </tr>';
	    }
	    $html[].='</tbody></table>';

	   if(isset($html) AND is_array($html) AND !empty($html))
	   {
	     $val=implode(" ",$html);
	     return MsgDisplay('success',$val,'');
	   }
	  }
  }

  public function changePassord()
  {
  	if(isset($_POST['oldPass']) AND isset($_POST['newPass']) AND isset($_POST['confirmPass']))
  	{
  		if(!empty($_POST['oldPass']) AND !empty($_POST['newPass']) AND !empty($_POST['confirmPass']))
	  	{
	  		$adminData=$this->getAdminDetail();
		  	if(is_array($adminData))
		  	{
		  		if($adminData['admin_password']===$_POST['oldPass'])
		  		{
		  			if($_POST['newPass']==$_POST['confirmPass'])
		  			{
		  				if(password_method($_POST['newPass'])===false)
						{
							return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Password Required<br><br> 1=Minimum 8 characters<br> 2=One uppercase letter<br> 3=One lowercase letter,<br> 4=One number</p>");
						}
						else
						{
							$response=$this->mlAdmin->changePassord();
			  				if($response=='success')
			  				{
			  					return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Password Change Successfully.......!</p>",'');
			  				}
			  				else
			  				{
			  					return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Something Thing Was Wrong Please Try Again.......!</p>",'');
			  				}
						}
		  			}
		  			else
		  			{
		  				return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>New Password AND Confirm Password Not Match.......!</p>",'');
		  			}
		  		}
		  		else
		  		{
		  			return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Old Password is wrong.......!</p>",'');
		  		}
		  	}
	  	}
	  	else
	  	{
	  		return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>All Feild Are Mandatory.......!</p>",'');
	  	}
  	}

  	return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Something Thing Was Wrong Please Try Again.......!</p>",'');
  }



  public function addNewAdmin()
  {
  	if(isset($_POST['adminName']) AND isset($_POST['adminEmail']) AND isset($_POST['password']) AND isset($_POST['confirmPass']))
  	{
  		if(!empty($_POST['adminName']) AND !empty($_POST['adminEmail']) AND !empty($_POST['password']) AND !empty($_POST['confirmPass']))
	  	{
	  		if($_POST['password']==$_POST['confirmPass'])
  			{
  				if(password_method($_POST['password'])===false)
				{
					return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Password Required<br><br> 1=Minimum 8 characters<br> 2=One uppercase letter<br> 3=One lowercase letter,<br> 4=One number</p>");
				}
				else
				{
					$response=$this->mlAdmin->addNewAdmin();

					if($response=='emailExist')
					{
						return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Email Already Exist Please Try Anthor One.......!</p>",'');
					}
					else if($response=='success')
					{
						return MsgDisplay('success',"<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Admin Added Successfully.......!</p>",'');
					}
					else
					{
						return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Something Thing Was Wrong Please Try Again.......!</p>",'');
					}
				}
			}
			else
			{
				return MsgDisplay('error',"<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a> Password AND Confirm Password Not Match.......!</p>",'');
			}
	  	}

  	}
  }

    public function logout()
	{
		unset($_SESSION['loginAdmin']);
		$this->redirect('admin');
	}
}

?>