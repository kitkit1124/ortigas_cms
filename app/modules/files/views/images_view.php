<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="nav-tabs-custom bottom-margin">
		<ul class="nav nav-tabs">
			<li class="nav item"><a class="nav-link" href="#tab_1" data-toggle="tab">Image</a></li>
			<li class="nav item"><a class="nav-link" href="#tab_2" data-toggle="tab">Edit</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<div class="full-image">
					<img src="<?php echo site_url($record->image_file); ?>" class="img-fluid img-thumbnail" />
				</div>
			</div>
			<div class="tab-pane" id="tab_2">
				<div class="modal-body">
					<form action="" method="POST">
						<div class="form-group">
							<label for="txtName">Name : </label>
							<input type="text" name="txtName" id="txtName" value="<?php echo $record->image_name ?>" class="form-control" />
						</div>
						<button type="button" id="submit" class="btn btn-default">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>