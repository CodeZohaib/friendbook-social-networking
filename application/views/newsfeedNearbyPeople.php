<?php
$user=new page;
$allusers=$user->getUserInfo('allUsers');
$userData=$user->getUserInfo();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="FriendBook, Social Media, Make Friends, Newsfeed, Profile Page, FriendBook" />
		<meta name="robots" content="index, follow" />
		<title>Nearby People | Find Local People</title>

		<!-- Stylesheets
    ================================================= -->
		<?php include "components/cssFiles.php" ?>
	</head>
  <body>

    <!-- Header
    ================================================= -->
		<?php include "components/navbar.php"; ?>
    <!--Header End-->

    <div id="page-contents">
    	<div class="container">
    		<div class="row">

    			<!-- Newsfeed Common Side Bar Left
          ================================================= -->
    			 <?php include "components/newsfeed_sidebar_left.php"; ?>


    			<div class="col-md-7">

            <!-- Post Create Box
            ================================================= -->
             <?php include "components/post_create_box.php"; ?>
             <!-- Post Create Box End -->

            <!-- Friend List
            ================================================= -->
            <div class="people-nearby scrollbarLoadData" style="height:1000px;overflow-y:scroll;;overflow-x: hidden;">
              <form method="POST" action="<?php echo BASEURL; ?>/users/searchUser" accept-charset="utf-8" class="search_friend_profile">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchUser" placeholder="Search Name & Email" style="border-radius:3px; text-align:center;">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" style="padding:7px" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                    </div>
                    <br>

                  <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="country">Country</label>
                    <select id="country" name ="country" class="form-control"></select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="state">Select State</label>
                     <select id ="state" name ="state" class="form-control"><option>First Select Country</option></select>
                  </div>

                  
                   
                </div></form><br><br><br><br>
              <div class="error_sms"></div><br>
              <div class="loadAjaxData">

              </div>


            </div>
          </div>

    			<!-- Newsfeed Common Side Bar Right
          ================================================= -->
    			<?php include "components/newsfeed_sidebar_right.php"; ?>
    		</div>
    	</div>
    </div>

    <!-- Footer
    ================================================= -->
     <?php include "components/footer.php"; ?>
     
    
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <?php include "components/jsFiles.php" ?>
    <script type="text/javascript">
        populateCountries("country", "state");
    </script>
  </body>
</html>
