<?php 
$PageTitle = 'employees_sign_data';
session_start();
$org_id=$_SESSION['org_id'];
$account_id=$_SESSION['account_id'];
//echo '<pre>';print_r($_SESSION);exit;
require_once ('top.php');
?>
<script type='text/javascript' language='javascript'>	
	function signbage(hashid){
		windowObjectReference = window.open(
    "print_visitor_badge.php?cid="+ hashid +"&action=allow_usr&decode=6767676gh5662684de61a08888",
    "DescriptiveWindowName",
    "width=350,height=300,resizable,scrollbars,status"
  );
	}

	function viewsignin(hashid){
		windowObjectReference = window.open(
    "view_employee_badge.php?cid="+ hashid +"&action=allow_usr&decode=6767676gh5662684de61a08888",
    "DescriptiveWindowName",
    "width=650,height=660,resizable,scrollbars,status"
  );
	}	
</script>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
		  <div class="row">
            <div class="col-xs-12">Employees Signin List
			<form action="signout_checkedEmployees.php?usr=<?php echo $session_login_usr; ?>&authsession=<?php echo $salt_key; ?>" method="post" id="form_signout">
				<button id="getChkBoxValues" name="visitorssignout" type="submit" class="btn btn-warning btn-sm pull-right"><i class="fa fa-sign-out"></i> Sign out Checked Visitors</button>
			  </form>
			</div></div>
          </form>
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
						
						<th>S NO</th>
						<th>Employee Name</th>
						<th>Company</th>
						<th>Signin Date</th>
                        <th>Signout Date</th>
                        <th>Phone No</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Teritory</th>
						<th>Image</th>
						<th>Quick View</th>
                      </tr>
                    </thead>
                    <tbody>
<?php	

$query="SELECT  * FROM employee_signins WHERE org_id=$org_id and user_id=$account_id order by id desc";
//echo $query;exit;
$list_visitors_result = mysqli_query($con_signin,$query);
$sno=1;
while($row = mysqli_fetch_array($list_visitors_result)){

$id = $row['id'];
$signin_date = $row['signin_date'];
$signout_date = $row['signout_date'];
$signin_time = $row['signin_time'];
$signout_time = $row['signout_time'];
$emp_id = $row['emp_id'];
$company = $row['company'];
if($company == 'nova_agri_tech'){
    $company= 'Nova agri tech';
  }else if($company == 'nova_agri_science'){
    $company= 'Nova agri science';
  }
$emp_name = $row['emp_name'];
$emp_email = $row['emp_email'];
$emp_phone = $row['emp_phone'];
$department = $row['department'];
$designation = $row['designation'];
$description = $row['description'];
$teritory = $row['teritory'];
$image_path = $row['image_path'];


//Grab Contact Name		

 

$force_signinout = '';

if($signout_date == '') {
  $signout_date = '<input type="checkbox" id="isVisitorSelected" name="isVisitorSelected[]" value='.$id.' class="chkbox" /> <a href="force_employee_signout.php?cid='.$id.'" role="button" title="Force Sign Out" class="btn btn-warning btn-xs"><i class="fa fa-sign-out"></i> Sign out </a>'; 
  $force_signinout = "<a href='force_employee_signout.php?cid=$id' role='button' title='Force Sign Out' class='btn btn-warning btn-sm'><i class='fa fa-sign-out'></i></a>"; 
  }


					
				echo "<tr>
						
						<td>$sno</td>
						<td>$emp_name ($emp_id)</td>
						<td>$company</td>
						<td>$signin_date 
                        $signin_time</td>
                        <td>$signout_date 
                        $signout_time</td>                       
						<td>$emp_phone</td>
						<td>$department</td>
						<td>$designation</td>
						<td>$teritory</td>
						<td>
						<img src='http://novaagri.in/visitormanagment/api/$image_path' width='80px' style='border-radius: 6px;' alt='Visitor Image'>
						</a></td>
						<td>
						  <a href='#' onClick='viewsignin(".$id.")' role='button' title='View Visitor Signin' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>$force_signinout
                        </td>
                      </tr>";
                      $sno++;
}
?>					  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
<script>
$(document).ready(function(e) {
    $('#getChkBoxValues').click(function(){
        var chkBoxArray = [];
	$('.chkbox:checked').each(function() {
            chkBoxArray.push($(this).val());
        });
	if(chkBoxArray == 0){
		alert('Please select at least one checkbox to sign out Visitor.');
		return false;
	} else {
		if(!confirm("Do you really want to do this? This can't be undone.")){
		return false;
		}
	}	
			$('<input />').attr('type', 'hidden')
          .attr('name', "visitor_id")
          .attr('value', '' + chkBoxArray)
          .appendTo('#form_signout');
	});
});
</script>	  
<?php include_once ('bottom.php'); ?>