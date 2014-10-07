<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid" id="pageText">
			<div <?php post_class('col-1-1 pageText'); ?>>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>							
					<div class="partners">					
						<?php if(has_post_thumbnail()) : ?>
						<div class="img">
							<?php the_post_thumbnail('sliver'); ?>
						</div>
						<?php endif;?>	
						<div class="padding">
							<h2><?php the_title(); ?></h2>
							<?php the_content(); ?>
							<span><a href="<?php print $_SERVER['HTTP_REFERER'];?>"><i class="fa fa-arrow-circle-o-left"></i> Back</a></span>
						</div>
					</div>
				<?php endwhile; else :  endif; ?>
				<div id="nav">
					<div class="col-1-2"><div class="navArrows alignleft"><?php next_post_link('%link', '<i class="fa fa-arrow-circle-o-left"></i> Next', FALSE); ?></div></div>
					<div class="col-1-2"><div class="navArrows alignright"><?php previous_post_link('%link', 'Previous <i class="fa fa-arrow-circle-o-right"></i>', FALSE); ?></div></div>
				</div>
			</div>	
		</div>
	</div>
</div>	

<?php get_footer(); ?>