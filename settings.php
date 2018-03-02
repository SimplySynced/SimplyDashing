<?php

include('common.php');

$kodi_query = $conn->prepare('SELECT * FROM devices WHERE device_name="kodi"');
$kodi_query->execute();
$kodi_devices = $kodi_query->fetchAll();

$oh_query = $conn->prepare('SELECT * FROM devices WHERE device_name="openhab"');
$oh_query->execute();
$oh_server = $oh_query->fetch();

$config_query = $conn->prepare('SELECT * FROM config');
$config_query->execute();
$config = $config_query->fetchAll();

// Set each config name as a variable with its value.
foreach ($config as $c) {
  ${$c['config_option']} = $c['config_value'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">

  <title>SimplyDashing - Settings</title>

  <!-- Bootstrap -->
  <link href="../css/bootstrap.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../css/font-awesome.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../css/green.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../css/custom.css" rel="stylesheet">
</head>

<body class="nav-sm footer_fixed">
<div class="container body">
  <div class="main_container">

    <!-- Sidebar -->
    <?php include('navbar.php'); ?>

    <!-- top navigation -->
    <div class="top_nav">
      <div class="nav_menu">
        <nav>
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>

          <ul class="nav navbar-nav navbar-right">
            <li class="">
              <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Settings
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- /top navigation -->

    <!-- page content -->
    <div class="right_col" role="main">

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">

            <div class="x_content">

              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">OpenHAB Server</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Kodi Devices</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Weather</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <h2>Waze</h2>
                    <p>Place in your Home and Work address below.  Ensure that a longitude and latitude is shown below your address.
                      If you receive an error or these do not update, the waze traffic data will not load.  Next choose how many routes you want to see when using the waze widget.
                      The routes will display in order of quickest to longest.</p>
                    <p>Home Address: <input size="50" type="text" name="waze_home_address" value="<?php echo $waze_home_address; ?>">
                       <strong>Longitude:</strong> <span name="waze_home_long"><?php echo $waze_home_long; ?></span> <strong>Latitude:</strong> <span name="waze_home_lat"><?php echo $waze_home_lat; ?></span></p>
                    <p>Work Address:&nbsp;&nbsp;<input size="50" type="text" name="waze_work_address" value="<?php echo $waze_work_address; ?>">
                      <strong>Longitude:</strong> <span name="waze_work_long"><?php echo $waze_work_long; ?></span> <strong>Latitude:</strong> <span name="waze_work_lat"><?php echo $waze_work_lat; ?></span></p>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <h2>OpenHAB Server Settings</h2>
                    <p>Insert the IP address and port of your OpenHAB server. </p>
                    Server IP: <input id="oh_ip" value="<?php echo $oh_server['device_ip']; ?>"> Port: <input id="oh_port" value="<?php echo $oh_server['device_port']; ?>"><br><br>
                    <p>If your OpenHAB server requires a user name and password place those in here.</p>
                    Username: <input id="oh_user"> Password: <input id="oh_pass">
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                    <h2>Kodi Devices</h2>
                    <p>Using the form below you can add or edit Kodi devices to be used on any page. Only one Kodi device can be displayed per page.  Kodi device information is called using the javascript function getKodi with the room name. Example getKodi('Living Room').</p>
                    <div style="width: 100%">
                      <div style="padding: 5px; float: left; width: 15%; font-weight: bold" >Location: </div>
                      <div style="padding: 5px; float: left; width: 15%; font-weight: bold" >IP Address: </div>
                      <div style="padding: 5px; float: left; width: 15%; font-weight: bold" >IP Port: </div>
                      <div style="padding: 5px; float: left; width: 15%; font-weight: bold" >User Name: </div>
                      <div style="padding: 5px; float: left; width: 15%; font-weight: bold" >Password: </div>
                      <div style="clear: both"></div>

                      <?php
                        $k=0;
                        foreach($kodi_devices as $kd){
                          echo '<div style="padding: 5px; float: left; width: 15%" >' . $kd['device_location'] . '</div>';
                          echo '<div style="padding: 5px; float: left; width: 15%" >' . $kd['device_ip'] . '</div>';
                          echo '<div style="padding: 5px; float: left; width: 15%" >' . $kd['device_port'] . '</div>';
                          echo '<div style="padding: 5px; float: left; width: 15%" >' . $kd['device_username'] . '</div>';
                          echo '<div style="padding: 5px; float: left; width: 15%" >' . $kd['device_password'] . '</div>';
                          echo '<div style="clear: both"></div>';
                          $k++;
                        }
                        ?>
                    </div>
                    <div style="clear: both"></div>
                    <h2>Add New Kodi Device</h2>
                    <form class="form-horizontal" action="actions.php?action=add_kodi" method="post">
                      Location: <input type="text" name="device_location" id="device_location">
                      IP Address: <input type="text" name="device_ip" id="device_ip">
                      IP Port: <input type="text" name="device_port" id="device_port">
                      Username: <input type="text" name="device_username" id="device_username">
                      Password: <input type="text" name="device_password" id="device_password">
                      <button class="btn btn-primary" type="submit"> Add</button>
                    </form>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                    <h2>Weather</h2>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

      <div class="clearfix"></div>

    </div>
    <!-- /page content -->

    <!-- footer content -->
    <footer>
      <div class="pull-right">
        Simply Dashing by <a href="https://simplysyncedllc.com">Simply Synced</a>
      </div>
      <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
  </div>
</div>

<!-- jQuery -->
<script src="../js/jquery.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.js"></script>
<!-- Custom Theme Scripts -->
<script src="../js/custom.js"></script>

<!-- Start JavaClock -->
<script type="text/javascript">

  function updateClock ( )
  {
    tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

    var d=new Date();
    var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
    if(nyear<1000) nyear+=1900;

    var currentTime = new Date ();

    var currentHours = currentTime.getHours ( );
    var currentMinutes = currentTime.getMinutes ( );
    //var currentSeconds = currentTime.getSeconds ( );

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
    //currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

    // Choose either "AM" or "PM" as appropriate
    var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

    // Convert the hours component to 12-hour format if needed
    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

    // Convert an hours component of "0" to "12"
    currentHours = ( currentHours == 0 ) ? 12 : currentHours;

    // Compose the string for display
    var currentTimeString = tday[nday] + " " + tmonth[nmonth] + " " + ndate + ", " + nyear + " - " + currentHours + ":" + currentMinutes + " " + timeOfDay;

    // Update the time display
    document.getElementById("clock").firstChild.nodeValue = currentTimeString;
  }

</script>
<!-- End JavaClock-->

<!-- Moment -->
<script src='../js/moment.js'></script>


</body>
</html>
