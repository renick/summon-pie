"use strict";

( function( $ ) {

	wp.customize.bind('ready', function () {
		trevisoInitMultiSelect();
		trevisoInitMultiCheckbox();
		trevisoInitGoogleFonts();
	});

	// Initialize multi-select
    function trevisoInitMultiSelect() {
		var $multiSelect = $('.customize-control-multi_select select[multiple]');
		$multiSelect.select2({
			placeholder: '',
			allowClear: true,
			sorter: function(data) {
				return data.sort(function(a, b) {
					if (a.text > b.text) {
						return 1;
					}
					if (a.text < b.text) {
						return -1;
					}
					return 0;
				});
			},
			width: '100%',
		});
		$multiSelect.on('select2:select', function(e) {
			var element = e.params.data.element;
			var $element = $(element);
			
			$element.detach();
			$(this).append($element).trigger('change');
		});
		$multiSelect.on('select2:unselect', function(e) {
			var element = e.params.data.element;
			var id = e.params.data.id;
			var text = e.params.data.text;
			var $element = $(element);
			
			$element.detach();
			$(this).trigger('change').append(new Option(text, id, false, false)).trigger('change');
		});
    }

	// Initialize multi-checkbox
    function trevisoInitMultiCheckbox() {
		$('.customize-control-multi_checkbox input[type="checkbox"]').on('change', function() {
			var checkbox_values = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
				function() {
					return this.value;
				}
			).get().join(',');

			$(this).parents('.customize-control').find('input[type="hidden"]').val(checkbox_values).trigger('change');
		});
    }

	// Initialize google-fonts
    function trevisoInitGoogleFonts() {
		var $fontSelect = $('.customize-control-google_fonts select.font-select');
		var dropdownClass = $fontSelect.attr('id') + '-dropdown'
		var debounce = null;
		var loadedFonts = [];
		const LOAD_AMOUNT = 6;

		$fontSelect.select2({
			dropdownCssClass: dropdownClass,
			templateResult: trevisoDisplayFont,
			templateSelection: trevisoDisplayFont,
			width: '100%',
			allowClear: true,
			placeholder: '',
		});
		$fontSelect.on('select2:open', function() {
			var $searchInput = $('.' + dropdownClass).find('.select2-search__field');
			$searchInput.on('keydown', function() {
				clearTimeout(debounce);
				debounce = setTimeout(function() {
					trevisoLoadFontsInView($resultsList);
				}, 250);
			});

			var $resultsList = $('.' + dropdownClass).find('.select2-results__options');
			$resultsList.on('scroll', function() {
				clearTimeout(debounce);
				debounce = setTimeout(function() {
					trevisoLoadFontsInView($resultsList);
				}, 250);
			});
			$resultsList.trigger('scroll');
		});
		$fontSelect.on('select2:close', function() {
			var $searchInput = $('.' + dropdownClass).find('.select2-search__field');
			$searchInput.off('keydown');

			var $resultsList = $('.' + dropdownClass).find('.select2-results__options');
			$resultsList.off('scroll');
		});
		$fontSelect.on('select2:clear', function() {
			var link = $(this).data('customize-setting-link');
			wp.customize.value(link).set('');
		});

		function trevisoDisplayFont(data, container) {
			var $option = $(data.element);
			$(container).attr('data-font', $option.val()).css({ 'font-family': data.text, });
			return data.text;
		}

		function trevisoLoadFontsInView($resultsList) {
			var scrollHeight = $resultsList[0].scrollHeight;
			var scrollTop = $resultsList.scrollTop();
			var scrolled = scrollTop / scrollHeight;
			var $listItems = $resultsList.children('li');
			var listIndex = Math.round(scrolled * $listItems.size());
			trevisoLoadFonts($listItems, listIndex, LOAD_AMOUNT);
		}

		function trevisoLoadFonts($listItems, listIndex, amount) {
			if (typeof $listItems === 'undefined') return;

			for (var i = listIndex; i < listIndex+amount; i++) {
				var $item = $listItems.eq(i);
				if (typeof $item === 'undefined') continue;
				var font = $item.text();

				if ($.inArray(font, loadedFonts) === -1) {
					$('<link>', {
						href: 'https://fonts.googleapis.com/css?family=' + $item.data('font'),
						rel: 'stylesheet',
						type: 'text/css',
					}).appendTo('head');
					loadedFonts.push(font);
				}
			}
		}
    }

}( jQuery ) );

//# sourceMappingURL=treviso-custom-controls.js.map
