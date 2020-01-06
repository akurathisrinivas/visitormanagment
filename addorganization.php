<?php
$PageTitle = 'addorganization';
require_once ('top.php');
//print_r($_SESSION);exit;
if (isset($_GET['orgid'])) {
    $orgid = $_GET['orgid'];
    $sql = "select org.*,u.firstname,u.lastname,u.email,u.password,u.ip,u.last_login_date,u.phonenumber from organizations_list as org join users u on org.org_id=u.org_id where org.org_id='" . $orgid . "' ";
    $result = mysqli_query($con_signin, $sql);
    $orgbyid = mysqli_fetch_row($result);
    //print_r($orgbyid);exit;
    $org_name = $orgbyid[1];
    $org_des = $orgbyid[2];
    $org_logo = $orgbyid[3];
    $first_name = $orgbyid[7];
    $last_name = $orgbyid[8];
    $org_email = $orgbyid[9];
    $org_phno = $orgbyid[13];
    $org_status = $orgbyid[5];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['neworg']) || isset($_POST['updateorg'])) {
        $orgname = mysqli_escape_string($con_signin, $_POST['orgname']);
        $orgdes = mysqli_escape_string($con_signin, $_POST['orgdes']);
        $orglogo = mysqli_escape_string($con_signin, $_FILES['orglogo']);
        $fname = mysqli_escape_string($con_signin, $_POST['fname']);
        $lname = mysqli_escape_string($con_signin, $_POST['lname']);
        $emailid = mysqli_escape_string($con_signin, $_POST['email']);
        $password = mysqli_escape_string($con_signin, md5($_POST['password']));
        $phonenumber = mysqli_escape_string($con_signin, $_POST['phno']);

        if (isset($_FILES['orglogo'])) {
            $success = '';
            $errors = '';
            $file_name = $_FILES['orglogo']['name'];
            $file_size = $_FILES['orglogo']['size'];
            $file_tmp = $_FILES['orglogo']['tmp_name'];
            $file_type = $_FILES['orglogo']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['orglogo']['name'])));

            $expensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $expensions) === false) {
                $errors = "extension not allowed, please choose a JPEG or PNG file.";
            }
            if ($file_size > 2097152) {
                $errors = 'File size must be excately 2 MB';
            }
            if (empty($errors) == true) {
                $path = time() . $file_name;
                move_uploaded_file($file_tmp, "orglogos/" . $path);
                $logo_path = "orglogos/". $path;
                if (isset($_POST['neworg'])) {
                    $sql = 'insert into organizations_list(org_name,org_ext,org_logo,status) values("' . $orgname . '","' . $orgdes . '","' . $logo_path . '",1)';
                    if (mysqli_query($con_signin, $sql)) {
                        $lastid = mysqli_insert_id($con_signin);
                        $sql = "insert into users(org_id,firstname,lastname,email,password,account_type_id,is_active,rank,phonenumber) values('" . $lastid . "','" . $fname . "','" . $lname . "','" . $emailid . "','" . $password . "',2,1,1,'" . $phonenumber . "')";
                       // echo $sql;exit;
                        $result = mysqli_query($con_signin, $sql);
                        $success = 'Organization has been added sucessfully';
                        unset($orgname);
                        unset($orgdes);
                        unset($orglogo);
                        unset($fname);
                        unset($lname);
                        unset($emailid);
                        unset($password);
                        unset($phonenumber);
                    }
                }
                if (isset($_POST['updateorg'])) {
                    $org_stat = mysqli_escape_string($con_signin, $_POST['org_is_active']);
                    $id = mysqli_escape_string($con_signin, $_POST['id']);
                    $sql = 'update organizations_list set org_name="' . $orgname . '",org_ext="' . $orgdes . '",org_logo="' . $logo_path . '",status="' . $org_stat . '" where org_id="' . $id . '"';

                    if (mysqli_query($con_signin, $sql)) {
                        $sql = 'update users set firstname="' . $fname . '",lastname="' . $lname . '",email="' . $emailid . '" ,phonenumber="' . $phonenumber . '",is_active="' . $org_stat . '" where org_id="' . $id . '"';
                        $result = mysqli_query($con_signin, $sql);
                        $success = 'Organization has been Update sucessfully';
                        unset($orgname);
                        unset($orgdes);
                        unset($orglogo);
                        unset($fname);
                        unset($lname);
                        unset($emailid);
                        unset($password);
                        unset($phonenumber);
                    }
                }
            }
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Organization
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form id='addorg' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <h4>
                                <?php if (!empty($success)) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong>Success!</strong> <?php echo $success; ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($errors)) { ?>
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong>Error!</strong> <?php echo $errors; ?>
                                    </div>
                                <?php } ?>
                        <!--<span><small  style='color:green;'><?php if (isset($success)) echo $success; ?></small></span>-->
                                <br />
                                <?php
