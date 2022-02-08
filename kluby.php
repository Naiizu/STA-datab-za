<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])<2)
  {
header('location:index.php');
}
else{

if($_GET['action']='del')
{
$id=intval($_GET['id']);

$query_kontrola=mysqli_query($con,"select * from tbladmin WHERE id='$id'");
while($row_kontrola=mysqli_fetch_array($query_kontrola))
{
$aid=$row_kontrola['AID'];
}

if($aid<=$_SESSION['AID']){
$query=mysqli_query($con,"DELETE FROM tbladmin where id='$id'");
}
}
if($query)
{
$msg="Klub bol vymazaný";
} else {
$error="Niečo sa nepodarilo, prosím skúste to znova.";
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
                                    <h4 class="page-title">STA kluby</h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-sm-12">
                            <?php if($_SESSION['AID']>=3){
                                ?>
                                <div class="card-box">
                                  <div class="">
                                  <a href="pridat-klub.php">
                                  <button class="btn btn-success waves-effect waves-light">Pridať klub <i class="mdi mdi-plus-circle-outline" ></i></button>
                                  </a>
                                   </div>
                                <?php
                                }
                                ?>

                                    <div class="table-responsive">
<table class="table table-colored table-centered table-inverse m-0">
<thead>
<tr>

<th>Klub</th>
<th>Počet členov</th>
<th>e-mail</th>
<?php if($_SESSION['AID']>=2){
    ?>
<th>ID</th>
<th>Úprava</th>
<?php
}
    ?>
</tr>
</thead>
<tbody>

<?php
$query=mysqli_query($con,"select * from tbladmin WHERE AID=1 ORDER BY AdminUserName ASC;");
$rowcount=mysqli_num_rows($query);
if($rowcount==0)
{
?>
<tr>
<td colspan="4" style="text-align: center;"><h3 style="color:red">Žiadny klub</h3></td>
<tr>
<?php
} else {
while($row=mysqli_fetch_array($query))
{
?>
<?php
$idd=$row['id'];
$query_pocet=mysqli_query($con,"select * from clenovia WHERE klub_id='$idd'");
$pocet=mysqli_num_rows($query_pocet);
?>
 <tr>
<td><b><?php echo htmlentities($row['klub']);?></b></td>
<td><?php echo htmlentities($pocet);?></td>
<td><?php echo htmlentities($row['AdminEmailId'])?></td>
<?php if($_SESSION['AID']>=2){
    ?>
<td>#<?php echo htmlentities($row['id']);?></td>

<td>

    <?php
    // ENCRYPT / DECRYPT //
      $ciphering = "AES-128-CBC";
      $iv_length = openssl_cipher_iv_length($ciphering);
      $encryption_key = "gg_tech";

      $klubId = openssl_encrypt($row['id'],$ciphering,$encryption_key);


    ?>
    <a href="clenovia.php?id=<?php echo $klubId;?>"><i class="fa fa-user-o" aria-hidden="true" title="Členovia klubu"></i></a>
    &nbsp;
    <a href="kluby.php?id=<?php echo htmlentities($row['id']);?>&&action=del" onclick="return confirm('Naozaj vymazať klub?')"> <i class="fa fa-trash-o" style="color: #f05050" title="Vymazať klub"></i></a>
    </td>
<?php
}
    ?>
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
