<form class="form-horizontal">
<fieldset>


<legend>Selected Database :<?php echo $databasename?> </legend>


<div class="form-group">
  <label class="col-md-4 control-laabel" for="selectbasic">Table List</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control" onchange="changed();"> 
      <?php
foreach ($data as $data) {
	echo '<option>';
	   // print_r($data);
      echo $data["TABLE_NAMES"]["Tables_in_$databasename"];
      echo '</option>';
  }

     ?>
    </select>
  </div>
</div>

</fieldset>
</form>
<script>
function changed()
{
var e = document.getElementById("selectbasic");
var value = e.options[e.selectedIndex].value;
var text = e.options[e.selectedIndex].text;
  $.ajax({
                url: "http://localhost/cake_querybuilder/users/listfields",
                type: 'POST',
                data: {tableid:text},
                success: function(result) {
                    // process the results from ttroller action
                }
            });
}

</script>