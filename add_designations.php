<?php 
$PageTitle = 'Designations';
require_once ('top.php');
session_start();
$account_id=$_SESSION['account_id'];
$org_id=$_SESSION['org_id'];
//echo '<pre>';print_r($_SESSION);exit;
//$org_id=$account_type_id;

?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Create Designation
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

if (isset($_POST['new_des'])){ 

//Grab and clean data
$name = stripslashes(htmlspecialchars($_POST['des_name'], ENT_QUOTES));
//Sanitize Data
$des_name = sanitize_sql_string($name);

$check_qry="select * from designations where des_name='$des_name' and org_id='$org_id' and user_id='$account_id'  and delete_status='1' ";
$check_usrnow = mysqli_query($con_signin, $check_qry);
$row = mysqli_fetch_assoc($check_usrnow);
//echo '<pre>';print_r($row);exit;
//Check for Email
if(!empty($row)) {
	echo '<div class="col-xs-12"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Designation name already exists.
                  </div>
                  <button type="submit" class="btn btn-warning" >
                  <a href="http://novaagri.in/visitormanagment/admin/add_designations.php"><i class="fa fa-reply"></i> Back</a>
                  </button>
                  </div></section></div>';
	include_once ('bottom.php');
	exit();
}



//Hash Password
//$emp_designation = md5($emp_designation);

//Insert User
$created_date=date('Y-m-d H:i:s');
$sql_insert_dep = "INSERT INTO designations  SET des_name='$des_name',org_id='$org_id',user_id='$account_id',status='1',delete_status='1',created_on='$created_date' ";//exit;
//echo $sql_insert_dep;exit;
$sql_insert_usrnow = mysqli_query($con_signin, $sql_insert_dep);

if($sql_insert_usrnow) {
	echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    New Designation created.
                  </div>';
//Report to Logs
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'Designation $des_name created', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
echo '<br /><a href="designations.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';
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
<?php 
echo "<label>Designation Name:</label> <br /><input type='text' name='des_name' class='form-control' autofocus required ><br />";
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
<input type="text" name="new_des" value="create_newemp" hidden>
                   <button type="submit" class="btn btn-warning" >
                    <a href="http://novaagri.in/visitormanagment/admin/designations.php">
                    <i class="fa fa-reply"></i> Back</a>
                  </button> 
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Create Designation</button>
                  </div></div>
                </form>
          </div>
        </section>
      </div>
<?php include_once ('bottom.php'); ?>