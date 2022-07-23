"use strict";

( function( $ ) {

	wp.customize.bind('ready', function () {
		wp.customize.control('header_transparent', function(control) {
			control.setting.bind(function(value) {
				if (true === value) {
					wp.customize.control('header_transparent_exclusions').activate();
					wp.customize.control('header_transparent_singular_only').activate();
				} else {
					wp.customize.control('header_transparent_exclusions').deactivate();
					wp.customize.control('header_transparent_singular_only').deactivate();
				}
			});
		});
	});

}( jQuery ) );

//# sourceMappingURL=treviso-customizer-controls.js.map
