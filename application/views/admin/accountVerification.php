<?php 
$obj=new admin;
$data=$obj->getTotalUser();

if(is_array($data) AND isset($data[6]))
{
    $totalAccVerification=$data[6]['totalAccVerification'];
}
else
{
    $totalAccVerification=0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel | Account Verification</title>

    <?php include __DIR__."/../components/adminCssFiles.php" ?>
  </head>
  <body>
    <div id="wrapper">

      <?php require_once __DIR__.'/include/header.php'; ?>

        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-2">
                    <?php require_once __DIR__.'/include/sidebar.php'; ?>
                </div>
                <div class="col-md-10">
                    <h1><i class="fa fa-users"></i> Account Verification <small>View All Account Verification</small></h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo BASEURL; ?>/admin/"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                      <li class="active"><i class="fa fa-users"></i> <a href="<?php echo BASEURL; ?>/admin/accountVerification">Account Verification</a></li>
                    </ol>
               
                    <form method="POST" action="<?php echo BASEURL; ?>/admin/searchUser" class="search_friend_profile">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputCity">Enter Name & Email</label>
                          <input type="text" class="form-control" name="searchUser" placeholder="Search Name & Email" style="border-radius:3px; text-align:center;">
                          <input type="hidden" class="form-control" name="accountVerification" hidden="true">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputState">Country</label>
                         <select id="country" name ="country" class="form-control"></select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputZip">State</label>
                           <div class="input-group">
                                <select id ="state" name ="state" class="form-control"><option>First Select Country</option></select>
                                <span class="input-group-btn">
                                  <button class="btn btn-primary" style="padding:7px" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </div>
                      </div><br><br>
                      <div class="error_sms"></div>
                    </form><br><br><br><br>
                    

                    <div class="searchUserData">
                        <?php
                         Pagination_admin($totalAccVerification,'getAccountVerification'); 
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <?php include  __DIR__.'/include/all_bootstrap_modal.php'; ?>

        <div id="footer" class="text-center">
            Copyright &copy; by <a href="#">Zohaib Khan</a> 2023
        </div>
    </div>

    <?php include __DIR__."/../components/adminJsFiles.php" ?>

    <script type="text/javascript">
       populateCountries("country", "state");
    </script>
  </body>
</html>