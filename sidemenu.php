<?php

if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
	include('config.php');
}

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>

<aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color:#ffffff;">
    <!-- Brand Logo -->
    <img src="img/zetts_cosmetics_logo.jpg" style="width:180px;height:180px;margin-left:35px;margin-top:6px">
  <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!--<div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>-->
        <div class="info">
          <a href="#" class="d-block" style="font-size:20px;font-weight:bold;color:black">Welcome <?php echo $username; ?></a>
        </div>
      </div>

     
      <!-- Sidebar Menu -->
		 
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link" id="index">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
           
          </li>
	 	<li class="nav-item" id="masters" >
				<a href="#" class="nav-link" id="mastera" >
              <i class="nav-icon fas fa-file"></i>
              <p>
              Masters
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
		<ul class="nav nav-treeview">
			<li class="nav-item" >
            <a href="vendormstreport.php" class="nav-link" id="vendortmst">
              <i class="far fa-circle nav-icon"></i>
              <p>
             Vendor Master
              </p>
            </a>
			</li>
			<!--<li class="nav-item" >
            <a href="supmstreport.php" class="nav-link" id="supmst">
              <i class="far fa-circle nav-icon"></i>
              <p>
             Supplier Master
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="itemmstreport.php" class="nav-link" id="itemmst">
              <i class="far fa-circle nav-icon"></i>
              <p>
              Item Master
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="bank_report.php" class="nav-link" id="bankmst">
              <i class="far fa-circle nav-icon"></i>
              <p>
              Bank Master
              </p>
            </a>
			</li>-->
			<?php if($type=='admin'){?>
			<li class="nav-item" >
            <a href="user_mst.php" class="nav-link" id="usermst">
              <i class="far fa-circle nav-icon"></i>
              <p>
              User Master
              </p>
            </a>
			</li>
			<?php }?>
		   		</ul>
			</li>
			
			<li class="nav-item" id="entry" >
				<a href="#" class="nav-link" id="entrya" >
              <i class="nav-icon fas fa-file"></i>
              <p>
              Entries
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
		<ul class="nav nav-treeview">
			
           <li class="nav-item" >
            <a href="reqentry.php" class="nav-link" id="reqentry">
             <i class="far fa-circle nav-icon"></i>
              <p>
              Requisition Entry
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="poentry.php" class="nav-link" id="poentry">
            <i class="far fa-circle nav-icon"></i>
              <p>
              PO Entry
              </p>
            </a>
			</li>

      <!--<li class="nav-item" >
            <a href="inventry.php" class="nav-link" id="inventry">
            <i class="far fa-circle nav-icon"></i>
              <p>
             	Invoice Entry
              </p>
            </a>
			</li>
		
			<li class="nav-item" >
            <a href="payment.php" class="nav-link" id="payentry">
             <i class="far fa-circle nav-icon"></i>
              <p>
              Payment Entry
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="receiptentry.php" class="nav-link" id="rcptentry">
            <i class="far fa-circle nav-icon"></i>
              <p>
              Receipt Entry
              </p>
            </a>
			</li>
			-->
			</ul>
			</li>
			
		<li class="nav-item" id="reports" >
				<a href="#" class="nav-link" id="reportsa" >
              <i class="nav-icon fas fa-file"></i>
              <p>
              Reports
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
		<ul class="nav nav-treeview">
			<li class="nav-item" >
            <a href="reqsearch.php" class="nav-link" id="reqreport">
            <i class="far fa-circle nav-icon"></i>
              <p>
              Requisition Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="posearch.php" class="nav-link" id="salereport">
            <i class="far fa-circle nav-icon"></i>
              <p>
              Po Report 
              </p>
            </a>
			</li>

      <!--<li class="nav-item" >
            <a href="invreport.php" class="nav-link" id="invreport">
            <i class="far fa-circle nav-icon"></i>
              <p>
             	Invoice Report
              </p>
            </a>
			</li>
      <li class="nav-item" >
            <a href="masterreport.php" class="nav-link" id="mstreport">
            <i class="far fa-circle nav-icon"></i>
              <p>
             	Master Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="paymentsearch.php" class="nav-link" id="payreport">
             <i class="far fa-circle nav-icon"></i>
              <p>
              Payment Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="receiptsearch.php" class="nav-link" id="rcptreport">
            <i class="far fa-circle nav-icon"></i>
              <p>
              Receipt Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="expreport.php" class="nav-link" id="expreport">
            <i class="far fa-circle nav-icon"></i>
              <p>
             	Expense Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="debtors.php" class="nav-link" id="debtreport">
           <i class="far fa-circle nav-icon"></i>
              <p>
              Debtors Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="creditors.php" class="nav-link" id="creditreport">
           <i class="far fa-circle nav-icon"></i>
              <p>
              Creditors Report
              </p>
            </a>
			</li>
			<li class="nav-item" >
            <a href="stockreport.php" class="nav-link" id="stkreport">
           <i class="far fa-circle nav-icon"></i>
              <p>
              Stock Report
              </p>
            </a>
			</li>-->
			</ul>
			</li>
			 
			
			
      	<li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-circle text-danger"></i>
               Logout
           	
            </a>
			</li>
			</ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>