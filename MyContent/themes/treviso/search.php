<?php
/**
 * The template for displaying search results pages.
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

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="title page-title">
								<?php
								printf(
									/* translators: %s: search query. */
									esc_html__( 'Search Results for: %s', 'treviso' ),
									get_search_query()
								);
								?>
							</h1>
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

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

							endwhile;
							?>
						</div>

						<?php

						treviso_posts_navigation();

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
