<?php
/**
 * Custom template tags for this theme. Child themes can override these functions.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

if ( ! function_exists( 'treviso_site_title' ) ) :
	/**
	 * Prints HTML for the site title or logo.
	 */
	function treviso_site_title() {
		if ( has_custom_logo() ) {
			printf(
				'<img class="navbar-logo" src="%s" alt="%s">',
				esc_url( treviso_get_the_logo() ),
				esc_attr( get_bloginfo( 'name' ) )
			);
		} else {
			printf( '<span class="navbar-heading">%s</span>', esc_html( get_bloginfo( 'name' ) ) );
		}
	}
endif;

if ( ! function_exists( 'treviso_hero_section' ) ) :
	/**
	 * Prints HTML for an optional hero section with post thumbnail as a background, title and tag.
	 */
	function treviso_hero_section() {
		$post         = get_queried_object();
		$hero_classes = array( 'hero', 'hero-featured', 'is-medium' );

		if ( has_post_thumbnail() ) {
			$hero_classes[] = 'has-bg';
		}
		if ( true === get_theme_mod( 'content_hero_parallax' ) ) {
			$hero_classes[] = 'parallax';
		}

		?>
		<section class="<?php echo esc_attr( implode( ' ', $hero_classes ) ); ?>" 
			style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( $post->ID ) ); ?>');">
			<div class="hero-overlay"></div>
			<div class="hero-body">
				<div class="container">
					<?php
					$categories = get_the_category( $post->ID );

					if ( $categories ) {
						echo '<div class="tags category-tags">';
						foreach ( $categories as $category ) {
							echo sprintf(
								'<a href="%1$s" class="tag" title="%2$s">%3$s</a>',
								esc_url( get_category_link( $category->term_id ) ),
								/* translators: %s: category */
								esc_attr( sprintf( __( 'View all posts in %s', 'treviso' ), $category->name ) ),
								esc_html( $category->name )
							);
						}
						echo '</div>';
					}
					?>
					<h1 class="title is-spaced page-title entry-title"><?php echo esc_html( get_the_title( $post->ID ) ); ?></h1>
					<p class="subtitle is-4 entry-summary"><?php echo esc_html( get_the_excerpt() ); ?></p>
				</div>
			</div>
		</section>
		<?php
	}
endif;

if ( ! function_exists( 'treviso_header_image_style' ) ) :
	/**
	 * Prints HTML for the site header image.
	 */
	function treviso_header_image_style() {
		if ( has_header_image() ) {
			printf(
				' style="background-image: url(%s);"',
				esc_url( get_header_image() )
			);
		}
	}
endif;

if ( ! function_exists( 'treviso_footer_copyright_text' ) ) :
	/**
	 * Prints HTML for the site footer copyright text (or default powered-by).
	 */
	function treviso_footer_copyright_text() {
		if ( empty( get_theme_mod( 'footer_copyrighttext' ) ) ) {
			echo '<div class="powered-by">' . esc_html__( 'Powered by Treviso WordPress Theme', 'treviso' ) . '</div>';
		} else {
			printf( '<div class="company">&copy; 2021 %s,&nbsp;</div>', esc_html( get_theme_mod( 'footer_copyrighttext' ) ) );
			echo '<div class="rights-text">' . esc_html__( 'All rights reserved', 'treviso' ) . '</div>';
		}
	}
endif;

if ( ! function_exists( 'treviso_posted_on' ) ) :
	/**
	 * Prints HTML for the current post date.
	 */
	function treviso_posted_on() {
		?>
		<span class="posted-on">
			<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
				<?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
			</time>
		</span>
		<?php
	}
endif;

if ( ! function_exists( 'treviso_posted_by' ) ) :
	/**
	 * Prints HTML for the current post author.
	 */
	function treviso_posted_by() {
		?>
		<span class="byline">
			By
			<span class="author vcard">
				<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" 
					title="<?php echo esc_attr( get_the_author() ); ?>">
					<?php echo esc_html( get_the_author() ); ?>
				</a>
			</span>
		</span>
		<?php
	}
endif;

if ( ! function_exists( 'treviso_in_category' ) ) :
	/**
	 * Prints HTML for the current post categories.
	 */
	function treviso_in_category() {
		if ( 'post' === get_post_type() ) {
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				?>
				<span class="cat-links">
					<ul class="post-categories">
						<?php foreach ( $categories as $category ) : ?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" rel="category tag" 
									alt="<?php /* translators: %s: post category */ sprintf( esc_attr_e( 'View all posts in %s', 'treviso' ), $category->name ); ?>">
								<?php echo esc_html( $category->name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</span>
				<?php
			}
		}
	}
