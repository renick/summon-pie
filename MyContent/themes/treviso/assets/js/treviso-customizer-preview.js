"use strict";

( function( $ ) {

	// Site Title.
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title .navbar-heading').text(to);
		});
	});

	// Site Description.
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});

	// Meta Color.
	wp.customize('head_meta_color', function(value) {
		value.bind(function(to) {
			$('#treviso_head_meta_color').remove();
			$('<meta>').attr('id', 'treviso_head_meta_color').prop('name', 'theme-color').prop('content', to).appendTo('head');
		});
	});

	// Header Background Color.
	wp.customize('header_bgcolor', function(value) {
		value.bind(function(to) {
			$('#treviso_header_bgcolor').remove();
			$('<style>').attr('id', 'treviso_header_bgcolor').prop('type', 'text/css').html(
				`.navbar,
				.navbar.is-transparent.is-scrolled {
					background: ${to};
				}`
				).appendTo('head');
		});
	});

	// Header Text Color.
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('#treviso_header_textcolor').remove();
				$('<style>').attr('id', 'treviso_header_textcolor').prop('type', 'text/css').html(
					`.site-title, .site-description {
						clip: rect(1px, 1px, 1px, 1px);
						position: absolute;
					}`
					).appendTo('head');
			} else {
				$('#treviso_header_textcolor').remove();
				$('<style>').attr('id', 'treviso_header_textcolor').prop('type', 'text/css').html(
					`.site-title, .site-description {
						clip: auto;
						position: relative;
					}
					.navbar-heading,
					.navbar.is-transparent.is-scrolled .navbar-heading,
					.navbar-caption,
					.navbar.is-transparent.is-scrolled .navbar-caption,
					.navbar-link,
					.navbar.is-transparent.is-scrolled .navbar-link.top,
					.navbar .card a,
					.navbar-search-icon:hover,
					.navbar-search-icon:focus,
					.navbar.is-transparent .navbar-search-icon:hover,
					.navbar.is-transparent .navbar-search-icon:focus,
					.navbar.is-transparent.is-scrolled .navbar-search-icon:hover,
					.navbar.is-transparent.is-scrolled .navbar-search-icon:focus {
						color: ${to};
					}
					.navbar-link:hover,
					.navbar-link:focus,
					.navbar .card a:hover,
					.navbar .card a:focus,
					.navbar-item:hover .navbar-heading,
					.navbar-item:focus .navbar-heading,
					.navbar.is-transparent.is-scrolled .navbar-item:hover .navbar-heading,
					.navbar.is-transparent.is-scrolled .navbar-item:focus .navbar-heading,
					.navbar.is-transparent .navbar-link.top:hover,
					.navbar.is-transparent .navbar-link.top:focus {
						color: ${trevisoAdjustBrightness(to,50)};
					}
					.navbar-button:hover,
					.navbar-button:focus,
					.navbar.is-transparent .navbar-button:hover,
					.navbar.is-transparent .navbar-button:focus,
					.navbar.is-transparent.is-scrolled .navbar-button:hover,
					.navbar.is-transparent.is-scrolled .navbar-button:focus {
						background: ${to};
						border: 1.2px solid ${to};
					}
					.navbar-menu {
						border-top: 2px solid ${to};
					}
					@media only screen and (min-width: 1024px) {
						.navbar-menu {
							border-top: none;
						}
						.navbar-dropdown {
							border-top: 2px solid ${to};
						}
					}`
					).appendTo('head');
			}
		});
	});

	// Hero Text Color.
	wp.customize('hero_textcolor', function(value) {
		value.bind(function(to) {
			$('#treviso_hero_textcolor').remove();
			$('<style>').attr('id', 'treviso_hero_textcolor').prop('type', 'text/css').html(
				`.hero.has-bg .title, .hero.has-bg .subtitle {
					color: ${to};
				}`
				).appendTo('head');
		});
	});

	// Content Primary Color.
	wp.customize('content_primarycolor', function(value) {
		value.bind(function(to) {
			$('#treviso_content_primarycolor').remove();
			$('<style>').attr('id', 'treviso_content_primarycolor').prop('type', 'text/css').html(
				`.site-main a,
				.sidebar a,
				.card .card-header-title {
					color: ${to};
				}

				.site-main a:hover,
				.sidebar a:hover {
					color: #4a4a4a;
				}
				
				.site-main .button,
				.site-main .tag,
				.hero .tag,
				.sidebar .button,
				.sidebar .tag {
					background: ${to};
					color: #ffffff;
				}
				
				.site-main .button:hover,
				.site-main .tag:hover,
				.sidebar .button:hover,
				.sidebar .tag:hover {
					background: #363636;
					color: #ffffff;
				}
				
				.card .ribbon,
				.site-main .pagination-link.is-current {
					background: ${to};
					border-color: ${to};
					color: #ffffff;
				}`
				).appendTo('head');
		});
	});

	// Sidebar Background Color.
	wp.customize('sidebar_bgcolor', function(value) {
		value.bind(function(to) {
			$('#treviso_sidebar_bgcolor').remove();
			$('<style>').attr('id', 'treviso_sidebar_bgcolor').prop('type', 'text/css').html(
				`.sidebar .widget:nth-child(odd) {
					background: ${to};
					border: 1px solid ${to};
				}
				.sidebar .widget:nth-child(even) {
					border: 1px solid ${to};
				}`
				).appendTo('head');
		});
	});

	// Footer Background Color.
	wp.customize('footer_bgcolor', function(value) {
		value.bind(function(to) {
			$('#treviso_footer_bgcolor').remove();
			$('<style>').attr('id', 'treviso_footer_bgcolor').prop('type', 'text/css').html(
				`.site-footer {
					background: linear-gradient(to top right, ${to}, ${trevisoAdjustBrightness(to,30)});
				}
				.site-footer .socials .social:hover i {
					color: ${to};
				}
				.site-footer .footer-link:active, .site-footer .footer-link:hover,
				.site-footer .copyright .footer-menu li a:hover {
					color: ${trevisoAdjustBrightness(to,50)};
				}`
				).appendTo('head');
		});
	});

	// Footer Text Color.
	wp.customize('footer_textcolor', function(value) {
		value.bind(function(to) {
			$('#treviso_footer_textcolor').remove();
			$('<style>').attr('id', 'treviso_footer_textcolor').prop('type', 'text/css').html(
				`.site-footer .title,
				.site-footer .footer-link,
				.site-footer .copyright .copyright-text,
				.site-footer .copyright .footer-menu li a {
					color: ${to};
				}`
				).appendTo('head');
		});
	});

	// Body Font Familiy.
	wp.customize('typography_bodyfontfamily', function(value) {
		value.bind(function(to) {
			if ('' === to) {
				$('#treviso-body-font-css').remove();

				$('#treviso_typography_bodyfontfamily').remove();
				$('<style>').attr('id', 'treviso_typography_bodyfontfamily').prop('type', 'text/css').html(
					`body, button, input, optgroup, select, textarea {
						font-family: BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", 
						"Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
					}`
					).appendTo('head');
				return;
			}
			
			$('<link>', {
				href: 'https://fonts.googleapis.com/css?family=' + to,
				rel: 'stylesheet',
				type: 'text/css',
			}).appendTo('head');

			$('#treviso_typography_bodyfontfamily').remove();
			$('<style>').attr('id', 'treviso_typography_bodyfontfamily').prop('type', 'text/css').html(
				`body, button, input, optgroup, select, textarea {
					font-family: ${to.substring(0, to.indexOf(':'))};
				}`
				).appendTo('head');
		});
	});

	// Body Font Size.
	wp.customize('typography_bodyfontsize', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_bodyfontsize').remove();
			$('<style>').attr('id', 'treviso_typography_bodyfontsize').prop('type', 'text/css').html(
				`body {
					font-size: ${to};
				}`
				).appendTo('head');
		});
	});

	// Body Font Weight.
	wp.customize('typography_bodyfontweight', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_bodyfontweight').remove();
			$('<style>').attr('id', 'treviso_typography_bodyfontweight').prop('type', 'text/css').html(
				`body {
					font-weight: ${to};
				}`
				).appendTo('head');
		});
	});

	// Body Font Style.
	wp.customize('typography_bodyfontstyle', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_bodyfontstyle').remove();
			$('<style>').attr('id', 'treviso_typography_bodyfontstyle').prop('type', 'text/css').html(
				`body {
					font-style: ${to};
				}`
				).appendTo('head');
		});
	});

	// Header Font Family.
	wp.customize('typography_headerfontfamily', function(value) {
		value.bind(function(to) {
			if ('' === to) {
				$('#treviso-header-font-css').remove();

				$('#treviso_typography_headerfontfamily').remove();
				$('<style>').attr('id', 'treviso_typography_headerfontfamily').prop('type', 'text/css').html(
					`.title, h1, h2, h3, h4, h5, h6 {
						font-family: BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", 
						"Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
					}`
					).appendTo('head');
				return;
			}

			$('<link>', {
				href: 'https://fonts.googleapis.com/css?family=' + to,
				rel: 'stylesheet',
				type: 'text/css',
			}).appendTo('head');

			$('#treviso_typography_headerfontfamily').remove();
			$('<style>').attr('id', 'treviso_typography_headerfontfamily').prop('type', 'text/css').html(
				`.title, h1, h2, h3, h4, h5, h6 {
					font-family: ${to.substring(0, to.indexOf(':'))};
				}`
				).appendTo('head');
		});
	});

	// Header Font Size.
	wp.customize('typography_headerfontsize', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_headerfontsize').remove();
			$('<style>').attr('id', 'treviso_typography_headerfontsize').prop('type', 'text/css').html(
				`.title, h1, h2, h3, h4, h5, h6 {
					font-size: ${to};
				}`
				).appendTo('head');
		});
	});

	// Header Font Weight.
	wp.customize('typography_headerfontweight', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_headerfontweight').remove();
			$('<style>').attr('id', 'treviso_typography_headerfontweight').prop('type', 'text/css').html(
				`.title, h1, h2, h3, h4, h5, h6 {
					font-weight: ${to};
				}`
				).appendTo('head');
		});
	});

	// Header Font Style.
	wp.customize('typography_headerfontstyle', function(value) {
		value.bind(function(to) {
			$('#treviso_typography_headerfontstyle').remove();
			$('<style>').attr('id', 'treviso_typography_headerfontstyle').prop('type', 'text/css').html(
				`.title, h1, h2, h3, h4, h5, h6 {
					font-style: ${to};
				}`
				).appendTo('head');
		});
	});

	// Header Image.
	wp.customize('header_image', function(value) {
		value.bind(function(to) {
			if ('remove-header' === to) {
				$('.site-header').removeClass('has-bg-image').removeAttr('style');
			} else {
				$('.site-header').addClass('has-bg-image').css({ 'background-image': 'url(' + to + ')' });
			}
		});
	});

	// Header Fixed.
	wp.customize('header_fixed', function(value) {
		value.bind(function(to) {
			var $body = $('body');
			var $navbar = $('.navbar');

			if (true === to) {
				if (!$body.hasClass('has-navbar-fixed-top')) {
					$body.addClass('has-navbar-fixed-top');
				}
				if (!$navbar.hasClass('is-fixed-top')) {
					$navbar.addClass('is-fixed-top');
				}
			} else {
				$body.removeClass('has-navbar-fixed-top');
				$navbar.removeClass('is-fixed-top');
			}
		});
	});

	// Header Transparent.
	wp.customize('header_transparent', function(value) {
		value.bind(function() {
			trevisoHeaderTransparency();
		});
	});

	// Header Transparent Exclusions.
	wp.customize('header_transparent_exclusions', function(value) {
		value.bind(function() {
			trevisoHeaderTransparency();
		});
	});

	// Header Transparent Singular Only.
	wp.customize('header_transparent_singular_only', function(value) {
		value.bind(function() {
			trevisoHeaderTransparency();
		});
	});

	// Hero Parallax Image Effect.
	wp.customize('content_hero_parallax', function(value) {
		value.bind(function(to) {
			var $hero = $('.hero.hero-featured');
			if (true === to) {
				if (!$hero.hasClass('parallax')) {
					$hero.addClass('parallax');
				}
			} else {
				$hero.removeClass('parallax');
			}
		});
	});

	// Footer Background Image.
	wp.customize('footer_bgimage', function(value) {
		value.bind(function(to) {
			if ('' === to) {
				$('.site-footer').removeClass('has-bg-image');
				$('.site-footer .container').removeAttr('style');
			} else {
				$('.site-footer').addClass('has-bg-image');
				$('.site-footer .container').css({ 'background-image': 'url(' + to + ')' });
			}
		});
	});

	// Footer Copyright Text.
	wp.customize('footer_copyrighttext', function(value) {
		value.bind(function(to) {
			$('.copyright-text .company').text('© 2021 ' + to + ',\xa0');
		});
	});

	// Back To Top Image.
	wp.customize('btt_btnimage', function(value) {
		value.bind(function(to) {
			var pxShow = 300;

			$('.back-to-top img').attr('src', to);
			if ($(window).scrollTop() >= pxShow) {
				$('.back-to-top').addClass('visible');
			}
		});
	});

	function trevisoAdjustBrightness(col, amt) {
		var usePound = false;
		if ( col[0] == '#' ) {
			col = col.slice(1);
			usePound = true;
		}
	
		var num = parseInt(col,16);
		var r = (num >> 16) + amt;
		if ( r > 255 ) r = 255;
		else if  (r < 0) r = 0;
	
		var b = ((num >> 8) & 0x00FF) + amt;
		if ( b > 255 ) b = 255;
		else if  (b < 0) b = 0;
	
		var g = (num & 0x0000FF) + amt;
		if ( g > 255 ) g = 255;
		else if  ( g < 0 ) g = 0;
	
		return (usePound?'#':'') + (g | (b << 8) | (r << 16)).toString(16);
	}

	function trevisoHeaderTransparency() {
		var header_transparent = wp.customize.value('header_transparent').get();
		var header_transparent_exclusions = wp.customize.value('header_transparent_exclusions').get();
		var isSingular = $('#page').data('singular');

		if (true === header_transparent) {
			var postId = $('#page').data('object-id').toString();
			var postCats = $('#page').data('categories').toString().split(',');
			var exclude = false;

			var exclusions = header_transparent_exclusions.split(',');
			exclusions = $.map(exclusions, function(value){ return value.trim(); });

			var exCats = $.grep(exclusions, function(value) { return value.startsWith('-'); });
			exclusions = $.grep(exclusions, function(value) { return $.inArray(value, exCats) < 0; });

			if ($.inArray(postId, exclusions) >= 0) {
				exclude = true;
			}

			$.each(postCats, function(index, value) {
				if ($.inArray('-' + value, exCats) >= 0) {
					exclude = true;
					return false;
				}
			});

			if ( ! isSingular && true === wp.customize.value('header_transparent_singular_only').get() ) {
				exclude = true;
			}

			if (!exclude) {
				$('.navbar').addClass('is-transparent');
			} else {
				$('.navbar').removeClass('is-transparent');
			}
		} else {
			$('.navbar').removeClass('is-transparent');
		}
	}

}( jQuery ) );

//# sourceMappingURL=treviso-customizer-preview.js.map
