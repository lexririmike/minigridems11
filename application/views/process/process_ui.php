

<div id="processlistModal<?php echo $id;?>" class="modal fade" tabindex="-1" role="dialog" >
<div class="modal-dialog" role="document">
		
		<div class="modal-content">
		<form method="post" accept-charset="utf-8" class="form-horizontal"action="<?php echo base_url($this->uri->segment(1).'/settings/feeds');?>" enctype="multipart/form-data">
         
    <div class="modal-header">
	<div class="row-info">
        <h3>FEED SETUP</h3>
		</div>
    </div>
    <div class="modal-body">
	<div class="row">
	<div class="clearfix"> </div>	
        <p>Log to feed: This processor logs to a timeseries feed which can then be used to explore historic data.</p>
              <input type="hidden" name="nodeid" value="<?php echo $node;?>" />
              <input type="hidden" name="inputid" value="<?php echo $id;?>" />
              <input type="hidden" name="slug" value="<?php echo $this->uri->segment(1);?>" />
			  
            <div class="form-group">
			<label for="ProcessInput" class="col-sm-2 control-label">Add/Edit process</label>
			<div class="col-sm-8">
                       <select id="feed-engine<?php echo $id;?>" class="form-control1" onchange="selFunction<?php echo $id;?>()">
                                        <option value="log">LOG TO FEED</option>
										<option value="+">+</option>
										<option value="X">X</option>
						</select>
               </div>
			   <input type="button" onclick="addFunction<?php echo $id;?>()" value="Add Value">
			   
			  
			   </div>
                          <div class="form-group" id="valinput<?php echo $id;?>" style="display: none;">
								<label for="feedtypeInput<?php echo $id;?>" class="col-sm-2 control-label">Value</label>
									<div class="col-sm-8">
                                    <input type="text" id="feedtypeInput<?php echo $id;?>" name="feedtypeInput" style="width:140px" placeholder="Type value..." />
                               </div>
							   
							   <input type="button" onclick="feedAdd<?php echo $id;?>()" value="Add Feed">
                            </div>
							<input type="hidden" id="hiddenfeed<?php echo $id;?>" name="hiddenfeed" value="" />
							 <div class="form-group">
								<label for="feedtypeName" class="col-sm-2 control-label">Feed Name</label>
									<div class="col-sm-8">
                                    <input type="text" id="feedtypeName" name="feedtypeName" style="width:140px" placeholder="FEED NAME" value="<?php if(!empty($fname)){echo $fname;}?>"/>
                                </div>
                            </div>
                          <div class="form-group">
			<label for="dataType" class="col-sm-2 control-label">Data Type</label>
			<div class="col-sm-8">
                                    <select name="dataType" id="dataType" class="form-control1">
                                        <option value=0>Generated</option>
                                        <option value=1>Distributed</option>
                                    </select>
                                </div>
                            </div>

           <?php if(empty($feeddb)){?>
			   

											<div class="form-group">
									<label for="GridrefInput" class="col-sm-2 control-label">Select CSV FILE</label>
									<div class="col-sm-8">
										<input type="file" class="form-control1" id="GridrefInput" name="GridfileInput" >
									</div>
									
									<div class="clearfix"> </div>	
								</div>
				<p style="background-color: #e4e4e4;">The csv has only two rows. Ensure the title for the rows in the csv are Timestamp and Values<p>
								
										
			   
		   <?php } ?>
                      
                     
<script>
			   
			   var nseldata<?php echo $id;?> = "";
function addFunction<?php echo $id;?>() {
     document.getElementById("valinput<?php echo $id;?>").style.display = "block";
	 
}
function selFunction<?php echo $id;?>() {
    var x = document.getElementById("feed-engine<?php echo $id;?>").value;
    nseldata<?php echo $id;?>= x;
}
function feedAdd<?php echo $id;?>() {
		var fdiv = document.getElementById('feedtypeInput<?php echo $id;?>');	
		var setval = fdiv.value;
        var incontent = document.getElementById('hiddenfeed<?php echo $id;?>');
          incontent.value = incontent.value + "|"+nseldata<?php echo $id;?>+setval;
       		  
	 }

</script>

</div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" id="close">Close</button>
        <button type="submit"  class="btn btn-success" style="float:right">Save</button>
    </div>
	</form>
	</div>
</div>
</div>

 