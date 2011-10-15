<?php
/*
 * File: widgets.php
 *
 * Description: This file extends the default widgets and create new widgets.
 *
 */



/*******************************************************************************
 * Description: adding widget support to the theme
 *
 *******************************************************************************
*/
if ( function_exists('register_sidebar') ) :
    register_sidebar(array(
        'before_widget' => '',
        'after_widget' => '<hr />',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
endif;


/*******************************************************************************
 * Function:  grey_unregister_widgets()
 * Description: unregister the default widgets
 *
 *
 * @return none
 *******************************************************************************
*/
add_action( 'widgets_init', 'grey_unregister_widgets' );
function grey_unregister_widgets() {
    //unregister_widget( 'WP_Widget_Pages' );
    //unregister_widget( 'WP_Widget_Archives' );
    //unregister_widget( 'WP_Widget_Links' );
    //unregister_widget( 'WP_Widget_Categories' );
    //unregister_widget( 'WP_Widget_Recent_Posts' );
    //unregister_widget( 'WP_Widget_Search' );
    //unregister_widget( 'WP_Widget_Tag_Cloud' );
    //unregister_widget( 'WP_Widget_Meta' );
    //unregister_widget( 'WP_Widget_RSS' );
    //unregister_widget( 'WP_Widget_Text' );
    //unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
}



/*******************************************************************************
 * Class:  Grey_Widget_Recent_Comments
 * Description: extends the default WP_Widget_Recent_Comments
 *
 *******************************************************************************
*/
class Grey_Widget_Recent_Comments extends WP_Widget_Recent_Comments {

    function Grey_Widget_Recent_Comments() {
		$widget_ops = array('classname' => 'widget_recent_comments', 'description' => __( 'The most recent comments' ) );
		$this->WP_Widget('recent-comments', __('Grey Recent Comments'), $widget_ops);
		$this->alt_option_name = 'widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'recent_comments_style') );

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
    }

	function recent_comments_style() {}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_comments', 'widget');
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title']);

		if ( ! $number = (int) $instance['number'] )
 			$number = 5;
 		else if ( $number < 1 )
 			$number = 1;

		$comments = get_comments( array( 'number' => $number, 'status' => 'approve' ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul class="recent_comments">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
                $comment_content = get_comment($comment->comment_ID, ARRAY_A);
                $comment_content['comment_content'] = ( strlen($comment_content['comment_content']) > 50) ? substr($comment_content['comment_content'], 0, 50 ) . '...' : $comment_content['comment_content'];
				$output .=  '<li>'. $comment_content['comment_content'] . '<br /><a href="'. get_comment_link($comment->comment_ID) .'">'. $comment->comment_author .'</a></li>';
			}
 		}
		$output .= '</ul><div class="clear"></div>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_comments', $cache, 'widget');
	}

}
register_widget('Grey_Widget_Recent_Comments');



/*******************************************************************************
 * Class:  Grey_Widget_Subscribe_RSS
 * Description: Subscribe RSS Widget
 *
 *******************************************************************************
*/
class Grey_Widget_Subscribe_RSS extends WP_Widget {

