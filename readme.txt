=== WP-bloginy ===
Contributors: inalgnu
Tags: sidebar, widget

== Description ==

This plugin shows the lasts feeds of the Algerian Digg-like "Bloginy"


== Installation ==

1. Upload 'wp-bloginy' to the '/wp-content/plugins/' directory.
2. Activate 'wp-bloginy' through the 'Plugins' menu in WordPress.
3. If you are using widgets then just add the widget in the adminstation panel.
3. Else insert the following code where you want to display the feeds.

	<?php if (function_exists('wp_bloginy')) { ?>
       
        <h2>Flux Bloginy</h2>
        <?php wp_bloginy(); ?>
        
	<?php } ?>


== Screenshots ==

1. Activation of the widget
