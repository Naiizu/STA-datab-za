<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(intval($_SESSION['AID'])<2)
  {
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$klub=$_POST['klub'];
$meno=$_POST['meno'];
$heslo=password_hash($_POST['heslo'],PASSWORD_DEFAULT);
$mheslo = $_POST['heslo'];
$email=$_POST['email'];
$query=mysqli_query($con,"insert into tbladmin(klub,AdminUserName,AdminPassword,AdminEmailId) values('$klub','$meno','$heslo','$email')");

$to = $_POST['email'];
$from = "noreply@gg-tech.eu";
$klub = $_POST['klub'];
$prihlmeno = $_POST['meno'];

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: noreply@gg-tech.eu" . "\r\n" .
"Reply-To: helpdesk@gg-tech.eu" . "\r\n" .
"X-Mailer: PHP/" . phpversion();

$subject = "Registrácia v STA databáze";
$cmessage = "Zdravím, Váš klub bol pridaný do databáze Slovenskej Taekwon-do Aliancie. Na prihlásenie prosím použite údaje uvedené nižšie. Odporúčame si heslo zmeniť po prvom prihlásení z bezpečnostných dôvodov.";
$footer = "Všetky technické problémy smerujte na mail: <strong>helpdesk@gg-tech.eu</strong>";
$footers = "Ďakujeme :)";

$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
$body .= "<table style='width: 100%;'>";
$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
$body .= "</td></tr></thead><tbody>";
$body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
$body .= "<tr>";
$body .= "<td style='border:none;'><strong>webová adresa:</strong> <a href='https://sta.gg-tech.eu'>https://sta.gg-tech.eu</a></td>";
$body .= "</tr><tr>";
$body .= "<tr>";
$body .= "<td style='border:none;'><strong>Prihlasovacie meno:</strong> {$meno}</td>";
$body .= "</tr><tr>";
$body .= "<td style='border:none;'><strong>Prihlasovacie heslo:</strong> {$mheslo}</td>";
$body .= "</tr>";
$body .= "<tr>";
$body .= "<td style='border:none;'><br>{$footer}<br>{$footers}</td>";
$body .= "</tr>";
$body .= "</tbody></table>";
$body .= "</body></html>";

if($query)
{
$msg="Klub bol pridaný";
mail($to, $subject, $body, $headers);
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
                                    <h4 class="page-title">Pridať Klub</h4>
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
header('location:kluby.php');
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
                        					<form class="form-horizontal" name="moderator" method="post" id="contactForm">
	                                            <div class="form-group">
	                                                <label class="col-md-2 control-label">Klub</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="klub" required>
	                                                </div>
	                                            </div>
                                              <div class="form-group">
	                                                <label class="col-md-2 control-label">Prihlasovacie meno</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="meno" required>
	                                                </div>
	                                            </div>
                                                <?php
                                                  function password_generate($chars){
                                                    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz%';
                                                    return substr(str_shuffle($data), 0, $chars);
                                                  }
                                                  $heslo = password_generate(7);
                                                ?>
                                              <div class="form-group">
	                                                <label class="col-md-2 control-label">Heslo</label>
	                                                <div class="col-md-10">
	                                                    <input type="password" class="form-control" value="<?php echo $heslo ?>" name="heslo" required readonly>
	                                                </div>
	                                            </div>
                                              <div class="form-group">
	                                                <label class="col-md-2 control-label">e-mail</label>
	                                                <div class="col-md-10">
	                                                    <input type="text" class="form-control" value="" name="email" required>
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
