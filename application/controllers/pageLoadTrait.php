<?php
trait pageLoadTrait{


	public function index()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	        $data=$this->mlUser->getUser('email',$_SESSION['loginUser'][1]);

	        if($data['status']=='securityVerification')
	        {
	             $_SESSION['confirm_email']=[
	                $data['name'],
	                $data['email'],
	                $data['image'],
	              ];
	              unset($_SESSION['loginUser']);

	              $this->redirect('users/emailConfirmation');
	        }
	        else
	        {
	           $this->redirect('page/newsfeed');
	        }
	        
	    }

	}

	public function error()
	{
		$this->view('error');
	}

	public function profile()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	 $this->view('profile');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function friendProfile($friendId)
	{

		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('friendProfile');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function newsfeed()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('newsfeed');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function viewTimeline()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('timeline');
        } 
		else
		{
		   $this->redirect();
		}  
	}

	public function timelineVideos()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('timelineVideos');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function timelineAudios()
	{
	    if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	      $this->view('timelineAudios');
	    } 
	    else
	    {
	      $this->redirect();
	    }  
	 }

	public function timelineAlbum()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('timelineAlbum');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function timelineFriend()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('timelineFriend');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function friendTimeline()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('friendTimeline');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function friendTimelineFriends()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('friendTimelineFriends');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function friendTimelineAlbum()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('friendTimelineAlbum');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function friendTimelineVideos()
    {
	    if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	 $this->view('friendTimelineVideos');
        } 
		else
		{
			$this->redirect();
		}  
	}

	
	public function friendTimelineAudios()
	{
	    if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
	    {
	      $this->view('friendTimelineAudios');
	    } 
	    else
	    {
	      $this->redirect();
	    }  
	 }

	public function viewPost()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	  $this->view('viewPost');
        } 
		else
		{
		   $this->redirect();
		}
        
	}

	public function getViewPost()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('viewPost');
        } 
		else
		{
		   $this->redirect();
		}
        
	}


	public function notification()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('notification');
        } 
		else
		{
			$this->redirect();
		}  
	}



	public function friendRequest()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('friendRequest');
        } 
		else
		{
			$this->redirect();
		}  
	}

	public function blockUser()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('blockUser');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function newsfeedFriends()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('newsfeed-friends');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function messages()
	{
		
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('messages');
        } 
		else
		{
			$this->redirect();
		}
        
	}

	public function newsfeedNearbyPeople()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('newsfeedNearbyPeople');
        } 
		else
		{
			$this->redirect();
		}
	}

	public function newsfeedImages()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('newsfeedImages');
        } 
		else
		{
			$this->redirect();
		}
	}

	public function newsfeedVideos()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('newsfeedVideos');
        } 
		else
		{
			$this->redirect();
		}
	}

	public function newsfeedAudios()
	{
		if(isset($_SESSION['loginUser']) AND !empty($_SESSION['loginUser']))
        {
    	   $this->view('newsfeedAudios');
        } 
		else
		{
			$this->redirect();
		}
	}



}

?>