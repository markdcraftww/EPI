<?php get_header(); ?>
<div class="page">	

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		
		<div class="grid" id="pageText">
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
			<div class="col-2-3">
				<div <?php post_class(); ?>>
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>
				</div>
			</div>
			<div class="related col-1-3">
				<h4>Further Resources:</h4>
				<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
			</div>
			<?php else : ?>
			<div class="col-1-1">
				<div <?php post_class(); ?>>
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>
					<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); if( $download != '' ) :  ?>
					<h3 class="downloadPDF"><a href="<?php global $post; $download = get_post_meta( $post->ID, '_cmb_download', true ); echo $download;  ?>"><i class="fa fa-arrow-circle-o-down"></i> Download Pledge Letter</a></h3>
					<?php endif; ?>
				</div>
			</div>			
			<?php endif; ?>
		</div>
		
	</div>	
	<?php endwhile; else :  endif; ?>
</div>

<?php get_footer(); ?>
