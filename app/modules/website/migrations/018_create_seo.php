<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Migration Class
 *
 * @package		Codifire
 * @version		1.0
 * @author 		Gutzby Marzan <gutzby.marzan@digify.com.ph>
 * @copyright 	Copyright (c) 2018, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
class Migration_Create_seo extends CI_Migration {

	private $_table = 'seo';

	private $_permissions = array(
		array('Seo Link', 'website.seo.link'),
		array('Seo List', 'website.seo.list'),
		array('View Seo', 'website.seo.view'),
		array('Add Seo', 'website.seo.add'),
		array('Edit Seo', 'website.seo.edit'),
		array('Delete Seo', 'website.seo.delete'),
	);

	private $_menus = array(
		array(
			'menu_parent'		=> 'website',
			'menu_text' 		=> 'SEO',    
			'menu_link' 		=> 'website/seo', 
			'menu_perm' 		=> 'website.seo.link', 
			'menu_icon' 		=> 'fa fa fa-line-chart', 
			'menu_order' 		=> 9, 
			'menu_active' 		=> 1
		),
	);

	function __construct()
	{
		parent::__construct();

		$this->load->model('core/migrations_model');
	}
	
	public function up()
	{
		// create the table
		$fields = array(
			'seo_id'			=> array('type' => 'TINYINT', 'constraint' => 3, 'auto_increment' => TRUE, 'unsigned' => TRUE, 'null' => FALSE),
			'seo_title'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
			'seo_content'		=> array('type' => 'TEXT', 'null' => FALSE),
			'seo_status'		=> array('type' => 'SET("Active","Disabled")', 'null' => FALSE),

			'seo_created_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seo_created_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seo_modified_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
			'seo_modified_on' 	=> array('type' => 'DATETIME', 'null' => TRUE),
			'seo_deleted' 		=> array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'seo_deleted_by' 	=> array('type' => 'MEDIUMINT', 'unsigned' => TRUE, 'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('seo_id', TRUE);
		$this->dbforge->add_key('seo_title');
		$this->dbforge->add_key('seo_status');

		$this->dbforge->add_key('seo_deleted');
		$this->dbforge->create_table($this->_table, TRUE);

		// add the module permissions
		$this->migrations_model->add_permissions($this->_permissions);

		// add the module menu
		$this->migrations_model->add_menus($this->_menus);


		$data = array(
			array(
				'seo_title'  => 'Google Tag Manager', 
				'seo_content' => 	"<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WHHR9T8');</script>
<!-- End Google Tag Manager -->",
				'seo_status' => 'Active',
			),
			array(
				'seo_title'  => 'Facebook Pixel Code', 
				'seo_content' =>	"<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '365076777159631', { em: 'insert_email_variable,'});
fbq('track', 'PageView');
</script>
<noscript><img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=365076777159631&ev=PageView&noscript=1'/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->",
				'seo_status' => 'Active',
			),
			array(
				'seo_title'  => 'Google Code for Remarketing Tag', 
				'seo_content' =>   '<!-- Google Code for Remarketing Tag -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 867370377;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript><div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/867370377/?guid=ON&amp;script=0"/></div>
<!-- End Google Code for Remarketing Tag -->
</noscript>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHHR9T8" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->',
				'seo_status' => 'Active',
			),	
		);
		$this->db->insert_batch($this->_table, $data);
	}

	public function down()
	{
		// drop the table
		$this->dbforge->drop_table($this->_table, TRUE);

		// delete the permissions
		$this->migrations_model->delete_permissions($this->_permissions);

		// delete the menu
		$this->migrations_model->delete_menus($this->_menus);
	}
}