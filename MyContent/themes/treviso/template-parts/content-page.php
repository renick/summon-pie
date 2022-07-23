<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() && true !== get_theme_mod( 'content_hero' ) ) : ?>
		<?php treviso_post_thumbnail(); ?>
	<?php endif; ?>
	<header class="entry-header">
		<?php if ( true !== get_theme_mod( 'content_hero' ) ) : ?>
			<?php the_title( '<h1 class="title entry-title">', '</h1>' ); ?>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'treviso' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'treviso' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer>
	<?php endif; ?>
</article>
