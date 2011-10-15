<?php get_header(); ?>




	    <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>


                        <?php if ( get_post_meta($post->ID, 'grey_custom_image', true) ) : ?>
                            <p><img class="teasier" src="<?php bloginfo('template_directory'); ?>/images/post_image.png" width="510" height="150" alt="image" /></p>
                        <?php endif; ?>

        				<div class="entry">
        					<?php the_content('Read full story'); ?>
        				</div>
                        <div class="clear"></div>
					</article>

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