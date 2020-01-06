<?php 
$PageTitle = 'Departments';
require_once ('top.php');
session_start();
$account_id=$_SESSION['account_id'];
$org_id=$_SESSION['org_id']; 
if(!empty($_GET)){
	$action=$_GET['action'];
	$id=$_GET['cid'];
	if($action == 'status'){
		$status=$_GET['status'];
		if($status == 1){ $new_stat=0; }else if($status == 0){ $new_stat=1; } 
		$query = "UPDATE departments SET status = '".$new_stat."'  WHERE id ='$id'";
		$status_update = mysqli_query($con_signin, $query);
		$sta='Updated';
	}else if($action == 'delete'){
		$query = "UPDATE departments SET delete_status = '0'  WHERE id ='$id'";
		$status_update = mysqli_query($con_signin, $query);
		$sta='Deleted';
	}
	echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully ".$sta." ');
    window.location.href='http://novaagri.in/visitormanagment/admin/departments.php';
    </script>");
}
?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Departments<span class="f-right">
              <a href="http://novaagri.in/visitormanagment/admin/add_departments.php" class="btn btn-primary">Create Department</a>
            </span>
            <div class="clears"></div>
          </h1>
          
        </section>
        <section class="content">
          <div class="row">
<?php
//Check Admin Rank
if($rank != 1) {
	echo "<div class='col-xs-12'>Error: You do not have permissions.</div></div></section></div>";
	include_once ('bottom.php');
	exit();
}
?>		  
            <div class="col-xs-12">
              
            
              <div class="box box-primary">

                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
						 <th>S NO</th>
						 <th>Department Name</th>
						 <th>Department ID</th>
                         <th>Status</th>
						 <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
//Get user list and display in table
//if($account_type_id>1)
	$q1="SELECT * FROM departments WHERE org_id='$org_id' AND user_id='$account_id' and delete_status='1' ORDER BY `id` desc";
//else
	//$q1="SELECT * FROM departments ORDER BY `rank` ASC";
	
$list_users_result = mysqli_query($con_signin,$q1);
$sno=1;
while($row = mysqli_fetch_array($list_users_result)){

$id = $row['id'];
$dep_name = $row['dep_name'];
$status = $row['status'];
$user_id = $row['user_id'];
$account_type_id_text="";
$dep_id= $row['id'];

if($status == '1') {
$is_active = '<a href="departments.php?action=status&cid='.$id.'&status='.$status.'" role="button" ><span class="label label-success">Active</span></a>'; 
}else if($status == '0'){
$is_active = '<a href="departments.php?action=status&cid='.$id.'&status='.$status.'" role="button" ><span class="label label-primary">Not Active</span><a>';
} else {
$rank = '<span class="label label-warning">Unknown</span>';	
}
					
				echo   "<tr>
						<td> $sno </td>
						<td>$dep_name</td>
                        <td>$dep_id</td>
						<td>$is_active</td>
						<td><a href='edit_departments.php?cid=$id' role='button' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a> 
            <a href='departments.php?action=delete&cid=$id' role='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i></a>
            </td>
                      </tr>";

      $sno++;                
}
?>					  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
<?php include_once ('bottom.php'); ?>