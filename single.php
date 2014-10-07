<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid" id="pageText">
			<div <?php post_class('col-1-1'); ?>>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>				
					<div class="partners">	
						<?php if(has_post_thumbnail()) : ?>
						<div class="img">
							<?php the_post_thumbnail('sliver'); ?>
						</div>
						<div class="padding">
							<h2><?php the_title(); ?></h2>
							<?php the_content(); ?>
						</div>
						<?php else : ?>
						<div class="padding">
							<h2><?php the_title(); ?></h2>
							<?php the_content(); ?>
						</div>						
						<?php endif;?>										
					</div>
				<?php endwhile; else :  endif; ?>
			</div>	
		</div>
	</div>
</div>		

<?php get_footer(); ?>