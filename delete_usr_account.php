<?php 
$PageTitle = 'Users List';
require_once ('top.php');


//Check for demo
if($demo_mode == 1) {
	$add_perm_demo = "and email != 'admin'";
} else {
	$add_perm_demo = '';
}

//Grab Data
$cid = (isset($_GET['cid']) ? $_GET['cid'] : "");
//Clean Data
$cid = mysqli_real_escape_string($con_signin,$cid);
//Grab Numbers Only
$cid = sanitize_int($cid);

$get_cid = $cid;
$cid = mysqli_query($con_signin,"SELECT * FROM users WHERE id = '$cid' $add_perm_demo LIMIT 1");
$cid = mysqli_fetch_assoc($cid);

$main_id = $cid['id'];
$firstname = $cid['firstname'];
$lastname = $cid['lastname'];
$email = $cid['email'];
?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Delete User
          </h1>
        </section>
        <section class="content">
<?php
if (isset($_POST['del_usr_id'])) { 

//Grab and clean data
$del_usr_id = stripslashes(htmlspecialchars($_POST['del_usr_id'], ENT_QUOTES));
//Grab Numbers Only
$del_usr_id = sanitize_int($del_usr_id);

//Delete Contact
$sql_delete_contact = "DELETE from users WHERE id = '$del_usr_id'";
$sql_check = mysqli_query($con_signin, $sql_delete_contact);



if($sql_check) {
	echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    User has been Deleted.
                  </div>';
//Report to Logs
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'User $del_usr_id Deleted', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
echo '<br /><a href="users_list.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';
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
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'User Failed to Delete $del_usr_id', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
	}
  
}

//Check Admin Rank
if($rank != 1 || $main_id == '') {
	echo "<div class='col-xs-12'>Error: You do not have permissions.</div></div></section></div>";
	include_once ('bottom.php');
	exit();
}
?>
          <div class="row">
		  <div class="col-md-6">
		  <div class="box box-primary">
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="box-body">
				  
Are you sure you want to Delete User below? Warning this can not be undone.<br /><br /><h4>
<?php 
echo "Firstname: " .$firstname. "<br />";
echo "Lastname: " .$lastname. "<br />";
echo "Email: " .$email. "<br />";
?>				  
</h4>				 
<br /><br />
<input type="text" name="del_usr_id" value="<?php echo $get_cid; ?>" hidden>
                   <button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button> <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete User</button>
                  </div></div>
                </form>
          </div>
        </section>
      </div>
<?php include_once ('bottom.php'); ?>