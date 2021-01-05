<?php
/*include header file*/
include "header.php";
try {
    //get workplan from url and save in variable
    if (isset($_GET['workPlan'])) {
        $workPlanId = $_GET['workPlan'];
        //get workpkan name
        $plans=getWorkPlans();
        for($i=0;$i<count((array)getWorkPlans());$i++)
          if($workPlanId==$plans[$i]->id) $workplanName=$plans[$i]->name;

    }
    //get number of "yes" feedbacks belong work plan by "getWorkplanFeedbacks" function
    $yes = getWorkplanFeedbacks($workPlanId, 'yes');
    //get number of "no" feedbacks belong work plan by "getWorkplanFeedbacks" function
    $no = getWorkplanFeedbacks($workPlanId, 'no');
    //save in array number of yes and no  and work plan id for calculate the feedbacks percent
    $php_data_array = [[$workPlanId, $yes, "satisfied"], [$workPlanId, $no, "not satisfied"]];
    //convert array from php to js array
    echo "<script>
        var my_2d = " . json_encode($php_data_array) . "
</script>";
}
catch(Exception $e) {
    print 'no feedbacks available';
}
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>

  try{

     google.charts.load('current', {'packages':['corechart']});
     // Draw the pie chart when Charts is loaded.
      google.charts.setOnLoadCallback(draw_my_chart);
      // Callback that draws the pie chart
      function draw_my_chart() {
        // Create the data table .
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'language');
        data.addColumn('number', 'Nos');
        for(i = 0; i < my_2d.length; i++)
    data.addRow([my_2d[i][2], parseInt(my_2d[i][1])]);
// above row adds the JavaScript two dimensional array data into required chart format
    var options = {title:'Feedback to workout ID: <?php echo $workPlanId ?> | NAME: <?php echo $workplanName?>',
                       width:1200,
                       height:600};

        // Instantiate and draw the chart
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

  }catch(e){document.write('No feedbacks available');}

</script>
    
<div id="chart_div"></div>
<?php /*include footer file*/
include "footer.php"; ?>
