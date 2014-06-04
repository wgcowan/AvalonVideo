<?php
class AvalonVideoPlugin extends Omeka_Plugin_AbstractPlugin
{
	const DEFAULT_VIEWER_WIDTH = 640;
    const DEFAULT_VIEWER_HEIGHT = 480;
    
    protected $_hooks = array('install',
    'uninstall',
    'config_form',
    'config',
    'public_avalon_video',
    );
        
    public function hookInstall()
    {
	    set_option('avalon_width_public', AvalonVideoPlugin::DEFAULT_VIEWER_WIDTH);
        set_option('avalon_height_public', AvalonVideoPlugin::DEFAULT_VIEWER_HEIGHT);

        $db = get_db();

	// Don't install if an element set named "Avalon Video" already exists.
  if ($db->getTable('ElementSet')->findByName('Avalon Video')) {
          throw new Exception('An element set by the name "Avalon Video" already exists. You must delete that '
                         . 'element set to install this plugin.');
}

		$elementSetMetadata = array(
			'record_type'        => "Item", 
			'name'        => "Avalon Video", 
			'description' => "Elements needed for streaming video for the AvalonVideo Plugin"
		);
		$elements = array(
			array(
				'name'           => "Avalon Section PURL",
				'description'    => "PURL for the Avalon Video to embed in an iframe."
			), 
			array(
				'name'           => "Avalon Width",
				'description'    => "Override Width for the iframe width parameter."
			),
			array(
				'name'           => "Avalon Height",
				'description'    => "Override Height for the iframe height parameter."
			)
			// etc.
		);
	insert_element_set($elementSetMetadata, $elements);
    }
    
    public  function hookUninstall()
    {
	    delete_option('avalon_width_public');
        delete_option('avalon_height_public');
        if ($elementSet = get_db()->getTable('ElementSet')->findByName("Avalon Video")) {
            $elementSet->delete();
        }
    }
	
    /**
* Appends a warning message to the uninstall confirmation page.
*/
    public static function admin_append_to_plugin_uninstall_message()
    {
        echo '<p><strong>Warning</strong>: This will permanently delete the Avalon Video element set and all its associated metadata. You may deactivate this plugin if you do not want to lose data.</p>';
    }
	
    public function hookConfigForm()
    {
        include 'config_form.php';
    }
    
    public function hookConfig()
    {
        if (!is_numeric($_POST['avalon_width_public']) ||
        !is_numeric($_POST['avalon_height_public'])) {
            throw new Omeka_Validator_Exception('The width and height must be numeric.');
        }
        set_option('avalon_width_public', $_POST['avalon_width_public']);
        set_option('avalon_height_public', $_POST['avalon_height_public']);
    }
    
    public function hookPublicAvalonVideo($args)
    {
        $this->append($args);
    }
  
    public function append($args)
    { ?>
      	<?php if (metadata('item',array('Avalon Video','Avalon Section PURL'))) {?>
			<div id="vid_player" style= "margin:0 auto;">
				<?php if (metadata('item',array('Avalon Video','Avalon Width'))) {?>
				<iframe style="margin:0 auto;" src=<?php echo html_escape(metadata("item",array("Avalon Video","Avalon Section PURL")))?>?urlappend=%2Fembed width=<?php echo metadata('item',array('Avalon Video','Avalon Width'));?> height=<?php echo metadata('item',array('Avalon Video','Avalon Height'));?> frameborder=0 webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			<?php } else { ?>
					<iframe style="margin:0 auto;" src=<?php echo html_escape(metadata("item",array("Avalon Video","Avalon Section PURL")))?>?urlappend=%2Fembed width=<?php echo get_option('avalon_width_public');?>; height=<?php echo get_option('avalon_height_public');?>; frameborder=0 webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>
		<?php	}  
			} 
	 } 
 } ?>
