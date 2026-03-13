<?php 
include ("config.php");
$cust=$_POST['cust'];
			 $qry="SELECT invno from cust_ac where custid='$cust' and code<>'$cust' group by custid having sum(cast(`add` as decimal)-cast(`less` as decimal)-cast(`other` as decimal)-cast(`tds` as decimal))>0";
			 if(mysqli_query($con,$qry)){
						$data =mysqli_query($con,$qry);
				 $response=array();
				 					   while( $row = mysqli_fetch_array($data)){
									$response[] = array("ainv"=>$row[0]);	  
				 					}
						echo json_encode($response);	 
			  }
				
			 ?>
