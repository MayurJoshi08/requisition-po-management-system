<?php
// error_reporting(0); 
include('config.php');
session_start(); 
if ($_SESSION['dcname'] == '') {
    header("Location: login.php");
} else {
    $username = $_SESSION['dcname'];
    $type = $_SESSION['dctype'];
}

if(isset($_GET['delete'])) {
    $code = $_GET['delete'];
        mysqli_query($con, "DELETE FROM itemmst WHERE code = '$code'");
        mysqli_query($con, "DELETE FROM prod_stk WHERE code = '$code'");
        header("location: itemmstreport.php");
    }


if($_POST['save']=="Save")
			  {
								//ini_set("display_errors",1);
								//error_reporting(E_ALL);				

								//echo"connected...";	
	
								if (!$con)
								{
									
										echo"connection unsuccessfull";}
								else{
									$code=$_POST['code'];
									$name=$_POST['name'];
									$unit=$_POST['unit'];
									//$hsn=$_POST['hsn'];
									//$cgst=$_POST['cgst'];
									//$sgst=$_POST['sgst'];
									//$igst=$_POST['igst'];
									$prate=$_POST['prate'];
									$srate=$_POST['srate'];
									$opnqty=$_POST['opnqty'];
									$minqty=$_POST['minqty'];
									$dt=$_POST['dt'];
$qry="INSERT INTO `itemmst`(`code`, `name`,`size`,`type`,`unit`,`hsn`,`cgst`,`sgst`,`igst`,`prate`,`srate`,`opnqty`,`minqty`,`dt`) VALUES ('$code','$name','','','$unit','','','','','$prate','$srate','$opnqty','$minqty','$dt')";
									if(mysqli_query($con,$qry)){
									mysqli_query($con,"INSERT INTO `prod_stk`(`code`, `dt`, `icode`,`add`, `less`) VALUES ('$code','$dt','$code','$opnqty','0')");
									}
									header("location:itemmst.php");
									
					}
			}


if($_POST['update']=="Update")
{									
											
									$code=$_POST['code'];
									$name=$_POST['name'];
									$unit=$_POST['unit'];
									//$hsn=$_POST['hsn'];
									//$cgst=$_POST['cgst'];
									//$sgst=$_POST['sgst'];
									//$igst=$_POST['igst'];
									$prate=$_POST['prate'];
									$srate=$_POST['srate'];
									$opnqty=$_POST['opnqty'];
	$minqty=$_POST['minqty'];
									$dt=$_POST['dt'];
									mysqli_query($con,"Delete from itemmst where code = '$code'") ;
									mysqli_query($con,"Delete from prod_stk where code = '$code'") ;
$qry="INSERT INTO `itemmst`(`code`, `name`,`size`,`type`,`unit`,`hsn`,`cgst`,`sgst`,`igst`,`prate`,`srate`,`opnqty`,`minqty`,`dt`) VALUES ('$code','$name','','','$unit','','','','','$prate','$srate','$opnqty','$minqty','$dt')";
									if(mysqli_query($con,$qry)){
									mysqli_query($con,"INSERT INTO `prod_stk`(`code`, `dt`, `icode`, `add`, `less`) VALUES ('$code','$dt','$code','$opnqty','0')");
									}
									header("location:itemmstreport.php");
}

					?>
