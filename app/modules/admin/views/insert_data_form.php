<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm form-group">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<?php echo form_textarea(array('id'=>'insert_data', 'name'=>'insert_data', 'rows'=>'3', 'class'=>'form-control')); ?>
					</div>
				</div>
				<button id="post" class="btn btn-success btn-lg pull-right" type="submit" data-loading-text="<?php echo lang('processing')?>">
					<i class="fa fa-save"></i> <?php echo lang('button_update')?>
				</button>
			</div>

		</div>
	</div>
</section>
<script>
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>