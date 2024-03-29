<div id="donate" class="postbox">
	<h3 class="hndle"><?php _e('Donate $10, $20 or $50!', 'broken-link-checker'); ?></h3>
	<div class="inside">
		<p><?php
		_e('If you like this plugin, please donate to support development and maintenance!', 'broken-link-checker');							
		?></p>
		
		<form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="G3GGNXHBSHKYC">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Broken Link Checker">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
			
			<input type="hidden" name="return" value="<?php 
				echo esc_attr(admin_url('options-general.php?page=link-checker-settings&donated=1')); 
			?>" />
			<input type="hidden" name="cbt" value="<?php 
				echo esc_attr(__('Return to WordPress Dashboard', 'broken-link-checker')); 
			?>" />
			<input type="hidden" name="cancel_return" value="<?php 
				echo esc_attr(admin_url('options-general.php?page=link-checker-settings&donation_canceled=1')); 
			?>" />
			
			<input type="image" src="https://www.sandbox.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online." style="max-width:170px;height:47px;">
		</form>
	</div>					
</div>

<?php
if ( !function_exists('fetch_feed') ){
	include_once(ABSPATH . WPINC . '/feed.php');
}
if ( function_exists('fetch_feed') ):
	$feed_url = 'http://w-shadow.com/files/blc-plugin-links.rss';
	$num_items = 3;
	
	$feed = fetch_feed($feed_url);
	if ( !is_wp_error($feed) ):	
?>
<style>
#advertising .inside {
	text-align: left;
}
</style>
<div id="advertising" class="postbox">
	<h3 class="hndle"><?php _e('More plugins by Janis Elsts', 'broken-link-checker'); ?></h3>
	<div class="inside">
		<ul>
		<?php
		foreach($feed->get_items(0, $num_items) as $item) {
			printf(
				'<li><a href="%1$s" title="%2$s">%3$s</a></li>',
				esc_url( $item->get_link() ),
				esc_attr( strip_tags( $item->get_title() ) ),
				esc_html( $item->get_title() )
			);
		}
		?>
		</ul>
	</div>					
</div>
<?php
	endif; 
endif; 
?>
