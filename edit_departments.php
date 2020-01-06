<?php 
$PageTitle = 'Departments';
require_once ('top.php');
session_start();
$account_id=$_SESSION['account_id'];
$org_id=$_SESSION['org_id'];
//echo '<pre>';print_r($_SESSION);exit;
//$org_id=$account_type_id;
$cid=$_GET['cid'];
$query="select * from departments where id='$cid' and delete_status='1' ";
$qry_record = mysqli_query($con_signin, $query);
$record = mysqli_fetch_assoc($qry_record);
//echo '<pre>';print_r($record);exit;
?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Update Department
          </h1>
        </section>
        <section class="content">
<?php
//Check Admin Rank
if($rank != 1) {
	echo "<div class='col-xs-12'>Error: You do not have permissions.</div></div></section></div>";
	include_once ('bottom.php');
	exit();
}

if (isset($_POST['new_dep'])){ 

//Grab and clean data
//$dep_name = stripslashes(htmlspecialchars($_POST['dep_name'], ENT_QUOTES));
//Sanitize Data
//$dep_name = sanitize_sql_string($dep_name);
$dep_name=$_POST['dep_name'];
$id=$_POST['id'];
$check_qry="select * from departments where dep_name='$dep_name' and org_id='$org_id' and user_id='$account_id'  and delete_status='1' and id!='$id' ";
$check_usrnow = mysqli_query($con_signin, $check_qry);
$row = mysqli_fetch_assoc($check_usrnow);
//echo '<pre>';print_r($row);exit;
//Check for Email
if(!empty($row)) {
	echo '<div class="col-xs-12"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Department name already exists.
                  </div>
                  <button type="submit" class="btn btn-warning" >
                  <a href="http://novaagri.in/visitormanagment/admin/edit_departments.php?cid='.$id.'"><i class="fa fa-reply"></i> Back</a>
                  </button>
                  </div></section></div>';
	include_once ('bottom.php');
	exit();
}



//Hash Password
//$emp_designation = md5($emp_designation);

//Insert User
$modified_on=date('Y-m-d H:i:s');

$sql_insert_dep = " UPDATE departments SET dep_name = '$dep_name',modified_on='$modified_on' WHERE id ='$id'";//exit;
//echo $sql_insert_dep;exit;
$sql_insert_usrnow = mysqli_query($con_signin, $sql_insert_dep);

if($sql_insert_usrnow) {
	echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                     Department updated sucessfully.
                  </div>';
//Report to Logs
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'Department $dep_name created', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
echo '<br /><a href="departments.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';
echo '</div></div>
        </section>
      </div>';
	include_once ('bottom.php');
	exit();		  
} else {
	echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    An Error occurred, contact support.
                  </div>';
//Report to Logs
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'User Failed to create $dep_name', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
	}
  
}
?>
      <div class="row">
		  <div class="col-md-6">
		  <div class="box box-primary">
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="box-body">
				  <br /><h4>
<?php $rdep_name=$record['dep_name'];
echo "<label>Department Name:</label> <br /><input type='text' name='dep_name' class='form-control' autofocus required value='$rdep_name'>
<input type='hidden' name='id' class='form-control' autofocus required value='$cid'><br />";
?>	
<!--<label>Active</label>
                      <select class="form-control" name="usr_is_active">
                        <option value="1" selected>Active Account</option>
						<option value="0">Not Active Account</option>
					  </select>
					  <br />
<label>Rank Type</label>
                      <select class="form-control" name="usr_rank">
                      <option value="1">Admin</option>
					  <option value="3" selected>User</option>

					  </select>	-->				  
</h4>				 
<br /><br />
<input type="text" name="new_dep" value="create_newemp" hidden>
                   <button type="submit" class="btn btn-warning" ><a href="http://novaagri.in/visitormanagment/admin/departments.php"><i class="fa fa-reply"></i> Back</a></button> <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Department</button>
                  </div></div>
                </form>
          </div>
        </section>
      </div>
<?php include_once ('bottom.php'); ?>