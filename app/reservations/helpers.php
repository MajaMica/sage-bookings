<?php

namespace App;

/**
 * Reservation helpers — counting and auto-calculation.
 */

function bagdala_count_web_reservations($putovanje_id) {
    if (! $putovanje_id) {
        return 0;
    }

    $ids = get_posts([
        'post_type'      => 'rezervacija',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $total = 0;
    foreach ($ids as $rid) {
        $rpid = (int) get_field('putovanje_id', $rid);
        if ($rpid !== (int) $putovanje_id) {
            continue;
        }
        $status = get_field('status', $rid);
        if (! in_array($status, ['pending', 'waiting_payment', 'confirmed'], true)) {
            continue;
        }
        $total += (int) get_field('broj_odraslih', $rid);
        $total += (int) get_field('broj_dece_6_12', $rid);
        $total += (int) get_field('broj_dece_do_6', $rid);
    }

    return $total;
}

add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'rezervacija') {
        return;
    }

    $total = (int) get_field('broj_odraslih', $post_id)
           + (int) get_field('broj_dece_6_12', $post_id)
           + (int) get_field('broj_dece_do_6', $post_id);

    update_field('ukupno_osoba', $total, $post_id);
}, 25);