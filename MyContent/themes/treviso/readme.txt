=== Treviso ===
Contributors: jbertolo31
Requires at least: 5.2
Tested up to: 5.7
Stable tag: 1.0.3
Requires PHP: 5.6
License: GPL-2.0-or-later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Treviso WordPress Theme, Copyright 2021 Jason Bertolo, https://jbsoftware.ca/
Treviso is distributed under the terms of the GNU GPL.

== Description ==

Treviso is a blazing-fast, light-weight WordPress theme based on the Bulma CSS Framework. No bloated and slow framework javascript, only what's needed is loaded. Treviso comes with plenty of options in the Customizer along with Google fonts, packaged Font-Awesome Free and social media share link buttons. Includes optional mega menu header, fixed/transparent header options. Multi-post pages use a Masonry design and single posts can configured with a Hero section. Mobile first, responsive and SEO ready.

== License ==

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.


== Frequently Asked Questions ==

= How do I build a mega menu in the header? =

You can add classes to the Navbar Start header menu (Screen Options, check CSS classes).
* Add "has-mega-menu" css class to top level navbar links to enable mega menu.
* Add "is-img" to child of "has-mega-menu" to enable a mega menu image card. Define image src as URL.
* Add "no-header" to any menu to disable the title.
* Add "is-post" to child of "has-mega-menu" to enable a mega menu post card showing the latest post.
* Add "post-{id} with "is-post" to define a particular post to show. Eg. "is-post post-222".
* Add "is-footer" to the last child of "has-mega-menu" to enable the mega menu footer.
* Add "is-footer-left" or "is-footer-right" to the child of "is-footer" to define a left and right alignment.
* Add "is-button" to any item to enable a navbar button.
* Add font-awesome classes to any item to enable an icon. Eg. "fas fa-rss".
* Add "is-search" to any item to enable a navbar search icon and form.

= How do I build a footer? =

Much like building the header you can add classes to the footer menu.
* Add "is-custom" css class to top level navbar links to enable a column with an image.
* Add "is-img" to child of "is-custom" to enable a footer image. Define image src as URL.
* Add "is-img-white" for an image with a white filter.
* Add "title" to enable a title, when no child menu items exist.
* Add "not-list-item" to disable the list item's bullet.
* Add "no-header" to any menu to disable the the title.
* Add "is-post" to child of "is-custom" to enable a post card showing the latest post.
* Add "post-{id} with "is-post" to define a particular post to show. Eg. "is-post post-222".
* Add "is-social" to child of "is-custom" to add social icons.
* Add font-awesome classes to child of "is-social" to enable an icon. Eg. "fab fa-facebook".

= The transparent header option is global, can I disable it for some posts? =

Yes. Below the transparent header option there is an option to disable it for certain posts (positive numbers) and categories (negative numbers). Use comma separated values. Eg. 3,14,15,-8 hide posts 3, 14 and 15 and all posts in category 8.

= Does this theme support any plugins? =

Treviso includes support for Infinite Scroll in Jetpack, WP-Forms and Elementor.

== Third Party Resources ==

Treviso WordPress Theme bundles the following third-party libraries and resources:

Bulma CSS Framework
Copyright Jeremy Thomas
License: MIT license
License URL: https://opensource.org/licenses/MIT
Source: https://bulma.io/

Select2
Copyright Kevin Brown
License: MIT license
License URL: https://opensource.org/licenses/MIT
Source: https://select2.org/

== Bundled Fonts ==

Font-Awesome Free icons
Copyright fontawesome.com
License: SIL OFL 1.1 License
License URL: https://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL
Source: https://fontawesome.com/

== Bundled Images ==

Image for theme screenshot, Copyright Marko Horvat
License: CC0 1.0 Universal (CC0 1.0)
License URL: https://stocksnap.io/license
Source: https://stocksnap.io/photo/nature-landscape-WX497RPJ7V


== Changelog ==
= 1.0.3 =
*Release date: 2021.07.20*

* Exclude some links from mobile nav focus trap
* Exclude ellipsis from except on admin pages
* Add more translatable strings

= 1.0.2 =
*Release date: 2021.07.19*

* Add focus trap for mobile navigation menu
* Improve customizer control sanitization
* Text translation edits
* Color fixes for UI components
* Layout padding fixes

= 1.0.1 =
*Release date: 2021.07.05*

* Fix keyboard navigation
* Several minor layout fixes
* Revamp comments sections to conform with Bulma
* Add responsive embeds support
* Update Bulma CSS to version 0.93

= 1.0.0 =
*Release date: 2021.06.08*

* First Treviso release

== Upgrade Notice ==

= 1.0.2 =
Checkbox, select and google font setting types have been reworked. You may need to reconfigure them.
