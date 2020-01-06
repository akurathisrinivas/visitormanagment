<?php 
date_default_timezone_set('Asia/Kolkata');
$PageTitle = 'Dashboard';
session_start();
$account_id=$_SESSION['account_id'];
$org_id=$_SESSION['org_id'];
//echo $$org_id; exit;

require_once ('top.php'); ?>
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
    "view_visitor_badge.php?cid="+ hashid +"&action=allow_usr&decode=6767676gh5662684de61a08888",
    "DescriptiveWindowName",
    "width=650,height=660,resizable,scrollbars,status"
  );
  } 
</script>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
        </section>
        <section class="content">

   

<div class="row cont_wrp">
  
  
    <div class="col-md-3"> <h2 class="datetitle"><?php 
date_default_timezone_set('Asia/Kolkata');
    echo $today = date("F j, Y ");?></h2></div>
    <div class="col-md-9">
      <div class="">
      <ul>
      <li>
<?php
date_default_timezone_set('Asia/Kolkata');
$today=date('Y-m-d');
$query="SELECT COUNT(id) as vis_in_out_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id and DATE(`signin_date`) = '".$today."' and signout_date IS NULL";
//echo $query;exit;
$sql=mysqli_query($con_signin,$query);
$vist_count=mysqli_fetch_assoc($sql);
?>
        <a href="visitors.php?action=todaysignin">
        <h1><?php echo $vist_count['vis_in_out_count'] ?></h1>
      <h4>VISITORS SIGN IN </h4>
      </a></li>
      <li>

<?php 
$query="SELECT COUNT(id) as vis_in_but_not_out_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id and DATE(`signin_date`) = '".$today."' ";
$sql=mysqli_query($con_signin,$query);
$vist_count=mysqli_fetch_assoc($sql);
?>
        <a href="visitors.php?action=today">
        <h1><?php echo $vist_count['vis_in_but_not_out_count'] ?></h1>
         <h4>TOTAL VISITORS </h4>
      </a></li>
      <li>
        <?php 


$query="SELECT COUNT(id) as vis_in_out_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id and DATE(`signin_date`) = '".$today."' and signout_date IS NOT NULL";
//echo $query;exit;
$sql=mysqli_query($con_signin,$query);
$vist_count=mysqli_fetch_assoc($sql);
//echo '<pre>'; print_r($results); exit;

?><a href="visitors.php?action=todaysignout">
        <h1><?php echo $vist_count['vis_in_out_count']; ?></h1>
         <h4>VISITORS SIGN OUT</h4>
      </a>
    </li>
    </ul>
    </div>

  </div>
</div>
<br/>

<div class="row listvist">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <div class="offer offer-radius offer-primary">
      <?php 
$query="SELECT COUNT(id) as week_vis_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id  and signin_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
//echo $query;exit;
$sql=mysqli_query($con_signin,$query);
$count=mysqli_fetch_assoc($sql);
?>
        <div class="offer-content">
          <h3 class="lead">
            Weekly wise visitors
          </h3>           
          <p>
          <span class="count"><?php echo $count['week_vis_count'];?></span><span>
            <a target="_blank" href='visitors.php?action=week' class="btn btn-primary btn-xs"> view more..</a></span>
          </p>
          <img src="../images/7.png"/>
        </div>
      </div>
    </div>

<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <div class="offer offer-radius offer-primary">
       <?php 
$query="SELECT COUNT(id) as month_vis_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id  and `signin_date` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
//echo $query;exit;
$sql=mysqli_query($con_signin,$query);
$count=mysqli_fetch_assoc($sql);
?>
        <div class="offer-content">
          <h3 class="lead">
            Monthly wise visitors
          </h3>           
          <p>
         <span class="count"><?php echo $count['month_vis_count'];?></span><span>
          <a target="_blank" href='visitors.php?action=month' class="btn btn-primary btn-xs"> view more..</a></span>
          </p>
          <img src="../images/31.png"/>
        </div>
      </div>
    </div>


    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <div class="offer offer-radius offer-primary">
<?php 
$query="SELECT COUNT(id) as year_vis_count FROM signin_tablet WHERE user_id=$account_id and org_id=$org_id  and `signin_date` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)";
//echo $query;exit;
$sql=mysqli_query($con_signin,$query);
$count=mysqli_fetch_assoc($sql);
?>
        <div class="offer-content">
          <h3 class="lead">
            Yearly wise visitors
          </h3>           
          <p>
           <span class="count"><?php echo $count['year_vis_count'];?></span><span>
            <a target="_blank" href='visitors.php?action=year' class="btn btn-primary btn-xs"> view more..</a></span>
          </p>
          <img src="../images/365.png"/>
        </div>
      </div>
    </div>
  </div>
  <br/>

         <div class="row">
            <div class="col-md-6">
        <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Today Visitors Signout</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
          <?php
