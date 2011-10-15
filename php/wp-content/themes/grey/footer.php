		<!-- footer -->
		<footer>
			<section id="footer_content">
				<div class="container_12">
					<div id="inspiration" class="grid_4">
						<h4>Find Inspiration</h4>

						<?php $socials = get_option('grey_socials');
                              echo grey_flickr_stream($socials['flickr']);
                        ?>
					</div>
					<div id="twitter_feed" class="grid_4">
						<h4>Twitter Feed</h4>

						<?php echo grey_twitter_timeline($socials['twitter']); ?>

						<p class="followme"><a href="http://twitter.com/<?php echo $socials['twitter']; ?>">follow me on twitter</a></p>
					</div>
					<div id="socials" class="grid_4">
						<h4>Find me elsewhere</h4>

						<?php grey_print_socials(); ?>
						<div class="clear"></div>

						<h5>Stay Updated</h5>

                <?php   if ($socials['feedburner']!='') : ?>
						<p class="stayupdated"><a href="http://feeds.feedburner.com/<?php echo $socials['feedburner']; ?>"><img src="<?php bloginfo('template_url'); ?>/images/socials/rss_32.png" alt="" /></a> <a href="http://feeds.feedburner.com/<?php echo $socials['feedburner']; ?>">rss feed updates</a></p>
                        <p class="stayupdated"><a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $socials['feedburner']; ?>&amp;loc=en_US"><img src="<?php bloginfo('template_url'); ?>/images/socials/email_32.png" alt="" /></a> <a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $socials['feedburner']; ?>&amp;loc=en_US">email updates</a></p>
                <?php   else: ?>
						<p class="stayupdated"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/socials/rss_32.png" alt="" /></a> <a href="<?php bloginfo('rss2_url'); ?>">rss feed updates</a></p>
                <?php   endif; ?>
                
                        <h5>Credits</h5>
						<p class="credits">Powered by <a href="http://wordpress.com">Wordpress</a>, enhanced with <a href="http://jquery.com">jQuery</a>. Icons courtesy of <a href="http://www.komodomedia.com/">Komodo Media</a>.</p>
                                        <p class="credits"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/us/88x31.png" /></a><br />This work by the <a xmlns:cc="http://creativecommons.org/ns#" href="http://blog-dcjbug.rhcloud.com" property="cc:attributionName" rel="cc:attributionURL">DC JBoss Users Group</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">Creative Commons Attribution-ShareAlike 3.0 United States License</a>.</p>
					</div>
					<div class="clear"></div>
				</div>
			</section>
			<section id="powered">
				<div class="container_12">
					<p class="grid_10">&copy; <?php echo date('Y'); ?>  free wordpress theme Grey | design by <a href="http://www.webexpedition18.com">Nikola Lazarevic</a> | code by <a href="http://simonedamico.com">Simone D'Amico</a></p>
					<p class="grid_2"><a class="top" href="#">&#9650; Back to top</a></p>
				</div>
			</section>
		</footer>

    <?php wp_footer(); ?>
    </body>
</html>
