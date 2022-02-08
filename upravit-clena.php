<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(intval($_SESSION['AID'])<2)
  {
header('location:index.php');
}
else{
if(isset($_POST['update']))
{

$technicky_stupen=$_POST['technicky_stupen'];
$id=$_POST['ic'];
$zmenil=$_SESSION['klub'];
$meno=$_POST['meno'];
$meno .= " ";
$meno .= $_POST['priezvisko'];
$query=mysqli_query($con,"insert into autorizacie set typ='zmena tech. stupňa', ziadatel='$zmenil',meno='$meno', id_clena='$id', vec1='$techStupenPred', vec2='$technicky_stupen', status='potrebná autorizácia'");
$queryTwo = mysqli_query($con,"update clenovia set autorizaciaStatus='overuje sa...' where id='$id'");
if($query && $queryTwo)
{
$msg="Člen upravený";
}
else{
$error="Niečo sa nepodarilo";
}

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
                                    <h4 class="page-title">Úprava Člena</h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

<div class="row">
<div class="col-sm-6">
<!---Success Message--->
<?php if($msg){
    if($_SESSION['AID']==1){
        header('location:klub.php');
    }
    elseif($_SESSION['AID']>1){
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        $ids=$params['klub'];
        header("location:clenovia.php?id=$ids");
    }
}?>

<!---Error Message--->
<?php if($error){ ?>
<div class="alert alert-danger" role="alert">
  <strong>Pozor!</strong> <?php echo htmlentities($error);?>
</div>
<?php } ?>


</div>
</div>

<?php
$id=intval($_GET['id']);
$query=mysqli_query($con,"select * from clenovia WHERE id='$id'");
while($row=mysqli_fetch_array($query))
{
$ids=$_GET['klub_id'];
?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <form name="upravit-clena" method="post">
 <div class="form-group m-b-20">
 <label>IČ</label>
 <input type="text" class="form-control" id="ic" value="<?php echo htmlentities($_GET['id']);?>" name="ic" placeholder="" required readonly>
<label for="exampleInputEmail1">Meno</label>
<input type="text" class="form-control" id="meno" value="<?php echo htmlentities($row['Meno']);?>" name="meno" placeholder="" required readonly>
</div>

<div class="form-group m-b-20">
<label for="exampleInputEmail1">Priezvisko</label>
<input type="email" class="form-control" id="priezvisko" value="<?php echo htmlentities($row['Priezvisko']);?>" name="priezvisko" placeholder="" required readonly>
</div>

<div class="form-group m-b-20">
<label for="exampleInputEmail1">Dátum Narodenia</label>
<?php
  $datumPredUpravou = $row['datum_narodenia'];
  $upravenyDatum = date("d.m.Y", strtotime($datumPredUpravou));
?>
<input type="text" class="form-control" id="priezvisko" value="<?php echo $upravenyDatum;?>" name="datum_narodenia" placeholder="" required readonly>
</div>

<div class="form-group m-b-20">
                                                    <label class="" for="exampleInputEmail1">Technický stupeň</label>
                                                    <div class="">
                                                    <select class="form-control" name="technicky_stupen" id="category" onChange="getSubCat(this.value);" required>
                                                    <option value="<?php echo htmlentities($row['technicky_stupen']);?>"><?php echo htmlentities($row['technicky_stupen']);?></option>
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


<?php } ?>
<a href="klub.php">
<button type="submit" name="update" class="btn btn-success waves-effect waves-light">Upraviť</button>
</a>
</form>

                                    </div>
                                </div> <!-- end p-20 -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->



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

        <!-- Jquery filer js -->
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

        <!-- page specific js -->
        <script src="assets/pages/jquery.blog-add.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script>

            jQuery(document).ready(function(){

                $('.summernote').summernote({
                    height: 240,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                 // set focus to editable area after initializing summernote
                });
                // Select2
                $(".select2").select2();

                $(".select2-limiting").select2({
                    maximumSelectionLength: 2
                });
            });
        </script>
  <script src="../plugins/switchery/switchery.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>



    </body>
</html>
<?php } ?>
