<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])<3) {
header('location:index.php');
} else {

if($_GET['action']='del') {
    $id=intval($_GET['id']);

    $query_kontrola=mysqli_query($con,"select * from tbladmin WHERE id='$id'");
    while($row_kontrola=mysqli_fetch_array($query_kontrola)) {
        $aid=$row_kontrola['AID'];
    }

    if($aid<=$_SESSION['AID']){
        $query=mysqli_query($con,"DELETE FROM tbladmin where id='$id'");
    }
}
if($query) {
$msg="Klub bol vymazaný";
} else {
    $error="Niečo sa nepodarilo, prosím skúste to znova.";
}
?>

<!DOCTYPE html>
<html>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>


    <body class="fixed-left">

        <div id="wrapper">

           <?php include('includes/topheader.php');?>

           <?php include('includes/leftsidebar.php');?>

            <div class="content-page">
                <div class="content">
                    <div class="container">


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">Administrátori</h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                  <div class="">
                                  <a href="pridat-klub.php">
                                  <button class="btn btn-success waves-effect waves-light">Pridať Administrátora <i class="mdi mdi-plus-circle-outline" ></i></button>
                                  </a>
                                   </div>

                                    <div class="table-responsive">
<table class="table table-colored table-centered table-inverse m-0">
<thead>
<tr>

<th>Administrátor</th>
<th>Prihlasovacie meno</th>
<th>ID</th>
<th>e-mail</th>
<th>Úprava</th>
</tr>
</thead>
<tbody>

<?php
$query=mysqli_query($con,"select * from tbladmin WHERE AID>=2");
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
 <tr>
<td><b><?php echo htmlentities($row['klub']);?></b></td>
<td><?php echo htmlentities($row['AdminUserName']);?></td>
<td>#<?php echo htmlentities($row['id']);?></td>
<td><?php echo htmlentities($row['AdminEmailId'])?></td>

<td>
    <a href="administratori.php?id=<?php echo htmlentities($row['id']);?>&&action=del" onclick="return confirm('Naozaj vymazať klub?')"> <i class="fa fa-trash-o" style="color: #f05050" title="Vymazať Administrátora"></i></a>
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

		<script src="assets/pages/jquery.blog-dashboard.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
