<?php
/**
 * The main fallback template file.
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
						<?php
						if ( is_home() && ! is_front_page() ) :
							?>
							<header>
								<h1 class="title page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
							<?php
						endif;

						?>
						<div class="masonry">
							<div class="masonry-sizer"></div>
							<div class="gutter-sizer"></div>
							<?php

							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );

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
