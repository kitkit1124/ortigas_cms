<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<?php echo form_open(current_url(), array('class'=>'form'));?>
		<div class="row">
			<div class="col form-group">
				<label for="first_name"><?php echo lang('first_name')?>:</label>
				<?php echo form_input(array('id'=>'first_name', 'name'=>'first_name', 'value'=>set_value('first_name', isset($record->first_name) ? $record->first_name : ''), 'class'=>'form-control'));?>
				<div id="error-first_name"></div>
			</div>

			<div class="col form-group">
				<label for="last_name"><?php echo lang('last_name')?>:</label>
				<?php echo form_input(array('id'=>'last_name', 'name'=>'last_name', 'value'=>set_value('last_name', isset($record->last_name) ? $record->last_name : ''), 'class'=>'form-control'));?>
				<div id="error-last_name"></div>
			</div>
		</div>

		<div class="row">
			<div class="col form-group">
				<label for="company"><?php echo lang('company')?>:</label>
				<?php echo form_input(array('id'=>'company', 'name'=>'company', 'value'=>set_value('company', isset($record->company) ? $record->company : ''), 'class'=>'form-control'));?>
				<div id="error-company"></div>
			</div>

			<div class="col form-group">
				<label for="phone"><?php echo lang('phone')?>:</label>
				<?php echo form_input(array('id'=>'phone', 'name'=>'phone', 'value'=>set_value('phone', isset($record->phone) ? $record->phone : ''), 'class'=>'form-control'));?>
				<div id="error-phone"></div>
			</div>
		</div>

		<div class="form-group">
			<label for="email"><?php echo lang('email')?>:</label>
			<?php echo form_input(array('id'=>'email', 'name'=>'email', 'value'=>set_value('email', isset($record->email) ? $record->email : ''), 'class'=>'form-control'));?>
			<div id="error-email"></div>
		</div>


		<div class="row">
			<div class="col form-group">
				<label for="password"><?php echo lang('password')?>:</label>
				<?php echo form_password(array('id'=>'password', 'name'=>'password', 'value'=>set_value('password'), 'class'=>'form-control'));?>
				<div id="error-password"></div>
				<?php if ($page_type == 'edit'): ?>
					<small class="form-text text-muted"><?php echo lang('edit_leave_blank')?></small>
				<?php endif; ?>
			</div>

			<div class="col form-group">
				<label for="password_confirm"><?php echo lang('password_confirm')?>:</label>
				<?php echo form_password(array('id'=>'password_confirm', 'name'=>'password_confirm', 'value'=>set_value('password_confirm'), 'class'=>'form-control'));?>
				<div id="error-password_confirm"></div>
			</div>
		</div>
		

		<div class="form-group">
			<label for="groups"><?php echo lang('groups')?>:</label>
			<select id="groups" class="custom-select" multiple="multiple">
				<?php foreach ($groups as $group):?>
					<option value="<?php echo $group->id?>"<?php echo (in_array($group->id, $current_groups)) ? ' selected': ''; ?>><?php echo $group->name?></option>
				<?php endforeach; ?>
			</select>
			<div id="error-groups"></div>
		</div>

	<?php echo form_close();?>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if ($page_type == 'add'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php else: ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php endif; ?>
</div>