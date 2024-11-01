<?php
/*
Plugin Name: WP-Bloginy
Plugin URI: http://blog.bloginy.com
Description:  Plugin qui permet d'afficher les dèrniers articles publiés sur le digg-like bloginy
Author: Inal Djafar
Version: 1.0
Author URI: http://www.inaldjafar.com

*/
/*  Copyright 2009 Djafar Inal (email : djafar.inal[at]gmail[dot]com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function wp_bloginy(){
	
	include_once(ABSPATH . WPINC . '/rss.php');
	$url="http://www.bloginy.com/rss";
	$rss = fetch_rss($url);
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::::::::: */
	
	// Here you can change the paramatres : maxitems & maxchars.
	
	$maxitems = 5;
	$maxchars = 25;
	
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	$items = array_slice($rss->items, 0, $maxitems);		
	echo '<ul>';
		 if (empty($items)) echo '<li>Aucun flux trouv&eacute;</li>';
			else
			foreach ( $items as $item ) :
			$title= substr($item['title'], 0, $maxchars);
			$title.='...';
				echo '<li><a href="'.$item['link'].'" title ="'.$item['title'].'" >'.$title.'</a></li>';
			endforeach;
	echo '</ul>';
	}


function wd_wp_bloginy($param){

	include_once(ABSPATH . WPINC . '/rss.php');
	$url="http://www.bloginy.com/rss";
	$rss = fetch_rss($url);
	$maxitems = $param[0];
	$items = array_slice($rss->items, 0, $maxitems);		
	echo '<ul>';
		 if (empty($items)) echo '<li>Aucun flux trouv&eacute;</li>';
			else
			foreach ( $items as $item ) :
			$title= substr($item['title'], 0, $param[1]);
			$title.='...';
				echo '<li><a href="'.$item['link'].'" title ="'.$item['title'].'" >'.$title.'</a></li>';
			endforeach;
	echo '</ul>';
}

function widget_wp_bloginy($args){
	extract($args);
	
	$options = get_option("widget_wp_bloginy");
  	if (!is_array( $options ))
	{
	  $options = array(
          'titre'  => 'Bloginy',
          'nbrss'  => '5',
          'nbchar' => '25'
      ); 
  	}
  	$paramBloginy= array($options['nbrss'],$options['nbchar']);
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $options['titre']
                . $after_title; ?>
            <?php wd_wp_bloginy($paramBloginy); ?>
        <?php echo $after_widget; ?>
<?php

}


function wp_bloginy_control(){

  $options = get_option("widget_wp_bloginy");
  
  if (!is_array( $options ))
	{
	  $options = array(
          'titre'  => 'Bloginy',
          'nbrss'  => '5',
          'nbchar' => '25' 
      ); 
  }    
  
  if ($_POST['wpBloginy-Submit']) 
  {
    $options['titre'] = htmlspecialchars($_POST['wpBloginy-Titre']);
    $options['nbrss'] = htmlspecialchars($_POST['wpBloginy-Nbrss']);
    $options['nbchar'] = htmlspecialchars($_POST['wpBloginy-Nbchar']);
    update_option("widget_wp_bloginy", $options);
  }

?>


<p>
	<b>Titre</b><br />
	<input type="text" class="widefat" id ="wpBloginy-Titre" name="wpBloginy-Titre" value="<?php echo $options['titre'] ?>" /><br />
	<b>Nombre de flux</b><br />
	<input type="text" class="widefat" id ="wpBloginy-Nbrss" name="wpBloginy-Nbrss" value="<?php echo $options['nbrss'] ?>" /><br />
	<b>Nombre de caract&egrave;res</b><br />
	<input type="text" class="widefat" id ="wpBloginy-Nbchar" name="wpBloginy-Nbchar" value="<?php echo $options['nbchar'] ?>" /><br />
	<input type="hidden" id="wpBloginy-Submit" name="wpBloginy-Submit" value="1" />

</p>

<?php
}


function wp_bloginy_init()
{

  register_sidebar_widget(__('Bloginy'), 'widget_wp_bloginy');
  register_widget_control(	 'Bloginy', 'wp_bloginy_control', 200, 200);

}


add_action("plugins_loaded", "wp_bloginy_init");

?>