//                                echo "<label for='orgname'><b>Organization Name:</b></label> <br /><input type='text' id='orgname' name='orgname' class='form-control' autofocus required placeholder='organization name'><br />";
//                                echo "<label for='orgdes'><b>Description:</b></label> <br /><input type='text' id='orgdes' name='orgdes' class='form-control' required placeholder='organization Description'><br />";
//                                echo "<label for='orglogo'><b>Logo:</label> </b><br /><input type='file' id='orglogo' name='orglogo' class='form-control' required><br />";
//                                echo "<label for='fname'><b>FirstName:</label></b> <br /><input type='text' id='fname' name='fname' class='form-control' required placeholder='FirstName'><br />";
//                                echo "<label for='lname'><b>LastName:</label> </b><br /><input type='text' id='lname name='lname' class='form-control' required placeholder='Last Name'><br />";
//                                echo "<label for='email'><b>Email:</label></b> <br /><input type='email' id='email' name='email' class='form-control' required placeholder='Email'><br />";
//                                echo "<label for='password'><b>Password:</label></b> <br /><input type='password' id='password' name='password' class='form-control' required placeholder='Password'><br />";
//                                
                                ?>
                                <label for='orgname'><b>Organization Name:</b></label> <br /><input type='text' value='<?php if (isset($org_name)) echo $org_name;if (isset($orgname)) echo $orgname ?>' id='orgname' name='orgname' class='form-control' autofocus required placeholder='organization name'><br />
                                <label for='orgdes'><b>Description:</b></label> <br /><input type='text' id='orgdes' value='<?php if (isset($org_des)) echo $org_des;if (isset($orgdes)) echo $orgdes ?>'   name='orgdes' class='form-control' required placeholder='organization Description'><br />
                                <label for='orglogo'><b>Logo:</label> </b><br /><input type='file' id='orglogo' value=''  name='orglogo' class='form-control' ><font size='2'>Current Image: <?php if (isset($org_logo)) echo $org_logo;if (isset($orglogo)) echo $orglogo ?></font><br />
                                <label for='fname'><b>FirstName:</label></b> <br /><input type='text' id='fname' value='<?php if (isset($first_name)) echo $first_name;if (isset($fname)) echo $fname ?>'  name='fname' class='form-control' required placeholder='FirstName'><br />
                                <label for='lname'><b>LastName:</label> </b><br /><input type='text' id='lname' value='<?php if (isset($last_name)) echo $last_name;if (isset($lname)) echo $lname ?>'  name='lname' class='form-control' required placeholder='Last Name'><br />
                                <label for='email'><b>Email:</label></b> <br /><input type='email' id='email' value='<?php if (isset($org_email)) echo $org_email;if (isset($emailid)) echo $emailid ?>'  name='email' class='form-control' required placeholder='Email'><br /><span id='emailcheck' style="color: red;font-size: 12px"></span>
                                <label for='phonenumber'><b>Phone Number:</label></b> <br /><input type='text' maxlength="10" id='phno' value='<?php if (isset($org_phno)) echo $org_phno;if (isset($phonenumber)) echo $phonenumber ?>'  name='phno' class='form-control' required placeholder='Phone Number'><br /><span id='phnocheck'></span>


<!--<span><small  style='color:red;'><?php if (isset($errors)) echo $errors; ?></small></span>-->
                            </h4>			 

<!--<input type="text" name="new_usr" value="create_newusr" hidden>-->

                            <?php if (!isset($orgid)) {
                                ?>
                                <h4><label for='password'><b>Password:</label></b> <br /><input type='password' value='<?php if (isset($password)) echo $password ?>'  id='password' name='password' class='form-control' required placeholder='Password'><br /></h4>
                                <button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button> 
                                <button type="submit" class="btn btn-primary" name='neworg'><i class="fa fa-plus"></i> Create Organization</button>
                                <?php
                            }

                            else {
                                ?>
                                <label>Active</label>
                                <select class="form-control" name="org_is_active">
                                    <option value="1" <?php
                                    if (isset($org_status)) {
                                        if ($org_status == 1)
                                            echo 'selected';
                                    }
                                    ?>>Active Account</option>
                                    <option value="2" <?php
                                    if (isset($org_status)) {
                                        if ($org_status == 2)
                                            echo 'selected';
                                    }
                                    ?>>Not Active Account</option>
                                </select><br />
                                <input type="hidden" name='id' value="<?php if (isset($_GET['orgid'])) echo $_GET['orgid']; ?>" />
                                <button type="submit" class="btn btn-warning" onclick="goBack()"><i class="fa fa-reply"></i> Back</button> 
                                <button type="submit" class="btn btn-primary" name='updateorg'><i class="fa fa-plus"></i> Update Organization</button>
                                <?php
                            }
                            ?>
                <!--<button type="submit" class="btn btn-primary" name='neworg'><i class="fa fa-plus"></i> Create Organization</button>-->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="../js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="../js/createorg.js" type="text/javascript"></script>
<script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#phno').keyup(function (e) {
                                            phone = $(this).val();
                                            phone = phone.replace(/[^0-9]/g, '');
                                            if (phone.length != 10)
                                            {
                                                $('#phnocheck').css({'color': 'red', 'font-size': '13px'}).html('phone number must be 10 digits');
                                                $('#phno').focus();
                                            } else if (phone.length == 10) {
                                               $.ajax({
                                                    url: "func.php",
                                                    method: "POST",
                                                    data: {phone: phone},
                                                    success: function (data) {
                                                        if(data==1){
                                                            alert("User Already exist");
                                                             $('#phno').val("");
                                                        }
                                                        
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax' + textStatus + errorThrown);
                                                    }
                                                });
                                                $('#phnocheck').html('');
                                            }
                                        });
                                        $('#phno').on('keypress', function (key) {
                                            if (key.charCode < 48 || key.charCode > 57) {
                                                return false;
                                            }
                                        });
                                        $('#orgname').change(function () {
                                            var orgname = $('#orgname').val();
                                            if (orgname == '') {
                                                alert('please enter Organization Name ');
                                                //$('#emailcheck').html('please enter orgname');
                                            } else {
                                                $.ajax({
                                                    url: "func.php",
                                                    method: "POST",
                                                    data: {orgname: orgname},
                                                    success: function (data) {
                                                        if(data==1){
                                                            alert("Organization Already exist");
                                                             $('#orgname').val("");
                                                        }
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {
                                                        alert('Error get data from ajax' + textStatus + errorThrown);
                                                    }
                                                });
                                            }
                                        });
                                    });
</script>
<?php include_once('bottom.php'); ?>