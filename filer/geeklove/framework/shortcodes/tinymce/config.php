<?php

/* BUTTONS CONFIG */
$stag_shortcodes['button'] = array(
		'no_preview' => true,
		'params' => array(
				'url' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Button URL', 'stag'),
					'desc' => __('Add the button\'s url eg http://example.com', 'stag')
				),
				'style' => array(
					'type' => 'select',
					'label' => __('Button Style', 'stag'),
					'desc' => __('Select the button\'s style, ie the button\'s colour', 'stag'),
					'options' => array(
						'grey' => 'Grey',
						'black' => 'Black',
						'green' => 'Green',
						'light-blue' => 'Light Blue',
						'blue' => 'Blue',
						'red' => 'Red',
						'orange' => 'Orange',
						'purple' => 'Purple'
					)
				),
				'size' => array(
					'type' => 'select',
					'label' => __('Button Size', 'stag'),
					'desc' => __('Select the button\'s size', 'stag'),
					'options' => array(
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large'
					)
				),
				'type' => array(
					'type' => 'select',
					'label' => __('Button Type', 'stag'),
					'desc' => __('Select the button\'s type', 'stag'),
					'options' => array(
						'round' => 'Round',
						'square' => 'Square'
					)
				),
				'target' => array(
					'type' => 'select',
					'label' => __('Button Target', 'stag'),
					'desc' => __('_self = open in same window. _blank = open in new window', 'stag'),
					'options' => array(
						'_self' => '_self',
						'_blank' => '_blank'
					)
				),
				'content' => array(
					'std' => 'Button Text',
					'type' => 'text',
					'label' => __('Button\'s Text', 'stag'),
					'desc' => __('Add the button\'s text', 'stag'),
				)
			),
		'shortcode' => '[stag_button url="{{url}}" style="{{style}}" size="{{size}}" type="{{type}}" target="{{target}}"]{{content}}[/stag_button]',
		'popup_title' => __('Insert Button Shortcode', 'stag')
);

/* ALERT CONFIG */

$stag_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Alert Style', 'stag'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'stag'),
			'options' => array(
				'white' => 'White',
				'grey' => 'Grey',
				'red' => 'Red',
				'yellow' => 'Yellow',
				'green' => 'Green',
				'blue' => 'Blue'
			)
		),
		'content' => array(
			'std' => 'Your Alert!',
			'type' => 'textarea',
			'label' => __('Alert Text', 'stag'),
			'desc' => __('Add the alert\'s text', 'stag'),
		),
	),
	'shortcode' => '[stag_alert style="{{style}}"]{{content}}[/stag_alert]',
	'popup_title' => __('Insert Alert Shortcode', 'stag')
);


/* TOGGLE CONFIG */
$stag_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'stag'),
			'desc' => __('Add the title that will go above the toggle content', 'stag'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'stag'),
			'desc' => __('Add the toggle content. Will accept HTML', 'stag'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'stag'),
			'desc' => __('Select the state of the toggle on page load', 'stag'),
			'options' => array(
				'open' => 'Open',
				'closed' => 'Closed'
			)
		),

	),
	'shortcode' => '[stag_toggle title="{{title}}" state="{{state}}"]{{content}}[/stag_toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'stag')
);


/* TABS CONFIG */
$stag_shortcodes['tabs'] = array(
	'params' => array(),
	'no_preview' => true,
	'shortcode' => '[stag_tabs] {{child_shortcode}}  [/stag_tabs]',
	'popup_title' => __('Insert Tab Shortcode', 'stag'),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => __('Tab Title', 'stag'),
				'desc' => __('Title of the tab', 'stag'),
			),
			'content' => array(
		    'std' => 'Tab Content',
		    'type' => 'textarea',
		    'label' => __('Tab Content', 'stag'),
		    'desc' => __('Add the tabs content', 'stag')
			)
		),
		'shortcode' => '[stag_tab title="{{title}}"]{{content}}[/stag_tab]',
		'clone_button' => __('Add Tab', 'stag')
	),
);

