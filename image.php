<?php get_header(); ?>
<div class="page">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>">
		<div class="grid" id="pageText">
		<?php while ( have_posts() ) : the_post(); ?>
			<div <?php post_class('col-1-1'); ?>>
				<div class="padding">
					<h2><?php the_title(); ?></h2>
					<?php
					$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
					foreach ( $attachments as $k => $attachment ) :
						if ( $attachment->ID == $post->ID )
							break;
					endforeach;
					$k++;
					if ( count( $attachments ) > 1 ) :
						if ( isset( $attachments[ $k ] ) ) :
							$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
						else :
							$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
						endif;
					else :
						$next_attachment_url = wp_get_attachment_url();
					endif;
					?>
					<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
					<?php
					$attachment_size = apply_filters( 'stop_ivory_attachment_size', array( 1060, 1060 ) );
					echo wp_get_attachment_image( $post->ID, $attachment_size );
					?>
					</a>
					<?php if ( ! empty( $post->post_excerpt ) ) : ?>
					<?php the_excerpt(); ?>
					<?php endif; ?>					
					<?php
					$metadata = wp_get_attachment_metadata();
					printf( __( 'Published <time class="entry-date" datetime="%1$s">%2$s</time> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'stop_ivory' ),
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					esc_url( wp_get_attachment_url() ),
					$metadata['width'],
					$metadata['height'],
					esc_url( get_permalink( $post->post_parent ) ),
					esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
					get_the_title( $post->post_parent )
					);
					?>

					<div id="nav" class="grid">
						<div class="alignleft col-1-2"><?php previous_image_link( false, __( '&larr; Previous', 'stop_ivory' ) ); ?></div>
						<div class="alignright col-1-2"><?php next_image_link( false, __( 'Next &rarr;', 'stop_ivory' ) ); ?></div>
					</div>
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'stop_ivory' ), 'after' => '</div>' ) ); ?>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>