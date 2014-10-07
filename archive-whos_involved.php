<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid">
			<div class="col-10-12 nopad">
				<div class="related col-1-1" id="mobilefilters">
					<h4>FILTER <i class="fa fa-caret-square-o-down"></i></h4>
					<div class="filterhide">
						<ul class="filterList">
							<li><button href="#filter" data-desc="<?php echo term_description(); ?>" data-filter="*" class="filterer activeFilter">SHOW ALL</button></li>
							<?php
								$args = array(
									'orderby'            => 'ID',
									'order'              => 'ASC',
									'style'              => 'list',
									'show_count'         => 0,
									'hide_empty'         => 1,
									'use_desc_for_title' => 0,
									'child_of'           => 0,
									'hierarchical'       => true,
									'title_li'           => '',
									'show_option_none'   => '',
									'number'             => NULL,
									'echo'               => 1,
									'depth'              => 0,
									'current_category'   => 0,
									'pad_counts'         => 0,
									'taxonomy'           => 'whos_involved_tx',
									'walker'             => new epi_tax_walker()
								);
								wp_list_categories($args); 
							?>
						</ul>
					</div>
				</div>
				<div class="grid">
					<div class="col-1-1" id="cat_desc"><?php echo term_description('41','whos_involved_tx'); ?></div>
				</div>
				<div class="grid" id="sortable">
					<?php
					$args = array (
						'post_type' => 'whos_involved',
						'taxonomy' => 'whos_involved_tx',
						'posts_per_page' => '100',
						'pagination' => true
					);
					$orgs = new WP_Query( $args );
					if ( $orgs->have_posts() ) {
						while ( $orgs->have_posts() ) {
							$orgs->the_post();
					?>			
						<div <?php post_class('col-1-3'); ?>>
							<a href="<?php the_permalink(); ?>">
							<div class="partners">
								<?php if(has_post_thumbnail()) : ?>
								<div class="img">
									<?php the_post_thumbnail(); ?>
								</div>
								<div class="padding">
								<?php else : ?>
								<div class="paddingTop">
								<?php endif;?>	
									<h2><?php the_title(); ?></h2>
									<p><?php echo excerpt(10); ?>...</p>
									<span>Read more <i class="fa fa-arrow-circle-o-right"></i></span>
								</div>
							</div>
							</a>
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
			<div class="related col-1-6" id="desktopfilters">
				<ul class="filterList">
					<li class="children"><button href="#filter" data-desc="<?php echo term_description('41','whos_involved_tx'); ?>" data-filter="*" class="filterer activeFilter">SHOW ALL</button></li>
					<?php
						$args = array(
							'orderby'            => 'ID',
							'order'              => 'ASC',
							'style'              => 'list',
							'show_count'         => 0,
							'hide_empty'         => 1,
							'use_desc_for_title' => 0,
							'child_of'           => 0,
							'hierarchical'       => true,
							'title_li'           => '',
							'show_option_none'   => '',
							'number'             => NULL,
							'echo'               => 1,
							'depth'              => 0,
							'current_category'   => 0,
							'pad_counts'         => 0,
							'taxonomy'           => 'whos_involved_tx',
							'walker'             => new epi_tax_walker()
						);
						wp_list_categories($args); 
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>