$stag_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'stag'),
	'no_preview' => true,

	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'stag'),
				'desc' => __('Select the type, ie width of the column.', 'stag'),
				'options' => array(
					'stag_one_third' => 'One Third',
					'stag_one_third_last' => 'One Third Last',
					'stag_two_third' => 'Two Thirds',
					'stag_two_third_last' => 'Two Thirds Last',
					'stag_one_half' => 'One Half',
					'stag_one_half_last' => 'One Half Last',
					'stag_one_fourth' => 'One Fourth',
					'stag_one_fourth_last' => 'One Fourth Last',
					'stag_three_fourth' => 'Three Fourth',
					'stag_three_fourth_last' => 'Three Fourth Last',
					'stag_one_fifth' => 'One Fifth',
					'stag_one_fifth_last' => 'One Fifth Last',
					'stag_two_fifth' => 'Two Fifth',
					'stag_two_fifth_last' => 'Two Fifth Last',
					'stag_three_fifth' => 'Three Fifth',
					'stag_three_fifth_last' => 'Three Fifth Last',
					'stag_four_fifth' => 'Four Fifth',
					'stag_four_fifth_last' => 'Four Fifth Last',
					'stag_one_sixth' => 'One Sixth',
					'stag_one_sixth_last' => 'One Sixth Last',
					'stag_five_sixth' => 'Five Sixth',
					'stag_five_sixth_last' => 'Five Sixth Last'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'stag'),
				'desc' => __('Add the column content.', 'stag'),
			)
		),
		'shortcode' => '[{{column}}]{{content}}[/{{column}}] ',
		'clone_button' => __('Add Column', 'stag')
	)
);


/* AUTHOR SHORTCODE */
global $stag_author;

$stag_shortcodes['author'] = array(
	'no_preview' => true,
	'params' => array(
		'author' => array(
			'type' => 'authors',
			'label' => __('Author Name', 'stag'),
			'desc' => __('Select the User to display.', 'stag'),
			'options' => $stag_author,
		),
	),
	'shortcode' => '[stag_author author="{{author}}"]',
	'popup_title' => __('Insert Author Shortcode', 'stag')
);


$stag_shortcodes['intro'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'textarea',
			'label' => __('Intro Text', 'stag'),
			'desc' => __('Enter the intro text.', 'stag'),
			// 'options' => $stag_author,
			'std' => 'Intro'
		),
	),
	'shortcode' => '[stag_intro]{{content}}[/stag_intro]',
	'popup_title' => __('Insert Author Shortcode', 'stag')
);

$stag_shortcodes['divider'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Divider', 'stag'),
			'desc' => __('Select the style of the Divider', 'stag'),
			'options' => array(
				'plain' => 'Plain',
				'horizontal_gradient' => 'Horizontal Gradient',
				'dashed_double' => 'Dashed Double Color',
				'dashed' => 'Dashed',
				'soft_blur' => 'Soft Side Blur',
				'single_direction_drop_shadow' => 'Single Direction Drop Shadow',
				'inset' => 'Inset',
				'flaired_edges' => 'Flaired Edges',
				'glyph' => 'Glyph',
				)
			),
		),
	'shortcode' => '[stag_divider style="{{style}}"]',
	'popup_title' => __('Insert Divider', 'stag')
);

/* CODE SHORTCODE */
$stag_shortcodes['code'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Code', 'stag'),
			'desc' => __('Input your code without code tags.', 'stag'),
			),
		'style' => array(
			'type' => 'select',
			'label' => __('Code Type', 'stag'),
			'desc' => __('Select the type of code you are using.', 'stag'),
			'options' => array(
				'markup php' => 'PHP',
				'css' => 'CSS',
				'javascript' => 'JavaScript',
				'markup html' => 'HTML',
				'clike' => 'Python',
				)
			),
		'line' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Highlight Lines', 'stag'),
			'desc' => __('Enter the lines to highlight. For example: 3,5-7,10', 'stag'),
			)
	),
	'shortcode' => '[stag_code data_line="{{line}}" style="{{style}}"]{{content}}[/stag_code]',
	'popup_title' => __('Insert Code Shortcode', 'stag')
);

?>