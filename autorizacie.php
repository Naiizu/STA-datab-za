<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])<2)
  {
header('location:index.php');
}
else{


if(isset($_POST['confirm'])){
  $ziadatel = $_POST['ziadatel'];
  $id_clena = $_POST['id_clena'];
  $vec2 = $_POST['vec2'];
  $id = $_POST['ic'];
  $user = $_SESSION['klub'];

  $query = mysqli_query($con,"update clenovia set zmenil='$ziadatel', technicky_stupen='$vec2', autorizaciaStatus='overený' where id='$id_clena'");
  $queryTwo = mysqli_query($con,"update autorizacie set status='autorizované', autorizoval='$user' where id='$id'");

  if($query && $queryTwo){
    header('location:autorizacie.php');
  }
  else{
    $error = "Niečo sa nepodarilo";
  }
}

if(isset($_POST['decline'])){
  $id = $_POST['ic'];
  $user = $_SESSION['klub'];
  $ziadatel = $_POST['ziadatel'];
  $id_clena = $_POST['id_clena'];

  $query = mysqli_query($con,"update autorizacie set status='zamienuté', autorizoval='$user' where id='$id'");
  $queryTwo = mysqli_query($con,"update clenovia set autorizaciaStatus='overený', zmenil='$ziadatel' where id='$id_clena'");

  if($query && $queryTwo){
    header('location:autorizacie.php');
  }
  else{
    $error = "Niečo sa nepodarilo";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>STA DATABÁZA</title>

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="../plugins/morris/morris.css">

        <!-- jvectormap -->
        <link href="../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/elements.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
           <?php include('includes/topheader.php');?>

            <!-- ========== Left Sidebar Start ========== -->
           <?php include('includes/leftsidebar.php');?>


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                      <?php if($error){ ?>
                      <div class="alert alert-danger" role="alert">
                        <strong>Pozor!</strong> <?php echo htmlentities($error);?>
                      </div>
                      <?php } ?>


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">Žiadosti o autorizáciu</h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->
                        <div class="row" style="display: flex;justify-content: start;">

                                    <div class="flexbox-main">
<table class="table table-colored table-centered table-inverse m-0">
<thead>
<tr>

<th style="width: 15%;">IČ</th>
<th>Vec</th>
<th>Žiadateľ</th>
<th style="width: 20%;">dátum žiadosti</th>
<th style="width: 10%;"></th>
</tr>
</thead>
<tbody>

<?php
$query=mysqli_query($con,"select * from autorizacie WHERE status='potrebná autorizácia'");
$rowcount=mysqli_num_rows($query);
if($rowcount==0)
{
?>
<tr>
<td colspan="4" style="text-align: left;"><h4 style="color:darkblue">Žiadna žiadosť</h3></td>
<tr>
<?php
} else {
while($row=mysqli_fetch_array($query))
{
?>
 <tr>
<td><b>#<?php echo htmlentities($row['id']);?></b></td>
<td><?php echo htmlentities($row['typ']);?></td>
<td><?php echo htmlentities($row['ziadatel']);?></td>
<td><?php echo htmlentities($row['datum']);?></td>
<td><a href="autorizacie.php?id=<?php echo htmlentities($row['id']);?>"<button class="btn btn-info waves-effect waves-light">Info</button></a></td>
 </tr>
<?php } }?>
<?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                      $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                      $url_components = parse_url($url);
                                      parse_str($url_components['query'], $params);
                                      $autorizacia_id=$params['id'];

                                      if(isset($autorizacia_id)) {
                                    ?>
                                    <div class="flexbox-minor">
                                      <?php
                                        $query=mysqli_query($con,"select * from autorizacie where id='$autorizacia_id'");
                                        while($row=mysqli_fetch_array($query)){
                                        ?>
                                          <form name="upravit-clena" method="post">
                                            <div class="form-group m-b-20" style="display: inline-block;float: left;">
                                              <label>Číslo žiadosti</label>
                                                <input type="text" class="form-control" id="ic" value="<?php echo htmlentities($_GET['id']);?>" name="ic" placeholder="" required readonly>
                                              <label for="exampleInputEmail1">Požiadavka</label>
                                                <input type="text" class="form-control" id="typ" value="<?php echo htmlentities($row['typ']);?>" name="typ" placeholder="" required readonly>
                                            </div>
                                            <div class="form-group m-b-20" style="display: inline-block;float: right;">
                                              <label for="exampleInputEmail1">Žiadateľ</label>
                                                <input type="email" class="form-control" id="ziadatel" value="<?php echo htmlentities($row['ziadatel']);?>" name="ziadatel" placeholder="" required readonly>
                                              <label for="exampleInputEmail1">Dátum podania žiadosti</label>
                                                <?php
                                                  $datumPredUpravou = $row['datum'];
                                                  $upravenyDatum = date("d.m.Y", strtotime($datumPredUpravou));
                                                ?>
                                                <input type="text" class="form-control" id="datum" value="<?php echo $upravenyDatum;?>" name="datum" placeholder="" required readonly>
                                            </div>
                                            <h4>Informácie o autorizácii</h4>
                                            <div class="form-group m-b-20" style="display: inline-block;float: left;">
                                              <label>Meno</label>
                                              <input type="text" class="form-control" id="meno" value="<?php echo htmlentities($row['meno'])?>" name="meno" readonly>
                                              <?php
                                                $id_clena = $row['id_clena'];
                                              ?>
                                              <input type="text" class="form-control" id="id_clena" value="<?php echo htmlentities($id_clena);?>" name="id_clena" readonly>

                                              <label>Klub</label>
                                              <?php
                                                $queryTwo = mysqli_query($con,"select * from clenovia where id='$id_clena'");
                                                $rowTwo = mysqli_fetch_array($queryTwo);

                                                $klubId = $rowTwo['klub_id'];
                                                $queryThree = mysqli_query($con,"select * from tbladmin where id='$klubId'");
                                                $rowThree = mysqli_fetch_array($queryThree);
                                              ?>
                                              <input type="text" class="form-control" id="klub" value="<?php echo htmlentities($rowThree['klub'])?>" name="klub" readonly>

                                              <label class="" for="exampleInputEmail1">Aktuálny tech. stupeň</label>
                                              <input type="text" class="form-control" id="vec1" value="<?php echo htmlentities($rowTwo['technicky_stupen'])?>" name="vec1" readonly>

                                              <label class="" for="vec2">Žiadaný tech. stupeň</label>
                                              <input type="text" class="form-control" id="vec2" value="<?php echo htmlentities($row['vec2']);?>" name="vec2" readonly>
                                        <?php } ?>
                                        <a href="autorizacie.php">
                                          <button type="submit" name="confirm" class="btn btn-success waves-effect waves-light" style="margin-top:1rem;">Potvrdiť</button>
                                        </a>
                                        <a href="autorizacie.php">
                                          <button type="submit" name="decline" class="btn btn-danger waves-effect waves-light" style="margin-top:1rem;">Zamietnuť</button>
                                        </a>
                                        </div>
                                      </form>
                                        <?php
                                        }
                                      ?>

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

        <!-- CounterUp  -->
        <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <!--Morris Chart-->
		<script src="../plugins/morris/morris.min.js"></script>
		<script src="../plugins/raphael/raphael-min.js"></script>

        <!-- Load page level scripts-->
        <script src="../plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="../plugins/jvectormap/gdp-data.js"></script>
        <script src="../plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>


        <!-- Dashboard Init js -->
		<script src="assets/pages/jquery.blog-dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
