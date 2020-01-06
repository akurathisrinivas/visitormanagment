<?php

$PageTitle = 'Employees_List';

require_once ('top.php');

session_start();

$org_id = $_SESSION['org_id'];

$account_id = $_SESSION['account_id'];

$cid = (isset($_GET['cid']) ? $_GET['cid'] : "");

$get_rowid=$cid;

$sql="select * from employees_list where row_id='".$cid."'";

$result= mysqli_query($con_signin, $sql);

$row= mysqli_fetch_array($result);

$employeename=$row['emp_name'];

$employeeid=$row['emp_id'];

$department=$row['department'];

$location=$row['location'];

$phonenumber=$row['phone_no'];

$employeeemailid=$row['email_id'];

$employeedesignation=$row['designation'];

$employeeaddress=$row['address'];

$company_id=$row['company_id'];

?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>

            Update Employee

        </h1>

    </section>

    <section class="content">

        <?php

//Check Admin Rank

        /*if ($rank != 3) {

            echo "<div class='col-xs-12'>Error: You do not have permissions.</div></div></section></div>";

            include_once ('bottom.php');

            exit();

        }*/



        if (isset($_POST['update_emp'])) {



//Grab and clean data

            $emp_name = stripslashes(htmlspecialchars($_POST['emp_name'], ENT_QUOTES));

            $emp_phone_no = stripslashes(htmlspecialchars($_POST['emp_phone_no'], ENT_QUOTES));

            $emp_email = stripslashes(htmlspecialchars($_POST['emp_email'], ENT_QUOTES));

            $emp_designation = stripslashes(htmlspecialchars($_POST['emp_designation'], ENT_QUOTES));

            $emp_id = stripslashes(htmlspecialchars($_POST['emp_id'], ENT_QUOTES));

            $emp_dept = stripslashes(htmlspecialchars($_POST['emp_dept'], ENT_QUOTES));

            $emp_loc = stripslashes(htmlspecialchars($_POST['emp_loc'], ENT_QUOTES));

            $emp_address = stripslashes(htmlspecialchars($_POST['emp_address'], ENT_QUOTES));

            $id=stripslashes(htmlspecialchars($_POST['id'], ENT_QUOTES));

//$usr_is_active = stripslashes(htmlspecialchars($_POST['usr_is_active'], ENT_QUOTES));

//$usr_rank = stripslashes(htmlspecialchars($_POST['usr_rank'], ENT_QUOTES));

//Sanitize Data

            $emp_name = sanitize_sql_string($emp_name);

            $emp_phone_no = sanitize_sql_string($emp_phone_no);

            $emp_email = sanitize_sql_string($emp_email);

            $emp_designation = sanitize_sql_string($emp_designation);

            $emp_id = sanitize_sql_string($emp_id);

            $emp_dept = sanitize_sql_string($emp_dept);

            $emp_loc = sanitize_sql_string($emp_loc);

            $emp_address = sanitize_sql_string($emp_address);

            $usr_is_active = sanitize_sql_string($usr_is_active);

            $usr_rank = sanitize_sql_string($usr_rank);

            $company_id= $_POST['company_id'];

//Check for Email

            if ($emp_email == '') {

                echo '<div class="col-xs-12"><div class="alert alert-danger alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <h4><i class="icon fa fa-ban"></i> Error!</h4>

                    You must have a email.

                  </div><button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button></div></section></div>';

                include_once ('bottom.php');

                exit();

            }



//Check for password

            if ($emp_designation == '') {

                echo '<div class="col-xs-12"><div class="alert alert-danger alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <h4><i class="icon fa fa-ban"></i> Error!</h4>

                    You must have a password.

                  </div><button type="submit" class="btn btn-warning" onclick="goBack()">Back</button></div></section></div>';

                include_once ('bottom.php');

                exit();

            }



//Hash Password

//$emp_designation = md5($emp_designation);

//Insert User

            $sql_insert_usr = "update employees_list  SET company_id='$company_id',emp_name='$emp_name', phone_no='$emp_phone_no', email_id='$emp_email',designation= '$emp_designation',emp_id='$emp_id',department='$emp_dept', location='$emp_loc',address='$emp_address',status=1 where row_id='".$id."'"; 

            $sql_insert_usrnow = mysqli_query($con_signin, $sql_insert_usr);



            if ($sql_insert_usrnow) {

                echo '<div class="alert alert-success alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <h4><i class="icon fa fa-check"></i> Success!</h4>

                     Employee Updated Successfully.

                  </div>';

//Report to Logs

                $sql_log_report = "insert into logs(alert,user,org_id,date,ip,status) values('Employee $emp_name Edited', '$session_login_usr','".$_SESSION['org_id']."', '$fptime', '$log_ip', '0')";

                mysqli_query($con_signin, $sql_log_report);

                echo '<br /><a href="emps_list.php" type="submit" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>';

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

                $sql_log_report = "insert into logs(alert,user,org_id,date,ip,status) values('User Failed to Edited $emp_name', '$session_login_usr','".$_SESSION['org_id']."', '$fptime', '$log_ip', '0')";

                mysqli_query($con_signin, $sql_log_report);

            }

        }

        ?>
        <?php 
