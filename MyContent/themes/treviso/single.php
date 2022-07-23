<?php
/**
 * The template for displaying all single posts.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

get_header();
?>
	<?php
	if ( true === get_theme_mod( 'content_hero' ) ) {
		treviso_hero_section();
	}
	?>

	<section class="section">
		<?php if ( true !== get_theme_mod( 'content_containers_disabled' ) ) : ?>
		<div class="container">
		<?php endif; ?>
			<div class="columns is-desktop">

				<?php
				if ( 'left' === get_theme_mod( 'content_sidebar_location' ) ) {
					get_sidebar();
				}
				?>

				<main id="primary" class="<?php echo esc_attr( treviso_get_main_classes() ); ?>">

					<?php
					if ( true === get_theme_mod( 'content_breadcrumbs' ) ) {
						treviso_breadcrumbs();
					}
					?>

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() );

						if ( true === get_theme_mod( 'content_post_nav' ) ) {
							treviso_posts_navigation();
						}

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile;
					?>

				</main>

				<?php
				if ( 'right' === get_theme_mod( 'content_sidebar_location' ) ) {
					get_sidebar();
				}
				?>

			</div>
		<?php if ( true !== get_theme_mod( 'content_containers_disabled' ) ) : ?>
		</div>
		<?php endif; ?>
	</section>

<?php
get_footer();