//Get Recent signin visitors          
//if($account_type_id>1)
  $q1="SELECT * FROM signin_tablet WHERE org_id=$org_id and user_id=$account_id and DATE(`signin_date`) = '".$today."' and signout_date IS NOT NULL ORDER BY `signin_tablet`.`id` DESC LIMIT 8";
//else
 // $q1="SELECT * FROM signin_tablet WHERE 1 ORDER BY `signin_tablet`.`id` DESC LIMIT 8";
  
$list_visitors_result = mysqli_query($con_signin,$q1);
$count_visitors = mysqli_num_rows($list_visitors_result);

if($count_visitors != 0) {
while($row = mysqli_fetch_array($list_visitors_result)){
$id = $row['id'];
$signin_date = $row['signin_date'];
$signout_date = $row['signout_date'];
$full_name = $row['full_name'];
$profile_in = $row['profile_in'];

//Show image if none is in db  
if($profile_in == '') {
$profile_in = $visitor_profile_none;  
} 
?>  
                    <li>
                     <a href='#' onClick='viewsignin("<?php echo $id; ?>")'>

                      <!--<img src="data:image/gif;base64,<?php echo $profile_in; ?>" width="80px" alt="User Image">-->
                       <img src="http://novaagri.in/visitormanagment/api/<?php echo $profile_in; ?>" alt="User Image">
                    </a>
                      <br />
          
                     <a class="users-list-name" href='#' onClick='viewsignin("<?php echo $id; ?>")'><?php echo $full_name; ?></a>
                      <span class="users-list-date"><?php echo $signin_date; ?></span>

                       <a href='#' onClick='signbage("<?php echo $id; ?>")' title="View Visitor" class="btn btn-info btn-sm"><i class="fa fa-print"></i> print</a>
           <a href='#' onClick='viewsignin("<?php echo $id; ?>")' title="Edit Lunch" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> view</a>
                    </li>                 
<?php } } else { ?>   
<div class="box-body"><ul class="products-list product-list-in-box"><li class="item"><strong>No Recent Visitors.</strong></li></ul></div>
<?php } ?></ul>
                </div>
                <!--<div class="box-footer text-center">
                  <a href="visitors.php" class="uppercase">View All Visitors</a>
                </div>-->
              </div>
        </div>
         <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Visitors have Not Signed Out</h3>
               </div>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
          <?php
//Get visitors that have not signed out yet   
//if($account_type_id>1)  
  $q2="SELECT * FROM signin_tablet WHERE org_id=$org_id and user_id=$account_id and DATE(`signin_date`) = '".$today."' and signout_date IS NULL ORDER BY `signin_tablet`.`id` DESC";
//else      
  //$q2="SELECT * FROM signin_tablet WHERE 1 AND signout_date = '' ORDER BY `signin_tablet`.`id` DESC LIMIT 8";
  //echo $q2;exit;   
$list_visitors_result = mysqli_query($con_signin,$q2);
$count_visitors = mysqli_num_rows($list_visitors_result);

if($count_visitors != 0) {
while($row = mysqli_fetch_array($list_visitors_result)){
$id = $row['id'];
$signin_date = $row['signin_date'];
$signout_date = $row['signout_date'];
$full_name = $row['full_name'];
$profile_in = $row['profile_in'];

//Show image if none is in db  
if($profile_in == '') {
$profile_in = $visitor_profile_none;
}
?>  
                    <li>
                    <a href='#' onClick='viewsignin("<?php echo $id; ?>")'>
                    <img src="http://novaagri.in/visitormanagment/api/<?php echo $profile_in; ?>" width="80px" alt="User Image">
                    </a>
                      <br />
          
                      <a class="users-list-name" href='#' onClick='viewsignin("<?php echo $id; ?>")'><?php echo $full_name; ?></a>
                      <span class="users-list-date"><?php echo $signin_date; ?></span>
                       <a href='#' onClick='signbage("<?php echo $id; ?>")' title="View Visitor" class="btn btn-info btn-sm"><i class="fa fa-print"></i> print</a>
           <a href='#' onClick='viewsignin("<?php echo $id; ?>")' title="Edit Lunch" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> view</a>
                    </li>                 
<?php } } else { ?>   
<div class="box-body"><ul class="products-list product-list-in-box"><li class="item"><strong>No Recent Visitors.</strong></li></ul></div>
<?php } ?></ul>
                </div>
               <!-- <div class="box-footer text-center">
                  <a href="visitors.php" class="uppercase">View All Visitors</a>
                </div>-->
              </div>
            </div>
          </div>


      </div>      
        </section>
      </div>    
<?php include_once ('bottom.php'); ?>