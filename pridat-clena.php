<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(intval($_SESSION['AID'])<1)
  {
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$klub_id=$_SESSION['klub_id'];
$meno=$_POST['meno'];
$priezvisko=$_POST['priezvisko'];
$datum_narodenia=$_POST['datum_narodenia'];
$technicky_stupen=$_POST['technicky_stupen'];
$zmenil=$_SESSION['klub'];
$query=mysqli_query($con,"insert into clenovia(klub_id,Meno,Priezvisko,datum_narodenia,technicky_stupen,zmenil) values('$klub_id','$meno','$priezvisko','$datum_narodenia','$technicky_stupen','$zmenil')");
if($query)
{
$msg="Klub bol pridaný";
}
else{
$error="Niečo bolo zlé, prosím skúste to znova.";
}
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>STA DATABÁZA</title>

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

<!-- Top Bar Start -->
 <?php include('includes/topheader.php');?>
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
           <?php include('includes/leftsidebar.php');?>
 <!-- Left Sidebar End -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">Pridať Člena</h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">



<div class="row">
<div class="col-sm-6">
<!---Success Message--->
<?php if($msg){
header('location:klub.php');
}?>

<!---Error Message--->
<?php if($error){ ?>
<div class="alert alert-danger" role="alert">
<strong>Oh snap!</strong> <?php echo htmlentities($error);?> | Odfoť to Dávidovi nech to opraví :)</div>
<?php } ?>


</div>
</div>
                        			<div class="row">
                        				<div class="col-md-6">
                        					<form class="form-horizontal" name="moderator" method="post">
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label">Meno</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="meno" required>
	                                                </div>
	                                            </div>
                                              <div class="form-group">
	                                                <label class="col-md-2 control-label">Priezvisko</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="priezvisko" required>
	                                                </div>
	                                            </div>
                                                <div class="form-group">
	                                                <label class="col-md-2 control-label">Dátum Narodenia</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="datum_narodenia" placeholder="DD.MM.RRRR" required>
	                                                </div>
	                                            </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="exampleInputEmail1">Technický stupeň</label>
                                                    <div class="col-md-10">
                                                    <select class="form-control" name="technicky_stupen" id="category" onChange="getSubCat(this.value);" required>
                                                    <option value="">-----</option>
                                                    <?php
                                                        // Feching active categories
                                                    $ret=mysqli_query($con,"select id,Category from  tblcategory");
                                                    while($result=mysqli_fetch_array($ret))
                                                    {
                                                    ?>
                                                    <option value="<?php echo htmlentities($result['Category']);?>"><?php echo htmlentities($result['Category']);?></option>
                                                    <?php } ?>
                                                    </select>
                                                    </div>
                                                    </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">&nbsp;</label>
                                                    <div class="col-md-10">
                                                <a href="kluby.php">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                                    Pridať
                                                </button>
                                                </a>
                                                    </div>
                                                </div>

	                                        </form>
                        				</div>


                        			</div>











                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->

<?php include('includes/footer.php');?>

            </div>
        </div>

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

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
<?php } ?>
