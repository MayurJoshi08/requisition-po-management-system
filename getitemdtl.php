<?php 
include ('config.php');
$item=$_POST['item'];

$qry="SELECT hsn,unit,igst,cgst,sgst From itemmst where code='$item'";
			 if(mysqli_query($con,$qry)){
						$data =mysqli_query($con,$qry);
				 $response=array();
				 					   while( $row = mysqli_fetch_array($data)){
										 
				 		$response[] = array("hsn"=>$row[0],"unit"=>$row[1],"igst"=>$row[2],"cgst"=>$row[3],"sgst"=>$row[4],"itemnm"=>$row[5]);
										 
									   }
			echo json_encode($response);	 
			  
			 }
			 ?>