<?php

include ('wunderground_api.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">

    <title>Simply Dashing</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../css/font-awesome.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.css" rel="stylesheet">
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
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Weather Dashboard
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
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Current Weather - <?php echo $location; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div style="width: 40%; float: left; padding: 5px;">
                    <img src="<?php echo $icon_url; ?>" style="width: 100%;">
                    <div style="width: 100%; text-align: center; font-weight: bold; font-size: 12pt;"><?php echo $weather; ?></div>
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

            <!-- begin radar widget -->
            <div class="col-md-5 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Radar Map</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <img src="<?php echo $animated_radar_url; ?>" style="width: 100%;">
                </div>
              </div>
            </div>
            <!-- end radar widget -->

            <!-- begin weather alert widget -->
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Weather Alerts</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php
                  if ($wac == 0) {
                    echo '<span style="color: green">No current weather alerts</span>';
                  }
                  for($a = 0; $a < $wac; $a++)
                  {
                    echo '<a href="" data-toggle="modal" data-target=".bs-example-modal-lg"><span style="color: red; "><b>' . ${'wa_type_'.$a};
                    echo ${'wa_description_'.$a} . '</b><br>';
                    echo '</a>';
                    ?>

                    <!-- begin weather alert modal -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel"><?php echo ${'wa_description_'.$a}; ?></h3>
                          </div>
                          <div class="modal-body">
                            <div style="float: left;"><?php echo 'Date/Time Issued: ' . ${'wa_date_'.$a}; ?></div>
                            <div style="float: right;"><?php echo 'Date/Time Expires: ' . ${'wa_expires_'.$a}; ?></div>
                            <pre><?php echo ${'wa_message_'.$a}; ?></pre>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- end weather alert modal -->

                  <?php
                    };
                  ?>
                </div>
              </div>
            </div>
            <!-- end weather alert widget -->

          </div>

          <div class="row">
            <div style="padding-left: 10px;"> <h2>Forecast</h2> </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Today</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                        Projected High: <?php echo $sf_high_f_0;?>&deg;F<br>
                        Projected Low: <?php echo $sf_low_f_0;?>&deg;F<br>
                        Projected Humidity: <?php echo $sf_humidity_average_0; ?>%<br>
                        Chance of Rain: <?php echo $tf_rain_prob_0; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b>Todays Forecast:</b><br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_0; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_0;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b>Tonights Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_1; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_1;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $tf_title_2; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                      Projected High: <?php echo $sf_high_f_1;?>&deg;F<br>
                      Projected Low: <?php echo $sf_low_f_1;?>&deg;F<br>
                      Projected Humidity: <?php echo $sf_humidity_average_1; ?>%<br>
                      Chance of Rain: <?php echo $tf_rain_prob_2; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_2; ?> Forecast:</b><br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_2; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_2;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_3; ?>s Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_3; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_3;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $tf_title_4; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                      Projected High: <?php echo $sf_high_f_3;?>&deg;F<br>
                      Projected Low: <?php echo $sf_low_f_3;?>&deg;F<br>
                      Projected Humidity: <?php echo $sf_humidity_average_3; ?>%<br>
                      Chance of Rain: <?php echo $tf_rain_prob_4; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_4; ?>s Forecast:</b><br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_4; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_4;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_5; ?>s Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_5; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_5;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $tf_title_6; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                      Projected High: <?php echo $sf_high_f_4;?>&deg;F<br>
                      Projected Low: <?php echo $sf_low_f_4;?>&deg;F<br>
                      Projected Humidity: <?php echo $sf_humidity_average_4; ?>%<br>
                      Chance of Rain: <?php echo $tf_rain_prob_6; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_6; ?>s Forecast:</b><br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_6; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_6;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_7; ?>s Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_7; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_7;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $tf_title_8; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                      Projected High: <?php echo $sf_high_f_5;?>&deg;F<br>
                      Projected Low: <?php echo $sf_low_f_5;?>&deg;F<br>
                      Projected Humidity: <?php echo $sf_humidity_average_5; ?>%<br>
                      Chance of Rain: <?php echo $tf_rain_prob_8; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_8; ?>s Forecast:</b><br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_8; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_8;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_9; ?>s Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_9; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_9;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $tf_title_10; ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div>
                    <div style="padding-bottom: 5px">
                      <b>Projected Conditions:</b><br>
                      Projected High: <?php echo $sf_high_f_6;?>&deg;F<br>
                      Projected Low: <?php echo $sf_low_f_6;?>&deg;F<br>
                      Projected Humidity: <?php echo $sf_humidity_average_6; ?>%<br>
                      Chance of Rain: <?php echo $tf_rain_prob_10; ?>%
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_10; ?>s Forecast:</b> <br>
                      <div style="width: 30%; float: left; padding: 5px;">
                        <img src="<?php echo $tf_icon_url_10; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; float: right; padding: 5px;">
                        <?php echo $tf_fcttext_10;?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                      <b><?php echo $tf_title_11; ?>s Forecast:</b><br>
                      <div style="width: 30%; padding: 5px; float: left;">
                        <img src="<?php echo $tf_icon_url_11; ?>" style="width: 100%;">
                      </div>
                      <div style="width: 70%; padding: 5px; float: right;">
                        <?php echo $tf_fcttext_11;?>
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

  </body>
</html>
