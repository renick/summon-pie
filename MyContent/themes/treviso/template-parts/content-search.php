<?php
/**
 * Template part for displaying results in search pages.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
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
			<div class="ribbon"><?php esc_html__( 'Featured', 'treviso' ); ?></div>
			<?php endif; ?>)
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
