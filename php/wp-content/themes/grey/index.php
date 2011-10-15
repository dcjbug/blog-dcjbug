<?php get_header(); ?>




	    <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
						<p class="info"><?php the_time(__('F jS, Y')) ?>  |  by <span><?php the_author_posts_link(); ?></span>  |  <?php echo strtolower( get_the_category_list(', ')); ?></p>
						<div class="time"><p><?php the_time(__('M')) ?><br /><span><?php the_time(__('d')) ?></span></p></div>


                        <p><?php the_post_thumbnail('grey_teasier', array('class'=>'teasier')); ?></p>
						
        				<div class="entry">
        					<?php the_content('Read full story'); ?>
        				</div>
                        <div class="clear"></div>
						<p class="bottom_info"><?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;'), '', __('Comments Closed') ); ?></p>
					</article>


    		<?php endwhile; ?>

    		<div class="navigation">
                <?php if ( get_next_posts_link() != '' ) : ?><div class="alignleft"><?php next_posts_link(__('Older Posts')) ?></div><?php endif; ?>
    			<?php if ( get_previous_posts_link() != '' ) : ?><div class="alignright"><?php previous_posts_link(__('Newer Posts')) ?></div><?php endif; ?>
    		</div>


	    <?php else : ?>

		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.'); ?></p>

        <?php endif; ?>








				</section>

<?php get_sidebar(); ?>

            </div>
        </div>

<?php get_footer(); ?>