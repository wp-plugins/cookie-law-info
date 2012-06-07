jQuery(function() {
	var colour_selectors = "#cli-colour-btn-accept, #cli-colour-btn-decline, #cli-colour-btn-readmore, #cli-colour-link-accept, #cli-colour-link-decline, #cli-colour-link-readmore, #cli-colour-text, #cli-colour-background, #cli-colour-border, #cli-colour-link-button-1, #cli-colour-btn-button-1";
	jQuery(colour_selectors).spectrum({
		showPalette: false,
		palette: [
			['#f00', '#ff0', '#0f0'], 
			['#00f', '#333', '#fff']
		],
		showInitial: true,
		preferredFormat: "hex"
	});
});