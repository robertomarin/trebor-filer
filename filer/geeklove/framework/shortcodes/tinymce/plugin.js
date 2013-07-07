(function ()
{
	// create stagShortcodes plugin
	tinymce.create("tinymce.plugins.stagShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("stagPopup", function ( a, params )
			{
				var popup = params.identifier;

				// load thickbox
				tb_show("Insert Stag Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "stag_button" )
			{
				var a = this;

				var btn = e.createSplitButton('stag_button', {
                    title: "Insert Stag Shortcode",
					image: StagShortcodes.plugin_folder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{
					a.addWithPopup( b, "Alerts", "alert" );
					a.addWithPopup( b, "Author", "author" );
					a.addWithPopup( b, "Buttons", "button" );
					a.addWithPopup( b, "Columns", "columns" );
					a.addWithPopup( b, "Divider", "divider" );
					a.addWithPopup( b, "Intro", "intro" );
					a.addWithPopup( b, "Styled Code", "code" );
					a.addWithPopup( b, "Tabs", "tabs" );
					a.addWithPopup( b, "Toggle", "toggle" );
				});

                return btn;
			}

			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("stagPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'Stag Shortcodes',
				author: 'Ram Ratan Maurya',
				authorurl: 'http://mauryaratan.me',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.1"
			}
		}
	});

	// add stagShortcodes plugin
	tinymce.PluginManager.add("stagShortcodes", tinymce.plugins.stagShortcodes);
})();