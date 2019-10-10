<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
				<div class="form-group">
			<label for="customer_fname"><?php echo lang('customer_fname')?>:</label>			
			<?php echo form_input(array('id'=>'customer_fname', 'name'=>'customer_fname', 'value'=>set_value('customer_fname', isset($record->customer_fname) ? $record->customer_fname : ''), 'class'=>'form-control'));?>
			<div id="error-customer_fname"></div>			
		</div>

		<div class="form-group">
			<label for="customer_lname"><?php echo lang('customer_lname')?>:</label>			
			<?php echo form_input(array('id'=>'customer_lname', 'name'=>'customer_lname', 'value'=>set_value('customer_lname', isset($record->customer_lname) ? $record->customer_lname : ''), 'class'=>'form-control'));?>
			<div id="error-customer_lname"></div>			
		</div>

		<div class="form-group">
			<label for="customer_telno"><?php echo lang('customer_telno')?>:</label>			
			<?php echo form_input(array('id'=>'customer_telno', 'name'=>'customer_telno', 'value'=>set_value('customer_telno', isset($record->customer_telno) ? $record->customer_telno : ''), 'class'=>'form-control'));?>
			<div id="error-customer_telno"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mobileno"><?php echo lang('customer_mobileno')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mobileno', 'name'=>'customer_mobileno', 'value'=>set_value('customer_mobileno', isset($record->customer_mobileno) ? $record->customer_mobileno : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mobileno"></div>			
		</div>

		<div class="form-group">
			<label for="customer_email"><?php echo lang('customer_email')?>:</label>			
			<?php echo form_input(array('id'=>'customer_email', 'name'=>'customer_email', 'value'=>set_value('customer_email', isset($record->customer_email) ? $record->customer_email : ''), 'class'=>'form-control'));?>
			<div id="error-customer_email"></div>			
		</div>

		<div class="form-group">
			<label for="customer_id_type"><?php echo lang('customer_id_type')?>:</label>			
			<?php echo form_input(array('id'=>'customer_id_type', 'name'=>'customer_id_type', 'value'=>set_value('customer_id_type', isset($record->customer_id_type) ? $record->customer_id_type : ''), 'class'=>'form-control'));?>
			<div id="error-customer_id_type"></div>			
		</div>

		<div class="form-group">
			<label for="customer_id_details"><?php echo lang('customer_id_details')?>:</label>			
			<?php echo form_input(array('id'=>'customer_id_details', 'name'=>'customer_id_details', 'value'=>set_value('customer_id_details', isset($record->customer_id_details) ? $record->customer_id_details : ''), 'class'=>'form-control'));?>
			<div id="error-customer_id_details"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_country"><?php echo lang('customer_mailing_country')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_country', 'name'=>'customer_mailing_country', 'value'=>set_value('customer_mailing_country', isset($record->customer_mailing_country) ? $record->customer_mailing_country : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_country"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_house_no"><?php echo lang('customer_mailing_house_no')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_house_no', 'name'=>'customer_mailing_house_no', 'value'=>set_value('customer_mailing_house_no', isset($record->customer_mailing_house_no) ? $record->customer_mailing_house_no : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_house_no"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_street"><?php echo lang('customer_mailing_street')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_street', 'name'=>'customer_mailing_street', 'value'=>set_value('customer_mailing_street', isset($record->customer_mailing_street) ? $record->customer_mailing_street : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_street"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_city"><?php echo lang('customer_mailing_city')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_city', 'name'=>'customer_mailing_city', 'value'=>set_value('customer_mailing_city', isset($record->customer_mailing_city) ? $record->customer_mailing_city : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_city"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_brgy"><?php echo lang('customer_mailing_brgy')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_brgy', 'name'=>'customer_mailing_brgy', 'value'=>set_value('customer_mailing_brgy', isset($record->customer_mailing_brgy) ? $record->customer_mailing_brgy : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_brgy"></div>			
		</div>

		<div class="form-group">
			<label for="customer_mailing_zip_code"><?php echo lang('customer_mailing_zip_code')?>:</label>			
			<?php echo form_input(array('id'=>'customer_mailing_zip_code', 'name'=>'customer_mailing_zip_code', 'value'=>set_value('customer_mailing_zip_code', isset($record->customer_mailing_zip_code) ? $record->customer_mailing_zip_code : ''), 'class'=>'form-control'));?>
			<div id="error-customer_mailing_zip_code"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_country"><?php echo lang('customer_billing_country')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_country', 'name'=>'customer_billing_country', 'value'=>set_value('customer_billing_country', isset($record->customer_billing_country) ? $record->customer_billing_country : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_country"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_house_no"><?php echo lang('customer_billing_house_no')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_house_no', 'name'=>'customer_billing_house_no', 'value'=>set_value('customer_billing_house_no', isset($record->customer_billing_house_no) ? $record->customer_billing_house_no : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_house_no"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_street"><?php echo lang('customer_billing_street')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_street', 'name'=>'customer_billing_street', 'value'=>set_value('customer_billing_street', isset($record->customer_billing_street) ? $record->customer_billing_street : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_street"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_city"><?php echo lang('customer_billing_city')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_city', 'name'=>'customer_billing_city', 'value'=>set_value('customer_billing_city', isset($record->customer_billing_city) ? $record->customer_billing_city : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_city"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_brgy"><?php echo lang('customer_billing_brgy')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_brgy', 'name'=>'customer_billing_brgy', 'value'=>set_value('customer_billing_brgy', isset($record->customer_billing_brgy) ? $record->customer_billing_brgy : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_brgy"></div>			
		</div>

		<div class="form-group">
			<label for="customer_billing_zip_code"><?php echo lang('customer_billing_zip_code')?>:</label>			
			<?php echo form_input(array('id'=>'customer_billing_zip_code', 'name'=>'customer_billing_zip_code', 'value'=>set_value('customer_billing_zip_code', isset($record->customer_billing_zip_code) ? $record->customer_billing_zip_code : ''), 'class'=>'form-control'));?>
			<div id="error-customer_billing_zip_code"></div>			
		</div>



	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if ($action == 'add'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php elseif ($action == 'edit'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php else: ?>
		<script>$(".modal-body :input").attr("disabled", true);</script>
	<?php endif; ?>
</div>	