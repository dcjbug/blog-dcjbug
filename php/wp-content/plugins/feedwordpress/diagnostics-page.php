<?php
require_once(dirname(__FILE__) . '/admin-ui.php');

class FeedWordPressDiagnosticsPage extends FeedWordPressAdminPage {
	function FeedWordPressDiagnosticsPage () {
		// Set meta-box context name
		FeedWordPressAdminPage::FeedWordPressAdminPage('feedwordpressdiagnosticspage');
		$this->dispatch = 'feedwordpress_diagnostics';
		$this->filename = __FILE__;
	}

	function has_link () { return false; }

	function display () {
		global $wpdb, $wp_db_version, $fwp_path;
		global $fwp_post;
		
		if (FeedWordPress::needs_upgrade()) :
			fwp_upgrade_page();
			return;
		endif;
	
		// If this is a POST, validate source and user credentials
		FeedWordPressCompatibility::validate_http_request(/*action=*/ 'feedwordpress_diagnostics', /*capability=*/ 'manage_options');
	
		if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') :
			$this->accept_POST($fwp_post);
			do_action('feedwordpress_admin_page_diagnostics_save', $GLOBALS['fwp_post'], $this);
		endif;

		////////////////////////////////////////////////
		// Prepare settings page ///////////////////////
		////////////////////////////////////////////////

		$this->display_update_notice_if_updated('Diagnostics');

		$this->open_sheet('FeedWordPress Diagnostics');
		?>
		<div id="post-body">
		<?php
		$boxes_by_methods = array(
			'info_box' => __('Diagnostic Information'),
			'diagnostics_box' => __('Display Diagnostics'),
			'updates_box' => __('Updates'),
		);
	
		foreach ($boxes_by_methods as $method => $title) :
			add_meta_box(
				/*id=*/ 'feedwordpress_'.$method,
				/*title=*/ $title,
				/*callback=*/ array('FeedWordPressDiagnosticsPage', $method),
				/*page=*/ $this->meta_box_context(),
				/*context=*/ $this->meta_box_context()
			);
		endforeach;
		do_action('feedwordpress_admin_page_diagnostics_meta_boxes', $this);
		?>
			<div class="metabox-holder">
			<?php
			fwp_do_meta_boxes($this->meta_box_context(), $this->meta_box_context(), $this);
			?>
			</div> <!-- class="metabox-holder" -->
		</div> <!-- id="post-body" -->

		<?php
		$this->close_sheet();
	} /* FeedWordPressDiagnosticsPage::display () */

	function accept_POST ($post) {
		if (isset($post['submit'])
		or isset($post['save'])) :
			update_option('feedwordpress_debug', $post['feedwordpress_debug']);
			update_option('feedwordpress_secret_key', $post['feedwordpress_secret_key']);
			
			if (!isset($post['diagnostics_output'])
			or !is_array($post['diagnostics_output'])) :
				$post['diagnostics_output'] = array();
			endif;
			update_option('feedwordpress_diagnostics_output', $post['diagnostics_output']);
	
			if (!isset($post['diagnostics_show'])
			or !is_array($post['diagnostics_show'])) :
				$post['diagnostics_show'] = array();
			endif;
			update_option('feedwordpress_diagnostics_show', $post['diagnostics_show']);

			if ($post['diagnostics_show']
			and in_array('updated_feeds:errors:persistent', $post['diagnostics_show'])) :
				update_option('feedwordpress_diagnostics_persistent_errors_hours', (int) $post['diagnostics_persistent_error_hours']);
			else :
				delete_option('feedwordpress_diagnostics_persistent_errors_hours');
			endif;
			
			if (in_array('email', $post['diagnostics_output'])) :
				$ded = $post['diagnostics_email_destination'];
				if ('mailto'==$ded) :
					$ded .= ':'.$post['diagnostics_email_destination_address'];
				endif;

				update_option('feedwordpress_diagnostics_email_destination', $ded);
			else :
				delete_option('feedwordpress_diagnostics_email_destination');
			endif;
			
			$this->updated = true; // Default update message
		endif;
	} /* FeedWordPressDiagnosticsPage::accept_POST () */

