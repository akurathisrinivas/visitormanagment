<?php 
$PageTitle = 'accounts';
require_once ('top.php');

//Grab Data
$cid = (isset($_GET['cid']) ? $_GET['cid'] : "");
//Clean Data
$cid = mysqli_real_escape_string($con_signin,$cid);
//Grab Numbers Only
$cid = sanitize_int($cid);
//Get Visitor Details
$cid = mysqli_query($con_signin,"SELECT * FROM vehicle_signins WHERE id = '$cid' LIMIT 1");
$checkfor_cid = mysqli_num_rows($cid);
$cid = mysqli_fetch_assoc($cid);

$main_id = $cid['id'];
$full_name = $cid['party_name'];
$vehicle_no= $cid['vehicle_number'];
?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
<?php 
		//Check is account exist
		if (!isset($_POST['del_contact_id'])) { 
		  if($checkfor_cid == 0) {
		  echo "Error: Account does not exist.";
		  echo "</section></div>";
		  include_once ('bottom.php');
		  exit();
		  } 
	}
?>
            Delete Visitor
          </h1>
        </section>
        <section class="content">
<?php
if (isset($_POST['del_contact_id'])) { 

//Grab and clean data
$del_contact_id = stripslashes(htmlspecialchars($_POST['del_contact_id'], ENT_QUOTES));
//Grab Numbers Only
$del_contact_id = sanitize_int($del_contact_id);

//Delete Visitor
$sql_delete_contact = "DELETE from vehicle_signins WHERE id = '$del_contact_id'";

$sql_delete_dc = "DELETE from vehicle_in_out_ward_details WHERE vehicle_signin_id = '$del_contact_id'";
//Check for Demo Mode
if($demo_mode == 0) {
$sql_check = mysqli_query($con_signin, $sql_delete_contact);
$sql_check = mysqli_query($con_signin, $sql_delete_dc);
} else {
$sql_check = 1;
}

if($sql_check) {
	echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    Vehicle has been Deleted.
                  </div>';
//Report to Logs
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'Vehicle Deleted $del_contact_id', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
echo '<br /><a href="vehicles.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';
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
$sql_log_report = "insert into logs values(LAST_INSERT_ID(), 'Vehicle Failed to Delete $del_contact_id', '$session_login_usr', '$fptime', '$log_ip', '0')";
mysqli_query($con_signin, $sql_log_report);
	}
}
?>
          <div class="row">
		  <div class="col-md-6">
		  <div class="box box-primary">
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="box-body">
				  
Are you sure you want to Delete Visitor below? Warning this can not be undone.<br /><br /><h4>
<?php 
echo "Visitor ID: " .$main_id. "<br />";
echo "Party Name: " .$full_name. "<br />";
echo "Vehicle NO: " .$vehicle_no. "<br />";
?>				  
</h4>				 
<br /><br />
<input type="text" name="del_contact_id" value="<?php echo $main_id; ?>" hidden>
                   <a href="vehicles.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a> 
                   <button type="submit" class="btn btn-danger"><i class='fa fa-trash-o'></i> Delete Vehicle</button>
                  </div></div>
                </form>
          </div>
        </section>
      </div>
<?php include_once ('bottom.php'); ?>