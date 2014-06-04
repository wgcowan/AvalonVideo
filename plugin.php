<?php
if (!defined('AVALONVIDEO_PLUGIN_DIR')) {
    define('AVALONVIDEO_PLUGIN_DIR', dirname(__FILE__));
}
add_plugin_hook('public_head', 'avalon_public_head');
add_plugin_hook('admin_head', 'avalon_admin_head');
 
require_once AVALONVIDEO_PLUGIN_DIR . '/AvalonVideoPlugin.php';
require_once AVALONVIDEO_PLUGIN_DIR . '/functions.php';
$avalonvideoPlugin = new AvalonVideoPlugin;
$avalonvideoPlugin->setUp();
?>