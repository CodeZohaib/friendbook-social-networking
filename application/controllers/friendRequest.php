<?php

include "controllerTrait.php";

class friendRequest extends framework{
	use controllerTrait;

	public function index()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
        	$this->redirect('timeline/newsfeed');
        } 
	}

	public function sendRequest()
	{
		$response=$this->mlFriendRequest->sendRequest();
	    if($response!=false)
	    {
			$user_id=$_SESSION['loginUser'][0];
			$request_id=$_POST['request_id'];
			if($request_id!=false)
			{
				$request=$this->checkFriendRequest($user_id,$request_id,'getdata');
				
				if(is_array($request))
				{
					if($request['request']=='friend')
					{
						$friendId=encryption('decrypt',$request_id);
					    $this->mlMessages->insertMessagesList($friendId);
					}
					else if($request['request']=='block')
					{
						$friendId=encryption('decrypt',$request_id);
					    $this->mlMessages->deleteMessagesList($friendId);
					}
				}
				else
				{
					$friendId=encryption('decrypt',$request_id);
					$this->mlMessages->deleteMessagesList($friendId);
				}	
			}

		  return MsgDisplay('friend_request',$response);
		}
	}

	public function findBlockUser()
	{
		if(isset($_POST['user_search']))
		{
			if(!empty($_POST['user_search']))
			{
				$response=$this->mlFriendRequest->findBlockUser();

				if($response=='not_found')
				{
					$msg=$_POST['user_search']." Was not found.....!";
					return MsgDisplay('error',$msg);
				}
				else if($response==false)
				{
					return MsgDisplay('error','Something Was Wrong Please Try Again');
				}
				else
				{
					if(is_array($response))
					{
						$html=[];
						foreach ($response as $key => $data) 
						{
				           $html[]="<div class='row'>

		                      <div class='col-md-2 col-sm-2'>
		                        <img src='".BASEURL.'/public/assets/images/users/'.$data['image']."' alt='user' class='profile-photo-lg' />
		                      </div>

		                      <div class='col-md-7 col-sm-7'>
		                        <h5><b>".htmlspecialchars($data['name'])."</b></h5>

		                        <p class='text-muted' title='User Account Created Date & Time'>".date('M j Y g:i A', strtotime($data['created_at']))."</p>
		                        
		                         <p style='font-size:20px;'>
		                           <span title='Country Flag ".$data['country']."' class='flag-icon flag-icon-".strtolower(countryName_to_code($data['country']))."' style='border:1px solid black'></span>
		                         </p> 
		                      </div>

		                      <div class='col-md-3 col-sm-3'>
		                         <input type='checkbox' class='checkboxes form-control user_checkboxes' name='checkboxes[]' value='".encryption('encrypt',$data['id'])."'>
		                      </div>
		                    </div><br><br>
		                 ";
						}
					}

					return MsgDisplay('success',$html);
				}
			}
			else
			{
				return MsgDisplay('error','Please Enter Block User Name....!');
			}
		}
	}


	public function blockUnblockUser()
	{
		if(isset($_POST['user_id']) AND isset($_POST['bulk_options']) AND is_array($_POST['user_id']))
		{
			$response=$this->mlFriendRequest->blockUnblockUser();

			if(is_array($response))
			{
				if(isset($response['blockUser']) AND !isset($response['unblockUser']) AND !isset($response['alreayBlockUser']) AND !isset($response['alreayUnBlockName']))
				{

					$msg='<b>'.strtoupper(implode(" , ",$response['blockUser'])).'</b> Successfully Block....!';
					return MsgDisplay('success',$msg);
				}
				else if(!isset($response['blockUser']) AND isset($response['unblockUser']) AND !isset($response['alreayBlockUser']) AND !isset($response['alreayUnBlockName']))
				{
					$msg='<b>'.strtoupper(implode(" , ",$response['unblockUser'])).'</b> Successfully UnBlock....!';
					return MsgDisplay('success',$msg);
					
				}
				else if(!isset($response['blockUser']) AND !isset($response['unblockUser']) AND isset($response['alreayBlockUser']) AND !isset($response['alreayUnBlockName']))
				{
					$msg='<b>'.strtoupper(implode(" , ",$response['alreayBlockUser'])).'</b> Already Block....!';
					return MsgDisplay('error',$msg);
				}
				else if(!isset($response['blockUser']) AND !isset($response['unblockUser']) AND !isset($response['alreayBlockUser']) AND isset($response['alreayUnBlockName']))
				{
					$msg='<b>'.strtoupper(implode(" , ",$response['alreayUnBlockName'])).'</b> Already UnBlock....!';
					return MsgDisplay('error',$msg);
				}
				else if($_POST['bulk_options']=='block' AND isset($response['alreayBlockUser']) AND isset($response['blockUser']))
				{
					$msg='<b>'.strtoupper(implode(" , ",$response['blockUser'])).'</b> is Successfully Block....!<br><b>'.strtoupper(implode(" , ",$response['alreayBlockUser'])).'</b> is Already Block User....!';
					return MsgDisplay('success',$msg);
				}
				else if($_POST['bulk_options']=='unblock' AND isset($response['alreayUnBlockName']) AND isset($response['unblockUser']))
				{
					$msg='<b>'.strtoupper(implode(" , ",$response['unblockUser'])).'</b> Successfully UnBlock....!<br><b>'.strtoupper(implode(" , ",$response['alreayUnBlockName'])).'</b> is already UnBlock User....!';
					return MsgDisplay('success',$msg);
				}
			}
		}
		
	}

	public function newsfeedFriends()
	{
	   $userId=encryption('decrypt', $_SESSION['loginUser'][0]);

       $allFriends=$this->mlFriendRequest->getfriends($userId);

        if(is_array($allFriends))
		{
		 $html=[];
		 foreach ($allFriends as $key => $value) 
		 {
		   
		   unset($value['password']);
		   unset($value['verification_code']);
		   $profile_id="94039".encryption('encrypt',$value['user_id']);

		  $html[].="<div class='col-md-6 col-sm-6'>
		    <div class='friend-card'>
		      <img src='".BASEURL.'/public/assets/images/covers/'.$value['bg_image']."' alt='profile-cover' class='img-responsive cover' />
		      <div class='card-info'>
		        <img src='".BASEURL.'/public/assets/images/users/'.$value['image']."' alt='user' class='profile-photo-lg' />
		        <div class='friend-info'>
		          <a href='".BASEURL.'/timeline/friendProfile/'.$profile_id."' class='pull-right text-green'>My Friend</a>
		          <h5><a href='".BASEURL.'/timeline/friendProfile/'.$profile_id."' class='profile-link'>".ucfirst($value['name'])."</a> </h5> 
		        </div>
		      </div>
		   </div>
		  </div>";  
		 }

		 if(isset($html) AND is_array($html))
	      {
	       $val=implode(" ",$html);
	       return MsgDisplay('success',$val,'');
	      }   
		}
		else
		{
		   return MsgDisplay('error','<br><br><div class="alert alert-danger alert-dismissable text-center">
           <a href="#" class="close" data-dismiss="alert">×</a>
         <p>Zero Friends.....!</p></div>','');  
		}
	}


    public function followUser()
	{
		if(isset($_POST['url']))
		{

			if(!empty($_POST['url']))
			{
				$friendId=explode('94039',$_POST['url']);
				if(is_array($friendId) AND isset($friendId[1]))
				{
				  $id=encryption('decrypt', $friendId[1]);
				  if($id!=false)
				  {
				    $userData=$this->getUserInfo('id',$id);
				    $friendRequest=$this->checkFriendRequest($_SESSION['loginUser'][0],$friendId[1],'getdata');
				    $myData=$this->getUserInfo('id',encryption('decrypt', $_SESSION['loginUser'][0]));
				    if(is_array($friendRequest))
				    {
				      if($friendRequest['request']=='blockUser')
				      {
				      	return MsgDialog('error','Account Follow Error','You have Block this Account Cannot follow. First Unblock the user. Then Follow the Account','');
				      }
				      else if($friendRequest['request']=='block')
				      {
				        return MsgDialog('error','Account Follow Error','User Block Your Account Cannot Follow Account......!','');
				      }
				    }

			      	 $response=$this->mlFriendRequest->followUser($id);
			      	 if($response=='already_follow')
			      	 {
			      	 	return MsgDialog('error','Account Follow Error','Already Follow this Account','');
			      	 }
			      	 else if($response=='success')
			      	 {
			      	 	return MsgDisplay('success','success');
			      	 }
				      
				  }
				  else
				  {
				     return MsgDialog('error','Account Follow Error','Invalid User Refersh Your Web Page......!','');
				  }
				}
			}
		}
	}

	public function unfollowUser()
	{
		if(isset($_POST['url']))
		{
			$friendId=explode('94039',$_POST['url']);
		    if(is_array($friendId) AND isset($friendId[1]))
		    {
		      $id=encryption('decrypt', $friendId[1]);
		      if($id!=false)
		      {
		        $userId=$id;
		      }
		    }
		    else
		    {
		    	$userId=encryption('decrypt', $_SESSION['loginUser'][0]);
		    }

		    $response=$this->mlFriendRequest->unfollowUser($userId);

		    if($response=='success')
		    {
		    	return MsgDisplay('success','success');
		    }
		}
	}

	public function Getfollower()
	{
		if(isset($_POST['url']))
		{
			$friendId=explode('94039',$_POST['url']);
		    if(is_array($friendId) AND isset($friendId[1]))
		    {
		      $id=encryption('decrypt', $friendId[1]);
		      if($id!=false)
		      {
		        $userId=$id;
		      }
		    }
		    else
		    {
		    	$userId=encryption('decrypt', $_SESSION['loginUser'][0]);
		    }

		    $response=$this->mlFriendRequest->follower('getAll',$userId);
		    if(is_array($response))
		    {
		    	$html=[];
		    	foreach ($response as $key => $detail) 
		    	{

		    		if($detail['follow_user_id']==$userId)
		    		{
		    			$title=formatDate($detail['date_time']);

						if($detail['bluetick']=='yes' AND $detail['bluetick']!='NULL')
						{
						  $badge="<span class='glyphicon glyphicon-ok-sign text-green' style='font-size:15px' title='verify'></span>";
						}
						else
						{
						  $badge='';
						}

						$flag=strtolower(countryName_to_code($detail['country']));
					    $profile_id=BASEURL."/timeline/friendProfile/94039".encryption('encrypt',$detail['user_id']);
					    $profile_img=BASEURL."/public/assets/images/users/".$detail['image'];

						$html[].="<div style='margin-bottom:20px' title='User Follow This Date ".$title."'>
						        <a href='user_profile.php?profile_id=".$profile_id."' class='profile-link'>
								  <img src='$profile_img' alt='user' class='profile-photo-sm' />
						        </a>

							    <a href='".$profile_id."' class='profile-link'>".ucwords($detail['name'])." $badge</a>
						        <span title='".strtoupper($detail['country'])."' class='flag-icon flag-icon-".$flag."' style='border:1px solid black;float:right;margin-top:10px'></span>
				             </div>";
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
		    	return MsgDisplay('error',"<p class='alert alert-danger text-center'>Zero Followers</p>");
		    }
		}
	}

	public function unfriendUser()
	{
		if(isset($_POST['url']))
		{
			$friendId=explode('94039',$_POST['url']);
		    if(is_array($friendId) AND isset($friendId[1]))
		    {
		      $id=encryption('decrypt', $friendId[1]);
		      if($id!=false)
		      {
		        $response=$this->mlFriendRequest->unfriendUser($id);
		        if($response=='success')
		        {
		        	$this->mlMessages->deleteMessagesList($id);
		        	return MsgDisplay('success','success');
		        }
		      }
		    }
		}
	}

	
	public function totalFriends()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']) AND isset($_POST['totalFriends']))
	    {
			$response=$this->mlFriendRequest->getTotalfriends();

			if(is_int($response))
			{
				return MsgDisplay('success',$response);
			}
     	}

     	return MsgDisplay('error','');
	}

	public function totalFriendRequest()
	{

		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']) AND isset($_POST['totalFriendRequest']))
	    {
	    	$response=$this->mlFriendRequest->getTotalFriendRequest();

	    	return MsgDisplay('success',$response);
	    }
	}

	public function totalBlockUser()
	{

		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']) AND isset($_POST['totalBlockUser']))
	    {
	    	$response=$this->mlFriendRequest->getTotalBlockUser();

				return MsgDisplay('success',$response);
			
	    }
	}

	
}

?>