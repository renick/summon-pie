<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="title page-title"><?php esc_html_e( 'Nothing Found', 'treviso' ); ?></h1>
	</header>

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'treviso' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);
		elseif ( is_search() ) :
			?>
			<div class="columns">
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
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'treviso' ); ?></p>
			<?php
		else :
			?>
			<div class="columns">
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
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'treviso' ); ?></p>
			<?php
		endif;
		?>
	</div>
</section>
