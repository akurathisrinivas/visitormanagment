<?php
$PageTitle = 'Users List';
require_once ('top.php');


//Check for demo
//if ($demo_mode == 1) {
//    $add_perm_demo = "and email != 'admin'";
//} else {
//    $add_perm_demo = '';
//}

//Grab Data
$cid = (isset($_GET['orgid']) ? $_GET['orgid'] : "");

$get_rowid=$cid;
//Clean Data
$cid = mysqli_real_escape_string($con_signin, $cid);
//Grab Numbers Only
$cid = sanitize_int($cid);
//echo $sql="SELECT * FROM organizations_list WHERE row_id = '$cid' LIMIT 1";exit;
$result = mysqli_query($con_signin, "SELECT * FROM organizations_list WHERE org_id = '$cid' LIMIT 1");
$row = mysqli_fetch_array($result);
$org_id = $row['org_id'];
$org_name = $row['org_name'];
$org_des = $row['org_ext'];

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Delete User
        </h1>
    </section>
    <section class="content">
        <?php
        if (isset($_POST['del_update_id'])) {

//Grab and clean data
            $del_update_id = stripslashes(htmlspecialchars($_POST['del_update_id'], ENT_QUOTES));
//Grab Numbers Only
            $del_update_id = sanitize_int($del_update_id);

//Delete Contact
            $sql_delete_contact = "DELETE from organizations_list WHERE org_id = '$del_update_id'";
            $sql_check = mysqli_query($con_signin, $sql_delete_contact);



            if ($sql_check) {
                echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    User has been Deleted.
                  </div>';
//Report to Logs
                $sql_log_report = "insert into logs(alert,user,org_id,data,ip,status) values('organization $del_update_id Deleted', '"$_SESSION['account_id']"','".$del_update_id."', '$fptime', '$log_ip', '0')";
                mysqli_query($con_signin, $sql_log_report);
                echo '<br /><a href="orglist.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';
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
                $sql_log_report = "insert into logs(alert,user,org_id,data,ip,status) values('organization Failed to Delete $del_update_id', '"$_SESSION['account_id']"', '".$del_update_id."','$fptime', '$log_ip', '0')";
                mysqli_query($con_signin, $sql_log_report);
            }
        }

//Check Admin Rank
        if ($rank != 1) {
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
                                echo "Organization Id: " . $org_id . "<br />";
                                echo "Organization Name: " . $org_name . "<br />";
                                echo "Organization Description: " . $org_des . "<br />";
                                ?>				  
                            </h4>				 
                            <br /><br />
                            <input type="text" name="del_update_id" value="<?php echo $cid; ?>" hidden>
                            <button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button> <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete User</button>
                        </div></div>
                </form>
            </div>
    </section>
</div>
<?php include_once ('bottom.php'); ?>