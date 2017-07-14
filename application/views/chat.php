<div id="page-wrapper">
<div class="main-page">
			<div class="row-one">
					<div class="col-md-5 profile widget-shadow">
						<h4 class="title3">Create A new Message</h4>
						<div class="profile-top">
							<img src="<?php echo base_url('uploads/profilepics/'.$user_profile); ?>" alt="" height=80 width=80>
							<h4><?php $user = $this->ion_auth->user()->row();
															echo $user->first_name;
											?></h4>
							<h5><?php echo $user->last_name;?></h5>
						</div>
						<div class="profile-text">
									

			<?php $attributes = array('id' => 'form_create','class'=>'form-horizontal'); ?>
			<?php echo form_open($this->uri->segment(1).'/chat/create', $attributes);?>
			<input type="hidden" name="HiddenUrl" id="HiddenUrl" value="<?php echo $this->uri->segment(1);?>" />
             <div class="form-body">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="title">Title:</label>
				<div class="col-sm-8">
				<input required="required" class="form-control1" type="text" name="title" id="title" />
			</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="content">Content:</label>
				<div class="col-sm-8">
				<textarea class="f-left col-twothirds" required="required" class="form-control1" type="textarea" rows="10" cols="50" name="content" id="content"></textarea>		
			</div>
			</div>
			<div class="form-group">
			<div class="col-sm-8">
				<input type="submit" class="btn btn-default"  value="Submit" id="submit-create" />
			</div>
			</div>
			</div>
			<?php echo form_close(); ?>				
		
							
						</div>
						
					</div>
					<div class="col-md-5 profile widget-shadow chat-mdl-grid">
						<h4 class="title3">MESSAGE BOARD</h4>
						<div class="scrollbar scrollbar1">
						<?php if(isset($records)) : foreach($records as $row) : ?>
							<div class="activity-row activity-row1 activity-right">
								<div class="col-xs-3 activity-img"><img src="images/1.png" class="img-responsive" alt=""></div>
								<div class="col-xs-9 activity-img1">
									<div class="activity-desc-sub">
									<h3><?php echo $row->title; ?></h3>
										<p><?php echo $row->message; ?></p>
										<small><?php echo anchor( $this->uri->segment(1)."/chat/delete/$row->id",'Delete', array('class' => 'confirmClick')); ?></small>
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#conf">Reply</button>
										<div id="conf" class="modal fade" role="dialog">
						<div class="modal-dialog" role="document">
								<div class="modal-content">
								<?php $attributes = array('id' => 'form_create','class'=>'form-horizontal'); ?>
			<?php echo form_open($this->uri->segment(1).'/chat/reply', $attributes);?>
			<div class="modal-body">
			<input type="hidden" name="HiddenUrl" id="HiddenUrl" value="<?php echo $this->uri->segment(1);?>" />
			<input type="hidden" name="HiddenId" id="HiddenId" value="<?php echo $row->id;?>" />
             <div class="form-body">
					
						<div class="form-group">
				<label class="col-sm-2 control-label" for="content">Reply:</label>
				<div class="col-sm-8">
				<textarea class="f-left col-twothirds" required="required" class="form-control1" type="textarea" rows="4" cols="50" name="content" id="content"></textarea>		
			</div>
			</div>
						</div>
					<div class="modal-footer">
				<input type="submit" class="btn btn-default"  value="Submit" id="submit-create" />
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
				</div>
				</div>
				<?php echo form_close(); ?>	
				</div>
				</div>
				</div>
										<span><?php echo $row->timestamp; ?></span>
										</div>
								</div>
								<div class="clearfix"> </div>
								</div>
								<?php if(!empty($replys)) : foreach($replys as $reply) : ?>
								<div class="activity-row activity-row1 activity-left">
								<div class="col-xs-9 activity-img2">
									<div class="activity-desc-sub1">
										<p><?php echo $reply->reply;?></p>
										<span class="right"><?php echo $reply->timestamp; ?></span>
									</div>
								</div>
								<div class="col-xs-3 activity-img"><img src="images/3.png" class="img-responsive" alt=""></div>
								<div class="clearfix"> </div>
							</div>
							<?php endforeach; ?>
							<?php endif;?>
										<?php endforeach; ?>
										<?php else : ?>	
										<div class="activity-row activity-row1 activity-right">
										<div class="col-xs-9 activity-img1">
									<div class="activity-desc-sub">
										<h2>No records</h2>
										</div>
								</div>
								</div>
										<?php endif;?>		
									
								
								<div class="clearfix"> </div>
							</div>

				        <div class="chat-bottom">
							
						</div>
						</div>
						<div class="clearfix"> </div>
				<div class="clearfix"> </div>
					</div>
					
					
				</div>
				
			</div>
			