endif;

if ( ! function_exists( 'treviso_comments_link' ) ) :
	/**
	 * Prints HTML for the current post comments link.
	 */
	function treviso_comments_link() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fas fa-comment fa-fw"></i>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave comment<span class="screen-reader-text"> on %s</span>', 'treviso' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'treviso_entry_footer' ) ) :
	/**
	 * Prints HTML for the current post footer.
	 */
	function treviso_entry_footer() {
		if ( ! is_singular() ) {
			?>
			<span class="read-more">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php esc_html_e( 'View Post', 'treviso' ); ?></a>
			</span>
			<?php
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'treviso' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'treviso_post_thumbnail' ) ) :
	/**
	 * Prints HTML for an optional post thumbnail. Wraps the post thumbnail in an 
	 * anchor element on index views, or a div element when on single views.
	 *
	 * @param string $size Image size to get.
	 */
	function treviso_post_thumbnail( $size = 'post-thumbnail' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</div>
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>">
				<?php
					the_post_thumbnail(
						$size,
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'treviso_truncated_excerpt' ) ) :
	/**
	 * Prints HTML for a truncated post excerpt.
	 */
	function treviso_truncated_excerpt() {
		echo esc_html( mb_strimwidth( get_the_excerpt(), 0, 180, '...' ) );
	}
endif;

if ( ! function_exists( 'treviso_category_tags' ) ) :
	/**
	 * Prints HTML for the available category tags.
	 */
	function treviso_category_tags() {
		$categories = get_categories( array( 'hide_empty' => false ) );
		if ( $categories ) {
			echo '<div class="tags category-tags">';
			foreach ( $categories as $category ) {
				echo sprintf(
					'<a href="%1$s" class="tag" alt="%2$s">%3$s</a>',
					esc_url( get_category_link( $category->term_id ) ),
					/* translators: %s: category */
					esc_attr( sprintf( __( 'View all posts in %s', 'treviso' ), $category->name ) ),
					esc_html( $category->name )
				);
			}
			echo '</div>';
		}
	}
endif;

if ( ! function_exists( 'treviso_post_tags' ) ) :
	/**
	 * Prints HTML for the tags for a post.
	 */
	function treviso_post_tags() {
		$post_tags = get_the_tags();
		if ( $post_tags ) {
			?>
			<div class="tags post-tags">
			<?php
			foreach ( $post_tags as $tag ) {
				?>
				<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
				<?php
			}
			?>
			</div>
			<?php
		}
	}
endif;

