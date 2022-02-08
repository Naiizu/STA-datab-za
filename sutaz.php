<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])<1)
  {
header('location:index.php');
}
else{
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="TKD Registrácia">
        <meta name="author" content="">
        <!-- App title -->
        <title>STA DATABÁZA</title>
		<link rel="stylesheet" href="../plugins/morris/morris.css">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- Button mobile view to collapse sidebar menu -->
            <?php include('includes/topheader.php');?>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/leftsidebar.php');?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <?php
                                        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        $url_components = parse_url($url);
                                        parse_str($url_components['query'], $params);
                                        // ENCRYPT / DECRYPT //
                                        $ciphering = "AES-128-CBC";
                                        $iv_length = openssl_cipher_iv_length($ciphering);
                                        $encryption_key = "gg_tech";
                                        $klub_id = $params['id'];
                                        $deKlubId = str_replace(" ","+",$klub_id);

                                        $klubId = openssl_decrypt($deKlubId,$ciphering,$encryption_key);



                                        //
                                        $query=mysqli_query($con_reg,"select * from sutaze where id=$klubId");
                                        $row=mysqli_fetch_array($query);
                                    ?>
                                    <h4 class="page-title"><?php echo htmlentities($row['nazov']) ?></h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <h5>Organizátor</h5>
                                        <b><p><?php echo htmlentities($row['organizator']);?></p></b>

                                        <?php
                                            $DatumZaciatok = $row['datum'];
                                            $upravenyDatumZaciatok = date("d.m.Y", strtotime($DatumZaciatok));
                                            $DatumKoniec = $row['datum_koniec'];
                                            $upravenyDatumKoniec = date("d.m.Y", strtotime($DatumKoniec));
                                        ?>
                                        <h5>Dátum súťaže</h5>
                                        <?php
                                            if($DatumZaciatok != $DatumKoniec){
                                        ?>
                                        <b><p><?php echo $upravenyDatumZaciatok ?> - <?php echo $upravenyDatumKoniec ?> </p></b>
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <b><p><?php echo $upravenyDatumZaciatok ?></p></b>
                                        <?php
                                            }
                                        ?>
                                        <h5>Dátum registrácie</h5>
                                          <?php
                                          $sutazID = intval($sutaz_id);
                                          $tabulka = "_sutaz";
                                          $tabulka .= $sutazID;
                                          $regQuery = mysqli_query($con_reg,"select * from `$tabulka`");
                                          $regRow = mysqli_fetch_array($regQuery);
                                          $registraciaKoniec = date("d.m.Y", strtotime($regRow['registraciaKoniec']));
                                          $registraciaZaciatok = date("d.m.Y", strtotime($regRow['registraciaStart']));
                                              if($registraciaZaciatok != $registraciaStart){
                                          ?>
                                          <b><p><?php echo $registraciaZaciatok ?> - <?php echo $registraciaKoniec ?> </p></b>
                                          <?php
                                              }
                                              else {
                                          ?>
                                              <b><p><?php echo $registraciaZaciatok ?></p></b>
                                          <?php
                                              }
                                          ?>
                                        <h5>Kontakt</h5>
                                        <b><p><?php echo htmlentities($row['kontakt']) ?><p></b>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                      <?php
                                        if(date("Y-m-d") >= $regRow['registraciaStart'] && $regRow['registraciaKoniec'] >= date("Y-m-d")){
                                      ?>
                                        <a href="https://reg.gg-tech.eu">
                                            <button class="btn btn-success waves-effect waves-light" style="width: 9em;">Registrovať sa</button>
                                        </a>
                                        <?php
                                        }
                                        elseif(date("Y-m-d") < $regRow['registraciaStart']){
                                          $registraciaStart = date("d.m.Y", strtotime($regRow['registraciaStart']));
                                          ?>
                                          <b><p>Registrácia sa otvára <?php echo $registraciaStart ?></p></b>
                                        <?php
                                        }
                                        elseif(date("Y-m-d") > $regRow['registraciaKoniec']){
                                          $registraciaKoniec = date("d.m.Y", strtotime($regRow['registraciaKoniec']));
                                        ?>
                                        <b><p>Registrácia sa skončila <?php echo $registraciaKoniec ?></p></b>
                                      <?php } ?>
                                    </div>
                                    <p>
                                    <p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Registrované kluby</p>
                                            <?php
                                                $sutazId = intval($sutaz_id);
                                                $table = "_sutaz$sutazId";
                                                $table .= "_sutaziaci";
                                                $query=mysqli_query($con_reg,"select distinct `klub` from `$table`");
                                                $num = mysqli_num_rows($query);
                                            ?>
                                        <h2><?php echo $num?></h2>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Registrovaný súťažiaci</p>
                                        <?php
                                          $query = mysqli_query($con_reg,"select * from `$table`");
                                          $num = mysqli_num_rows($query);
                                        ?>
                                        <h2><?php echo $num?></h2>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container -->

                </div> <!-- content -->
<?php include('includes/footer.php');?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="mdi mdi-close-circle-outline"></i>
                </a>
                <h4 class="">Settings</h4>
                <div class="setting-list nicescroll">
                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Notifications</h5>
                            <p class="text-muted m-b-0"><small>Do you need them?</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">API Access</h5>
                            <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Auto Updates</h5>
                            <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Online Status</h5>
                            <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- Counter js  -->
        <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <!--Morris Chart-->
		<script src="../plugins/morris/morris.min.js"></script>
		<script src="../plugins/raphael/raphael-min.js"></script>

        <!-- Dashboard init -->
        <script src="assets/pages/jquery.dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
<?php } ?>
