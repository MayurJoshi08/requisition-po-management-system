<?php
// error_reporting(0); 
include('config.php');
//session_start(); 
if ($_SESSION['dcname'] == '') {
    header("Location: login.php");
} else {
    $username = $_SESSION['dcname'];
    $type = $_SESSION['dctype'];
}

	if(isset($_GET['delete'])){
		 
			$code = $_GET['delete'];

			mysqli_query($con,"Delete from vendormst where code = '$code'") ;
			header("location: vendormstreport.php");
}

if($_POST['save']=="Save")
			  {
								ini_set("display_errors",1);
								error_reporting(E_ALL);				

								//echo"connected...";	
	
								if (!$con)
								{
									
										echo"connection unsuccessfull";}
								else{
									$code=$_POST['code'];
									$name=$_POST['name'];
									$adrs=$_POST['adrs'];
									$city=$_POST['city'];
									$pincode=$_POST['pincode'];
									$state=$_POST['state'];
									//$stcode=$_POST['stcode'];
									$email=$_POST['email'];
									$mobile=$_POST['mobile'];
									//$opnbal=$_POST['opnbal'];
									//$cinno=$_POST['cinno'];
									//$gstinno=$_POST['gstinno'];
$qry="INSERT INTO `vendormst`(`code`, `name`,`adrs`,`city`,`pincode`,`state`,`email`,`mobile`) VALUES ('$code','$name','$adrs','$city','$pincode','$state','$email','$mobile')";
									
                                    mysqli_query($con, $qry);
									header("location:vendormst.php");
					}
			}


if($_POST['update']=="Update")
{									
											
									$code=$_POST['code'];
									$name=$_POST['name'];
									$adrs=$_POST['adrs'];
									$city=$_POST['city'];
									$pincode=$_POST['pincode'];
									$state=$_POST['state'];
									//$stcode=$_POST['stcode'];
									$email=$_POST['email'];
									$mobile=$_POST['mobile'];
									//$opnbal=$_POST['opnbal'];
									//$cinno=$_POST['cinno'];
									//$gstinno=$_POST['gstinno'];
									mysqli_query($con,"Delete from vendormst where code = '$code'") ;
$qry="INSERT INTO `vendormst`(`code`, `name`,`adrs`,`city`,`pincode`,`state`,`email`,`mobile`) VALUES ('$code','$name','$adrs','$city','$pincode','$state','$email','$mobile')";
									
mysqli_query($con, $qry);
									header("location:vendormstreport.php");
}

					?>
