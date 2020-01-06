<?php 

$PageTitle = 'Visitor_Report';

require_once ('top.php');



//Count recent user activity 

/*$sql_act_count = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_00' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity = mysqli_num_rows($sql_act_count);



$sql_act_count00 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_00' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity00 = mysqli_num_rows($sql_act_count00);



$sql_act_count11 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_11' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity11 = mysqli_num_rows($sql_act_count11);



$sql_act_count22 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_22' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity22 = mysqli_num_rows($sql_act_count22);



$sql_act_count33 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_33' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity33 = mysqli_num_rows($sql_act_count33);



$sql_act_count44 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_44' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity44 = mysqli_num_rows($sql_act_count44);



$sql_act_count55 = mysqli_query($con_signin, "SELECT * FROM signin_tablet WHERE LEFT(signin_date, 10) = '$fptime_55' ORDER BY `signin_tablet`.`signin_date` DESC");

$log_activity55 = mysqli_num_rows($sql_act_count55);*/

?>

<!--<script language="javascript">

function printdiv(printpage)

{

var headstr = "<html><head><title></title></head><body>";

var footstr = "</body>";

var newstr = document.all.item(printpage).innerHTML;

var oldstr = document.body.innerHTML;

document.body.innerHTML = headstr+newstr+footstr;

window.print();

document.body.innerHTML = oldstr;

return false;

}

</script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

      <div class="content-wrapper">

        <section class="content-header">

          <h1>

		  <div class="row">

            <div class="col-xs-6">Visitors Report</div>

			<div class="col-xs-6 text-right">

			<button id="printpagebutton" type="button" onClick="printdiv('div_print');" class="btn btn-primary btn" /><i class="fa fa-print"></i> Print Report</button>

			</div>

			</div>

          </h1>

        </section>

        <section class="content">

          <div class="row">

       <div id="div_print" class="col-xs-12">

		<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});

      google.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([

          ['Year', '# of Visitors'],

		  ['100', 100],

		  ['50', 25],

		  ['<?php echo $fptime_33; ?>', <?php echo $log_activity33; ?>],

		  ['<?php echo $fptime_22; ?>', <?php echo $log_activity22; ?>],

          ['<?php echo $fptime_11; ?>', <?php echo $log_activity11; ?>],		  

          ['<?php echo $fptime_00; ?>', <?php echo $log_activity00; ?>],



        ]);



        var options = {

          title: 'Visitors Activity',

          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},

          vAxis: {minValue: 0}

        };



        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));

        chart.draw(data, options);

      }

    </script>

	<div id="chart_div" style="width: 100%px; height: 500px;"></div>

	</div>

	</div>

        </section>

      </div>-->
      <?php 
session_start();
$account_id=$_SESSION['account_id'];
$org_id=$_SESSION['org_id'];
$m= date("m");

$de= date("d");

$y= date("Y");
$week_days=array();
for($i=0; $i<=6; $i++){

$day= "'".date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y))."'"; 
$week_days[]= $day;

$query="select count(id) as vis_count from signin_tablet where signin_date=$day and user_id=$account_id and org_id=$org_id";
//echo $query;exit;
$q_row = mysqli_query($con_signin, $query);
$row = mysqli_fetch_assoc($q_row);
$day_count=$row['vis_count'];
$day_counts[]=$day_count;
}

//echo '<pre>';print_r($day_counts);exit;
$week_days_str=implode(',',array_reverse($week_days));
$week_days_counts=implode(',',array_reverse($day_counts));
//echo '<pre>';print_r($week_days_str);exit;
      ?>
<div class="content-wrapper">

        <section class="content-header">

          <h1>

     

  <div class="col-xs-12">Visitors Report</div>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



        </section>

      </div>

<style type="text/css">
  
  #container {
  min-width: 310px;
  max-width: 800px;
  height: 400px;
  margin: 0 auto
}
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<!--<script src="https://code.highcharts.com/modules/series-label.js"></script>-->
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script type="text/javascript">
  
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Weekly Report'
    },
    subtitle: {
        text: 'Source: Novagroup.com'
    },
    xAxis: {
        categories: [<?php echo $week_days_str;?>]
    },
    yAxis: {
        title: {
            text: 'Total Weekly Report'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Total Visitors',
        data: [<?php echo $week_days_counts; ?>]
    }]
});

</script> 


<?php include_once ('bottom.php'); ?>