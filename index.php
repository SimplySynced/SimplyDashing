<?php

include('wunderground_api.php');
include('waze.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">

  <title>SimplyDashing - Home</title>

  <!-- Bootstrap -->
  <link href="../css/bootstrap.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../css/font-awesome.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../css/green.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../css/custom.css" rel="stylesheet">
  <!-- Full Calendar -->
  <link href='../css/fullcalendar.css' rel='stylesheet' />
  <link href='../css/fullcalendar.print.css' rel='stylesheet' media='print' />
</head>

<body class="nav-sm">
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
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Dashboard Home
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

        <!-- start of current conditions widget -->
        <div class="col-md-3 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Current Weather - <?php echo $location; ?></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div style="width: 40%; float: left; padding: 5px;">
                <img src="<?php echo $icon_url; ?>" style="width: 100%;">
                <div style="width: 100%; text-align: center; font-weight: bold; font-size: 100%;"><?php echo $weather; ?></div>
              </div>
              <div style="width: 60%; float: right; padding: 5px;">
                <h4><b>Conditions:</b></h4>
                <b>Current Temperature:</b> <?php echo $temp_f; ?>&deg;F<br>
                <b>Current Humidity:</b> <?php echo $relative_humidity; ?><br>
                <b>Feels Like:</b> <?php echo $feelslike_f; ?>&deg;F<br>
                <b>Wind:</b> <?php echo $wind_string; ?><br>
                <b>Wind Speed:</b> <?php echo $wind_mph; ?> mph<br>
              </div>
            </div>
          </div>
        </div>
        <!-- end current conditions widget -->

        <!-- being outside camera widget -->
        <div class="col-md-6 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Outside Camera</h2>
              <div class="clearfix"></div>
            </div>
            <img src="http://10.1.1.164:1030">
          </div>
        </div>
        <!-- end outside camera widget -->

        <!-- begin waze widget -->
        <div class="col-md-3 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Work Traffic</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php for($w=0; $w < $waze_paths; $w++) { ?>
              <table cellpadding="5px" style="border: 0px; width: 100%">
                <tr>
                  <th colspan="2">Route - <?php echo ${'routeName_'.$w}; ?> </th>
                </tr>
                <tr>
                  <td valign="top" width="50%"><strong>Time:</strong> <?php echo ${'routeTime_'.$w}; ?> min</td>
                  <td valign="top" width="50%"><strong>Distance:</strong> <?php echo ${'routeDist_'.$w}; ?> miles</td>
                </tr>
                <tr>
                  <td valign="top"><strong>ETA:</strong> <?php echo ${'routeETA_'.$w}; ?></td>
                  <td></td>
                </tr>
              </table>
              <br>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- end waze widget -->

      </div>

      <div class="row">

        <!-- Start to do list -->
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Todays Events</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div id="calendar"></div>
              <button id="authorize-button">Authorize</button>
            </div>
          </div>
        </div>
        <!-- End to do list -->

        <!-- begin away mode widget -->
        <div class="col-md-3 col-sm-3 col-xs-12" style="float:right;">
          <div class="x_panel">
            <div class="x_title">
              <h2>Away Mode</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              Insert away switch.
            </div>
          </div>
        </div>
        <!-- end away mode widget -->

      </div>

      <div class="clearfix"></div>

      <div id="calendarModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
                <span class="sr-only">close</span>
              </button>
              <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
              <div style="padding: 5px" id="time">
              <div style="float: left;">Start: <span class="start"></span> </div> <div style="float: right; ">End: <span class="end"></span> </div>
            </div>
            <div class="clearfix"></div>
            <div style="padding: 5px" id="eventDesc"> </div>
            <div style="padding: 5px" id="eventURL"> </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    </div>

    <!-- /page content -->

    <!-- footer content -->
    <footer>
      <div class="pull-right">
        Simply Dashing by <a href="https://colorlib.com">Simply Synced</a>
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

<!-- Full Calendar -->
<script src='../js/moment.js'></script>
<script src='../js/fullcalendar.js'></script>
<!-- GCal Init -->
<script src="../js/gcal_private_days.js"></script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>

</body>
</html>
