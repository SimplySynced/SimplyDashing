<?php

include('openhab.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simply Dashing</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../css/font-awesome.css" rel="stylesheet">
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
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Living Room
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

            <!-- begin light control -->
            <div class="col-md-2 col-sm-2 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Ceiling Dimmer</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <input class="knob" data-width="100%" data-angleOffset="-125" data-angleArc="250" data-fgColor="#34495E" data-rotation="clockwise" data-name="Light_MasterBed_Lamp_Dim" value="<?php echo $Light_MasterBed_Lamp_Dim; ?>">
                </div>
              </div>
            </div>
            <!-- end light control -->

            <div class="clearfix"></div>

          </div>
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
    <!-- jQuery Knob -->
    <script src="../js/jquery.knob.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.js"></script>

    <!-- jQuery Knob -->
    <script>
      $(function($) {

        $(".knob").knob({
          change: function(value) {
            //console.log("change : " + value);
          },
          release: function(value) {
            //console.log(this.$.attr('value'));
            console.log("release : " + value);
            var name = this.$.data('name');
            //console.log(this.$.data('name'));
            $.post ("http://<?php echo $oh_ip; ?>:<?php echo $oh_port; ?>/CMD?"+name+"="+value);
          },
          cancel: function() {
            console.log("cancel : ", this);
          },

        });

      });
    </script>
    <!-- /jQuery Knob -->

  </body>
</html>
