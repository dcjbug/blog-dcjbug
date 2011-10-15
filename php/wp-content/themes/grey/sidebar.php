				<aside class="prefix_1 grid_5">
					
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

					<!-- search -->
                    <?php get_search_form(); ?>


					<!-- Categories-->
					<h4>Categories</h4>
					<ul class="categories">
						<?php wp_list_categories('title_li='); ?>
					</ul>
					<div class="clear"></div>
					<hr />


					<!-- RSS / Twitter -->
					<section id="rss">
						<p><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/socials/rss_32.png" alt="Subscribe Feed" /></a></p>
						<p><a href="<?php bloginfo('rss2_url'); ?>">SUBSCRIBE</a><br /><strong><?php $socials = get_option('grey_socials'); echo grey_feeds_count( $socials['feedburner'] ); ?></strong> readers</p>
						<p class="rss_sub_links"><a href="<?php bloginfo('rss2_url'); ?>">rss feed</a> <?php if( $socials['feedburner'] ) : ?>| <a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $socials['feedburner']; ?>&amp;loc=en_US">email updates</a><?php endif; ?></p>
					</section>
					<section id="twitter">
						<p><a href="http://twitter.com/<?php echo $socials['twitter']; ?>"><img src="<?php bloginfo('template_url'); ?>/images/socials/twitter_32.png" alt="Follow on Twitter" /></a></p>
						<p><a href="http://twitter.com/<?php echo $socials['twitter']; ?>">FOLLOW ME</a><br /><strong><?php echo grey_twitter_count( $socials['twitter'] ); ?></strong> followers</p>
					</section>
					<hr />


					<!-- Comments -->
					<h4>Recent Comments</h4>
					<?php grey_last_comments(5, 50); ?>
					<div class="clear"></div>
					<hr />


					<!-- Blogroll -->
					<h4>Blogroll</h4>
					<ul class="blogroll">
						<?php wp_list_bookmarks('categorize=0&title_li='); ?>
					</ul>
                    <hr />

                    <?php endif; ?>
				</aside>

