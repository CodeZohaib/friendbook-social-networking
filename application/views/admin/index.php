<?php 
$obj=new admin;
$data=$obj->getDashboardData();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel</title>

    <!-- Bootstrap -->

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
                    <h1><i class="fa fa-tachometer"></i> Dashboard <small>Statistics Overview</small></h1><hr>
                    <ol class="breadcrumb">
                      <li class="active"><i class="fa fa-tachometer"></i> Dashboard</li>
                    </ol>

                    <div class="row tag-boxes">
                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-users fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $data['totalUsers'][0]['totalUser']; ?></div>
                                            <div class="text-right">Total Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo BASEURL."/admin/allUsers" ?>">
                                    <div class="panel-footer">
                                        <!--<span class="pull-left">View All</span>-->
                                        <!--<div class="clearfix"></div>-->
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-users fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $data['totalUsers'][1]['totalVerify']; ?></div>
                                            <div class="text-right">Verified Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-users fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $data['totalUsers'][2]['totalNotVerify']; ?></div>
                                            <div class="text-right">Not Verified Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-users fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $data['totalUsers'][3]['totalBlock']; ?></div>
                                            <div class="text-right">Block Users</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div><hr>

                    <h3>Recent Join Users</h3>
                    <?php 

                      if(isset($data['totalUsers'][0]['totalUser']))
                      {
                        if($data['totalUsers'][0]['totalUser']>0)
                        {   
                         ?>
                          <div class="sms_display"></div><br>
                          <table class="table table-bordered table-striped table-hover">
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
                             <tbody>
                                <?php
                                 $i=1;

                                 foreach ($data['recentJoin'] as $key => $value) 
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

                                     echo "<tr>
                                            <td>".$i++."</td>
                                            <td><img src='". $imgPath."' width='30px' class='profile-photo-md image_style' data-toggle='modal' data-target='.img_display'></td>
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
                                ?>
                              </tbody>
                          </table>
                        
                   <a href="<?php echo BASEURL."/admin/allUsers" ?>" class="btn btn-primary">View All Users</a><hr>
                   <?php  
                       }
                       else
                       {
                        echo "<h3 class='alert alert-danger text-center'>No  Users Created Account........!</h3>";
                       }
                    }
                    else
                    {
                         echo "<h3 class='alert alert-danger text-center'>No  Users Created Account........!</h3>";
                    }

                    echo "<h3>Recent Post Reports</h3>";
                    $i=1;
                    
                    if(is_array($data['postReports']))
                    {
                    ?>
                    
                    <table class="table">
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
                        <tbody>
                            <?php 
                             $i=1;
                             foreach ($data['postReports'] as $key => $value) 
                             {
                                $getPost=$obj->getPostData(encryption('encrypt',$value['post_id']));
                                $totalComplaint=$this->totalPostComplaint($value['post_id']);
                                 $complaintUser=$obj->getUserInfo('id',$value['post_user_id']);
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
                                 
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                    <?php echo "<a href='' user_id='".encryption('encrypt',$complaintUser['id'])."' data-target='.view_Profile' data-toggle='modal' onclick='viewUserProfile(this)'>".ucfirst($complaintUser['name'])."</a>"; ?>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-success" onclick="viewPost(this)" value="<?php echo encryption('encrypt',$value['post_id']); ?>">Post</button></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="postComplaint(this)" class="btn btn-danger btn-xs" value="<?php echo encryption('encrypt',$value['post_id']); ?>">Complaint</button></td>
                                <td><?php echo $total_Complaint; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo date('M j Y g:i A', strtotime($value['complaint_date'])) ?></td>
                            </tr>
                            <?php 
                             }
                            ?>
                               
                        </tbody>
                    </table>
                
                <a href="<?php echo BASEURL."/admin/allPostReport" ?>" class="btn btn-primary">View All Post Reposts</a><br><br><hr>
                <?php
                }
                else
                {
                    echo "<h3 class='alert alert-danger text-center'>Zero Post Complaint........!</h3>";
                }

                echo "<h3>Recent Account Reports</h3>";
                $i=1;
                if(is_array($data['profileReports']))
                {
                ?>
                    <table class="table">
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
                        <tbody>
                            <?php 
                            //check($data['profileReports']);

                             $i=1;
                             foreach ($data['profileReports'] as $key => $value) 
                             {
                                $complaintOn=$obj->getUserInfo('id',$value['profile_user_id']);
                                $profile_id=encryption('encrypt',$value['profile_user_id']);
                                $totalReport=$obj->totalAccountComplaint($value['profile_user_id']);

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
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                               
                                <td>

                                    <?php echo "<a href='' user_id='".encryption('encrypt',$complaintOn['id'])."' data-target='.view_Profile' data-toggle='modal' onclick='viewUserProfile(this)'>".ucfirst($complaintOn['name'])."</a>"; ?>
                                </td>
                                <td><button class="btn btn-sm btn-danger" onclick="accountComplaint(this)" value="<?php echo encryption('encrypt',$value['profile_user_id']); ?>">Complaint</button></td>
                                <td><?php echo $total_Complaint; ?></td>
                                <td><?php echo $status;  ?></td>
                                <td><?php echo date('M j Y g:i A', strtotime($value['complaint_date'])) ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <a href="<?php echo BASEURL."/admin/allAccountReport"; ?>" class="btn btn-primary">View All Account Reposts</a><br>
                <?php
                }
                else
                {
                    echo "<h3 class='alert alert-danger text-center'>Zero Account Reposts........!</h3>";
                }
                ?>
                </div>
            </div>
        </div>

        <?php include  __DIR__.'/include/all_bootstrap_modal.php'; ?>

        <div id="footer" class="text-center">
            Copyright &copy; by <a href="#">Zohaib Khan</a> 2023
        </div>
    </div>
    <div id="dialog" hidden="true"></div>
     <?php include __DIR__."/../components/adminJsFiles.php" ?>

  </body>
</html>