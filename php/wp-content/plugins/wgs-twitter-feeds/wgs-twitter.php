<?php
/*
   Plugin Name: WGS Twitter Feeds
   Plugin URI: http://webgeeksolution.com
   Description: Twitter Feeds for Wordpress widgets
   Version: 1.0
   Author: Efren Labrador
   Author URI: webgeeksolution.com/about/
*/


function twitter_add_javascript(){
	wp_enqueue_script('twitter',  'http://widgets.twimg.com/j/2/widget.js');
}
	add_action( 'wp_print_scripts', 'twitter_add_javascript' );
	
	

class wgstwitterFeeds extends WP_Widget {
    
    function wgstwitterFeeds() {
        parent::WP_Widget(false, $name = 'wgsTwitter Feeds');
    }

    function widget($args, $instance) {
        extract( $args );
		
		$tweeterusername = esc_attr( $instance['tweeterusername'] );
		$height = esc_attr( $instance['height'] );
		$width = esc_attr( $instance['width'] );
		$background = esc_attr( $instance['background'] );
		$fontcolor = esc_attr( $instance['fontcolor'] );	
		$tweetsbackground = esc_attr ( $instance['tweetsbackground'] );
		$tweetsfontcolor = esc_attr( $instance['tweetsfontcolor'] );
		$tweetslinks = esc_attr( $instance['tweetslinks'] );
		
		echo "
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'profile',
			  rpp: 5,
			  interval: 6000,
			  width: " . $width . ",
			  height: " . $height . ",
			  theme: {
				shell: {
				  background: '#" . $background . "',
				  color: '#" . $fontcolor . "'
				},
				tweets: {
				  background: '#" . $tweetsbackground . "',
				  color: '#" . $tweetsfontcolor . "',
				  links: '#" . $tweetslinks . "'
				}
			  },
			  features: {
				scrollbar: true,
				loop: false,
				live: false,
				hashtags: true,
				timestamp: true,
				avatars: false,
				behavior: 'all'
			  }
			}).render().setUser('" . $tweeterusername . "').start();
			</script>
		";
       
    }

   
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['tweeterusername'] = strip_tags( $new_instance['tweeterusername'] );
		$instance['height'] = (int) $new_instance['height'];
		$instance['width'] = (int) $new_instance['width'];
		$instance['background'] = strip_tags( $new_instance['background'] ); 
		$instance['fontcolor'] = strip_tags( $new_instance['fontcolor'] );
		$instance['tweetsbackground'] = strip_tags ( $new_instance['tweetsbackground'] );
		$instance['tweetsfontcolor'] = strip_tags( $new_instance['tweetsfontcolor'] );
		$instance['tweetslinks'] = strip_tags( $new_instance['tweetslinks'] );
		
		return $instance;
    }

   
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 
															'tweeterusername' => 'webgeeksolution',
															'height' => '300', 
															'width' => '200' , 
															'background' => '000000',
															'fontcolor' => 'ffffff',
															'tweetsbackground' => '000000',
															'tweetsfontcolor' => 'ffffff',
															'tweetslinks' => '4aed05'
															) );
	
		$tweeterusername = esc_attr( $instance['tweeterusername'] );
		$height = (int)$instance['height'];
		$width  = (int)$instance['width'];
		$background = esc_attr( $instance['background'] );	
		$fontcolor = esc_attr( $instance['fontcolor'] );
		$tweetsbackground = esc_attr ( $instance['tweetsbackground'] );
		$tweetsfontcolor = esc_attr( $instance['tweetsfontcolor'] );
		$tweetslinks = esc_attr( $instance['tweetslinks'] );
		
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('tweeterusername'); ?>"><?php _e('Twitter Username:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tweeterusername'); ?>" name="<?php echo $this->get_field_name('tweeterusername'); ?>" type="text" value="<?php echo $tweeterusername; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php echo $background; ?>" maxlength="6" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('fontcolor'); ?>"><?php _e('Font Color:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fontcolor'); ?>" name="<?php echo $this->get_field_name('fontcolor'); ?>" type="text" value="<?php echo $fontcolor; ?>" maxlength="6" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('tweetsbackground'); ?>"><?php _e('Tweets Background:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tweetsbackground'); ?>" name="<?php echo $this->get_field_name('tweetsbackground'); ?>" type="text" value="<?php echo $tweetsbackground; ?>" maxlength="6" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('tweetsfontcolor'); ?>"><?php _e('Tweets Font Color:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tweetsfontcolor'); ?>" name="<?php echo $this->get_field_name('tweetsfontcolor'); ?>" type="text" value="<?php echo $tweetsfontcolor; ?>" maxlength="6" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('tweetslinks'); ?>"><?php _e('Tweets Links Color:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tweetslinks'); ?>" name="<?php echo $this->get_field_name('tweetslinks'); ?>" type="text" value="<?php echo $tweetslinks; ?>" maxlength="6" />
        </p>
        <?php 
    }

}


add_action('widgets_init', create_function('', 'return register_widget("wgstwitterFeeds");'));
	
	
	
	
	