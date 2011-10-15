<?php
/*
 * File: widgets.php
 *
 * Description: This file extends the admin area of Wordpress.
 *
 */
 


 
/*******************************************************************************
 * Function:  grey_create_menu()
 * Description: adding the option page on Wordpress menu
 *
 *
 * @return none
 *******************************************************************************
*/
add_action('admin_menu', 'grey_create_menu');
function grey_create_menu() {
    add_theme_page(
        'Grey\'s Options',
        'Grey\'s Options',
        'edit_theme_options',
        'grey-options',
        'grey_options'
    );
    add_dashboard_page(
        'Grey\'s Options',
        'Grey\'s Options',
        'edit_theme_options',
        'grey-options',
        'grey_options'
    );

}

/*******************************************************************************
 * Function:  grey_options()
 * Description: options page for theme
 *
 *
 * @return none
 *******************************************************************************
*/
function grey_options() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  
  if ($_POST['update_socials'] == 'true') grey_options_update();

  $socials = get_option('grey_socials');
?>

<style type="text/css">
    .socials { margin: 30px 0; }
    .socials li label { width: 100px; display: inline-block; padding: 10px; }
    .socials li img { margin-bottom: -10px }
    
    .first li { margin-left: 20px; }
    .others li { width: 260px; padding: 20px; float: left; }
</style>
<div class="wrap">
    <h2>Grey's Options</h2>

    <!--<div class="updated fade below-h2">-->
        <p>In this page you can customize Grey's Theme with your social accounts. Please, add your social IDs in the boxes below, to add them in Footer.</p>
    <!--</div>-->
    
    <form action="#" method="post">
    
        <ul class="socials first">
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/rss_32.png" alt="feedburner" /> <label for="feedburner">Feedburner:</label> <input type="text" name="feedburner" id="feedburner" value="<?php echo $socials['feedburner']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/twitter_32.png" alt="twitter" /> <label for="twitter">Twitter:</label> <input type="text" name="twitter" id="twitter" value="<?php echo $socials['twitter']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/flickr_32.png" alt="flickr" /> <label for="flickr">Flickr:</label> <input type="text" name="flickr" id="flickr" value="<?php echo $socials['flickr']; ?>" /> <a target="_blank" href="http://idgettr.com/">Find My ID</a></li>
        </ul>

        <hr />
        <ul class="socials others">
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/blogger_32.png" alt="blogger" /> <label for="blogger">Blogger:</label> <input type="text" name="blogger" id="blogger" value="<?php echo $socials['blogger']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/delicious_32.png" alt="delicious" /> <label for="delicious">Delicious:</label> <input type="text" name="delicious" id="delicious" value="<?php echo $socials['delicious']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/designfloat_32.png" alt="designfloat" /> <label for="designfloat">Design Float:</label> <input type="text" name="designfloat" id="designfloat" value="<?php echo $socials['designfloat']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/deviantart_32.png" alt="deviantart" /> <label for="deviantart">Deviantart:</label> <input type="text" name="deviantart" id="deviantart" value="<?php echo $socials['deviantart']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/digg_32.png" alt="digg" /> <label for="digg">Digg:</label> <input type="text" name="digg" id="digg" value="<?php echo $socials['digg']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/dribbble_32.png" alt="dribbble" /> <label for="dribbble">Dribbble:</label> <input type="text" name="dribbble" id="dribbble" value="<?php echo $socials['dribbble']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/facebook_32.png" alt="facebook" /> <label for="facebook">Facebook:</label> <input type="text" name="facebook" id="facebook" value="<?php echo $socials['facebook']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/friendfeed_32.png" alt="friendfeed" /> <label for="friendfeed">FriendFeed:</label> <input type="text" name="friendfeed" id="friendfeed" value="<?php echo $socials['friendfeed']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/lastfm_32.png" alt="lastfm" /> <label for="lastfm">LastFm:</label> <input type="text" name="lastfm" id="lastfm" value="<?php echo $socials['lastfm']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/linkedin_32.png" alt="linkedin" /> <label for="linkedin">LinkedIn:</label> <input type="text" name="linkedin" id="linkedin" value="<?php echo $socials['linkedin']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/myspace_32.png" alt="myspace" /> <label for="myspace">MySpace:</label> <input type="text" name="myspace" id="myspace" value="<?php echo $socials['myspace']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/picasa_32.png" alt="picasa" /> <label for="picasa">Picasa:</label> <input type="text" name="picasa" id="picasa" value="<?php echo $socials['picasa']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/reddit_32.png" alt="reddit" /> <label for="reddit">Reddit:</label> <input type="text" name="reddit" id="reddit" value="<?php echo $socials['reddit']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/skype_32.png" alt="skype" /> <label for="skype">Skype:</label> <input type="text" name="skype" id="skype" value="<?php echo $socials['skype']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/stumbleupon_32.png" alt="stumbleupon" /> <label for="stumbleupon">Stumbleupon:</label> <input type="text" name="stumbleupon" id="stumbleupon" value="<?php echo $socials['stumbleupon']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/tumblr_32.png" alt="tumblr" /> <label for="tumblr">Tumblr:</label> <input type="text" name="tumblr" id="tumblr" value="<?php echo $socials['tumblr']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/vimeo_32.png" alt="vimeo" /> <label for="vimeo">Vimeo:</label> <input type="text" name="vimeo" id="vimeo" value="<?php echo $socials['vimeo']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/windows_32.png" alt="windows" /> <label for="windows">WindowsMessenger:</label> <input type="text" name="windows" id="windows" value="<?php echo $socials['windows']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/yahoo_32.png" alt="yahoo" /> <label for="yahoo">YahooMessenger:</label> <input type="text" name="yahoo" id="yahoo" value="<?php echo $socials['yahoo']; ?>" /></li>
        	<li><img src="<?php bloginfo('template_url'); ?>/images/socials/youtube_32.png" alt="youtube" /> <label for="youtube">YouTube:</label> <input type="text" name="youtube" id="youtube" value="<?php echo $socials['youtube']; ?>" /></li>
        </ul>

        <div style="clear:both; display: block;"></div>
        <p class="submit"><input type="hidden" name="update_socials" value="true" /><input type="submit" value="Save" /></p>

    </form>
</div>

<?php
}



/*******************************************************************************
 * Function:  grey_options_update()
 * Description: update the options of the theme
 *
 *
 * @return none
 *******************************************************************************
*/
function grey_options_update() {
    $new_socials = Array();
    foreach ( $_POST as $key => $value ) $new_socials[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    unset( $new_socials['update_socials'] );
    
    update_option('grey_socials', $new_socials);
    update_option('grey_configured', '1');

    echo '<div id="message" class="updated fade"><p><strong>Grey settings saved.</strong></p></div>';
}






/*******************************************************************************
 * Description: Array of Custom Fields
 *
 *******************************************************************************
*/
$grey_custom_image = Array(
					   "grey_custom_image" => Array(
						                          "name" => "grey_custom_image",
						                          "std" => "",
						                          "title" => "Grey Custom Image",
						                          "description" => "Custom image is an optional field that allow you to insert a teasier image on post. Put the full address in the box above for adding the image. It's reccomended to use 510x150 images."
                                              )
                    );
                    




?>