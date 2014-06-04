<h3>Avalon Video Playback</h3>
<p> Uses its own hook so you need to add a fire_plugin_hook for public_avalon_video in your theme to make it display on a page. In general the plugin is designed to display an item.</p>
<label style="font-weight:bold;" for="avalon_width_public">Default iframe width, in pixels:</label>
<p><?php echo get_view()->formText('avalon_width_public', 
                              get_option('avalon_width_public'), 
                              array('size' => 5));?></p>
<label style="font-weight:bold;" for="avalon_height_public">Default iframe height, in pixels:</label>
<p><?php echo get_view()->formText('avalon_height_public', 
                              get_option('avalon_height_public'), 
                              array('size' => 5));?></p>
