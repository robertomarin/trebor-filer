jQuery(document).ready(function($) {
    var stags = {
    	loadVals: function()
    	{
    		var shortcode = $('#_stag_shortcode').text(),
    			uShortcode = shortcode;

    		// fill in the gaps eg {{param}}
    		$('.stag-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('stag_', ''),		// gets rid of the stag_ prefix
    				re = new RegExp("{{"+id+"}}","g");

    			uShortcode = uShortcode.replace(re, input.val());
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_stag_ushortcode').remove();
    		$('#stag-sc-form-table').prepend('<div id="_stag_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_stag_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;

    			$('.stag-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('stag_', '')		// gets rid of the stag_ prefix
    					re = new RegExp("{{"+id+"}}","g");

    				rShortcode = rShortcode.replace(re, input.val());
    			});

    			shortcodes = shortcodes + rShortcode + "\n";
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_stag_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_stag_cshortcodes" class="hidden">' + shortcodes + '</div>');

    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_stag_ushortcode').text().replace('{{child_shortcode}}', shortcodes);

    		// add updated parent shortcode
    		$('#_stag_ushortcode').remove();
    		$('#stag-sc-form-table').prepend('<div id="_stag_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});

    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();

    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}

    			return false;
    		});

    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'

			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				stagPopup = $('#stag-popup');

            tbWindow.css({
                height: stagPopup.outerHeight() + 50,
                width: stagPopup.outerWidth(),
                marginLeft: -(stagPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: stagPopup.outerWidth()
			});

			$('#stag-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	stags = this,
    			popup = $('#stag-popup'),
    			form = $('#stag-sc-form', popup),
    			shortcode = $('#_stag_shortcode', form).text(),
    			popupType = $('#_stag_popup', form).text(),
    			uShortcode = '';

    		// resize TB
    		stags.resizeTB();
    		$(window).resize(function() { stags.resizeTB() });

    		// initialise
    		stags.loadVals();
    		stags.children();
    		stags.cLoadVals();

    		// update on children value change
    		$('.stag-cinput', form).live('change', function() {
    			stags.cLoadVals();
    		});

    		// update on value change
    		$('.stag-input', form).change(function() {
    			stags.loadVals();
    		});

    		// when insert is clicked
    		$('.stag-insert', form).click(function() {
    			if(window.tinyMCE)
				{
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_stag_ushortcode', form).html());
					tb_remove();
				}
    		});
    	}
	}

    // run
    $('#stag-popup').livequery( function() { stags.load(); } );
});