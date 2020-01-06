<?php
echo "RRRR";
/*
class final_obj
{
	public $Status="";
	public $Content="";
	public $Mssg="";
}
$f_obj = new final_obj();

require_once ('../core/config.php');
require_once ('../core/sanitize.inc.php');

$query = file_get_contents('php://input');
$qrery_string = json_decode($query,true);
@$userPwd=$qrery_string['userPwd'];
@$userName=$qrery_string['userName'];
//$authorizationKey=mysql_real_escape_string($authorizationKey);
//or is_numeric($mobileNumber)==false
if(strlen($userName)<=0 )
{
	$f_obj->Status="0";
	$f_obj->Content="";
	$f_obj->Mssg="Please Enter Valid Username";
	echo json_encode($f_obj);
	exit;
}


//Clean Data
$lg_email = mysqli_real_escape_string($con_signin,$lg_email);
$lg_password = mysqli_real_escape_string($con_signin,$lg_password);

//Sanitize Login User Data
//Sanitize Data
$lg_email = sanitize_sql_string($lg_email);
$lg_password = sanitize_sql_string($lg_password);
//MD5 Hash Password
$lg_password = MD5($lg_password);

//Checking the user
$sel_user = "select * from users where email = '$lg_email' AND password = '$lg_password'";
$run_user = mysqli_query($con_signin, $sel_user);
$check_user = mysqli_num_rows($run_user);

//Check user if valid
if($check_user>0)
{
	
}else
{
	$f_obj->Status="0";
	$f_obj->Content="";
	$f_obj->Mssg="Invalid credentials..";
	echo json_encode($f_obj);
	exit;
}

*/


/*












$result_login = mysqli_query($con_signin,"SELECT * FROM users WHERE email = '$session_login_usr'");
while($row = mysqli_fetch_array($result_login))
  {
  $usr_id = $row['id'];
  $first = $row['firstname'];
  $last = $row['lastname'];
  $email = $row['email'];
  $rank = $row['rank'];
  $is_active = $row['is_active'];
  $last_date = $row['date'];  
  $last_ip = $row['ip']; 
  }
  
//Count Signin 
$sql_signin_count = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE signin_date != '' and signout_date != ''");
$signin_count = mysqli_num_rows($sql_signin_count);

















$sql = "SELECT * FROM users u , usertypes ut where u.User_type_id=ut.User_type_id and u.User_email='$userName' ";//and u.User_password='".md5($userPwd)."'
$rs = mysql_query($sql) or die(mysql_error());
$rowsCount  = mysql_num_rows($rs);
$usersList=array();


if($rowsCount > 0)
{
	$displayName="-";$mobileNumber="-";$designation="-";$userRoleId="-";$profilePic="-";$userId="-";$userName="-";$userPwd="-";$ownerName="-";$senderId="-";$projectId="-";$regId="-";$ownerId="-";$orgFullName="-";
	while($rsVal = mysql_fetch_assoc($rs))
	{
		$displayName=$rsVal['User_name'];
		$mobileNumber=$rsVal['User_mobile_number'];
	}
}

$usersList[]=array(
			"displayName"=>$displayName,
			"mobileNumber"=>$mobileNumber,
			"designation"=>$designation,
			"userRoleId"=>$userRoleId,
			"userId"=>$userId,
			"userName"=>$userName,
			"userPwd"=>$userPwd,
			"ownerName"=>$ownerName
			);	

$f_obj->Status="1";
					$f_obj->Content=$usersList;
					$f_obj->Mssg="Valid User";
					echo json_encode($f_obj);
					exit;
					
*/					
					
?>