	function info_box ($page, $box = NULL) {
		global $feedwordpress;
		$link_category_id = FeedWordPress::link_category_id();
	?>
		<table class="edit-form narrow">
		<thead style="display: none">
		<th scope="col">Topic</th>
		<th scope="col">Information</th>
		</thead>

		<tbody>
		<tr>
		<th scope="row">Version:</th>
		<td>You are using FeedWordPress version <strong><?php print FEEDWORDPRESS_VERSION; ?></strong>.</td>
		</tr>

		<tr>
		<th scope="row">Link Category:</th>
		<td><?php if (!is_wp_error($link_category_id)) :
			$term = get_term($link_category_id, 'link_category');
		?><p>Syndicated feeds are
		kept in link category #<?php print $term->term_id; ?>, <strong><?php print $term->name; ?></strong>.</p>
		<?php else : ?>
		<p><strong>FeedWordPress has been unable to set up a valid Link Category
		for syndicated feeds.</strong> Attempting to set one up returned an
		<code><?php $link_category_id->get_error_code(); ?></code> error with this
		additional data:</p>
		<table>
		<tbody>
		<tr>
		<th scope="row">Message:</th>
		<td><?php print $link_category_id->get_error_message(); ?></td>
		</tr>
		<?php $data = $link_category_id->get_error_data(); if (!empty($data)) : ?>
		<tr>
		<th scope="row">Auxiliary Data:</th>
		<td><pre><?php print esc_html(FeedWordPress::val($link_category_id->get_error_data())); ?></pre></td>
		</tr>
		<?php endif; ?>
		</table>
		<?php endif; ?></td>
		</tr>
		
		<tr>
		<th scope="row"><?php _e('Secret Key:'); ?></th>
		<td><input type="text" name="feedwordpress_secret_key" value="<?php print esc_attr($feedwordpress->secret_key()); ?>" />
		<p class="setting-description">This is used to control access to some diagnostic testing functions. You can change it to any string you want,
		but only tell it to people you trust to help you troubleshoot your
		FeedWordPress installation. Keep it secret&#8212;keep it safe.</p></td>
		</tr>
		</table>

		<?php
	} /* FeedWordPressDiagnosticsPage::info_box () */
	
	function diagnostics_box ($page, $box = NULL) {
		$settings = array();
		$settings['debug'] = (get_option('feedwordpress_debug')=='yes');

		$diagnostics_output = get_option('feedwordpress_diagnostics_output', array());
		
		$users = fwp_author_list();

		$ded = get_option('feedwordpress_diagnostics_email_destination', 'admins');

		if (preg_match('/^mailto:(.*)$/', $ded, $ref)) :
			$ded_addy = $ref[1];
		else :
			$ded_addy = NULL;
		endif;
		
		// Hey ho, let's go...
		?>
<table class="edit-form">
<tr style="vertical-align: top">
<th scope="row">Debugging mode:</th>
<td><select name="feedwordpress_debug" size="1">
<option value="yes"<?php echo ($settings['debug'] ? ' selected="selected"' : ''); ?>>on</option>
<option value="no"<?php echo ($settings['debug'] ? '' : ' selected="selected"'); ?>>off</option>
</select>

<p>When debugging mode is <strong>ON</strong>, FeedWordPress displays many
diagnostic error messages, warnings, and notices that are ordinarily suppressed,
and turns off all caching of feeds. Use with caution: this setting is useful for
testing but absolutely inappropriate for a production server.</p>

</td>
</tr>
<tr>
<th scope="row">Diagnostics output:</th>
<td><ul class="options">
<li><input type="checkbox" name="diagnostics_output[]" value="error_log" <?php print (in_array('error_log', $diagnostics_output) ? ' checked="checked"' : ''); ?> /> Log in PHP error logs</label></li>
<li><input type="checkbox" name="diagnostics_output[]" value="admin_footer" <?php print (in_array('admin_footer', $diagnostics_output) ? ' checked="checked"' : ''); ?> /> Display in WordPress admin footer</label></li>
<li><input type="checkbox" name="diagnostics_output[]" value="echo" <?php print (in_array('echo', $diagnostics_output) ? ' checked="checked"' : ''); ?> /> Echo in web browser as they are issued</label></li>
<li><input type="checkbox" name="diagnostics_output[]" value="echo_in_cronjob" <?php print (in_array('echo_in_cronjob', $diagnostics_output) ? ' checked="checked"' : ''); ?> /> Echo to output when they are issued during an update cron job</label></li>
<li><input type="checkbox" name="diagnostics_output[]" value="email" <?php print (in_array('email', $diagnostics_output) ? ' checked="checked"' : ''); ?> /> Send a daily email digest to:</label> <select name="diagnostics_email_destination" id="diagnostics-email-destination" size="1">
<option value="admins"<?php if ('admins'==$ded) : ?> selected="selected"<?php endif; ?>>the site administrators</option>
<?php foreach ($users as $id => $name) : ?>
<option value="user:<?php print (int) $id; ?>"<?php if (sprintf('user:%d', (int) $id)==$ded) : ?> selected="selected"<?php endif; ?>><?php print esc_html($name); ?></option>
<?php endforeach; ?>
<option value="mailto"<?php if (!is_null($ded_addy)) : ?> selected="selected"<?php endif; ?>>another e-mail address...</option>
</select>
<input type="email" id="diagnostics-email-destination-address" name="diagnostics_email_destination_address" value="<?php print $ded_addy; ?>" placeholder="email address" /></li>
</ul></td>
</tr>
</table>

<script type="text/javascript">
	contextual_appearance(
		'diagnostics-email-destination',
		'diagnostics-email-destination-address',
		'diagnostics-email-destination-default',
		'mailto',
		'inline'
	);
	jQuery('#diagnostics-email-destination').change ( function () {
		contextual_appearance(
			'diagnostics-email-destination',
			'diagnostics-email-destination-address',
			'diagnostics-email-destination-default',
			'mailto',
			'inline'
		);
	} );	
</script>
		<?php
	} /* FeedWordPressDiagnosticsPage::diagnostics_box () */
	
