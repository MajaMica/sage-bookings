<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json'));

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Disable on-demand block asset loading.
 *
 * @link https://core.trac.wordpress.org/ticket/61965
 */
add_filter('should_load_separate_core_block_assets', '__return_false');

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});
/**
 * Register custom post type and taxonomies
 */
add_action('init', function () {
    register_post_type('putovanje', [
        'labels' => [
            'name'          => 'Putovanja',
            'singular_name' => 'Putovanje',
            'add_new'       => 'Dodaj putovanje',
            'add_new_item'  => 'Dodaj novo putovanje',
            'edit_item'     => 'Izmeni putovanje',
            'all_items'     => 'Sva putovanja',
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-palmtree',
        'menu_position' => 5,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'       => ['slug' => 'putovanja'],
        'show_in_rest'  => true,
    ]);

    register_taxonomy('kategorija_putovanja', 'putovanje', [
        'labels' => [
            'name'          => 'Kategorije putovanja',
            'singular_name' => 'Kategorija',
        ],
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite'      => ['slug' => 'kategorija'],
    ]);

    register_taxonomy('grad', 'putovanje', [
        'labels' => [
            'name'          => 'Gradovi',
            'singular_name' => 'Grad',
        ],
        'hierarchical' => false,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite'      => ['slug' => 'grad'],
    ]);
});

/**
 * Register SCF fields for putovanje
 */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

       acf_add_local_field_group([
        'key'   => 'group_putovanje_details',
        'title' => 'Detalji putovanja',
        'fields' => [
            [
                'key'            => 'field_datum_polaska',
                'label'          => 'Datum i vreme polaska',
                'name'           => 'datum_polaska',
                'type'           => 'date_time_picker',
                'required'       => 1,
                'display_format' => 'd.m.Y H:i',
                'return_format'  => 'Y-m-d H:i:s',
            ],
            [
                'key'            => 'field_datum_dolaska',
                'label'          => 'Datum i vreme dolaska',
                'name'           => 'datum_dolaska',
                'type'           => 'date_time_picker',
                'required'       => 1,
                'display_format' => 'd.m.Y H:i',
                'return_format'  => 'Y-m-d H:i:s',
            ],
            [
                'key'     => 'field_broj_nocenja',
                'label'   => 'Broj noćenja',
                'name'    => 'broj_nocenja',
                'type'    => 'number',
                'required' => 1,
                'min'     => 0,
                'default_value' => 0,
            ],
            [
                'key'     => 'field_cena',
                'label'   => 'Cena (€)',
                'name'    => 'cena',
                'type'    => 'number',
                'required' => 1,
                'min'     => 0,
            ],
            [
                'key'          => 'field_napomena',
                'label'        => 'Napomena',
                'name'         => 'napomena',
                'type'         => 'text',
                'instructions' => 'npr. "Doručak uključen" ili "Fakultativno: Venecija"',
                'required'     => 0,
            ],
            [
                'key'   => 'field_galerija',
                'label' => 'Galerija',
                'name'  => 'galerija',
                'type'  => 'gallery',
                'required' => 0,
            ],
            [
                'key'          => 'field_program',
                'label'        => 'Program putovanja',
                'name'         => 'program',
                'type'         => 'wysiwyg',
                'required'     => 0,
                'tabs'         => 'all',
                'toolbar'      => 'full',
                'media_upload' => 1,
                'instructions' => 'Detaljan opis putovanja — šta se obilazi, šta je uključeno u cenu, napomene.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'putovanje',
                ],
            ],
        ],
    ]);
});

/**
 * Register options page for homepage sections
 */
