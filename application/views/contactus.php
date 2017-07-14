<div id="page-wrapper">
			<div class="main-page compose">
			<div class="col-md-8 compose-right widget-shadow">
			<div class="panel-default">
						<div class="panel-heading">
							Compose New Message 
						</div>
						<div class="panel-body">
							<div class="alert alert-info">
								Please fill details to send a new message
							</div>
							<form method="post" accept-charset="utf-8"  class="com-mail" action="<?php echo base_url('help/contactus');?>">
								<input type="text" name="EmailInput" class="form-control1 control3" placeholder="FROM :">
								<input type="text" name="SubjectInput" class="form-control1 control3" placeholder="Subject :">
								<textarea rows="6" name="MessageInput" class="form-control1 control2" placeholder="Message :" ></textarea>
								
								<input type="submit" value="Send Message"> 
							</form>
						</div>
					</div>
					<div class="clearfix"> </div>	
					</div>
			</div>
			</div>