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

        <title>STA DATABÁZA</title>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

    </head>


    <body class="fixed-left">

        <div id="wrapper">

            <div class="topbar">

            <?php include('includes/topheader.php');?>
            </div>

    <?php include('includes/leftsidebar.php');?>

            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <?php
                                        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        $url_components = parse_url($url);
                                        parse_str($url_components['query'], $params);

                                        // ENCRYPT / DECRYPT

                                        $klubId = openssl_decrypt($deKlubId,$ciphering,$encryption_key);

                                        $query=mysqli_query($con_reg,"select * from sutaze where id=$klubId");
                                        $row=mysqli_fetch_array($query);
                                    ?>
                                    <h4 class="page-title"><?php echo htmlentities($row['nazov']) ?></h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>


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

                    </div>

                </div>
<?php include('includes/footer.php');?>

            </div>
            

        </div>



        <script>
            var resizefunc = [];
        </script>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/pages/jquery.dashboard.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
<?php } ?>