$query="SELECT * FROM designations WHERE org_id='$org_id' AND user_id='$account_id' and status='1' and delete_status='1' ORDER BY `des_name` asc";
$list_designations = mysqli_query($con_signin,$query);
$designations=array();
while($row = mysqli_fetch_assoc($list_designations)){
$designations[]=$row;
  }

$query="SELECT * FROM departments WHERE org_id='$org_id' AND user_id='$account_id' and status='1' and delete_status='1' ORDER BY `dep_name` asc";
$list_departments = mysqli_query($con_signin,$query);
$departments=array();
while($row = mysqli_fetch_assoc($list_departments)){
$departments[]=$row;
  }


$query="SELECT * FROM companies  ORDER BY `id` asc";
$list_comp = mysqli_query($con_signin,$query);
$companies=array();
while($row = mysqli_fetch_assoc($list_comp)){
$companies[]=$row;
  }
?>

        <div class="row">

            <div class="col-md-6">

                <div class="box box-primary">

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                        <div class="box-body">

                            <h5>



                                <label>Emp Id:</label> <br />

                                <input type='text' name='emp_id' class='form-control' value="<?php if(isset($employeeid)) echo $employeeid; ?>" readonly><br />

                                <input type='hidden' name='emp_id' class='form-control' value="<?php if(isset($employeeid)) echo $employeeid; ?>">

                                <label>Company :</label>
                                <select class="form-control" name="company_id" required="">
                                <option value="" selected>select</option>
                                <?php foreach($companies as $com){?>
                                <option value="<?php echo $com['id']?>" 
                                    <?php if($company_id == $com['id']){?> selected <?php }?> ><?php echo $com['name']?></option>
                                <?php }?>
                                </select>
                                <br />

                                <label>Emp Name:</label> <br /><input type='text' value="<?php if(isset($employeename)) echo $employeename; ?>" name='emp_name' class='form-control' required autofocus><br />

                               

                                <label>Phone:</label> <br /><input type='text' name='emp_phone_no' class='form-control' value="<?php if(isset($phonenumber)) echo $phonenumber; ?>" onkeypress='return isNumberKey(event)' maxlength='10' required ><br />

                                <label>Email:</label> <br /><input type='email' name='emp_email' class='form-control' value="<?php if(isset($employeeemailid)) echo $employeeemailid; ?>" required><br />
                                <label>Department :</label>
                                <select class="form-control" name="emp_dept" required="">
                                <option value="" selected>select</option>
                                <?php foreach($departments as $dep){?>
                                <option value="<?php echo $dep['id']?>" 
                                    <?php if($department == $dep['id']){?> selected <?php }?> ><?php echo $dep['dep_name']?></option>
                                <?php }?>
                                </select>
                                <br />
                                <label>Designation :</label>
                                <select class="form-control" name="emp_designation" required="">
                                <option value="" selected>select</option>
                                <?php foreach($designations as $des){?>
                                <option value="<?php echo $des['id']?>" <?php if($employeedesignation == $des['id']){?> selected <?php }?> ><?php echo $des['des_name']?></option>
                                <?php }?>
                                </select> 
                                <br />

                                <label>Location:</label> <br /><input type='text' name='emp_loc' class='form-control' value="<?php if(isset($location)) echo $location; ?>" required autofocus><br />

                                <label>Address:</label> <br />
                                <textarea type='text' name='emp_address' class='form-control' required><?php if(isset($employeeaddress)) echo $employeeaddress; ?></textarea>
                                <br />

                                <input type='hidden' name='id' value="<?php if(isset($get_rowid)) echo $get_rowid ?>" class='form-control' ><br />

	

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

                            </h5>				 

                            

                            <input type="text" name="update_emp" value="Update_newemp" hidden>

                            <button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button> <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Employee</button>

                        </div></div>

                </form>

            </div>

    </section>

</div>

<script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<?php include_once ('bottom.php'); ?>