<div class="col-md-2 static">
  <div class="suggestions" id="sticky-sidebar" >
    <h4 class="grey">Nearby Users</h4>
    <?php
    if(is_array($allusers))
    {
      $count=0;
       foreach ($allusers as $key1 => $value1) 
       {
         if(encryption('encrypt',$value1['email'])!=$_SESSION['loginUser'][1])
         {
          $count++;
           unset($value1['password']);
           unset($value1['verification_code']);
           $friendId=encryption('encrypt', $value1['id']);
           $myRequest=$user->checkFriendRequest($_SESSION['loginUser'][0],$friendId,'exist');
           $friendRequest=$user->checkFriendRequest($friendId,$_SESSION['loginUser'][0],'exist');

           if($myRequest===false AND $friendRequest==false)
           {
           ?>
              <div class="follow-user">
                <img src="<?php echo BASEURL."/public/assets/images/users/".$value1['image']; ?>" onclick="imageView(this)" class="profile-photo-sm pull-left" />
                <div>
                  <h5><a href="<?php echo BASEURL."/timeline/friendProfile/94039".$friendId; ?>"> <?php echo ucfirst($value1['name']); ?></a></h5>
                    <span class='request_btn'>
                      <a href='' class='btn btn-primary add_friend_sidbar' friend_request="<?php echo $friendId; ?>">Add Friend</a>
                    </span>
                </div>
              </div>
           <?php 
           }
           else
           {
             $count++;
           }
        }
      }
    }
    else
    {
      ?>
      <p class="alert alert-danger text-center alert-dismissable" style="color:black"><a href="#" class="close" data-dismiss="alert" style="color:black">×</a>Users not Exist...!</p>
      <?php
    }

    if(isset($count))
    {
      if(count($allusers)==$count-count($allusers))
      {
        ?>
        <p class="alert alert-danger text-center alert-dismissable" style="color:black"><a href="#" class="close" data-dismiss="alert" style="color:black">×</a>Users not Exist...!</p>
        <?php
      }
    }
  

  ?>
  </div>
</div>
