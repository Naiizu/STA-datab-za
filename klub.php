<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(intval($_SESSION['AID'])!=1)
  {
header('location:index.php');
}
else{

if($_GET['action']='del')
{
$id=intval($_GET['id']);
$query=mysqli_query($con,"DELETE FROM clenovia where id='$id'");
}
if($query)
{
$msg="Člen bol vymazaný";
} else {
$error="Niečo sa nepodarilo, prosím skúste to znova.";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

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


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title"><?php echo htmlentities($_SESSION['klub']);?></h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->




                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                 <?php if($_SESSION['AID']<2){
                                    ?>
                                  <div class="">
                                  <a href="pridat-clena.php">
                                  <button class="btn btn-success waves-effect waves-light">Pridať člena <i class="mdi mdi-plus-circle-outline" ></i></button>
                                  </a>
                                   </div>
                                   <?php
                                   }
                                   ?>

                                    <div class="table-responsive">
<table class="table table-colored table-centered table-inverse m-0">
<thead>
<tr>

<th>IČ</th>
<th>Meno</th>
<th>Priezvisko</th>
<th>Dátum Narodenia</th>
<th>Technický stupeň</th>
<th>Posledná zmena</th>
<th>Status</th>
<th>Zmenil</th>
<th>Úprava</th>
</tr>
</thead>
<tbody>

<?php
$id=intval($_SESSION['id']);
if($_SESSION['AID']>=2){
    $query=mysqli_query($con,"select * from clenovia");
}
else {
$query=mysqli_query($con,"select * from clenovia where klub_id=$id");
}
$rowcount=mysqli_num_rows($query);
if($rowcount==0)
{
?>
<tr>
<td colspan="4" style="text-align: left;"><h4 style="color:darkblue">Žiadny člen</h3></td>
<tr>
<?php
} else {
while($row=mysqli_fetch_array($query))
{
?>
 <tr>
<td><b>#<?php echo htmlentities($row['id']);?></b></td>
<td><?php echo htmlentities($row['Meno'])?></td>
<td><?php echo htmlentities($row['Priezvisko'])?></td>
<?php
  $datumPredUpravou = $row['datum_narodenia'];
  $upravenyDatum = date("d.m.Y", strtotime($datumPredUpravou));
?>
<td><?php echo $upravenyDatum?></td>
<td><?php echo htmlentities($row['technicky_stupen'])?></td>
<td><?php echo htmlentities($row['UpdationDate']) ?></td>
<?php
  if($row['autorizaciaStatus']=='overuje sa...'){
    $farbaOverenie = 'color: orange;';
  }
  elseif($row['autorizaciaStatus']=='overený'){
    $farbaOverenie = 'color: green;';
  }
  elseif($row['autorizaciaStatus']=='neoverený'){
    $farbaOverenie = 'color: red;';
  }
?>
<td style="<?php echo $farbaOverenie ?>"><?php echo htmlentities($row['autorizaciaStatus'])?></td>
<td><?php echo htmlentities($row['zmenil'])?></td>

<td>
    <a href="klub.php?id=<?php echo htmlentities($row['id']);?>&&action=del" onclick="return confirm('Naozaj vymazať člena?')"> <i class="fa fa-trash-o" style="color: #f05050" title="Vymazať člena"></i></a>
</td>
 </tr>
<?php } }?>
<?php } ?>

                                            </tbody>
                                        </table>
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
