<?php
trait controllerTrait{
	private $mlUser;
	private $mlPost;
	private $mlFriendRequest;
	private $mlMessages;
	private $mlAdmin;
	
	public function __construct()
	{
		$this->helper('helper');
		$this->mlUser=$this->model("mlUser");
		$this->mlPost=$this->model('mlPost');
		$this->mlFriendRequest=$this->model('mlFriendRequest');
		$this->mlMessages=$this->model('mlMessages');
		$this->mlAdmin=$this->model('mlAdmin');

		
	}

	public function DisplayPostComment($postId)
	{
		if(encryption('decrypt',$postId)!=false)
		{
		   $post_id=encryption('decrypt',$postId);
		   $user_id=encryption('decrypt',$_SESSION['loginUser'][0]);

		  $post_detail=$this->mlPost->postExist($postId,'details');

			if($post_id!=false AND $post_detail!=false)
			{
				$RequestCheck=$this->mlFriendRequest->friendRequestCheck($post_detail['user_id'],$user_id,'getdata');

		    $post_user=$this->mlFriendRequest->getUser('id',$post_detail['user_id']);

        if($RequestCheck!=false AND is_array($RequestCheck))
				{
					if($RequestCheck['request']=='friend' AND $post_user['account_type']=='private' OR $RequestCheck['request']=='friend' AND $post_user['account_type']=='public' OR $RequestCheck['request']=='send' AND $post_user['account_type']=='public')
					{
						$response=$this->mlPost->getPostComment($post_id);
					}
					else if($RequestCheck['request']=='block')
					{
						return 'Sorry not allow to block user post comment View.....!';
					}
				}
				else if($RequestCheck==false AND $post_user['account_type']=='public' AND encryption('decrypt',$post_detail['post_status'])=='public' OR $post_user['id']==$user_id)
				{
					    $response=$this->mlPost->getPostComment($post_id);
				}
				else
				{
					return 'Sorry Not allow to View Friend & Private Post Comments....';
				}

				if(isset($response))
				{
					if($response=='noComment')
					{
						return "emptyComment";
					}
					else if ($response==false) 
					{
						return 'error';
					}
					else if (is_array($response)) 
					{
						return $response;
					}
					else
					{
						return 'error';
					}
				}

			}
			else
			{
				return 'error';
			}		
		}
	}

	public function check_like($post_id)
	{
		$response=$this->mlPost->check_likes($post_id);

		return $response;
	}

	public function getUserInfo($user=null,$value=null)
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']) OR isset($_SESSION['loginAdmin']) AND !empty($_SESSION['loginAdmin']))
        {
        	if($user==null AND $value==null)
        	{
        		$response=$this->mlUser->getUser('email',$_SESSION['loginUser'][1]);
	        	if(is_array($response))
	        	{
	        		unset($response['password']);
	        		unset($response['verification_code']);
	        		
	        		return $response;
	        	}
        	}
        	else if($user=='id')
        	{
        		$response=$this->mlUser->getUser('id',$value);
	        	if(is_array($response))
	        	{
	        		unset($response['password']);
	        		unset($response['verification_code']);
	        		
	        		return $response;
	        	}
        	}
        	else
        	{
        		$response=$this->mlUser->getUser('allUsers',$_SESSION['loginUser'][1]);
        		if(is_array($response))
	        	{
	        		return $response;
	        	}
        		
        	}
        } 
        else
        {
        	$this->redirect();
        }
		
	}

	public function checkFriendRequest($user_id,$send_user_id,$request)
	{
		$user_id=encryption('decrypt',$user_id);
		$send_user_id=encryption('decrypt',$send_user_id);

		$data=$this->getUserInfo('id',$send_user_id);
		if(is_array($data) AND $data['id']==$send_user_id)
		{
			$response=$this->mlFriendRequest->friendRequestCheck($user_id,$send_user_id,$request);
		   return $response;
		}
		
		return false;
	}

  public function followCheck($id,$request)
  {
    if(!empty($id) AND !empty($request))
    {
       $userId=encryption('decrypt', $_SESSION['loginUser'][0]);
       if($request=='total')
       {
         $response=$this->mlFriendRequest->follower($request,$id);
       }
       else if($request=='check')
       {
        $response=$this->mlFriendRequest->follower($request,$userId,$id);
       }
      

      if(is_array($response))
      {
        return $response;
      }
      else if(is_int($response))
      {
         return $response;
      }
    }

    return false;
  }

  public function GetfollowData($userId,$friendId)
  {
    if(!empty($userId) AND !empty($friendId))
    {

        $response=$this->mlFriendRequest->follower('check',$userId,$friendId);      

      if(is_array($response))
      {
        return $response;
      }
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

	
	public function getPost($postId)
	{
		if(!empty($postId))
		{
			if(encryption('decrypt',$postId))
			{
				$post_detail=$this->mlPost->getPost($postId);
				if(is_array($post_detail))
				{
					return $post_detail;
				}
			}
		}

		return false;
	}

	public function getMessageListFirst()
	{
		$response=$this->mlMessages->getAllMessagesList('first');
  	if(is_array($response))
  	{
  		return $response[0]['id'];
  	}

  	return false;
	}
  
	public function current_time()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
    {
    	$response=$this->mlUser->current_time();

    	return $response;
    } 
    else
    {
    	$this->redirect();
    }
	}
}

?>