<?php
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

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

@$ownerId=$qrery_string['ownerId'];

@$userId=$qrery_string['userId'];



$insert_visitor = "INSERT INTO api_track set raw_input='$query' , request_from='deplist'";//id = '$vId' 

mysqli_query($con_signin, $insert_visitor);



if(strlen($userId)<=0 )

{

	$f_obj->Status="0";

	$f_obj->Content="";

	$f_obj->Mssg="User Id is required";

	echo json_encode($f_obj);

	exit;

}

if(strlen($ownerId)<=0 )

{

	$f_obj->Status="0";

	$f_obj->Content="";

	$f_obj->Mssg="OwnerId is required";

	echo json_encode($f_obj);

	exit;

}





//Checking the visitor

$dep_list_q = "SELECT * FROM departments WHERE status='1' AND delete_status='1' AND org_id='$ownerId' and user_id='$userId' ";//id = '$vId' 

$dep_list_rs = mysqli_query($con_signin, $dep_list_q);

$dep_list_count = mysqli_num_rows($dep_list_rs);

$depList=array();

//Check visitor if valid

if($dep_list_count>0)

{

	$depList=array();

	while($row = mysqli_fetch_array($dep_list_rs))

	{

		$status=1;

		$depList[]=array(

			"depId"=>$row['id'],

			"org_id"=>$row['org_id'],

			"user_id"=>$row['user_id'],

			"dep_name"=>$row['dep_name'],

			"stauts"=>$row['stauts'],

			);	

  	}

  	

  	$f_obj->Status="1";

	$f_obj->Content=$depList;

	$f_obj->Mssg="Success";

	echo json_encode($f_obj);

	exit;

	


}else

{

	// not found

	$f_obj->Status="0";

	$f_obj->Content="";

	$f_obj->Mssg="Not Found.";

	echo json_encode($f_obj);

	exit;

}

?>