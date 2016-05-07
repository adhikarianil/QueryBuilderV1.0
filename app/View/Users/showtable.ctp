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

                                                
//table.append("<tr><td id=td"+i+"><input type=checkbox name=rbtnCount id="+i+" />"+" "+data[i].COLUMNS.Field+"</td>");
table.append("<tr><td><input type=checkbox name=rbtnCount id="+i+" /></td>"+"<td id=td"+i+">"+data[i].COLUMNS.Field+"</td>");
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
        
        //window.alert("rowLength2");
        
        //Code to check all check boxes used for testing
       /* $(':checkbox').prop('checked', true);
         window.alert("checkboxes");*/
        //window.alert("sometext");
        
        
    var oTableData = [];
    //gets table
    var oTable = document.getElementById('dynamicTable');

    //gets rows of table
    var rowLength = oTable.rows.length;


    
    //window.alert(rowLength);
   // var checkboxes = document.querySelectorAll("dynamicTable input[type=checkbox]");
     //window.alert(checkboxes);
     var field="";
  var fieldArray=[];    
   
 for(var i=0;i<rowLength;i++){
 if(document.getElementById(i).checked)
 {
    //window.alert(document.getElementById("td"+i).innerHTML);
    fieldArray.push(document.getElementById("td"+i).innerHTML); 
      //field=field+document.getElementById("td"+i).innerHTML+" "
 }
 }
 //condition to check if no checkbox are checked and break the execution of the onClick function incase nothing is checked.
 if( fieldArray.length == 0)
 {
    window.alert("Please select at least one checkbox");
    return;
 }
 //Creating comma separated database table element, for use with SQL query.
 
 
 if(fieldArray.length>1)
 {
 for(var i=0;i<fieldArray.length-1;i++)
 {
     field=field+fieldArray[i]+",";
 }
 field=field+fieldArray[fieldArray.length-1];
 }
 else
 {
     field=field+fieldArray[fieldArray.length-1];
 }
   
   
 //window.alert(field);
  
  //creating ajax xml query request which goes to userconroller and uses the listfieldsdata method to fetch details
  //from database.
    $.ajax({
             type: "post",  // Request method: post, get
             url: "<?php echo $this->params->webroot?>users/listfieldsdata", // URL to request
             data: {tableid:text,tablefield:field},  // post data
             success: function(response) {
				 content="";
				 
                                var data=JSON.parse(response);
                              // window.alert($data);
                               
                                 $('#dynamictable').empty();

                          $('#dynamictable').append('<table id="dynamicTable" class="table"></table>');
var table = $('#dynamictable').children();  




content+="<tr>";
				 
				 for(var i=0;i<fieldArray.length;i++)
 {
     content+="<td><b>"+fieldArray[i]+"</b></td>";
 }
                         content+="</tr>";

//iterating through JSON data object returned from the database.

//window.alert(jsonStr);
for (var key in data) {
	
	content+="<tr>";
     
    for(var key2 in data[key])
    {
   // table.append("<tr>");
    for(var key3 in data[key][key2])
    {
      
        //var jsonStr1 = JSON.stringify(key3);
   // table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+jsonStr1+"</td>");
    //table.append("<td>"+data[key][key2][key3]+"</td></tr>");
    //table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+key2+"</td>");
	content+="<td>"+data[key][key2][key3]+"</td>";
    
    }
    
     //table.append("</tr>");
    
    }
     //table.append("</tr>");
	 content+="</tr>";
}    

window.alert(content);
table.append(content);

/*for (var i = 0; i < data.length; i++) {
window.alert(data.length);
                                                
table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+data[i]+"</td>");

// $('#dynamictable').empty();
}*/
                               
//var jsonStr = JSON.stringify(data);
    //table.append("<tr><td><input type=checkbox name=rbtnCount /></td><td>"+jsonStr+"</td>");

                           },
                           error:function (XMLHttpRequest, textStatus, errorThrown) {
                                  alert(textStatus);
                           }
          });
    
    
    
    
    
    }
   
</script>
