<?php

namespace App;

/**
 * Reservation CPT and SCF fields.
 */

add_action('init', function () {
    register_post_type('rezervacija', [
        'labels' => [
            'name'          => 'Rezervacije',
            'singular_name' => 'Rezervacija',
            'all_items'     => 'Sve rezervacije',
            'menu_name'     => 'Rezervacije',
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'menu_icon'       => 'dashicons-tickets-alt',
        'menu_position'   => 6,
        'supports'        => ['title'],
        'capability_type' => 'post',
        'capabilities'    => ['create_posts' => 'do_not_allow'],
        'map_meta_cap'    => true,
    ]);
});

add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_putovanje_mesta',
        'title'    => 'Mesta i rezervacije',
        'location' => [[[
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'putovanje',
        ]]],
        'position' => 'normal',
        'fields'   => [
            [
                'key'     => 'field_stanje_info',
                'label'   => '',
                'name'    => '',
                'type'    => 'message',
                'message' => '',
            ],
            [
                'key'          => 'field_ukupno_mesta',
                'label'        => '🎫 Ukupan broj mesta',
                'name'         => 'ukupno_mesta',
                'type'         => 'number',
                'min'          => 0,
                'instructions' => 'Leave empty to disable seat counting.',
            ],
            [
                'key'           => 'field_rezervisano_rucno',
                'label'         => '📞 Rezervisano telefonom',
                'name'          => 'rezervisano_rucno',
                'type'          => 'number',
                'default_value' => 0,
                'min'           => 0,
                'wrapper'       => ['width' => '50'],
            ],
            [
                'key'          => 'field_istaknuto_mesta',
                'label'        => '💬 Marketing message (optional)',
                'name'         => 'istaknuto_mesta',
                'type'         => 'text',
                'placeholder'  => 'e.g. Only 2 seats left!',
                'wrapper'      => ['width' => '50'],
            ],
        ],
    ]);

    acf_add_local_field_group([
        'key'      => 'group_rezervacija_details',
        'title'    => 'Detalji rezervacije',
        'location' => [[[
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'rezervacija',
        ]]],
        'fields' => [
            [
                'key'           => 'field_putovanje_id',
                'label'         => 'Putovanje',
                'name'          => 'putovanje_id',
                'type'          => 'post_object',
                'post_type'     => ['putovanje'],
                'return_format' => 'id',
                'required'      => 1,
            ],
            [
                'key'      => 'field_ime_prezime',
                'label'    => 'Ime i prezime',
                'name'     => 'ime_prezime',
                'type'     => 'text',
                'required' => 1,
                'wrapper'  => ['width' => '50'],
            ],
            [
                'key'      => 'field_telefon',
                'label'    => 'Telefon',
                'name'     => 'telefon',
                'type'     => 'text',
                'required' => 1,
                'wrapper'  => ['width' => '50'],
            ],
            [
                'key'      => 'field_email',
                'label'    => 'Email',
                'name'     => 'email',
                'type'     => 'email',
                'required' => 1,
            ],
            [
                'key'           => 'field_broj_odraslih',
                'label'         => 'Odrasli',
                'name'          => 'broj_odraslih',
                'type'          => 'number',
                'default_value' => 1,
                'min'           => 1,
                'wrapper'       => ['width' => '25'],
            ],
            [
                'key'           => 'field_broj_dece_6_12',
                'label'         => 'Deca 6-12',
                'name'          => 'broj_dece_6_12',
                'type'          => 'number',
                'default_value' => 0,
                'min'           => 0,
                'wrapper'       => ['width' => '25'],
            ],
            [
                'key'           => 'field_broj_dece_do_6',
                'label'         => 'Deca do 6',
                'name'          => 'broj_dece_do_6',
                'type'          => 'number',
                'default_value' => 0,
                'min'           => 0,
                'wrapper'       => ['width' => '25'],
            ],
            [
                'key'     => 'field_ukupno_osoba',
                'label'   => 'Ukupno',
                'name'    => 'ukupno_osoba',
                'type'    => 'number',
                'wrapper' => ['width' => '25'],
            ],
            [
                'key'   => 'field_napomena_klijenta',
                'label' => 'Napomena klijenta',
                'name'  => 'napomena_klijenta',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'           => 'field_status',
                'label'         => 'Status',
                'name'          => 'status',
                'type'          => 'select',
                'choices'       => [
                    'pending'         => '🟡 Novo',
                    'waiting_payment' => '🟠 Čeka uplatu',
                    'confirmed'       => '🟢 Potvrđeno',
                    'cancelled'       => '🔴 Otkazano',
                ],
                'default_value' => 'pending',
                'required'      => 1,
            ],
            [
                'key'   => 'field_admin_napomena',
                'label' => '🔒 Interna napomena',
                'name'  => 'admin_napomena',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
        ],
    ]);
});