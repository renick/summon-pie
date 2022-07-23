<?php
/**
 * The search form for the theme.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

?>
<form role="search" method="get" action="<?php echo esc_url( get_home_url() ); ?>">
	<div class="field has-addons">
		<div class="control is-expanded">
			<?php $treviso_search_query = get_search_query(); ?>
			<input class="input navbar-search" name="s" type="text" 
				value="<?php echo esc_attr( $treviso_search_query ); ?>" 
				placeholder="<?php esc_attr_e( 'Search', 'treviso' ); ?>">
		</div>
		<div class="control">
			<button type="submit" class="button"><i class="fas fa-search"></i></button>
		</div>
	</div>
</form>
