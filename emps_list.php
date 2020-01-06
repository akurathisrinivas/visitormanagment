<?php 
$PageTitle = 'Employees_List';
require_once ('top.php'); 

if(!empty($_GET)){
  $action=$_GET['action'];
  $id=$_GET['cid'];
  if($action == 'delete'){
    $query = "DELETE FROM employees_list WHERE row_id ='$id'";
    //echo $query;exit;
    $status_update = mysqli_query($con_signin, $query);
    $sta='Deleted';
  }
  echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully ".$sta." ');
    window.location.href='http://novaagri.in/visitormanagment/admin/emps_list.php';
    </script>");
}

?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Employees<span class="f-right">
              <a href="http://novaagri.in/visitormanagment/admin/new_emp_account.php" class="btn btn-primary">Create Employee</a>
            </span>
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
						            <th>Employee ID</th>
						            <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Action</th>
						          </tr>
                    </thead>
                    <tbody>
<?php
//echo '<pre>';print_r($_SESSION);exit;
$org_id=$_SESSION['org_id']; 
$account_id=$_SESSION['account_id'];
//echo '<pre>';print_r($account_type_id);exit;
//Get user list and display in table
//echo $con_signin;exit;
$list_users_result = mysqli_query($con_signin,"SELECT e.*,dep.dep_name,des.des_name FROM employees_list e inner join departments dep on dep.id=e.department inner join designations des on des.id=e.designation where e.org_id='".$org_id."' and e.user_id='".$account_id."'  ORDER BY `e`.`row_id` DESC");
$s_no=1;
while($row = mysqli_fetch_array($list_users_result)){

$id = $row['row_id'];
//echo '<pre>';print_r($id);exit;
$emp_name = $row['emp_name'];
$emp_id = $row['emp_id'];
$phone_no = $row['phone_no'];
$department = $row['dep_name'];
$designation = $row['des_name'];
$email = $row['email_id'];

/*$ip = $row['ip'];
$is_active = $row['is_active'];
$rank = $row['rank'];*/


if($rank == '1') {
$rank = '<span class="label label-success">Admin</span>'; 
} else if($rank == '3'){
$rank = '<span class="label label-primary">User</span>';
} else {
$rank = '<span class="label label-warning">Unknown</span>';	
}

if($is_active == '1') {
$is_active = '<span class="label label-success">Active</span>'; 
} else if($is_active == '0'){
$is_active = '<span class="label label-primary">Not Active</span>';
} else {
$rank = '<span class="label label-warning">Unknown</span>';	
}


$delete=0;
if($delete == 1){
$delete_view="<a href='emps_list.php?action=delete&cid=$id' role='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i></a>";
	}else{
$delete_view="";
	}				
				          echo "<tr>
						            <td>$s_no</td>
                        <td>$emp_id</td>
						            <td>$emp_name</td>
                        <td>$phone_no</td>
                        <td><a href='mailto:$email'>$email</a></td>
                        <td>$department</td>
                        <td>$designation</td>
                        <td>
                        <a href='edit_emp_account.php?cid=$id' role='button' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                         $delete_view
                         </td>
            					</tr>";
                      $s_no++;
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