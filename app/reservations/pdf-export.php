<?php

namespace App;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'bagdala_pdf_export',
        'PDF Export',
        function ($post) {
            $url = wp_nonce_url(admin_url('admin-post.php?action=bagdala_export_pdf&post_id=' . $post->ID), 'bagdala_pdf_' . $post->ID);
            echo '<p style="margin-bottom:10px;">Preuzmite rezervaciju kao PDF dokument.</p>';
            echo '<a href="' . esc_url($url) . '" class="button button-primary" target="_blank">📄 Preuzmi PDF</a>';
        },
        'rezervacija',
        'side',
        'high'
    );
});

add_action('admin_post_bagdala_export_pdf', function () {
    if (!isset($_GET['post_id']) || !isset($_GET['_wpnonce'])) {
        wp_die('Nevažeći zahtev.');
    }

    $post_id = (int) $_GET['post_id'];
    if (!wp_verify_nonce($_GET['_wpnonce'], 'bagdala_pdf_' . $post_id)) {
        wp_die('Sigurnosna provera nije prošla.');
    }

    if (!current_user_can('edit_post', $post_id)) {
        wp_die('Nemate dozvolu.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'rezervacija') {
        wp_die('Rezervacija nije pronađena.');
    }
    
    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);

    $putovanje_id = (int) get_field('putovanje_id', $post_id);
    $trip_title   = $putovanje_id ? get_the_title($putovanje_id) : 'Nepoznato putovanje';
    
    $datum_polaska = get_field('datum_polaska', $putovanje_id);
    $datum_dolaska = get_field('datum_dolaska', $putovanje_id);
    $datum_format = '';
    if ($datum_polaska && $datum_dolaska) {
        $datum_format = date('d.m.Y', strtotime($datum_polaska)) . ' – ' . date('d.m.Y', strtotime($datum_dolaska));
    }

    $ime           = get_field('ime_prezime', $post_id);
    $email         = get_field('email', $post_id);
    $telefon       = get_field('telefon', $post_id);
    $mesto_polaska = get_field('mesto_polaska', $post_id);
    $odrasli       = (int) get_field('broj_odraslih', $post_id);
    $deca_6_12     = (int) get_field('broj_dece_6_12', $post_id);
    $deca_do_6     = (int) get_field('broj_dece_do_6', $post_id);
    $ukupno        = (int) get_field('ukupno_osoba', $post_id);
    $napomena      = get_field('napomena_klijenta', $post_id);
    $admin_nap     = get_field('admin_napomena', $post_id);
    $status        = get_field('status', $post_id);
    $putnici       = get_field('putnici', $post_id);

    $status_labels = [
        'pending'         => 'Novo',
        'waiting_payment' => 'Čeka uplatu',
        'confirmed'       => 'Potvrđeno',
        'cancelled'       => 'Otkazano',
    ];
    $status_text = isset($status_labels[$status]) ? $status_labels[$status] : $status;

    $putnici_html = '';
    if (!empty($putnici) && is_array($putnici)) {
        foreach ($putnici as $index => $p) {
            $p_ime = isset($p['ime_prezime']) ? esc_html($p['ime_prezime']) : '';
            $p_tip = isset($p['tip']) ? esc_html($p['tip']) : 'odrastao';
            
            $tip_prikaz = 'Odrastao';
            if ($p_tip === 'dete_6_12') $tip_prikaz = 'Dete 6-12';
            if ($p_tip === 'dete_do_6') $tip_prikaz = 'Dete do 6';

            $putnici_html .= '<tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">' . ($index + 1) . '.</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>' . $p_ime . '</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">' . $tip_prikaz . '</td>
            </tr>';
        }
    }

    $html = '
    <!DOCTYPE html>
    <html lang="sr">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
            .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1A2E5A; padding-bottom: 15px; }
            .header h1 { margin: 0; color: #1A2E5A; font-size: 24px; }
            .header p { margin: 5px 0 0 0; color: #E87B3A; font-weight: bold; font-size: 14px; }
            
            .section-title { background: #f8f7f5; padding: 8px 12px; font-weight: bold; color: #1A2E5A; margin: 20px 0 10px 0; border-left: 4px solid #E87B3A; }
            
            .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
            .info-table td { padding: 6px 0; vertical-align: top; }
            .info-table .label { width: 140px; color: #666; }
            .info-table .value { font-weight: bold; }
            
            .passengers-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            .passengers-table th { text-align: left; padding: 8px; background: #f8f7f5; border-bottom: 1px solid #ddd; }
            
            .note-box { background: #fef3c7; padding: 15px; border-radius: 5px; margin-top: 10px; }
            .admin-note { background: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 10px; border: 1px dashed #ccc; }
            .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 10px; }
        </style>
    </head>
    <body>

        <div class="header">
            <h1>Bagdala Travel & Service 037</h1>
            <p>Detalji rezervacije #' . $post_id . '</p>
        </div>

        <div class="section-title">Podaci o putovanju</div>
        <table class="info-table">
            <tr><td class="label">Putovanje:</td><td class="value">' . esc_html($trip_title) . '</td></tr>
            <tr><td class="label">Datum:</td><td class="value">' . esc_html($datum_format) . '</td></tr>
            <tr><td class="label">Mesto polaska:</td><td class="value">' . esc_html($mesto_polaska) . '</td></tr>
            <tr><td class="label">Status:</td><td class="value">' . esc_html($status_text) . '</td></tr>
        </table>

        <div class="section-title">Podaci o klijentu</div>
        <table class="info-table">
            <tr><td class="label">Ime i prezime:</td><td class="value">' . esc_html($ime) . '</td></tr>
            <tr><td class="label">Telefon:</td><td class="value">' . esc_html($telefon) . '</td></tr>
            <tr><td class="label">Email:</td><td class="value">' . esc_html($email) . '</td></tr>
            <tr><td class="label">Ukupno osoba:</td><td class="value">' . $ukupno . ' (Odrasli: ' . $odrasli . ', Deca 6-12: ' . $deca_6_12 . ', Deca do 6: ' . $deca_do_6 . ')</td></tr>
        </table>';

    if ($putnici_html) {
        $html .= '
        <div class="section-title">Lista putnika</div>
        <table class="passengers-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Ime i prezime</th>
                    <th width="120">Tip</th>
                </tr>
            </thead>
            <tbody>
                ' . $putnici_html . '
            </tbody>
        </table>';
    }

    if ($napomena) {
        $html .= '
        <div class="section-title">Napomena klijenta</div>
        <div class="note-box">' . nl2br(esc_html($napomena)) . '</div>';
    }

    if ($admin_nap) {
        $html .= '
        <div class="section-title">Interna napomena (Admin)</div>
        <div class="admin-note">' . nl2br(esc_html($admin_nap)) . '</div>';
    }

    $html .= '
        <div class="footer">
            Generisano: ' . date('d.m.Y H:i') . ' | Bagdala Travel & Service 037 DOO Kruševac
        </div>

    </body>
    </html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream('Rezervacija-' . $post_id . '-' . sanitize_title($ime) . '.pdf', ['Attachment' => true]);
    exit;
});