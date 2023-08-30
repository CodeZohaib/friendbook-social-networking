<div id="dialog"></div>
<div id="footer">
      <div class="container">
      	<div class="row">
          <div class="footer-wrapper">
            
            <div class="col-md-3 col-sm-3">
              <a href="" style="font-size:30px">FriendBook</a>
              <ul class="list-inline social-icons">
              	<li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
              </ul>
            </div>
            <div class="col-md-3 col-sm-3">
              <h6>For individuals</h6>
              <ul class="footer-links">
                <li><a href="">Signup</a></li>
                <li><a href="">login</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
            
            <div class="col-md-3 col-sm-3">
              <h6>About</h6>
              <ul class="footer-links">
                <li><a href="">About us</a></li>
                <li><a href="">Contact us</a></li>
                <li><a href="">Help</a></li>
              </ul>
            </div>
            <div class="col-md-3 col-sm-3">
              <h6>Contact Us</h6>
                <ul class="contact">
                	<li><i class="icon ion-ios-telephone-outline"></i>+923139943227</li>
                	<li><i class="icon ion-ios-email-outline"></i>Kzohaib935@gmail.com</li>
                  <li><i class="icon ion-ios-location-outline"></i>Hakeemabad Nowshera</li>
                </ul>
            </div>

          </div>
      	</div>
      </div>
      <div class="copyright">
        <p>Copyright <a href="https://www.facebook.com/kzohaib935/">Zohaib Khan</a>.All rights reserved</p>
      </div>
