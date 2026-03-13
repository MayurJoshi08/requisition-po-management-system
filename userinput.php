<?php
session_start(); 
if ($_SESSION['dcname']==''){header("Location:login.php");}else{
define('DB_SERVER', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');    // lanuser password
    define('DB_NAME', 'receptionlg1');

$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

}


if(isset($_GET['delete'])){
     $code = $_GET['delete'];
      mysqli_query($con,"Delete from login where code = '$code'");
      header("location: user_mst.php");
}
if($_POST['save']=="Save")
        {
                //ini_set("display_errors",1);
                //error_reporting(E_ALL);       
                if(!$con){echo"connection unsuccessfull";}
                else{
                  $code=$_POST['code'];
                  $unm=$_POST['unm'];
                  $pwd=$_POST['pwd'];
                  $type=$_POST['type'];
                
					
					 // $loc=$_POST['loc'];
               //  $cust=$_POST['cust'];
                  $qry="INSERT INTO login(`code`,`unm`,`pwd`,`type`) VALUES('$code','$unm','$pwd','$type')";
                  mysqli_query($con,$qry);
                  header("location:user_mst.php");
                  
          }
      }
if($_POST['update']=="Update")
        {
              if(!$con){echo"connection unsuccessfull";}
                else{
                    $code=$_POST['code'];
                  $unm=$_POST['unm'];
                  $pwd=$_POST['pwd'];
                  $dept=$_POST['dept'];	
                  $type=$_POST['type'];
					//  $loc=$_POST['loc'];
                  // $cust=$_POST['cust'];
                  mysqli_query($con,"Delete from login where code = '$code'");
                  $qry="INSERT INTO login(`code`,`unm`,`pwd`,`type`) VALUES('$code','$unm','$pwd','$type')";

                  mysqli_query($con,$qry);
                  header("location:user_mst.php");
                  
          }
  }

?>