<div class="row">
	<!-- Daily Shares Line Chart -->
	<div class="col-xs-12">
		<div class="widget-box transparent">
			<div class="widget-header">
				<h4 class="widget-title lighter"><i class="ace-icon fa fa-line-chart orange2"></i> Daily Share</h4>
				<div class="widget-toolbar no-border no-margin no-padding">
					<div id="reportrange" class="pull-right btn-minier daterange">
					    <span></span> <b class="caret"></b>
					</div>
				</div>
			</div>		
			<div class="widget-body">
				<div class="widget-main no-padding">
					<div id="report_line_chart"></div>
				</div>
			</div>
		</div>
	</div>	
</div>

<hr class="hr hr20 hr-dotted" />

<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
	<thead>
		<tr>
			<th class="all"><?php echo lang('index_url'); ?></th>
			<th class="all"><?php echo lang('index_shares'); ?></th>
		</tr>
	</thead>
</table>