	/*static*/ function updates_box ($page, $box = NULL) {
		$hours = get_option('feedwordpress_diagnostics_persistent_errors_hours', 2);
		$fields = apply_filters('feedwordpress_diagnostics', array(
			'Update Diagnostics' => array(
				'updated_feeds' => 'as each feed is checked for updates',
				'updated_feeds:errors:persistent' => 'when attempts to update a feed have resulted in errors</label> <label>for at least <input type="number" min="1" max="360" step="1" name="diagnostics_persistent_error_hours" value="'.$hours.'" /> hours',
				'updated_feeds:errors' => 'any time FeedWordPress encounters any errors while checking a feed for updates',
				'syndicated_posts' => 'as each syndicated post is added to the database',
				'feed_items' => 'as each syndicated item is considered on the feed',
				'memory_usage' => 'indicating how much memory was used',
			),
			'Syndicated Post Details' => array(
				'feed_items:freshness' => 'as FeedWordPress decides whether to treat an item as a new post, an update, or a duplicate of an existing post',
				'feed_items:rejected' => 'when FeedWordPress rejects a post without syndicating it',
				'syndicated_posts:meta_data' => 'as syndication meta-data is added on the post',
			),
			'Advanced Diagnostics' => array(
				'feed_items:freshness:sql' => 'when FeedWordPress issues the SQL query it uses to decide whether to treat items as new, updates, or duplicates', 
				'syndicated_posts:static_meta_data' => 'providing meta-data about syndicated posts in the Edit Posts interface',
			),
		), $page);
		
		foreach ($fields as $section => $items) :
			foreach ($items as $key => $label) :
				$checked[$key] = '';
			endforeach;
		endforeach;

		$diagnostics_show = get_option('feedwordpress_diagnostics_show', array());
		if (is_array($diagnostics_show)) : foreach ($diagnostics_show as $thingy) :
			$checked[$thingy] = ' checked="checked"';
		endforeach; endif;

		// Hey ho, let's go...
		?>
<table class="edit-form">
	<?php foreach ($fields as $section => $ul) : ?>
	  <tr>
	  <th scope="row"><?php print esc_html($section); ?>:</th>
	  <td><p>Show a diagnostic message...</p>
	  <ul class="options">
	  <?php foreach ($ul as $key => $label) : ?>
	    <li><label><input
	    	type="checkbox" name="diagnostics_show[]"
	    	value="<?php print esc_html($key); ?>"
	    	<?php print $checked[$key]; ?> />
	    <?php print $label; ?></label></li>
	  <?php endforeach; ?>
	  </ul></td>
	  </tr>
	<?php endforeach; ?>
</table>
		<?php
	} /* FeedWordPressDiagnosticsPage::updates_box () */
} /* class FeedWordPressDiagnosticsPage */

	$diagnosticsPage = new FeedWordPressDiagnosticsPage;
	$diagnosticsPage->display();