if ( ! function_exists( 'treviso_breadcrumbs' ) ) :
	/**
	 * Prints HTML for breadcrumbs.
	 */
	function treviso_breadcrumbs() {
		if ( is_front_page() ) {
			return;
		}

		echo '<nav class="breadcrumb has-arrow-separator" aria-label="breadcrumbs">' . "\n";
		echo '<ul>' . "\n";
			
		printf(
			'<li><a href="%s">%s</a></li>' . "\n",
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	
		if ( is_singular() ) {
			$categories = get_the_category();
			printf(
				'<li><a href="%s">%s</a></li>' . "\n",
				esc_url( get_category_link( $categories[0]->term_id ) ),
				esc_html( $categories[0]->cat_name )
			);

			printf(
				'<li class="is-active"><a aria-current="page">%s</a></li>' . "\n",
				esc_html( get_the_title() )
			);
		} elseif ( is_archive() ) {
			$text = '';
			if ( is_day() ) {
				$text = get_the_date();
			} elseif ( is_month() ) {
				$text = get_the_date( _x( 'F Y', 'monthly archives date format', 'treviso' ) );
			} elseif ( is_year() ) {
				$text = get_the_date( _x( 'Y', 'yearly archives date format', 'treviso' ) );
			} else {
				$text = esc_html__( 'Blog Archives', 'treviso' );
			}

			printf(
				'<li class="is-active"><a aria-current="page">%s</a></li>' . "\n",
				esc_html( $text )
			);
		}

		echo '</nav>';
	}
endif;

if ( ! function_exists( 'treviso_social_buttons' ) ) :
	/**
	 * Prints HTML for social buttons.
	 */
	function treviso_social_buttons() {
		$content_socialbtns = get_theme_mod( 'content_socialbtns' );
		if ( ! is_array( $content_socialbtns ) ) {
			return;
		}

		$social_networks = treviso_get_social_media_networks();
		
		echo '<div class="buttons social">';
		foreach ( $content_socialbtns as $button ) {
			if ( ! array_key_exists( $button, $social_networks ) ) {
				continue;
			}
			$network = $social_networks[ $button ];
			$options = get_theme_mod( 'content_socialbtns_options' );

			$btn_classes = array( 'button', 'is-' . $button );
			if ( in_array( 'rounded', $options, true ) ) {
				$btn_classes[] = 'is-circular';
			}
			if ( in_array( 'outlined', $options, true ) ) {
				$btn_classes[] = 'is-outlined';
			}
			if ( in_array( 'shadow', $options, true ) ) {
				$btn_classes[] = 'has-shadow';
			}
			if ( in_array( 'label', $options, true ) ) {
				$btn_classes[] = 'has-label';
			}
			if ( in_array( 'size_md', $options, true ) ) {
				$btn_classes[] = 'is-medium';
			}

			?>
			<a class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" href="<?php echo esc_url( $network['share_url'] ); ?>" 
				title="<?php echo esc_attr( $network['name'] ); ?> share link."<?php treviso_print_data_attrs( $network['url_params'] ); ?>>
				<span class="icon">
					<i class="<?php echo esc_attr( $network['fa_icon'] ); ?>"></i>
				</span>
				<?php if ( in_array( 'label', $options, true ) ) : ?>
				<span><?php echo esc_html( $network['name'] ); ?></span>
				<?php endif; ?>
			</a>
			<?php
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'treviso_posts_navigation' ) ) :
	/**
	 * Prints HTML for numeric post navigation buttons.
	 */
	function treviso_posts_navigation() {
		if ( is_singular() ) {
			the_post_navigation(
				array(
					'next_text' => '<i class="fas fa-arrow-alt-circle-right"></i> <span class="nav-subtitle"></span>Next Up: <span class="nav-title">%title</span>',
					'prev_text' => '<i class="fas fa-arrow-alt-circle-left"></i> <span class="nav-subtitle"></span>Previously: <span class="nav-title">%title</span>',
				)
			);
			return;
		}

		global $wp_query;

		// Stop execution if there's only 1 page.
		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );

		// Add current page to the array.
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		// Add the pages around the current page to the array.
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<nav class="pagination is-centered" role="navigation" aria-label="pagination">' . "\n";
		
		// Previous Post Link.
		if ( get_previous_posts_link() ) {
			printf(
				'<a class="pagination-previous" href="%s">Previous</a>' . "\n",
				esc_url( get_previous_posts_page_link() )
			);
		} else {
			echo '<a class="pagination-previous" title="This is the first page" disabled>Previous</a>' . "\n";
		}

		// Next Post Link.
		if ( get_next_posts_link() ) {
			printf(
				'<a class="pagination-next" href="%s">Next</a>' . "\n",
				esc_url( get_next_posts_page_link() )
			);
		} else {
			echo '<a class="pagination-next" title="This is the last page" disabled>Next</a>' . "\n";
		}

		echo '<ul class="pagination-list">' . "\n";

		// Link to first page, plus ellipses if necessary.
		if ( ! in_array( 1, $links, true ) ) {
			printf(
				'<li><a class="pagination-link%s" aria-label="Goto page %s"%s href="%s">%s</a></li>' . "\n",
				( 1 === $paged ? ' is-current' : '' ),
				'1',
				( 1 === $paged ? ' aria-current="page"' : '' ),
				esc_url( get_pagenum_link( 1 ) ),
				'1'
			);

			if ( ! in_array( 2, $links, true ) ) {
				echo '<li><span class="pagination-ellipsis">&hellip;</span></li>' . "\n";
			}
		}

		// Link to current page, plus 2 pages in either direction if necessary.
		sort( $links );
		foreach ( (array) $links as $link ) {
			printf(
				'<li><a class="pagination-link%s" aria-label="Goto page %s"%s href="%s">%s</a></li>' . "\n",
				( $paged === $link ? ' is-current' : '' ),
				esc_html( $link ),
				( $paged === $link ? ' aria-current="page"' : '' ),
				esc_url( get_pagenum_link( $link ) ),
				esc_html( $link )
			);
		}

		// Link to last page, plus ellipses if necessary.
		if ( ! in_array( $max, $links, true ) ) {
			if ( ! in_array( $max - 1, $links, true ) ) {
				echo '<li><span class="pagination-ellipsis">&hellip;</span></li>' . "\n";
			}

			printf(
				'<li><a class="pagination-link%s" aria-label="Goto page %s"%s href="%s">%s</a></li>' . "\n",
				( $paged === $max ? ' is-current' : '' ),
				esc_html( $max ),
				( $paged === $max ? ' aria-current="page"' : '' ),
				esc_url( get_pagenum_link( $max ) ),
				esc_html( $max )
			);
		}

		echo '</ul></nav>' . "\n";
	}
endif;

