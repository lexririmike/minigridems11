<div id="page-wrapper">
			<div class="main-page">
			<div class="tables">
<h1 class="title1"><?php echo lang('groups_heading');?></h1>
<p><?php echo lang('groups_subheading');?></p>

<div class="panel-body widget-shadow">
<table class="table table-hover table-bordered">
	<tr>
		<th><?php echo lang('groups_id');?></th>
		<th><?php echo lang('groups_name');?></th>
		<th><?php echo lang('groups_description');?></th>
		<th></th>
		
	</tr>
	<?php foreach ($groups as $group):?>
		<tr class="info">
            <td><?php echo htmlspecialchars($group->id,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
			<td>
				
					<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                
			</td>
			
		</tr>
	<?php endforeach;?>
</table>
</div>
<p> <?php echo anchor('auth/create_group', lang('groups_create_group_link'))?></p>
</div>
</div>
</div>