    function Grey_Widget_Subscribe_RSS() {
		$widget_ops = array('classname' => 'widget_subscribe_rss', 'description' => __( 'Show links for feed and number of readers' ) );
		$this->WP_Widget('subscribe-rss', __('Grey Subscribe Rss'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $output = '<section id="rss">';
        $output .= '<p><a href="http://feeds.feedburner.com/'. $instance['feedburner_id'] .'"><img src="'. get_bloginfo('template_url') .'/images/socials/rss_32.png" alt="Subscribe Feed" /></a></p>';
        $output .= '<p><a href="http://feeds.feedburner.com/'. $instance['feedburner_id'] .'">SUBSCRIBE</a><br />';
        $output .= $instance['show_readers'] ? '<strong>'. grey_feeds_count($instance['feedburner_id']) .'</strong> readers</p>' : '</p>';
        $output .= '<p class="rss_sub_links"><a href="http://feeds.feedburner.com/'. $instance['feedburner_id'] .'">rss feed</a>';
        $output .= $instance['show_email'] ? ' | <a href="http://feedburner.google.com/fb/a/mailverify?uri='. $instance['feedburner_id'] .'&amp;loc=en_US">email updates</a></p>' : '</p>';
        $output .= '</section>';
        echo $output;
    }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['feedburner_id'] = $new_instance['feedburner_id'];
		$instance['show_readers'] = $new_instance['show_readers'];
		$instance['show_email'] = $new_instance['show_email'];

		return $instance;
	}
    
    function form( $instance ) {
        $socials = get_option('grey_socials');
		$defaults = array( 'feedburner_id' => $socials['feedburner'],
                           'show_readers' => 0,
                           'show_email' => 0 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$show_readers = $instance['show_readers'] ? 'checked="checked"' : '';
		$show_email = $instance['show_email'] ? 'checked="checked"' : '';


        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_id' ); ?>">FeedBurner ID:</label>
			<input id="<?php echo $this->get_field_id( 'feedburner_id' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_id' ); ?>" value="<?php echo $instance['feedburner_id']; ?>" />
		</p>

        <p>
    		<input class="checkbox" type="checkbox" <?php echo $show_readers; ?> id="<?php echo $this->get_field_id('show_readers'); ?>" name="<?php echo $this->get_field_name('show_readers'); ?>" />
    		<label for="<?php echo $this->get_field_id('show_readers'); ?>"><?php _e('Display number of readers'); ?></label>
        </p>

        <p>
    		<input class="checkbox" type="checkbox" <?php echo $show_email; ?> id="<?php echo $this->get_field_id('show_email'); ?>" name="<?php echo $this->get_field_name('show_email'); ?>" />
    		<label for="<?php echo $this->get_field_id('show_email'); ?>"><?php _e('Show Email Updates link'); ?></label>
        </p>

        <p>Note: To use these options you have to activate them on the <a href="http://feedburner.google.com/" target="_blank">FeedBurner panel</a>.</p>

        <?php
    }
}
register_widget('Grey_Widget_Subscribe_RSS');



/*******************************************************************************
 * Class:  Grey_Widget_Twitter
 * Description: Twitter Follower Widget
 *
 *******************************************************************************
*/
class Grey_Widget_Twitter extends WP_Widget {

    function Grey_Widget_Twitter() {
		$widget_ops = array('classname' => 'widget_twitter', 'description' => __( 'Show Twitter link and number of followers' ) );
		$this->WP_Widget('twitter', __('Grey Twitter'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $output = '<section id="twitter">';
        $output .= '<p><a href="http://twitter.com/'. $instance['twitter_user'] .'"><img src="'. get_bloginfo('template_url') .'/images/socials/twitter_32.png" alt="Follow on Twitter" /></a></p>';
        $output .= '<p><a href="http://twitter.com/'. $instance['twitter_user'] .'">FOLLOW ME</a><br />';
        $output .= $instance['show_followers'] ? '<strong>'. grey_twitter_count($instance['twitter_user']) .'</strong> followers</p>' : '</p>';
        $output .= '</section>';
        echo $output;
    }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['twitter_user'] = $new_instance['twitter_user'];
		$instance['show_followers'] = $new_instance['show_followers'];

		return $instance;
	}

    function form( $instance ) {
        $socials = get_option('grey_socials');
		$defaults = array( 'twitter_user' => $socials['twitter'],
                           'show_followers' => 0 );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$show_followers = $instance['show_followers'] ? 'checked="checked"' : '';


        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_user' ); ?>">Twitter Account:</label>
			<input id="<?php echo $this->get_field_id( 'twitter_user' ); ?>" name="<?php echo $this->get_field_name( 'twitter_user' ); ?>" value="<?php echo $instance['twitter_user']; ?>" />
		</p>

        <p>
    		<input class="checkbox" type="checkbox" <?php echo $show_followers; ?> id="<?php echo $this->get_field_id('show_followers'); ?>" name="<?php echo $this->get_field_name('show_followers'); ?>" />
    		<label for="<?php echo $this->get_field_id('show_followers'); ?>"><?php _e('Display number of followers'); ?></label>
        </p>

        <?php
    }
}
register_widget('Grey_Widget_Twitter');





?>