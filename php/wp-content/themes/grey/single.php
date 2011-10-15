<?php get_header(); ?>




	    <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
						<p class="info"><?php the_time(__('F jS, Y')) ?>  |  by <span><?php the_author_posts_link(); ?></span>  |  <?php echo strtolower( get_the_category_list(', ')); ?></p>
						<div class="time"><p><?php the_time(__('M')) ?><br /><span><?php the_time(__('d')) ?></span></p></div>
                        <div class="post_socials">
                            <!--twitter -->
                            <script type="text/javascript">tweetmeme_style = 'compact'; tweetmeme_source = 'tweetmeme';</script>
                            <script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
                            <!--facebook -->
                            <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=recommend&amp;font=verdana&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width: 100px; height:21px" allowTransparency="true"></iframe>
                        </div>

                        <?php if ( get_post_meta($post->ID, 'grey_custom_image', true) ) : ?>
                            <p><img class="teasier" src="<?php bloginfo('template_directory'); ?>/images/post_image.png" width="510" height="150" alt="image" /></p>
                        <?php endif; ?>
                        
                        <?php the_post_thumbnail('grey_teasier', array('class'=>'teasier')); ?>

        				<div class="entry">
        					<?php the_content('Read full story'); ?>
        				</div>
                        <div class="clear"></div>
                        
                        <div id="box_author">
                            <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); }?>
                            <p class="authored">Authored by <span><?php the_author_posts_link(); ?></span></p>
                            <p><?php the_author_description(); ?></p>
                        </div>
					</article>
					
                    <?php comments_template(); ?>

    		<?php endwhile; ?>
	    <?php else : ?>

		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.'); ?></p>

        <?php endif; ?>








				</section>

<?php get_sidebar(); ?>

            </div>
        </div>

<?php get_footer(); ?>