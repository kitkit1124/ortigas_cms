META TAGS MODULE

This module was created to be used for adding SEO meta tags for pages, posts and other frontend pages.


USAGE

* It requires an existing record in the module before the meta tags can be used
* It also requires a meta tag field. eg. page_metatag_id in the pages table or property_metatag_id in the properties table
  Therefore you need to create a migration file for this. eg.

class Migration_Edit_properties_01 extends CI_Migration 
{

	var $table = 'properties';

	function __construct()
	{
		parent::__construct();
	}
	
	public function up()
	{
		$fields = array(
			'property_metatag_id' => array('type' => 'INT', 'unsigned' => TRUE, 'default' => NULL),
		);
		$this->dbforge->add_column($this->_table, $fields);
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix($this->_table) . ' ADD INDEX `property_metatag_id` (`property_metatag_id`)');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table, 'property_metatag_id');
	}
}

* It can be accessed in any module by adding a call to a modal box like the one below:

<?php if (isset($record->page_id)): ?>
	<a href="<?php echo site_url('metatags/form/website/pages/' . $record->page_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
<?php endif; ?>

isset($record->page_id) checks if a record exists.  Change page_id into the primary key of the module.  eg. for properties module, use property_id

For this URI site_url('metatags/form/website/pages/' . $record->page_id)

website 			= the module name
pages 				= the model name (excluding the _model)
$record->page_id 	= the primary key of the record 


* It also requires the public $metatag_key field in the model. Eg.

class Posts_model extends BF_Model 
{

	protected $table_name			= 'posts';
	protected $key					= 'post_id';

	...

	public $metatag_key				= 'post_metatag_id';

	...
}