<div class="create-post">
  <div class="row">
    <div class="col-md-6 col-sm-6">
      <div class="form-group">
        <img src="<?php echo BASEURL."/public/assets/images/users/".$userData['image']; ?>" alt="" class="profile-photo-md" />

      <form action="<?php echo BASEURL; ?>/post/insertPost" class="formProgressBar createPost" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

        <textarea name="texts" id="exampleTextarea" cols="30" rows="2" class="form-control emojiBottom" placeholder="Write what you wish....!"></textarea>
        </div>

      <div class="form-group" style="display: none;">
        <input type="file" name="image" class="inputimagevideo" >
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
        <button type="submit" class="btn btn-primary pull-right">Publish</button>
      </form>

      </div>
    </div>
  </div><br>

  
</div>
<div class="row">
  <div class="form-group">
      <div class="progress-bar-wrapper">
        <span class="progress-bar progress-bar-primary"><span class="percentage"></span></span>
      </div>
  </div><br>

  <div class="col-lg-12 progressMsg"></div>

</div><br>
<!-- Post Create Box End -->