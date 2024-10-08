(function ($) {
	"use strict";

	var default_color = 'bfbfbf';

	function pickColor(color) {
		$('#background-color').val(color);
	}
	function toggle_text() {
		var background_color = $('#background-color');
		if (background_color.val() == undefined || '' === background_color.val().replace('#', '')) {
			background_color.val(default_color);
			pickColor(default_color);
		} else {
			pickColor(background_color.val());
		}
	}

	$(document).ready(function () {
		var background_color = $('#background-color');
		background_color.wpColorPicker({
			change: function (event, ui) {
				pickColor(background_color.wpColorPicker('color'));
			},
			clear: function () {
				pickColor('');
			}
		});
		$('#background-color').click(toggle_text);

		var font_color = $('#font-color');
		font_color.wpColorPicker({
			change: function (event, ui) {
				pickColor(font_color.wpColorPicker('color'));
			},
			clear: function () {
				pickColor('');
			}
		});
		$('#font-color').click(toggle_text);

		toggle_text();

	});

}(jQuery));