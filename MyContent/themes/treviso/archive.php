<?php
/**
 * The template for displaying archive pages.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

get_header();
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

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="title page-title">', '</h1>' );
							the_archive_description( '<h2 class="subtitle is-3 archive-description">', '</h2>' );
							?>
						</header>

						<div class="columns is-vcentered">
							<div class="column is-8">
								<?php get_search_form(); ?>
							</div>
							<div class="column is-4">
								<?php
								wp_dropdown_categories(
									array(
										'show_option_all' => esc_html__( 'Select Category', 'treviso' ),
										'class'           => 'cat-dropdown',
									)
								);
								?>
							</div>
						</div>

						<div class="masonry">
							<div class="masonry-sizer"></div>
							<div class="gutter-sizer"></div>
							<?php
							while ( have_posts() ) :
								the_post();

								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile;

							?>
						</div>

						<?php treviso_posts_navigation(); ?>

						<?php

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
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
