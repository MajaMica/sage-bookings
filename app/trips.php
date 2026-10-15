<?php

namespace App;

/**
 * Trip lifecycle — auto-expire past trips.
 */

add_filter('cron_schedules', function ($schedules) {
    $schedules['daily_midnight'] = [
        'interval' => DAY_IN_SECONDS,
        'display'  => __('Once Daily (midnight)', 'sage'),
    ];
    return $schedules;
});

add_action('init', function () {
    if (! wp_next_scheduled('bagdala_expire_trips')) {
        $next_midnight = strtotime('tomorrow midnight', current_time('timestamp'));
        wp_schedule_event($next_midnight, 'daily_midnight', 'bagdala_expire_trips');
    }
});

add_action('bagdala_expire_trips', function () {
    $now = current_time('Y-m-d H:i:s');

    $expired_ids = get_posts([
        'post_type'      => 'putovanje',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'meta_query'     => [
            [
                'key'     => 'datum_polaska',
                'value'   => $now,
                'compare' => '<',
                'type'    => 'DATETIME',
            ],
        ],
    ]);

    if (empty($expired_ids)) {
        return;
    }

    foreach ($expired_ids as $id) {
        wp_update_post([
            'ID'          => $id,
            'post_status' => 'draft',
        ]);
    }
});