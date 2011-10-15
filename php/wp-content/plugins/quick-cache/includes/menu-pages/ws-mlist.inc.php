<?php
if (is_object ($ws__temp_o = wp_get_current_user ()) && $ws__temp_o->ID)
	{
		echo '<form id="ws-mlist-form" action="http://websharks-inc.us1.list-manage1.com/subscribe/post?u=8f347da54d66b5298d13237d9&amp;id=19e9d213bc" method="post" target="_blank">' . "\n";
		/**/
		if (!is_ssl ()) /* Only display this whenever we are NOT inside an SSL-enabled administrative panel. */
			{
				echo '<div id="ws-mlist-div-feed-animator">' . "\n";
				echo '<a href="http://feeds.feedburner.com/~r/s2member-updates/~6/1" target="_blank"><img src="http://feeds.feedburner.com/s2member-updates.1.gif" alt="s2Member ( Updates )" style="border:0" /></a>' . "\n";
				echo '</div>' . "\n";
			}
		/**/
		echo '<div id="ws-mlist-div-header">' . "\n";
		echo '<ins>+</ins>Email Updates<em>!</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '<div id="ws-mlist-div-container">' . "\n";
		/**/
		echo '<div id="ws-mlist-div-fname">' . "\n";
		echo '<label for="ws-mlist-fname">First Name:</label><br />' . "\n";
		echo '<input type="text" name="FNAME" id="ws-mlist-fname" value="' . format_to_edit ($ws__temp_o->first_name) . '" />' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '<div id="ws-mlist-div-lname">' . "\n";
		echo '<label for="ws-mlist-lname">Last Name:</label><br />' . "\n";
		echo '<input type="text" name="LNAME" id="ws-mlist-lname" value="' . format_to_edit ($ws__temp_o->last_name) . '" />' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '<div id="ws-mlist-div-email">' . "\n";
		echo '<label for="ws-mlist-email">Email Address: *</label><br />' . "\n";
		echo '<input type="text" name="EMAIL" id="ws-mlist-email" value="' . format_to_edit ($ws__temp_o->user_email) . '" />' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '<div id="ws-mlist-div-groups">' . "\n";
		echo '<label>Interest Group(s):</label>' . "\n";
		echo '<ul>' . "\n";
		echo '<li><input type="checkbox" value="1" name="group[1][1]" id="ws-mlist-group-1-1"><label for="ws-mlist-group-1-1">WordPress® Themes</label></li>' . "\n";
		echo '<li><input type="checkbox" value="2" name="group[1][2]" id="ws-mlist-group-1-2"><label for="ws-mlist-group-1-2">All WordPress® Plugins</label></li>' . "\n";
		echo '<li><input type="checkbox" value="4" name="group[1][4]" id="ws-mlist-group-1-4" checked="checked"><label for="ws-mlist-group-1-4">s2Member®/s2Member Pro</label></li>' . "\n";
		echo '</ul>' . "\n";
		echo '</div>' . "\n";
		/**/
		if (!is_ssl ()) /* Only display this whenever we are NOT inside an SSL-enabled administrative panel. */
			{
				echo '<div id="ws-mlist-div-subs">' . "\n";
				echo '<script type="text/javascript" src="http://websharks-inc.us1.list-manage.com/subscriber-count?b=31&u=8c67d547-edf6-41c5-807d-2d2d0e6cffd1&id=19e9d213bc"></script>' . "\n";
				echo '</div>' . "\n";
			}
		/**/
		echo '<div id="ws-mlist-div-priv">' . "\n";
		echo '( <a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Privacy URI")) . '" target="_blank">we DO respect your privacy</a> )' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '<div id="ws-mlist-div-submit">' . "\n";
		echo '<input type="submit" value="Subscribe" name="subscribe" />' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		/**/
		unset ($ws__temp_o);
	}
?>