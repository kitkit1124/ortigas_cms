<div class="row">
	<!-- Daily Shares Line Chart -->
	<div class="col-xs-12">
		<div class="widget-box transparent">
			<div class="widget-header">
				<h4 class="widget-title lighter"><i class="ace-icon fa fa-line-chart orange2"></i> Daily Shares</h4>
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
<div class="row">
	<!-- Top Pages -->
	<div class="col-sm-7">
		<div class="widget-box transparent">
			<div class="widget-header">
				<h4 class="widget-title lighter"><i class="ace-icon fa fa-star orange"></i> Content</h4>
				<div class="widget-toolbar"></div>
			</div>
			<div class="widget-body">
				<div class="widget-main no-padding">
					<table id="top_pages" class="table table-bordered table-striped table-hover table-sm">
						<thead class="thin-border-bottom">
							<tr>
								<th>Top Content</th>
								<th width="15%" class="text-right">Shares</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><h5 class="text-center lighter"><i class="fa fa-spinner fa-spin fa-lg"></i> Loading...</h5></td>
							</tr>
						</tbody>
						<tfoot class="hidden">
							<tr>
								<td colspan="2" class="text-center">
									<a href="<?php echo site_url('social_plugins/contents') ?>" class="btn btn-white btn-info btn-sm btn-round">
										<i class="ace-icon fa fa-files-o orange2 middle"></i> 
										View all content pages 
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Top Channels -->
	<div class="col-sm-5 no-margin">
		<div class="widget-box transparent">
			<div class="widget-header">
				<h4 class="widget-title lighter"><i class="ace-icon fa fa-share-alt"></i> Channels</h4>
				<div class="widget-toolbar no-border">
					
				</div>
			</div>
			<div class="widget-body">
				<div class="widget-main no-padding">
					<table id="top_channels" class="table table-bordered table-striped table-hover">
						<thead class="thin-border-bottom">
							<tr>
								<th>Top Channels</th>
								<th width="15%" class="text-right">Shares</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><h5 class="text-center lighter"><i class="fa fa-spinner fa-spin fa-lg"></i> Loading...</h5></td>
							</tr>
						</tbody>
						<tfoot class="hidden">
							<tr>
								<td><h4 class="no-margin no-padding">Total</h4></td>
								<td class="infobox-green infobox-dark text-right"><h4 class="no-margin no-padding total-shares">&mdash;</h4></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>		
	</div>

</div>