add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Podešavanja početne',
        'menu_title' => 'Početna',
        'menu_slug'  => 'pocetna-podesavanja',
        'capability' => 'edit_posts',
        'position'   => 30,
        'icon_url'   => 'dashicons-admin-home',
        'redirect'   => false,
    ]);

    acf_add_local_field_group([
        'key'   => 'group_homepage_sections',
        'title' => 'Sekcije na početnoj',
        'fields' => [
            [
                'key'          => 'field_sekcije',
                'label'        => 'Sekcije',
                'name'         => 'sekcije',
                'type'         => 'repeater',
                'button_label' => 'Dodaj sekciju',
                'layout'       => 'block',
                'sub_fields'   => [
                    [
                        'key'         => 'field_sekcija_naslov',
                        'label'       => 'Naslov sekcije',
                        'name'        => 'naslov',
                        'type'        => 'text',
                        'required'    => 0,
                        'placeholder' => 'npr. Izleti',
                    ],
                   [
    'key'           => 'field_sekcija_kategorija',
    'label'         => 'Kategorije',
    'name'          => 'kategorija',
    'type'          => 'taxonomy',
    'taxonomy'      => 'kategorija_putovanja',
    'field_type'    => 'multi_select',
    'allow_null'    => 1,
    'add_term'      => 0,
    'return_format' => 'id',
    'instructions'  => 'Izaberi jednu ili više kategorija. Ostavi prazno za sve kategorije.',
],
                    [
                        'key'           => 'field_sekcija_broj',
                        'label'         => 'Broj putovanja',
                        'name'          => 'broj',
                        'type'          => 'number',
                        'default_value' => 6,
                        'min'           => 1,
                        'max'           => 12,
                    ],
                    [
                        'key'      => 'field_sekcija_link',
                        'label'    => 'Link "Vidi sve"',
                        'name'     => 'link',
                        'type'     => 'url',
                        'required' => 0,
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'pocetna-podesavanja',
                ],
            ],
        ],
    ]);
});
/**
 * Set first gallery image as featured image on save
 */
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'putovanje') {
        return;
    }

    $galerija = get_field('galerija', $post_id);
    $current_thumb = get_post_thumbnail_id($post_id);

    if (!empty($galerija) && is_array($galerija) && !$current_thumb) {
        $first_image_id = $galerija[0]['ID'] ?? null;
        if ($first_image_id) {
            set_post_thumbnail($post_id, $first_image_id);
        }
    }
}, 20);
/**
 * Sort all putovanje queries by departure date (nearest first)
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'putovanje') {
        return;
    }

    if ($query->get('orderby')) {
        return;
    }

    $query->set('meta_key', 'datum_polaska');
    $query->set('orderby', 'meta_value');
    $query->set('order', 'ASC');
});

add_action('pre_get_posts', function ($query) {
    if (is_admin()) {
        return;
    }

    if ($query->get('post_type') !== 'putovanje' && !$query->is_tax(['kategorija_putovanja', 'grad'])) {
        return;
    }

    if ($query->get('orderby')) {
        return;
    }

    $query->set('meta_key', 'datum_polaska');
    $query->set('orderby', 'meta_value');
    $query->set('order', 'ASC');
});
/**
 * Handle contact form submission
 */
add_action('admin_post_nopriv_bagdala_contact', 'bagdala_handle_contact');
add_action('admin_post_bagdala_contact', 'bagdala_handle_contact');

function bagdala_handle_contact() {
    if (!isset($_POST['bagdala_contact_nonce']) || !wp_verify_nonce($_POST['bagdala_contact_nonce'], 'bagdala_contact')) {
        wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    $ime      = sanitize_text_field($_POST['ime'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $telefon  = sanitize_text_field($_POST['telefon'] ?? '');
    $putovanje = sanitize_text_field($_POST['putovanje'] ?? '');
    $poruka   = sanitize_textarea_field($_POST['poruka'] ?? '');

    if (empty($ime) || empty($email) || empty($poruka)) {
        wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    $to      = 'bagdalatravel@gmail.com';
    $subject = 'Novi upit sa sajta — ' . ($putovanje ?: 'Opšti kontakt');

    $body = "Novi upit sa Bagdala Travel sajta:\n\n";
    $body .= "Ime: {$ime}\n";
    $body .= "Email: {$email}\n";
    $body .= "Telefon: {$telefon}\n";
    $body .= "Putovanje: {$putovanje}\n\n";
    $body .= "Poruka:\n{$poruka}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
    ];

    wp_mail($to, $subject, $body, $headers);

    wp_safe_redirect(add_query_arg('contact', 'success', wp_get_referer()) . '#kontakt-forma');
    exit;
}