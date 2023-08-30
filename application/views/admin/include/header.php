<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo BASEURL."/admin/" ?>">FriendBook Admin</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="" data-toggle="modal" data-target=".addAdmin"><i class="fa fa-user"></i> Add Admin</a></li>
          <li><a href="" data-toggle="modal" data-target=".view_Profile"><i class="fa fa-user"></i> Profile</a></li>
          <li><a href="<?php echo BASEURL."/admin/logout"; ?>"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>
      </div>

    </div>
  </nav>