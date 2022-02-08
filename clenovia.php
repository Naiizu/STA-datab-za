<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(intval($_SESSION['AID'])<2)
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
                                    <h4 class="page-title"><?php echo htmlentities($_SESSION['klub']);?></h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>

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
<th>status</th>
<th>Zmenil</th>
<th>Úprava</th>
</tr>
</thead>
<tbody>

<?php

// ENCRYPT / DECRYPT

$klubId = openssl_decrypt($klub_id,$ciphering,$encryption_key);


if($_SESSION['AID']>=2){
    $query=mysqli_query($con,"select * from clenovia WHERE klub_id='$klubId' ORDER BY Meno ASC, Priezvisko ASC");
}
$rowcount=mysqli_num_rows($query);
if($rowcount==0)
{
?>
<tr>
<td colspan="4"><h4 style="color:red">Žiadny člen</h4></td>
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
<?php
  $datumPredUpravou = $row['UpdationDate'];
  $upravenyDatum = date("d.m.Y", strtotime($datumPredUpravou));
?>
<td><?php echo $upravenyDatum ?></td>
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

<td><a href="upravit-clena.php?id=<?php echo htmlentities($row['id']);?>&klub=<?php echo htmlentities($_GET['id']);?>"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a>

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
