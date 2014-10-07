<?php get_header(); ?>

<?php if( is_front_page() ) { ?>
<div class="page">	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">

		<div class="grid" id="pageText">
			<div class="col-3-4">
				<div class="grid owl-carousel" id="homePageCarousel" data-owlCarousel>
				<?php
				$args = array (
					'post_type'	 			 => 'epi_in_action',
					'pagination'             => true,
					'post__in'				 => get_option('sticky_posts'),
					'order'                  => 'DESC',
					'orderby'                => 'date',
				);
				$news = new WP_Query( $args );
				if ( $news->have_posts() ) {
					while ( $news->have_posts() ) {
						$news->the_post();
				?>
					<div class="col-1-1 nopad">
						<div <?php post_class('newsGridHome'); ?>>
							<a href="<?php the_permalink(); ?>">
							<?php if(has_post_thumbnail()) : ?>
							<div class="img">
							<?php the_post_thumbnail('big'); ?>
							</div>
							<?php endif;?>
							<div class="padding">
								<h4><?php the_title(); ?></h4>
								<p><?php echo excerpt(24); ?>...</p>
								<a href="<?php the_permalink(); ?>" class="readMore">Read more <i class="fa fa-arrow-circle-o-right"></i></a>
			    			</div>
			    			</a>
						</div>
					</div>
				<?php
					}
				} else {
					// no posts found
				}
				wp_reset_postdata();
				?>
				</div>		
			</div>
			<div class="col-1-4">
				<article id="twitter" class="clearfix">
					<h3>TWITTER NEWSFEED</h3>
					<a class="twitter-timeline" href="https://twitter.com/StopIvory" data-widget-id="477086014574297088" data-chrome="nofooter transparent" data-link-color="#d81420" data-theme="dark" data-aria-polite="assertive">Tweets by @StopIvory</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</article>
			</div>
		</div>	
			
	</div>	
	
	<?php endwhile; else :  endif; ?>
</div>	
<?php }  else if( is_page('How To Engage') ) { ?>
<div class="page">		
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
	<?php 
		$args = array( 
			'orderby' => 'menu_order',
			'order' => 'ASC', 
			'post_parent' => $post->ID, 
			'post_type' => 'page', 
			'post_status' => 'publish' 
		); 
		$postslist = get_posts($args); 
		foreach ($postslist as $post) : setup_postdata($post); 
	?>
	 
	<div class="slide" data-anchor="<?php the_title(); ?>">
		<div class="grid" id="pageText">
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
			<div class="col-3-4">
				<div <?php post_class(); ?>>
					<?php global $post; $howTo = get_post_meta( $post->ID, '_cmb_howTo', true ); if( $howTo != '' ) :  ?>
					<div class="paddingTop">
						<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_howTo', true ) );  ?>
					</div>
					<?php endif;?>
					<?php if(has_post_thumbnail()) : ?>
					<div class="img">
					<?php the_post_thumbnail('sliver'); ?>
					</div>
					<?php endif;?>
					<div class="padding">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
						<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); if( $download != '' ) :  ?>
						<h3 class="downloadPDF"><a href="<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); echo $download;  ?>"><i class="fa fa-arrow-circle-o-down"></i> Download Letter of Commitment</a></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="relatedNews col-1-4">
				<h4>Further Resources:</h4>
				<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
			</div>
			<?php else : ?>
			<div class="col-1-1 nopad">
				<div <?php post_class(); ?>>
					<?php global $post; $howTo = get_post_meta( $post->ID, '_cmb_howTo', true ); if( $howTo != '' ) :  ?>
					<div class="paddingTop">
						<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_howTo', true ) );  ?>
					</div>
					<?php endif;?>
					<?php if(has_post_thumbnail()) : ?>
					<div class="img">
					<?php the_post_thumbnail('sliver'); ?>
					</div>
					<?php endif;?>
					<div class="padding">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
						<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); if( $download != '' ) :  ?>
						<h3 class="downloadPDF"><a href="<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); echo $download;  ?>"><i class="fa fa-arrow-circle-o-down"></i> Download Letter of Commitment</a></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>			
			<?php endif; ?>
		</div>		
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
	</div>	
<?php } else { ?>
<div class="page">	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		
		<div class="grid" id="pageText">
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
			<div class="col-3-4">
				<div <?php post_class(); ?>>
					<?php if(has_post_thumbnail()) : ?>
					<div class="img">
					<?php the_post_thumbnail('sliver'); ?>
					</div>
					<?php endif;?>
					<div class="padding">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
						<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); if( $download != '' ) :  ?>
						<h3 class="downloadPDF"><a href="<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); echo $download;  ?>"><i class="fa fa-arrow-circle-o-down"></i> Download Letter of Commitment</a></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="relatedNews col-1-4">
				<h4>Further Resources:</h4>
				<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
			</div>
			<?php else : ?>
			<div class="col-1-1 nopad">
				<div <?php post_class(); ?>>
					<?php if(has_post_thumbnail()) : ?>
					<div class="img">
					<?php the_post_thumbnail('sliver'); ?>
					</div>
					<?php endif;?>
					<div class="padding">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
						<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); if( $download != '' ) :  ?>
						<h3 class="downloadPDF"><a href="<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); echo $download;  ?>"><i class="fa fa-arrow-circle-o-down"></i> Download Letter of Commitment</a></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>			
			<?php endif; ?>
		</div>
		
	</div>	
	<?php endwhile; else :  endif; ?>
</div>	
<?php } ?>

<?php get_footer(); ?>