</div>

    <!--Add User Address Popup-->
    <div class="modal fade createPost" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">Create New Post......!</h4>
                </div>

                <div class="modal-body">
                  <div class="row create-post">
                    
                    <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                     <img src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="" class="profile-photo-md" />
                  <form action="<?php echo BASEURL; ?>/post/insertPost" class="formProgressBar" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      <textarea name="texts" cols="30" rows="2" class="form-control" placeholder="Write what you wish....!"></textarea>
                      </div>

                    <div class="form-group" style="display: none;">
                      <input type="file" name="image" class="inputImageVideo">
                    </div>

                  </div>

                  <div class="col-md-6 col-sm-6">
                    <div class="tools">
                      <ul class="publishing-tools list-inline">
                        
                        <li>
                          <select class="form-control" name="post_status">
                            <option value="public">Public </option>
                            <option value="friend">Friend</option>
                            <option value="private">Private</option>
                          </select>
                        </li>
                        <li><a ><i class="ion-images post_image"></i></a></li>
                        <li><a ><i class="ion-ios-videocam post_video"></i></a></li>
                      </ul>
                      

                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                        <div class="progress-bar-wrapper">
                          <span class="progress-bar progress-bar-primary"><span class="percentage"></span></span>
                        </div>
                    </div><br>

                    <div class="col-lg-12 progressMsg"></div>
                    <button type="submit" id="post_insert" class="btn btn-primary pull-right">Publish</button>
                    </form>
                  </div>
                  </div>
                </div>

                <div class="modal-footer server_message">
                  
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Add User Address Popup Close-->


 <!--Edit Name-->
   <div class="modal fade edit_name" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <br>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title">Edit Your Name</h4>
        </div>

        <div class="modal-body bg-warning">
           <center><p class="">You can change the name only 3 times</p></center>
          <form action="<?php echo BASEURL."/users/userUpdate"; ?>" method="post" class="form">
            <div class="form-group">
              <label for="name">New Name</label>
              <input type="text" name="new_name" class="form-control" placeholder="Enter Your New Name......!" required>
            </div>

            <div class="form-group">
              <label for="name">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter Your Password for Identification......!" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Name</button>
            <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>
          </form>

        </div>

        <div class="modal-footer">
         
        </div>
      </div>
    </div>
   </div>
  
  <!--/Edit Name box-->

 <div id="all_like" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content modal-sm">

      <div class="modal-header bg-warning">
        <button class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove-sign"></span></button>
        <h1 class="modal-title">Likes <span class="glyphicon glyphicon-thumbs-up" style="font-size:28px"></span></h1>
      </div>

      <div class="modal-body" style="height:350px; overflow-y:scroll;font-size:18px">

        <div id="view_likes">

        </div>

      </div>

      <div class="modal-footer bg-success">
         <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
   </div>
 </div>

 

 <div id="all_dislike" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content modal-sm">

      <div class="modal-header bg-warning">
        <button class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove-sign"></span></button>
        <h1 class="modal-title text-danger">Dislikes <span class="glyphicon glyphicon-thumbs-down" style="font-size:28px"></span></h1>
      </div>

      <div class="modal-body" style="height:350px; overflow-y:scroll;font-size:18px">

        <div id="view_dislikes">

        </div>

      </div>

      <div class="modal-footer bg-success">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
 </div>

 <div class="modal fade my-modal delete_post" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <br>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title text-danger">Delete Post</h4>
        </div>

        <div class="modal-body  bg-info">
          <h4 class='text-info'>Are You Sure You Want to Delete Your Post.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm yes_delete" onclick="yes_delete_post()">Yes</button>
             <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer show_error_myPost">
          
        </div>
    </div>
   </div>
 </div>


 <div class="modal fade my-modal delete_comment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title" style='color:yellow;'>Delete Comment</h4>
        </div>

        <div class="modal-body  bg-warning">
          <h4 class='text-info'>Are You Sure You Want to Delete this Comment.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm yes_delete_comment">Yes</button>
             <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer comment_del_error">
          
        </div>
    </div>
   </div>
 </div>



 <div class="modal fade my-modal delete_message" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title" style='color:yellow;'>Delete Message</h4>
        </div>

        <div class="modal-body  bg-warning">
          <h4 class='text-info'>Are You Sure You Want to Delete this Message.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm deleteForMe">Delete For Me</button>
             <button type="button" class="btn btn-success btn-sm deleteForEveryone">Delete For Everyone</button>

             <button type="close" style="float:right;" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer messageError">
          
        </div>
    </div>
   </div>
 </div>


  <div class="modal fade my-modal delete_friend_message" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title" style='color:yellow;'>Delete Message</h4>
        </div>

        <div class="modal-body  bg-warning">
          <h4 class='text-info'>Are You Sure You Want to Delete this Message.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm deleteForMe">Delete</button>
             <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer messageError">
          
        </div>
    </div>
   </div>
 </div>


  <div class="modal fade my-modal clearChatBox" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title" style='color:yellow;'>Delete All Chat</h4>
        </div>

        <div class="modal-body  bg-warning">
          <h4 class='text-info'>Are You Sure You Want to Delete All Chat.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm yes_delete_allChat">Yes</button>
             <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer chat_del_error">
          
        </div>
    </div>
   </div>
 </div>


  <div class="modal fade my-modal delete_comment_realtime" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title" style='color:yellow;'>Delete Comment</h4>
        </div>

        <div class="modal-body  bg-warning">
          <h4 class='text-info'>Are You Sure You Want to Delete this Comment.?</h4>

           <div class="text-center">
             <button type="button" class="btn btn-success btn-sm yes_delete_comment_realtime">Yes</button>
             <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>
       

        <div class="modal-footer comment_del_error">
          
        </div>
    </div>
   </div>
 </div>


  <div class="modal fade my-modal logout" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header"><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title">Logout ID</h4>
        </div>

        <div class="modal-body bg-warning">
          <p><strong><?php if(isset($userData)){ echo ucwords($userData['name']); } ?></strong> Are You Sure You Want To Logout ID.?</p>
        </div>
      
       <div class="modal-footer text-center">
         <a href="<?php echo BASEURL."/users/logout"; ?>" class="btn btn-success btn-sm">Yes</a>
         <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
       </div>
    </div>
   </div>
 </div>

  <div id="follower" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content modal-sm">

      <div class="modal-header bg-warning">
        <button class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove-sign"></span></button>
        <h2 class="modal-title">My Followers <span class="ion ion-android-person-add" style="font-size:28px"></span></h2>
      </div>

      <div class="modal-body" style="height:350px; overflow-y:scroll;font-size:18px">

        <div id="total_follower">

        </div>

      </div>

      <div class="modal-footer bg-success">
         <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
   </div>
 </div>

 <div class="modal fade" id="accountVerification" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="post-content">
          <div class="post-container bg-warning">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                <h4 class="modal-title text-success">Account Verification</h4>
              </div>

              <div class="modal-body">
                 <p><b>Make Sure your account profile data match to the documents</b></p>
                 <ul>
                   <li>Account Name,Address Match to the Documents</li>
                   <li>Use real documentation and photos to prove your identity</li>
                   <li>Upload Government-issued ID</li>
                   <li>Upload Birthday Certificate</li>
                   <li>Upload Utility Bill</li>
                   <li>Upload Any Proof to confirm your identity</li>
                 </ul>
                <form class="report" action="<?php echo BASEURL."/users/accountVerification"; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                   Upload Proof <input type="file" name="image[]" class="reportFile" class="form-control" multiple required><br>

                    <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                    <input type="submit" name="submit" value="Submit" style="float:right;" class="btn btn-success"><br>
                  </form><br>
              </div>

              <div class="modal-footer">
                <div class="row">
                  <div class="form-group">
                      <div class="progress-bar-wrapper">
                        <span class="progress-bar progress-bar-primary"><span class="percentage"></span></span>
                      </div>
                  </div><br>

                  <div class="col-lg-12 progressMsg"></div>

                </div><br>
              </div>

          </div>
        </div>
      </div>
    </div>
 </div>

 <div class="modal fade" id="accountReport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="post-content">
          <div class="post-container bg-warning">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                <h4 class="modal-title text-success">Account Report</h4>
              </div>

              <div class="modal-body">
                <form class="report" action="<?php echo BASEURL."/users/userReport"; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                   <textarea class="textarea" name="complaint" rows="5" col="10" placeholder="Enter Your Complaint .....!" pattren="[A-Za-z]{550}" maxlength="550" required></textarea><br><br>

                   Attach Proof <input type="file" name="image[]" class="reportFile" class="form-control" multiple required><br>

                    <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                    <input type="submit" name="submit" value="Submit Report" style="float:right;" class="btn btn-success"><br>
                  </form><br>
              </div>

              <div class="modal-footer">
                <div class="row">
                  <div class="form-group">
                      <div class="progress-bar-wrapper">
                        <span class="progress-bar progress-bar-primary"><span class="percentage"></span></span>
                      </div>
                  </div><br>

                  <div class="col-lg-12 progressMsg"></div>

                </div><br>
              </div>

          </div>
        </div>
      </div>
    </div>
 </div>


   <div class='modal fade' id="verificationHistory" tabindex='-1' role='dialog' aria-hidden='true' style="margin-top: 30px;">
      <div class='modal-dialog modal-xs modal-content' >


          <div class="modal-header">
             <a href="" data-dismiss="modal" class="close">X</a>
            <h3> Account Verification History </h3>

          </div>

          <div class="modal-body">
            <?php 
             if(is_array($verificationHistory))
             {
               foreach ($verificationHistory as $key => $value) 
               { 
                  if($value['verification_status']=='reject')
                  {

                    echo '<b>Verification Status:- <span class="text-danger">'.ucwords($value['verification_status']).'</span></b>';
                  }
                  else if($value['verification_status']=='pending')
                  {
                    echo '<b>Verification Status:- <span class="text-success">'.ucwords($value['verification_status']).'</span></b>';
                  }
                  else if($value['verification_status']=='verify')
                  {
                    echo '<b>Verification Status:- <span class="text-primary">'.ucwords($value['verification_status']).'</span></b>';
                  }
                   

                  if(!empty($value['admin_reply']))
                  {
                     echo '<br><b>Admin Reply:-</b>
                      <p style="margin-left:20px;font-size:15px">'.$value['admin_reply'].'</p>';
                  }

                  if(!empty($value['upload_file_name']))
                  {
                    $uploadFileName=explode("940961",$value['upload_file_name']);
                    $document_id=mt_rand(11111,99999);
                    echo "
                    <br><button data-toggle='collapse' data-target='#".$document_id."' class='btn btn-sm btn-success'>View Documents</button>
                    <div style='margin:10px' id='".$document_id."' class='collapse'>
                    <center>";
                    foreach ($uploadFileName as $key => $name) 
                    {
                      if(!empty($name))
                      {
                        $path=BASEURL."/public/assets/account_verification/".$name;
                         echo '<br><img src="'.$path.'" style="width:300px;height:300px;border:2px black solid"><br>';

                      }
                      
                    }
                    echo "</center>
                    </div>";
                  }
                  


                  echo "<br><hr/><br>";
               }
             
             }
            ?>
          </div>
               
            <div class="modal-footer">
              <button class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
      </div>
    </div>


   <div class='modal fade viewVideo' tabindex='-1' role='dialog' aria-hidden='true' style="margin-top: 30px; overflow-y: hidden;">
      <div class='modal-dialog modal-sm timeline_ablum modal-content' >
        <div class="videoLink"> 
            
        </div>
    
        <div class=' checkVideo'>
          
        </div>
      </div>
    </div>

   <div class='modal fade viewChatBoxMedia' tabindex='-1' role='dialog' aria-hidden='true' style="overflow-y: hidden;">
      <div class='modal-dialog timeline_ablum modal-content' >
        <div class="loadMedia"> 
            
        </div>
      </div>
    </div>

       <div class="modal fade post_report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xs">
        <div class="modal-content">
          <div class="post-content">
            <div class="post-container bg-warning">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close" style="font-size:30px">&times;</button>

                  <h4 class="modal-title text-success">Post Report</h4>
                </div>

                <div class="modal-body">
                  <form class="report" action="<?php echo BASEURL."/post/postReport"; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                     <textarea class="textarea" name="complaint" rows="5" col="10" placeholder="Enter Your Post Complaint .....!" pattren="[A-Za-z]{550}" maxlength="550" required></textarea><br><br>

                     Attach Proof <input type="file" name="image[]" class="reportFile" class="form-control" multiple required><br>

                      <button type="button" data-dismiss='modal' style="float:right;margin-left:6px" class="btn btn-danger">Close</button>

                      <div id="postInputID" hidden>
                        
                      </div>

                      <input type="submit" name="submit" value="Submit Report" style="float:right;" class="btn btn-success"><br>
                    </form><br>
                </div>

                <div class="modal-footer">
                  <div class="row">
                    <div class="form-group">
                        <div class="progress-bar-wrapper">
                          <span class="progress-bar progress-bar-primary"><span class="percentage"></span></span>
                        </div>
                    </div><br>

                    <div class="col-lg-12 progressMsg"></div>

                  </div><br>
                </div>

                 <div class="complaintHistory">
               
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    


          <!--Popup-->

  <div class="modal fade my-modal model-image" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header"><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
          <h4 class="modal-title">Image</h4>
        </div>

        <div class="modal-body bg-warning">
          <div class="show-image">
           
          </div>
        </div>
      
       <div class="modal-footer text-center">
         <button type="close" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
       </div>
    </div>
   </div>
 </div>