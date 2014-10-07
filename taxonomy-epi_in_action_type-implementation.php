<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid">
			<div class="col-10-12 nopad">
				<div class="related col-1-1" id="mobilefilters">
					<h4>IMPLEMENTATION <i class="fa fa-caret-square-o-down"></i></h4>
					<div class="filterhide">
						<ul class="filterList">
							<li><button href="#filter" data-desc="<?php echo term_description('41','epi_in_action_tx'); ?>" data-filter="*" class="filterer activeFilter">SHOW ALL</button></li>
							<?php
								$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
								$taxonomy = 'epi_in_action_tx';
									$args = array(
										'orderby'            => 'ID',
										'order'              => 'ASC',
										'style'              => 'list',
										'show_count'         => 0,
										'hide_empty'         => 0,
										'use_desc_for_title' => 0,
										'child_of'           => $term->term_id,
										'hierarchical'       => true,
										'title_li'           => '',
										'show_option_none'   => '',
										'number'             => NULL,
										'echo'               => 1,
										'depth'              => 1,
										'current_category'   => 0,
										'pad_counts'         => 0,
										'taxonomy'           => $taxonomy,
										'walker'             => new epi_tax_walker()
									);
									wp_list_categories($args); 
							?>
						</ul>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php endwhile; ?>
						<div id="post-navigation">
							<?php next_posts_link(__( '<i class="fa fa-caret-square-o-left"></i> Older' )) ?>
							<?php previous_posts_link(__( 'Newer <i class="fa fa-caret-square-o-right"></i>' )) ?>
						</div>					
						<?php else :  endif; ?>
					</div>
				</div>
				<div class="grid">
					<div class="col-1-1" id="cat_desc"><?php echo term_description('41','epi_in_action_tx'); ?></div>
				</div>
				<div class="grid" id="sortable">
					<?php
					$terms = get_terms( 'epi_in_action_tx' );
					$term_ids = wp_list_pluck( $terms, 'term_id' );
					$args = array (
						'post_type' => 'epi_in_action',
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'epi_in_action_type',
								'field' => 'slug',
								'terms' => array('implementation')
							),
							array(
								'taxonomy' => 'epi_in_action_tx',
								'field' => 'term_id',
								'terms' => $term_ids
							),
						),
						'posts_per_page' => -1
					);
					$orgs = new WP_Query( $args );
					if ( $orgs->have_posts() ) :
						while ( $orgs->have_posts() ) :
							$orgs->the_post();
					?>			
						<div <?php post_class('col-1-3'); ?>>
							<a href="<?php the_permalink(); ?>">
							<div class="partners">
								<?php if(has_post_thumbnail()) : ?>
								<div class="img">
								<?php the_post_thumbnail('grid'); ?>
								</div>
								<?php endif;?>						
								<div class="padding">
									<h2><?php the_title(); ?></h2>
									<?php the_excerpt(); ?>
									<span>...Read more &raquo;</span>
								</div>
							</div>
							</a>
						</div>
					<?php endwhile; ?>
					<div id="post-navigation">
						<?php next_posts_link(__( '<i class="fa fa-caret-square-o-left"></i> Older' )) ?>
						<?php previous_posts_link(__( 'Newer <i class="fa fa-caret-square-o-right"></i>' )) ?>
					</div>					
					<?php else :  endif; ?>
				</div>
			</div>	
			<div class="related col-1-6" id="desktopfilters">
				<h4>IMPLEMENTATION</h4>
					<ul class="filterList">
						<li><button href="#filter" data-desc="<?php echo term_description('41','epi_in_action_tx'); ?>" data-filter="*" class="filterer activeFilter">SHOW ALL</button></li>
						<?php
							$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
							$taxonomy = 'epi_in_action_tx';
								$args = array(
									'orderby'            => 'ID',
									'order'              => 'ASC',
									'style'              => 'list',
									'show_count'         => 0,
									'hide_empty'         => 0,
									'use_desc_for_title' => 0,
									'child_of'           => $term->term_id,
									'hierarchical'       => true,
									'title_li'           => '',
									'show_option_none'   => '',
									'number'             => NULL,
									'echo'               => 1,
									'depth'              => 1,
									'current_category'   => 0,
									'pad_counts'         => 0,
									'taxonomy'           => $taxonomy,
									'walker'             => new epi_tax_walker()
								);
								wp_list_categories($args); 
						?>
						</ul>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php endwhile; ?>
					<div id="post-navigation">
						<?php next_posts_link(__( '<i class="fa fa-caret-square-o-left"></i> Older' )) ?>
						<?php previous_posts_link(__( 'Newer <i class="fa fa-caret-square-o-right"></i>' )) ?>
					</div>					
					<?php else :  endif; ?>
			</div>
		</div>
	</div>
</div>	

<?php get_footer(); ?>