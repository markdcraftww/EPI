<?php get_header(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid" id="pageText">
			<div class="col-1-2">
				<div class="partner type-page">
					<div class="paddingTop">
						<h2>ERROR 404 / NOT FOUND</h2>
						<p>The page you were looking for has been moved or does not exist</p>
						<p>Please browse our latest news instead.</p>
					</div>
				</div>
			</div>	
			<div class="col-1-2 nopad">
				<div class="partner type-page">
					<div class="paddingTop">
						<ul class="epiInAction">
						<?php
							$args = array (
								'post_type' => 'epi_in_action',
							);
							$orgs = new WP_Query( $args );
							if ( $orgs->have_posts() ) {
								while ( $orgs->have_posts() ) {
									$orgs->the_post();
							?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php
								}
							} else {
								// no posts found
							}
							wp_reset_postdata();
							?>	
						</ul>						
					</div>
				</div>
			</div>			
		</div>
		
	</div>	
	
<?php get_footer(); ?>