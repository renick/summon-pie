"use strict";

( function( $ ) {

    // Initialize navbar and responsive hamburger
    function trevisoInitNavbar() {
        const DESKTOP_BREAKPOINT = 1024;
        const SCROLL_THRESHOLD = 30;

        // Open the mobile navbar menu when the navbar burger is clicked
        $('.navbar-burger').on('click', function(e) {
            e.preventDefault();
            $('.navbar-burger').toggleClass('is-active');
            $('.navbar-menu').toggleClass('is-active');
            $('html').toggleClass('is-clipped');

            if ($('.navbar-menu').hasClass('is-active')) {
                var $firstFocusElement = $('.navbar-item.site-title');
                var $lastFocusElement = $('.navbar-menu')
                    .find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').last();

                // Trap focus inside the mobile navbar menu (a modal)
                $(document).on('keydown.trapfocus', function(ev) {
                    if (ev.key !== 'Tab') return;

                    var $focused = $(':focus');

                    if (ev.shiftKey) {
                        if ($focused.is($firstFocusElement)) {
                            // if user focused first element and shift tabs, focus last element
                            $lastFocusElement.trigger('focus');
                            ev.preventDefault();
                        }
                    } else {
                        if ($focused.is($lastFocusElement)) {
                            // if user focused last element and tabs, focus first element
                            $firstFocusElement.trigger('focus');
                            ev.preventDefault();
                        }
                    }
                });
            } else {
                $(document).off('keydown.trapfocus');
            }
        });

        // Add the "is-scrolled" class when the user scolls below the threshold
        $(window).on('scroll', function() {
            var $navbar = $('.navbar');
            if ($navbar.hasClass('is-transparent') && $navbar.hasClass('is-fixed-top')) {
                var height = $(window).scrollTop();
                if (height > SCROLL_THRESHOLD) {
                    $navbar.addClass('is-scrolled');
                } else {
                    $navbar.removeClass('is-scrolled');
                }
            }
        });

        // Add "is-active" class on navbar link click for mobile and tablet screen modes
        $('.navbar-link').on('click', function() {
            var browserWidth = window.innerWidth || document.documentElement.clientWidth;
            if (browserWidth < DESKTOP_BREAKPOINT) {
                $(this).next('.navbar-dropdown').toggleClass('is-active');
            }
        });

        // Navbar search icon
        $('.navbar-search-icon').on('click', function(e) {
            e.preventDefault();
            $(this).next('.navbar-search-block').toggleClass('is-active');
            $(this).next('.navbar-search-block').find('input.navbar-search').trigger('focus');
        });

        // Close the navbar search block when clicked outside
        $(window).on('click', function(e) {
            if (!$(e.target).is('.navbar-search-block, .navbar-search-block *, .navbar-search-icon, .navbar-search-icon *')) {
                $('.navbar-search-block').removeClass('is-active');
            }
        });

        // Disable hastag links in the header and footer
        $('.navbar a, footer a').on('click', function(e) {
            if ('#' === $(this).attr('href')) {
                e.preventDefault();
            }
        });
    }

    // Initialize back to top button
    function trevisoInitBackToTop() {
        const SHOW_AFTER_PIXELS = 300;
        const SCROLL_SPEED = 500;

        // Show/hide back to top button when user scrolls past threshold
        $(window).on('scroll', function() {
            if ($(window).scrollTop() >= SHOW_AFTER_PIXELS) {
                $('.back-to-top').addClass('visible');
            } else {
                $('.back-to-top').removeClass('visible');
            }
        });

        // Scroll to top of page on click
        $('.back-to-top a').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, SCROLL_SPEED);
            return false;
        });
    }

    // Initialize masonry
    function trevisoInitMasonry() {
        var $masonry = $('.masonry').imagesLoaded( function() {
            $masonry.masonry({
                itemSelector: '.masonry-item',
                columnWidth: '.masonry-sizer',
                percentPosition: true,
                gutter: '.gutter-sizer',
            });
        });
    
        $(window).on('resize', function() {
            $('.masonry').masonry();
        });
    }

    // Initialize social buttons
    function trevisoInitSocialButtons() {
        $('.buttons.social a').on('click', function(e) {
            e.preventDefault();

            // Build share URL
            var shareUrl = new URL($(this).attr('href'));
            $.each($(this).data(), function(key, value) {
                shareUrl.searchParams.append(key, value);
            });

            // Open social window
            var left = (screen.width - 570) / 2;
            var top = (screen.height - 570) / 2;
            var params = 'menubar=no,toolbar=no,status=no,width=570,height=570,top=' + top + ',left=' + left;
            window.open(shareUrl.href, 'Social Share', params);
        });
    }

    // Initialize category dropdown change handler
    function trevisoInitCatDropdown() {
        $('.cat-dropdown,.postform').on('change', function() {
            if ($(this).val() > 0) {
                window.location = window.location.origin + '?cat=' + $(this).val();
            }
        });
    }

    // Initialize reply link
    function trevisoInitReplyLink() {
        $('.reply-link').on('click', function(e) {
            e.preventDefault();
            $('#comment').trigger('focus');
        });
    }

    // Initialize comments validation
    function trevisoInitCommentsValidation() {
        var $form = $('#commentform');

        $form.removeAttr('novalidate');

        // Validate comment form on submit
        $form.on('submit', function(e) {
            var hasError = false;
            var firstFocus = false;

            var $comment = $('.comment-form-content textarea');
            if ($comment.length) {
                if ($comment.val().length === 0) {
                    $comment.addClass('is-danger');
                    $comment.parent().next('.help').text('Comment is required.');
                    if (!firstFocus) {
                        $comment.trigger('focus');
                        hasError = true;
                        firstFocus = true;
                    }
                } else {
                    $comment.removeClass('is-danger');
                    $comment.parent().next('.help').text('');
                }
            }

            var $author = $('.comment-form-author input');
            if ($author.length) {
                if ($author.val().length === 0) {
                    $author.addClass('is-danger');
                    $author.parent().next('.help').text('Name is required.');
                    if (!firstFocus) {
                        $author.trigger('focus');
                        hasError = true;
                        firstFocus = true;
                    }
                } else {
                    $author.removeClass('is-danger');
                    $author.parent().next('.help').text('');
                }
            }

            var $email = $('.comment-form-email input');
            if ($email.length) {
                if ($email.val().length === 0 || !trevisoValidateEmailAddress($email.val())) {
                    $email.addClass('is-danger');
                    $email.parent().next('.help').text('Email is required and needs to be valid.');
                    if (!firstFocus) {
                        $email.trigger('focus');
                        hasError = true;
                        firstFocus = true;
                    }
                } else {
                    $email.removeClass('is-danger');
                    $email.parent().next('.help').text('');
                }
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    }

    function trevisoValidateEmailAddress(email) {
        var atSymbol = email.indexOf('@');
        var dot = email.indexOf('.');

        if (atSymbol < 1) return false;
        if (dot <= atSymbol + 2) return false;
        if (dot === email.length - 1) return false;

        return true;
    }

    trevisoInitNavbar();
    trevisoInitBackToTop();
    trevisoInitMasonry();
    trevisoInitSocialButtons();
    trevisoInitCatDropdown();
    trevisoInitReplyLink();
    trevisoInitCommentsValidation();

}( jQuery ) );

//# sourceMappingURL=treviso.js.map
