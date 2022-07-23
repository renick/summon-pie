<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

get_header();
?>
	<section class="section hero">
		<div class="hero-body">
			<p class="title">
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'treviso' ); ?>
			</p>
			<p class="subtitle">
				<?php esc_html_e( 'Try searching or clicking one of the links below.', 'treviso' ); ?>
			</p>
		</div>
	</section>
	<section class="section">
		<?php if ( true !== get_theme_mod( 'content_containers_disabled' ) ) : ?>
		<div class="container">
		<?php endif; ?>
			<div class="columns is-centered">
				<div class="column is-half">
					<?php get_search_form(); ?>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<h3 class="title is-4"><?php esc_html_e( 'Recent Posts', 'treviso' ); ?></h3>
					<ul>
						<?php
						$treviso_recent_posts_query = new WP_Query(
							array(
								'posts_per_page'      => 5,
								'no_found_rows'       => true,
								'post_status'         => 'publish',
								'ignore_sticky_posts' => true,
								'post__not_in'        => array( get_queried_object_id() ),
							)
						);

						while ( $treviso_recent_posts_query->have_posts() ) {
							$treviso_recent_posts_query->the_post();
							printf(
								'<li><a href="%s">%s</a></li>',
								esc_attr( get_permalink() ),
								esc_html( get_the_title() )
							);
						}
						?>
					</ul>
				</div>
				<div class="column">
					<h3 class="title is-4"><?php esc_html_e( 'Monthly Archives', 'treviso' ); ?></h3>
					<ul>
						<?php
						wp_get_archives(
							array(
								'type'  => 'monthly',
								'limit' => 5,
							)
						);
						?>
					</ul>
				</div>
				<div class="column">
					<h3 class="title is-4"><?php esc_html_e( 'Popular Categories', 'treviso' ); ?></h3>
					<ul>
						<?php
						$treviso_categories = get_categories(
							array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'hide_empty' => false,
							)
						);

						foreach ( array_slice( $treviso_categories, 0, 5 ) as $treviso_category ) {
							printf(
								'<li><a href="%s">%s (%s)</a></li>',
								esc_url( get_permalink( $treviso_category->term_id ) ),
								esc_html( $treviso_category->name ),
								esc_html( $treviso_category->count )
							);
						}
						?>
					</ul>
				</div>
			</div>
		<?php if ( true !== get_theme_mod( 'content_containers_disabled' ) ) : ?>
		</div>
		<?php endif; ?>
	</section>

<?php
get_footer();
