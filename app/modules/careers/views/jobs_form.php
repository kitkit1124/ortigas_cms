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
			<div class="row">
				<div class="col-sm-2">
					<label for="Date"><?php echo lang('date')?>:</label>	
				</div>
				<div class="col-sm-10">
					<?php 
					$dtpost = date_create($record->job_created_on); 
					echo form_input(array('id'=>'Date', 'name'=>'Date', 'value'=>set_value('Date', isset($record->job_created_on) ? date_format($dtpost,"F j, Y - h:s A") : ''), 'class'=>'form-control'));?>
				</div>
			</div>		
		</div>


		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="division_id"><?php echo lang('division_id')?>:</label>	
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'division_id', 'name'=>'division_id', 'value'=>set_value('division_id', isset($divisions->division_name) ? $divisions->division_name : ''), 'class'=>'form-control'));?>
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="department_id"><?php echo lang('department_id')?>:</label>	
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'department_id', 'name'=>'department_id', 'value'=>set_value('department_id', isset($departments->department_name) ? $departments->department_name : ''), 'class'=>'form-control'));?>
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_career_id"><?php echo lang('job_career_id')?>:</label>	
				</div>
				<div class="col-sm-10">
						<?php echo form_dropdown('job_career_id', $careers, set_value('job_career_id', (isset($record->job_career_id)) ? $record->job_career_id : ''), 'id="job_career_id" class="form-control"'); ?>
					<div id="error-job_career_id"></div>	
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_applicant_name"><?php echo lang('job_applicant_name')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'job_applicant_name', 'name'=>'job_applicant_name', 'value'=>set_value('job_applicant_name', isset($record->job_applicant_name) ? $record->job_applicant_name : ''), 'class'=>'form-control'));?>
					<div id="error-job_applicant_name"></div>			
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_email"><?php echo lang('job_email')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'job_email', 'name'=>'job_email', 'value'=>set_value('job_email', isset($record->job_email) ? $record->job_email : ''), 'class'=>'form-control'));?>
					<div id="error-job_email"></div>			
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_mobile"><?php echo lang('job_mobile')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'job_mobile', 'name'=>'job_mobile', 'value'=>set_value('job_mobile', isset($record->job_mobile) ? $record->job_mobile : ''), 'class'=>'form-control'));?>
					<div id="error-job_mobile"></div>			
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_referred"><?php echo lang('job_referred')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php echo form_input(array('id'=>'job_referred', 'name'=>'job_referred', 'value'=>set_value('job_referred', isset($record->job_referred) ? $record->job_referred : '', false), 'class'=>'form-control'));?>
					<div id="error-job_referred"></div>			
				</div>
			</div>		
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_document"><?php echo lang('job_document')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php 
					$path = site_url().isset($record->job_document) ? $record->job_document : '';
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					switch ($ext)
					{
						case "docx":
						case "doc":
						case "dotx":
						case "dot":
						case "docm":
							$thumb = 'fa fa-file-word-o fa-5x';
							break;
						case "xlsx":
						case "xlsb":
						case "xls":
						case "xltx":
						case "xla":
						case "xlt":
							$thumb = 'fa fa-file-excel-o fa-5x';
							break;
						case "pptx":
						case "ppt":
						case "pptm":
						case "ppsm":
						case "ppsx":
						case "psw":
							$thumb = 'fa fa-file-powerpoint-o fa-5x';
							break;
						case "pdf":
							$thumb = 'fa fa-file-pdf-o fa-5x';
							break;
					}
					?>
					<a href="<?php echo getenv('UPLOAD_ROOT'); echo isset($record->job_document) ? $record->job_document : '' ?>" download><i class="<?php echo isset($record->job_document) ? $thumb : ''; ?>" aria-hidden="true"></i><i class="fa fa-download" aria-hidden="true"></i></a>
					<?php //echo form_input(array('id'=>'job_document', 'name'=>'job_document', 'value'=>set_value('job_document', isset($record->job_document) ? $record->job_document : ''), 'class'=>'form-control'));?>
					<div id="error-job_document"></div>			
				</div>
			</div>		
		</div>

		<div class="form-group" style="display: none">
			<div class="row">
				<div class="col-sm-2">
					<label for="job_pitch"><?php echo lang('job_pitch')?>:</label>
				</div>
				<div class="col-sm-10">
					<?php echo form_textarea(array('id'=>'job_pitch', 'name'=>'job_pitch', 'rows'=>'3', 'value'=>set_value('job_pitch', isset($record->job_pitch) ? $record->job_pitch : ''), 'class'=>'form-control')); ?>
					<div id="error-job_pitch"></div>			
				</div>
			</div>		
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