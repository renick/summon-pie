<?php
/**
 * The header for our theme. This is the template that displays all of the <head> section
 * and everything up until first section.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site"<?php treviso_preview_data_attr(); ?>>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'treviso' ); ?></a>
	<?php if ( true !== get_theme_mod( 'header_disabled' ) ) : ?>
	<header id="masthead" class="<?php echo esc_attr( treviso_get_header_classes() ); ?>" role="navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'treviso' ); ?>"<?php treviso_header_image_style(); ?>>
		<div class="navbar-brand">
			<a class="navbar-item site-title" href="<?php echo esc_url( get_home_url() ); ?>" title="<?php esc_attr_e( 'Home', 'treviso' ); ?>">
				<?php treviso_site_title(); ?>
			</a>
			<?php if ( ! has_nav_menu( 'navbar-start' ) ) : ?>
			<div class="navbar-item navbar-caption site-description">
				<?php bloginfo( 'description' ); ?>
			</div>
			<?php endif; ?>
			<a href="#" role="button" class="navbar-burger burger" aria-label="<?php esc_attr_e( 'Menu', 'treviso' ); ?>" aria-expanded="false" data-target="navbar-menu">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>
		<div id="navbar-menu" class="navbar-menu">
			<?php
			if ( has_nav_menu( 'navbar-start' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'navbar-start',
						'container'       => 'div',
						'container_class' => 'navbar-start',
						'items_wrap'      => '%3$s',
						'walker'          => new Treviso_Walker_Nav_Menu(),
					)
				);
			}
			?>
			<?php
			if ( has_nav_menu( 'navbar-end' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'navbar-end',
						'container'       => 'div',
						'container_class' => 'navbar-end',
						'items_wrap'      => '%3$s',
						'walker'          => new Treviso_Walker_Nav_Menu(),
					)
				);
			}
			?>
		</div>
	</header>
	<?php endif; ?>
