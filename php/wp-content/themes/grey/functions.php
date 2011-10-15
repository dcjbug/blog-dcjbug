<?php
/*
 * Grey functions and definitions
 *
 * This file includes libraries and functions for the customization of Grey.
 *
 */



/*
 * Include libraries
 */
 
require_once(TEMPLATEPATH.'/libs/admin.php');
require_once(TEMPLATEPATH.'/libs/socials.php');
require_once(TEMPLATEPATH.'/libs/widgets.php');





/*
 * What theme supports
 */
add_theme_support('menus');  
add_theme_support('post-thumbnails');
if ( function_exists( 'add_image_size' ) )
	add_image_size( 'grey_teasier', 510, 150, true ); 

$GLOBALS['content_width'] = 510;



/*
 * Functions
 */
/*******************************************************************************
 * Function:  grey_setup()
 * Description: install the theme with default fields and options
 *
 *
 * @return none
 *******************************************************************************
*/
function grey_setup() {
    //add_options
    add_option('grey_feedburner_count','0');
    add_option('grey_feedburner_timer', mktime()-100000);
    add_option('grey_twitter_count','0');
    add_option('grey_twitter_timer', mktime()-100000);
    add_option('grey_configured','0');

    $socials = Array(
                'feedburner' => '',
                'twitter' => '',
                'blogger' => '',
                'delicious' => '',
                'designfloat' => '',
                'deviantart' => '',
                'digg' => '',
                'dribbble' => '',
                'facebook' => '',
                'flickr' => '',
                'friendfeed' => '',
                'lastfm' => '',
                'linkedin' => '',
                'myspace' => '',
                'picasa' => '',
                'reddit' => '',
                'skype' => '',
                'stumbleupon' => '',
                'tumblr' => '',
                'vimeo' => '',
                'windows' => '',
                'yahoo' => '',
                'youtube' => ''
               );
    add_option('grey_socials', $socials);
    unset($socials);
}
add_action('after_setup_theme','grey_setup');



/*******************************************************************************
 * Function:  grey_notice()
 * Description: notice you need to configure the theme
 *
 *
 * @return none
 *******************************************************************************
*/
function grey_notice() {
    echo "<div id='grey_error' class='error fade' style='background-color:red;'><p><strong>Grey must be configured.</strong> Please add your social IDs on <strong><a href='". get_bloginfo('url') ."/wp-admin/index.php?page=grey-options'>Options Page</a></strong>.</p></div>";
}

if( get_option('grey_configured') == '0' && !isset($_POST['update_socials']) )
    add_action( 'admin_notices', 'grey_notice' );



/*******************************************************************************
 * Function:  grey_search_form()
 * Description: replace the default search form
 *
 *
 * @return string
 *******************************************************************************
*/
function grey_search_form() {
    $form = '<form action="'. get_option('home') .'" method="get">
            	<input type="text" id="search" name="search" value="I\'m searching for..." />
             </form>
            ';

    return $form;
}
add_filter('get_search_form', 'grey_search_form');



/*******************************************************************************
 * Function:  grey_search_form()
 * Description: return the last comments
 *
 * @param int $number : Optional, Default = 5, number of comments
 * @param int $strip  : Optional, Default= 50, number of chars before to cut
 *
 * @return string
 *******************************************************************************
*/
function grey_last_comments( $number = 5, $strip = 50 ) {
    $comments = get_comments('number='.$number.'&status=approve');
    $return = "<ul class='recent_comments'>";
    
    foreach($comments as $comment):
        $comment_type = get_comment_type();
        $comm_content = get_comment($comment->comment_ID, ARRAY_A);
        $comm_link = get_comment_link($comment->comment_ID);
        $comm_text = ( strlen($comm_content['comment_content']) > $strip) ? substr($comm_content['comment_content'], 0, $strip ) . '...' : $comm_content['comment_content'];

        $return .= "<li>{$comm_text}<br /><a href='{$comm_link}'>{$comment->comment_author}</a></li>";
    endforeach;
    
    echo $return .= "</ul>";
}



/*******************************************************************************
 * Function:  grey_wp_list_pages()
 * Description: return the last comments
 *
 *
 * @return string
 *******************************************************************************
*/
function grey_wp_list_pages() {
?>
    <ul>
        <li <?php if(is_home()) { ?> class="current_page_item"<?php } ?>><a href="<?php bloginfo('url'); ?>">Home</a></li>
		<?php wp_list_pages('title_li='); ?>
    </ul>
<?php
}



/*******************************************************************************
 * Function:  grey_print_socials()
 * Description: print the icons of socials where the user is registered
 *
 *
 * @return string
 *******************************************************************************
*/
function grey_print_socials() {
    $socials = get_option('grey_socials');
    $return = "<ul class='socials'>";
    
    foreach( $socials as $key => $value ) {
        if($value != '') {
            switch($key) {
                case 'feedburner': $href="http://feeds.feedburner.com/".$value; break;
                case 'twitter': $href="http://twitter.com/".$value; break;
                case 'blogger': $href="http://www.blogger.com/profile/".$value; break;
                case 'delicious': $href="http://delicious.com/".$value; break;
                case 'designfloat': $href="http://www.designfloat.com/user/profile/".$value."/"; break;
                case 'deviantart': $href="http://{$value}.deviantart.com/"; break;
                case 'digg': $href="http://digg.com/users/".$value; break;
                case 'dribbble': $href="http://dribbble.com/players/".$value; break;
                case 'facebook': $href="http://www.facebook.com/profile.php?id=".$value; break;
                case 'flickr': $href="http://www.flickr.com/people/".$value."/"; break;
                case 'friendfeed': $href="http://friendfeed.com/".$value; break;
                case 'lastfm': $href="http://www.lastfm.it/user/".$value; break;
                case 'linkedin': $href="http://it.linkedin.com/in/".$value; break;
                case 'myspace': $href="http://www.myspace.com/".$value; break;
                case 'picasa': $href="http://picasaweb.google.com/".$value; break;
                case 'reddit': $href="http://www.reddit.com/user/".$value; break;
                case 'skype': $href="skype:".$value."?add"; break;
                case 'stumbleupon': $href="http://www.stumbleupon.com/stumbler/".$value."/"; break;
                case 'tumblr': $href="http://".$value."tumblr.com/"; break;
                case 'vimeo': $href="http://vimeo.com/".$value; break;
                case 'windows': $href="msnim:add?contact=".$value; break;
                case 'yahoo': $href="mailto:".$value; break;
                case 'youtube': $href="http://www.youtube.com/user/".$value; break;

                default: $href="#"; break;
            }
        
            $return .= "<li><a href='{$href}'><img src='". get_bloginfo('template_directory') ."/images/socials/{$key}_32.png' alt='{$key}' /></a></li>";
        }
    }
    
    echo $return .= "</ul>";
}

?>