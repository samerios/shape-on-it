<?php /*include header file*/
include "header.php"; ?>
<br/>
<!DOCTYPE html>
<html>
<head>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>
<body>
  <!-- header-->

<h1 align="center">'Shape On It' | Work schedule</h1>

<div id="main" style="width: 100%; height: 350px; margin-bottom: 10px;"></div>


<script type="text/javascript">
//grid setting
var config = {
    grid: { 
        name: 'grid',
        selectType: 'cell',
        show: { 
            footer: true,
            lineNumbers: false
        },
        onColumnClick: function (event) {
            this.selectNone();
            var column = this.getColumn(event.field, true);
            var sel    = [];
            for (var i = 0; i < this.total; i++) {
                sel.push({ recid: this.records[i].recid, column: column });

            }
            this.select.apply(this, sel);
            event.preventDefault();

        },
        onSelectionExtend: function (event) {
            event.onComplete = function () {
                console.log('Original:', event.originalRange[0], '-', event.originalRange[1]);
                console.log('New:', event.newRange[0], '-', event.newRange[1]);
               // w2alert('Selection expanded (see more details in the console).');
            }
        },

         onDelete: function (event) {
            event.force = true;
        }
    }
};

$(function () {
    // initialization
    $().w2grid(config.grid);
    // create columns
    var tmp = ['hour','sunday', 'monday', 'tuesday', 'wedensday', 'thursday', 'friday', 'saturday'];
    var values     = {};
    for (var i = 0; i < tmp.length; i++) {
        w2ui.grid.columns.push({
            field: tmp[i],
            caption: '<div style="text-align: center">' + tmp[i].toUpperCase() + '</div>',
            size: '15%',
            resizable: true,
            sortable: false,
            editable: false,

            render: function (record, index, col_index) {
                var field     = this.columns[col_index].field;
                var val     = record[field];
                var style     = '';
                if (record.changed && record.changes[field]) val = record.changes[field];
                if (record.style && record.style[col_index]) style = record.style[col_index];
                return '<div style="'+ style +'; padding: 15px 3px; height: '+ this.recordHeight +'px">'+ val +'</div>';
            }
        });
        values[tmp[i]] = '';
    }

    // insert  records

    try{

    <?php
//get all work scuhedule data by "getWorkScchedule" function
$schedule = getWorkScchedule();
$count = count((array)getWorkScchedule());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>0)
    {
      //convert array from php to js array

      var schedule = [];
      var schedule = <?php echo json_encode($schedule); ?>;

        for (var i = 0; i < lenght;i++){
        w2ui.grid.records.push($.extend({ recid:i+1 }, values));    
        }
        w2ui.grid.total = w2ui.grid.records.length;
        w2ui.grid.buffered = w2ui.grid.total;
        // init some values
        var rec = w2ui.grid.records;
  //add work schedule details to grid and show them

   for(var i=0;i<lenght;i++)
   {

          $.extend(rec[i], { hour : schedule[i].hour,sunday : schedule[i].sunday,
            monday : schedule[i].monday,tuesday : schedule[i].tuesday,
            wedensday : schedule[i].wedensday,thursday : schedule[i].thursday,
            friday : schedule[i].friday,saturday : schedule[i].saturday});
   }   
  }


}catch(e)
{

}


    $('#main').w2render('grid');
});


</script>

</body>
</html>

<?php include /*include footer file*/
"footer.php"; ?>
