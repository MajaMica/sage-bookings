<?php

namespace App;

add_action('wp_ajax_nopriv_bagdala_submit_reservation', function () {
    bagdala_submit_reservation();
});

add_action('wp_ajax_bagdala_submit_reservation', function () {
    bagdala_submit_reservation();
});

function bagdala_submit_reservation() {
    check_ajax_referer('bagdala_reservation', 'nonce');

    $putovanje_id  = isset($_POST['putovanje_id'])  ? (int) $_POST['putovanje_id'] : 0;
    $ime           = isset($_POST['ime_prezime'])   ? sanitize_text_field($_POST['ime_prezime']) : '';
    $email         = isset($_POST['email'])         ? sanitize_email($_POST['email']) : '';
    $telefon       = isset($_POST['telefon'])       ? sanitize_text_field($_POST['telefon']) : '';
    $mesto_polaska = isset($_POST['mesto_polaska']) ? sanitize_text_field($_POST['mesto_polaska']) : '';
    $napomena      = isset($_POST['napomena'])      ? sanitize_textarea_field($_POST['napomena']) : '';

    $odrasli   = isset($_POST['broj_odraslih'])  ? max(1, (int) $_POST['broj_odraslih']) : 1;
    $deca_6_12 = isset($_POST['broj_dece_6_12']) ? max(0, (int) $_POST['broj_dece_6_12']) : 0;
    $deca_do_6 = isset($_POST['broj_dece_do_6']) ? max(0, (int) $_POST['broj_dece_do_6']) : 0;

    $putnici_raw = isset($_POST['putnici']) && is_array($_POST['putnici']) ? $_POST['putnici'] : [];
    $putnici     = [];

    foreach ($putnici_raw as $p) {
        $p_ime = isset($p['ime_prezime']) ? sanitize_text_field($p['ime_prezime']) : '';
        $p_tip = isset($p['tip'])         ? sanitize_text_field($p['tip']) : 'odrastao';

        if ($p_ime === '') {
            continue;
        }

        if (! in_array($p_tip, ['odrastao', 'dete_6_12', 'dete_do_6'], true)) {
            $p_tip = 'odrastao';
        }

        $putnici[] = [
            'ime_prezime' => $p_ime,
            'tip'         => $p_tip,
        ];
    }

    if (! $putovanje_id || ! $ime || ! $email || ! $telefon || ! $mesto_polaska) {
        wp_send_json_error(['message' => 'Sva obavezna polja moraju biti popunjena.'], 400);
    }

    if (! is_email($email)) {
        wp_send_json_error(['message' => 'Email adresa nije ispravna.'], 400);
    }

    $reservation_id = wp_insert_post([
        'post_type'   => 'rezervacija',
        'post_status' => 'publish',
        'post_title'  => $ime . ' — ' . get_the_title($putovanje_id),
    ]);

    if (is_wp_error($reservation_id) || ! $reservation_id) {
        wp_send_json_error(['message' => 'Došlo je do greške. Pokušajte ponovo.'], 500);
    }

    update_field('putovanje_id',      $putovanje_id,  $reservation_id);
    update_field('ime_prezime',       $ime,           $reservation_id);
    update_field('email',             $email,         $reservation_id);
    update_field('telefon',           $telefon,       $reservation_id);
    update_field('mesto_polaska',     $mesto_polaska, $reservation_id);
    update_field('broj_odraslih',     $odrasli,       $reservation_id);
    update_field('broj_dece_6_12',    $deca_6_12,     $reservation_id);
    update_field('broj_dece_do_6',    $deca_do_6,     $reservation_id);
    update_field('napomena_klijenta', $napomena,      $reservation_id);
    update_field('ukupno_osoba',      $odrasli + $deca_6_12 + $deca_do_6, $reservation_id);
    update_field('status',            'pending',      $reservation_id);

    if (! empty($putnici)) {
        update_field('putnici', $putnici, $reservation_id);
    }

    bagdala_send_reservation_emails($reservation_id);

    wp_send_json_success([
        'message' => 'Rezervacija primljena. Javićemo vam se uskoro.',
        'id'      => $reservation_id,
    ]);
}