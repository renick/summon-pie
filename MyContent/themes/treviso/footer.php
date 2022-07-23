<?php
/**
 * The template for displaying the footer.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
	<?php if ( true !== get_theme_mod( 'footer_disabled' ) ) : ?>
	<footer id="colophon" class="<?php echo esc_attr( treviso_get_footer_classes() ); ?>">
		<div class="container"<?php treviso_bg_style_attr( get_theme_mod( 'footer_bgimage' ) ); ?>>
			<div class="columns is-centered">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_id'        => 'site-footer',
							'container'      => '',
							'items_wrap'     => '%3$s',
							'walker'         => new Treviso_Walker_Footer_Menu(),
						)
					);
				}
				?>
			</div>
			<div class="copyright">
				<div class="copyright-start copyright-text">
					<?php treviso_footer_copyright_text(); ?>
				</div>
				<div class="copyright-end copyright-text">
					<?php
					if ( has_nav_menu( 'copyright' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'copyright',
								'menu_class'     => 'footer-menu',
							)
						);
					}
					?>
				</div>
			</div>
		</div>
	</footer>
	<?php endif; ?>
</div>

<div class="back-to-top">
	<a href="#" title="<?php esc_attr_e( 'Back to top', 'treviso' ); ?>">
		<?php treviso_back_to_top(); ?>
	</a>
</div>

<?php wp_footer(); ?>

</body>
</html>
