<?php
/**
 * Template part for displaying posts.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
<?php if ( is_singular() ) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( true !== get_theme_mod( 'content_hero' ) ) : ?>
				<?php treviso_in_category(); ?>
				<?php the_title( '<h1 class="title is-spaced entry-title">', '</h1>' ); ?>
				<p class="subtitle is-4 entry-summary"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="entry-meta">
				<?php
				treviso_posted_by();
				esc_html_e( ' on ', 'treviso' );
				treviso_posted_on();
				?>
			</div>
		</header>

		<?php
		if ( ! empty( get_theme_mod( 'content_socialbtns' ) ) ) {
			if ( 'top' === get_theme_mod( 'content_socialbtns_location' ) || 'topbottom' === get_theme_mod( 'content_socialbtns_location' ) ) {
				treviso_social_buttons();
			}
		}
		?>

		<?php if ( has_post_thumbnail() && true !== get_theme_mod( 'content_hero' ) ) : ?>
			<?php treviso_post_thumbnail(); ?>
		<?php endif; ?>

		<div class="content entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'treviso' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'treviso' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php
		if ( true === get_theme_mod( 'content_post_tags' ) ) {
			treviso_post_tags();
		}

		if ( ! empty( get_theme_mod( 'content_socialbtns' ) ) ) {
			if ( 'bottom' === get_theme_mod( 'content_socialbtns_location' ) || 'topbottom' === get_theme_mod( 'content_socialbtns_location' ) ) {
				treviso_social_buttons();
			}
		}
		?>

		<footer class="entry-footer">
			<?php treviso_entry_footer(); ?>
		</footer>
	</article>
<?php else : ?>
	<a href="<?php echo esc_url( get_permalink() ); ?>" id="post-<?php the_ID(); ?>" <?php post_class( array( 'masonry-item', 'card' ) ); ?>>
		<header class="card-header">
			<?php
			the_title(
				'<p class="title card-header-title entry-title">',
				'</p>'
			);
			?>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="card-image<?php echo is_sticky() ? ' has-ribbon' : ''; ?>">
			<?php if ( is_sticky() ) : ?>
			<div class="ribbon"><?php esc_html_e( 'Featured', 'treviso' ); ?></div>
			<?php endif; ?>
			<figure class="image is-16by9">
				<?php the_post_thumbnail( 'medium' ); ?>
			</figure>
		</div>
		<?php endif; ?>
		<div class="card-content<?php echo empty( get_the_excerpt() ) ? ' empty' : ''; ?>">
			<div class="content">
				<div class="entry-summary">
					<?php treviso_truncated_excerpt(); ?>
				</div>
			</div>
		</div>
		<footer class="card-footer entry-footer">
			<div class="card-footer-item item-start">
				<?php treviso_posted_on(); ?>
			</div>
		</footer>
	</a>
<?php endif; ?>
