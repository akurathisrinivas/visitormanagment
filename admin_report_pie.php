<?php
$PageTitle = 'Piecharts';
require_once ('top.php');
$sql = "SELECT count(id),year(signin_date) FROM signin_tablet group by year(signin_date) order by year(signin_date) desc LIMIT 4";
$result = mysqli_query($con_signin, $sql);
function data($year){
    $link = mysqli_connect('localhost', 'root', '', 'omnisoft_visitorsmgt');
    $sql='call getVisitorsByYear('.$year.')';
    $result_y= mysqli_query($link, $sql);
   $prefix = '';
    echo "data : [\n";
    while ($row = mysqli_fetch_array($result_y)) {
        echo $prefix . " {\n";
        echo '  "title": "' . $row[1] . '",' . "\n";
        echo '  "value": ' . $row[0] . "\n" . ',';
        echo '  "discription": "click to drill down" ' . ',';
        echo  getDateByMonth($row[2],$row[3]);
        echo " }";
        $prefix = ",\n";
    }
    echo "\n]";    
}
function getDateByMonth($month,$year){
    $link = mysqli_connect('localhost', 'root', '', 'omnisoft_visitorsmgt');
    $sql='call getDatesByYear("'.$month.'","'.$year.'")';
    $result_y= mysqli_query($link, $sql);
   $prefix = '';
    echo "data : [";
    while ($row = mysqli_fetch_array($result_y)) {
        echo $prefix . " {";
        echo '  "title": "' . $row[1] . '",' ;
        echo '  "value": ' . $row[0] ;
        echo " }";
        $prefix = ",\n";
    }
    echo "\n]";    
}
?>
<!--<script language="javascript">
    function printdiv(printpage)
    {
        var headstr = "<html><head><title></title></head><body>";
        var footstr = "</body>";
        var newstr = document.all.item(printpage).innerHTML;
        var oldstr = document.body.innerHTML;
        document.body.innerHTML = headstr + newstr + footstr;
        window.print();
        document.body.innerHTML = oldstr;
        return false;
    }
</script>-->

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <div class="row">
                <div class="col-xs-6">Visitors Report</div>
                <!--                <div class="col-xs-6 text-right">
                                    <button id="printpagebutton" type="button" onClick="printdiv('div_print');" class="btn btn-primary btn" /><i class="fa fa-print"></i> Print Report</button>
                                </div>-->
            </div>
        </h1>
    </section>
    <section class="content">
        <style>

#chartdiv {
  width: 500px;
  height: 500px;
  margin: 0 auto;
}</style>
        <!-- Chart code -->
        <script type="text/javascript">
            var chartData =<?php
            $prefix = '';
    echo "[";
    while ($row = mysqli_fetch_array($result)) {
        echo $prefix . " {";
        echo '  "title": "' . $row[1] . '",' ;
        echo '  "value": "' . $row[0] . '",' ;
        echo '  "discription": "click to drill down" ' . ',';
        echo  data($row[1]);
        echo " }";
        $prefix = ",";
    }
    echo "]";
            ?>
                   
            // create pie chart
           var chart = AmCharts.makeChart("chartdiv", {
  "type": "pie",
  "dataProvider": chartData,
  "valueField": "value",
  "titleField": "title",
  "labelText": "[[title]]: [[value]]",
  "pullOutOnlyOne": true,
  "titles": [{
    "text": "Last 4 Years Visitors Count"
  }],
  "allLabels": []
});

// initialize step array
chart.drillLevels = [{
  "title": "Departments",
  "data": chartData
}];

// add slice click handler
chart.addListener("clickSlice", function (event) {
  
  // get chart object
  var chart = event.chart;
  
  // check if drill-down data is avaliable
  if (event.dataItem.dataContext.data !== undefined) {
    
    // save for back button
    chart.drillLevels.push(event.dataItem.dataContext);
    
    // replace data
    chart.dataProvider = event.dataItem.dataContext.data;
    
    // replace title
    chart.titles[0].text = event.dataItem.dataContext.title+" - Visitors Count";
    
    // add back link
    // let's add a label to go back to yearly data
    event.chart.addLabel(
      0, 25, 
      "< Go back",
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      'javascript:drillUp();');
    
    // take in data and animate
    chart.validateData();
    chart.animateAgain();
  }
});

function drillUp() {
  
  // get level
  chart.drillLevels.pop();
  var level = chart.drillLevels[chart.drillLevels.length - 1];
  
  // replace data
  chart.dataProvider = level.data;

  // replace title
  chart.titles[0].text = level.title;
  
  // remove labels
  if (chart.drillLevels.length === 1)
    chart.clearLabels();
  
  // take in data and animate
  chart.validateData();
  chart.animateAgain();
}

            </script>
            
            <div id="chartdiv"></div>
        <?php //include_once('admin_report_pie.php'); ?>
    </section>
<!--    <section class="content">
    <?php //include_once ('admin_report_pie.php'); ?>
    </section>-->
</div>
<?php include_once ('bottom.php'); ?>
        


