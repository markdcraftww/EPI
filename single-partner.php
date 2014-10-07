<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid" id="pageText">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

			<div <?php post_class('col-1-2'); ?>>
				<div class="partners">
    			<?php if(has_post_thumbnail()) : ?>
    				<div class="img">
    					<?php the_post_thumbnail('sliver'); ?>
    				</div>
    				<div class="padding">
    				<?php else : ?>
    				<div class="paddingTop">
    				<?php endif;?>						
    					<h2><?php the_title(); ?></h2>
    					<?php the_content(); ?>
    					<span><a href="<?php print $_SERVER['HTTP_REFERER'];?>"><i class="fa fa-arrow-circle-o-left"></i> Back</a></span>
    				</div>
    			</div>
			</div>	
			<div class="relatedNews col-1-2">
				<h4>News</h4>
					<ul>
					<?php
		    			$args = array (
		    				'connected_type' => 'orgs2news',
		    				'connected_items' => $post,
		    				'nopaging' => true,
		    				'orderby' => 'rand'
		    			);
		    			$lecture_speaker = new WP_Query( $args );
		    			if ( $lecture_speaker->have_posts() ) {
		    				while ( $lecture_speaker->have_posts() ) {
		    					$lecture_speaker->the_post();
		    		?>    								
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		    		<?php
		    				}
		    			} else {
		    		?>
		    			<li>No news found</li>
		    		<?php
		    			}
		    			wp_reset_postdata();
		    		?>	
					</ul>		
			</div>	
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
			<div class="relatedNews col-1-2">
				<h4>Further Resources:</h5>
				<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
			</div>
			<?php endif; ?>
		<?php endwhile; else :  endif; ?>
		</div>
	</div>
</div>	

<?php get_footer(); ?>