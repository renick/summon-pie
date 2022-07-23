<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="column is-4-desktop sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