if ( ! function_exists( 'treviso_comments' ) ) :
	/**
	 * Prints HTML for the custom comments.
	 * 
	 * @param object $comment The current comment.
	 * @param array  $args Arguments for the comments.
	 * @param int    $depth Depth of nested comments.
	 */
	function treviso_comments( $comment, $args, $depth ) {
		if ( $depth > 1 ) {
			$size_class = 'is-32x32';
		} else {
			$size_class = 'is-48x48';
		}
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
			<figure class="media-left">
				<p class="image <?php echo esc_attr( $size_class ); ?>">
					<?php echo get_avatar( $comment, $depth > 1 ? '32' : '48', '', '', array( 'class' => 'is-rounded' ) ); ?>
				</p>
			</figure>
			<div class="media-content">
				<div class="content">
					<p>
						<strong><?php echo esc_html( get_comment_author() ); ?></strong>
						<br>
						<small>
							<?php
							printf(
								/* translators: 1: date and time(s). */
								esc_html__( '%1$s at %2$s', 'treviso' ),
								esc_html( get_comment_date() ),
								esc_html( get_comment_time() )
							);
							?>
						</small>
						<br>
						<?php comment_text(); ?>
					</p>
				</div>
				<nav class="level is-mobile">
					<div class="level-left">
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => '<span class="icon-text"><span class="icon"><i class="fas fa-reply"></i></span><span>Reply</span></span>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
									'before'     => '<div class="level-item">',
									'after'      => '</div>',
								)
							)
						)
						?>
					</div>
				</nav>
			</div>
		</li>
		<?php
	}
endif;

if ( ! function_exists( 'treviso_comment_form' ) ) :
	/**
	 * Prints HTML for the custom comments form.
	 */
	function treviso_comment_form() {
		$commenter     = wp_get_current_commenter();
		$req_email     = get_option( 'require_name_email' );
		$comments_aria = ( $req_email ? " aria-required='true'" : '' );

		$args = array(
			'comment_field'       => '<div class="field comment-form-content">'
								. '<label class="label">' . esc_html__( 'Comment', 'treviso' ) . ' *</label> '
								. '<div class="control">'
								. '<textarea class="textarea" id="comment" name="comment" aria-required="true"></textarea>'
								. '</div>'
								. '<p class="help is-danger"></p>'
								. '</div>',
			'title_reply_before'  => '<h6 id="reply-title" class="title is-6 comment-reply-title">',
			'title_reply_after'   => '</h6>',
			'cancel_reply_before' => '<p class="subtitle is-6">',
			'cancel_reply_after'  => '</p>',
			'fields'              => apply_filters(
				'treviso_comment_form_default_fields',
				array(
					'author'  => '<div class="field comment-form-author">'
							. '<label class="label">' . esc_html__( 'Name', 'treviso' ) . ( $req_email ? ' *' : '' ) . '</label> '
							. '<div class="control">'
							. '<input class="input" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $comments_aria . ' />'
							. '</div>'
							. '<p class="help is-danger"></p>'
							. '</div>',
					'email'   => '<div class="field comment-form-email">'
							. '<label class="label">' . esc_html__( 'Email', 'treviso' ) . ( $req_email ? ' *' : '' ) . '</label> '
							. '<div class="control">'
							. '<input class="input" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $comments_aria . ' />'
							. '</div>'
							. '<p class="help is-danger"></p>'
							. '</div>',
					'url'     => '<div class="field comment-form-url">'
							. '<label class="label">' . esc_html__( 'Website', 'treviso' ) . '</label>'
							. '<div class="control">'
							. '<input class="input" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />'
							. '</div>'
							. '</div>',
					'cookies' => '<div class="field comment-form-cookies-consent">'
							. '<div class="control">'
							. '<label class="checkbox">'
							. '<input type="checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" value="yes"/>'
							. esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'treviso' )
							. '</label>'
							. '</div>'
							. '</div>',
				)
			),
		);

		comment_form( $args );
	}
endif;

if ( ! function_exists( 'treviso_back_to_top' ) ) :
	/**
	 * Prints HTML for the Back To Top button.
	 */
	function treviso_back_to_top() {
		if ( ! empty( get_theme_mod( 'btt_btnimage' ) ) ) {
			printf(
				'<img src="%s" width="20" height="20" alt="%s">',
				esc_url( get_theme_mod( 'btt_btnimage' ) ),
				esc_attr__( 'Back to top', 'treviso' )
			);
		} else {
			echo '<i class="fas fa-angle-double-up fa-2x"></i>';
		}
		echo '<span class="is-sr-only">' . esc_html__( 'Back to top', 'treviso' ) . '</span>';
	}
endif;
