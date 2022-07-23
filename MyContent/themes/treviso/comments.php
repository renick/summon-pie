<?php
/**
 * The template for displaying comments.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
	if ( have_comments() ) :
		?>
		<p class="title is-4 comments-title">
			<span class="icon-text">
				<?php
				printf(
					'<span>%s Comment%s</span>',
					get_comments_number(),
					get_comments_number() > 1 ? 's' : ''
				);
				?>
				<span class="icon">
					<i class="fas fa-comment"></i>
				</span>
			</span>
		</p>
		<p class="subtitle is-6"><a href="#" class="reply-link"><?php esc_html_e( 'Leave a reply', 'treviso' ); ?></a></p>

		<?php the_comments_navigation(); ?>

		<ul class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ul',
					'short_ping' => true,
					'callback'   => 'treviso_comments',
				)
			);
			?>
		</ul>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'treviso' ); ?></p>
			<?php
		endif;

	endif;

	treviso_comment_form();
	?>
</div>
