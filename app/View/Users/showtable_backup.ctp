<form class="form-horizontal" onsubmit="onSubmit()">
<fieldset>


<legend>Selected Database :<?php 
echo $databasename
?> </legend>


<div class="form-group">
  <label class="col-md-4 control-laabel" for="selectbasic">Table List</label>
  <div class="col-md-4">
    <select id="selectbasicdata" name="selectbasic" class="form-control" onchange="changed();" > 
      <?php
foreach ($data as $data) {
	echo '<option>';
	    //print_r($data);
      echo $data["TABLE_NAMES"]["Tables_in_$databasename"];
      echo '</option>';
  }

     ?>
    </select>
      
  </div>
</div>

</fieldset>
   
</form>
 



<div id="dynamictable" class="table-responsive"></div>
<button id="click" onclick="onClick()">Click</button>
<script>
function changed()
{
var e = document.getElementById("selectbasicdata");
var value = e.options[e.selectedIndex].value;
var text = e.options[e.selectedIndex].text;

 $.ajax({
             type: "post",  // Request method: post, get
             url: "<?php echo $this->params->webroot?>users/listfields", // URL to request
             data: {tableid:text},  // post data
             success: function(response) {
                                var data=JSON.parse(response);
                               
                               
                                 $('#dynamictable').empty();

                          $('#dynamictable').append('<table id="dynamicTable" class="table"></table>');
var table = $('#dynamictable').children();    
                               for (var i = 0; i < data.length; i++) {

                                                
table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+data[i].COLUMNS.Field+"</td>");

// $('#dynamictable').empty();
}
                           



                           },
                           error:function (XMLHttpRequest, textStatus, errorThrown) {
                                  alert(textStatus);
                           }
          });
          
          
}


function onClick()
{
    
     //window.alert($databasename);
   // var database=$databasename;
    var e = document.getElementById("selectbasicdata");
    var value = e.options[e.selectedIndex].value;
    var text = e.options[e.selectedIndex].text;
        
        window.alert("rowLength2");
        $(':checkbox').prop('checked', true);
         window.alert("checkboxes");
        //window.alert("sometext");
    var oTableData = [];
    //gets table
    var oTable = document.getElementById('dynamicTable');

    //gets rows of table
    var rowLength = oTable.rows.length;



    window.alert(rowLength);
    var checkboxes = document.querySelectorAll("dynamicTable input[type=checkbox]");
     window.alert(checkboxes);
   // window.alert(checkboxes[0].checked);
    
    
    $.ajax({
             type: "post",  // Request method: post, get
             url: "<?php echo $this->params->webroot?>users/listfieldsdata", // URL to request
             data: {tableid:text},  // post data
             success: function(response) {
                         window.alert("$data");
                                var data=JSON.parse(response);
                              // window.alert($data);
                               
                                 $('#dynamictable').empty();

                          $('#dynamictable').append('<table id="dynamicTable" class="table"></table>');
var table = $('#dynamictable').children();    
                               
var jsonStr = JSON.stringify(data);
    table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+jsonStr+"</td>");

                           },
                           error:function (XMLHttpRequest, textStatus, errorThrown) {
                                  alert(textStatus);
                           }
          });
    
    
    
    
    
    }
   
</script>
