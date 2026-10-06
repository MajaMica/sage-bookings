<?php

namespace App;

/**
 * Reservation email notifications.
 */
function bagdala_send_reservation_emails($reservation_id) {
    $putovanje_id = (int) get_field('putovanje_id', $reservation_id);
    $ime          = get_field('ime_prezime', $reservation_id);
    $email        = get_field('email', $reservation_id);
    $telefon      = get_field('telefon', $reservation_id);
    $odrasli      = (int) get_field('broj_odraslih', $reservation_id);
    $deca_6_12    = (int) get_field('broj_dece_6_12', $reservation_id);
    $deca_do_6    = (int) get_field('broj_dece_do_6', $reservation_id);
    $ukupno       = $odrasli + $deca_6_12 + $deca_do_6;
    $napomena     = get_field('napomena_klijenta', $reservation_id);

    $trip_title   = get_the_title($putovanje_id);
    $trip_url     = get_permalink($putovanje_id);
    $trip_image   = get_the_post_thumbnail_url($putovanje_id, 'medium_large');

    $datum_polaska = get_field('datum_polaska', $putovanje_id);
    $datum_dolaska = get_field('datum_dolaska', $putovanje_id);
    $datum_format  = '';
    if ($datum_polaska && $datum_dolaska) {
        $datum_format = date('d.m.Y', strtotime($datum_polaska)) . ' – ' . date('d.m.Y', strtotime($datum_dolaska));
    }

    $admin_email = 'bagdalatravel@gmail.com';

    $osobe_text = $odrasli . ' ' . ($odrasli === 1 ? 'odrasla osoba' : 'odraslih');
    if ($deca_6_12 > 0) $osobe_text .= ' + ' . $deca_6_12 . ' ' . ($deca_6_12 === 1 ? 'dete 6-12' : 'dece 6-12');
    if ($deca_do_6 > 0) $osobe_text .= ' + ' . $deca_do_6 . ' ' . ($deca_do_6 === 1 ? 'dete do 6' : 'dece do 6');

    // ─── CUSTOMER EMAIL ───
    $customer_subject = '✅ Rezervacija primljena — ' . $trip_title;

    $customer_body = '<!DOCTYPE html>
<html lang="sr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rezervacija primljena</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f5f4;font-family:Arial,Helvetica,sans-serif;color:#1c1917;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f4;padding:30px 15px;">
  <tr>
    <td align="center">

      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);">

        <tr>
          <td style="background:#1A2E5A;padding:25px 30px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:24px;font-weight:bold;color:#ffffff;letter-spacing:1px;">
              Bagdala <span style="color:#E87B3A;">Travel</span>
            </div>
            <div style="font-size:11px;color:#ffffff;opacity:0.6;margin-top:4px;">&amp; service 037</div>
          </td>
        </tr>

        ' . ($trip_image ? '
        <tr>
          <td style="padding:0;">
            <img src="' . esc_url($trip_image) . '" alt="' . esc_attr($trip_title) . '" style="display:block;width:100%;max-width:600px;height:auto;">
          </td>
        </tr>
        ' : '') . '

        <tr>
          <td style="padding:35px 35px 20px 35px;">

            <div style="display:inline-block;background:#dcfce7;color:#166534;font-size:12px;font-weight:bold;padding:6px 14px;border-radius:20px;margin-bottom:18px;letter-spacing:0.5px;">
              ✓ REZERVACIJA PRIMLJENA
            </div>

            <h1 style="margin:0 0 12px 0;font-size:24px;color:#1A2E5A;font-weight:bold;line-height:1.3;">
              Hvala ti, ' . esc_html($ime) . '!
            </h1>

            <p style="margin:0 0 25px 0;font-size:15px;line-height:1.6;color:#57534e;">
              Tvoja prijava za putovanje je uspešno primljena. Naš tim će te kontaktirati u roku od 24 sata radi potvrde i daljih informacija.
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f7f5;border-radius:12px;padding:0;margin-bottom:25px;">
              <tr>
                <td style="padding:22px 25px;">

                  <div style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#a8a29e;font-weight:bold;margin-bottom:10px;">
                    Detalji rezervacije
                  </div>

                  <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="padding:6px 0;font-size:14px;color:#57534e;width:120px;">Putovanje:</td>
                      <td style="padding:6px 0;font-size:14px;color:#1c1917;font-weight:bold;">' . esc_html($trip_title) . '</td>
                    </tr>
                    ' . ($datum_format ? '
                    <tr>
                      <td style="padding:6px 0;font-size:14px;color:#57534e;">Datum:</td>
                      <td style="padding:6px 0;font-size:14px;color:#1c1917;">' . esc_html($datum_format) . '</td>
                    </tr>' : '') . '
                    <tr>
                      <td style="padding:6px 0;font-size:14px;color:#57534e;">Osobe:</td>
                      <td style="padding:6px 0;font-size:14px;color:#1c1917;">' . esc_html($osobe_text) . ' <span style="color:#a8a29e;">(' . $ukupno . ' ukupno)</span></td>
                    </tr>
                    <tr>
                      <td style="padding:6px 0;font-size:14px;color:#57534e;">Broj rez.:</td>
                      <td style="padding:6px 0;font-size:14px;color:#1c1917;font-weight:bold;">#' . $reservation_id . '</td>
                    </tr>
                  </table>

                </td>
              </tr>
            </table>

            <div style="background:#fef3c7;border-left:4px solid #E87B3A;padding:15px 20px;border-radius:8px;margin-bottom:25px;">
              <div style="font-size:14px;color:#78350f;line-height:1.5;">
                <strong>📞 Javićemo vam se uskoro</strong><br>
                Kontaktiraćemo te na <strong>' . esc_html($telefon) . '</strong> ili <strong>' . esc_html($email) . '</strong> radi potvrde i informacija o uplati.
              </div>
            </div>

            <div style="text-align:center;margin:30px 0 10px 0;">
              <a href="' . esc_url($trip_url) . '" style="display:inline-block;background:#E87B3A;color:#ffffff;text-decoration:none;font-weight:bold;font-size:14px;padding:14px 32px;border-radius:30px;">
                Pogledaj putovanje →
              </a>
            </div>

          </td>
        </tr>

        <tr>
          <td style="background:#f8f7f5;padding:25px 35px;text-align:center;border-top:1px solid #e7e5e4;">
            <div style="font-size:13px;color:#57534e;line-height:1.7;">
              <strong style="color:#1A2E5A;">Bagdala Travel &amp; Service 037</strong><br>
              Balkanska 36, Kruševac<br>
              060/04-55-232 &nbsp;·&nbsp; 060/44-55-230<br>
              <a href="mailto:bagdalatravel@gmail.com" style="color:#E87B3A;text-decoration:none;">bagdalatravel@gmail.com</a>
            </div>
          </td>
        </tr>

      </table>

      <div style="font-size:11px;color:#a8a29e;margin-top:20px;text-align:center;">
        Ovo je automatska potvrda. Molimo ne odgovarajte direktno na ovaj mejl.
      </div>

    </td>
  </tr>
</table>

</body>
</html>';

    // ─── ADMIN EMAIL ───
    $admin_subject = '🎫 Nova rezervacija — ' . $trip_title . ' (' . $ime . ')';

    $admin_body = '<!DOCTYPE html>
<html lang="sr">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f5f5f4;font-family:Arial,Helvetica,sans-serif;color:#1c1917;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f4;padding:30px 15px;">
  <tr><td align="center">

    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);">

      <tr>
        <td style="background:#1A2E5A;padding:25px 30px;">
          <div style="font-size:20px;font-weight:bold;color:#ffffff;">🎫 Nova rezervacija</div>
          <div style="font-size:13px;color:#ffffff;opacity:0.7;margin-top:5px;">Rezervacija #' . $reservation_id . '</div>
        </td>
      </tr>

      ' . ($trip_image ? '
      <tr><td style="padding:0;">
        <img src="' . esc_url($trip_image) . '" alt="' . esc_attr($trip_title) . '" style="display:block;width:100%;max-width:600px;height:auto;">
      </td></tr>
      ' : '') . '

      <tr>
        <td style="padding:30px;">

          <div style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#a8a29e;font-weight:bold;margin-bottom:12px;">
            Putovanje
          </div>

          <div style="background:#f8f7f5;border-radius:12px;padding:20px 22px;margin-bottom:22px;">
            <div style="font-size:18px;font-weight:bold;color:#1A2E5A;margin-bottom:5px;">' . esc_html($trip_title) . '</div>
            ' . ($datum_format ? '<div style="font-size:14px;color:#57534e;">' . esc_html($datum_format) . '</div>' : '') . '
          </div>

          <div style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#a8a29e;font-weight:bold;margin-bottom:12px;">
            Podaci klijenta
          </div>

          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f7f5;border-radius:12px;">
            <tr><td style="padding:18px 22px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:5px 0;font-size:14px;color:#57534e;width:100px;">Ime:</td>
                  <td style="padding:5px 0;font-size:14px;color:#1c1917;font-weight:bold;">' . esc_html($ime) . '</td>
                </tr>
                <tr>
                  <td style="padding:5px 0;font-size:14px;color:#57534e;">Telefon:</td>
                  <td style="padding:5px 0;font-size:14px;color:#1c1917;"><a href="tel:' . esc_attr($telefon) . '" style="color:#E87B3A;text-decoration:none;font-weight:bold;">' . esc_html($telefon) . '</a></td>
                </tr>
                <tr>
                  <td style="padding:5px 0;font-size:14px;color:#57534e;">Email:</td>
                  <td style="padding:5px 0;font-size:14px;color:#1c1917;"><a href="mailto:' . esc_attr($email) . '" style="color:#E87B3A;text-decoration:none;">' . esc_html($email) . '</a></td>
                </tr>
                <tr>
                  <td style="padding:5px 0;font-size:14px;color:#57534e;">Osobe:</td>
                  <td style="padding:5px 0;font-size:14px;color:#1c1917;"><strong>' . $ukupno . '</strong> — ' . esc_html($osobe_text) . '</td>
                </tr>
              </table>
            </td></tr>
          </table>

          ' . ($napomena ? '
          <div style="margin-top:22px;">
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#a8a29e;font-weight:bold;margin-bottom:10px;">Napomena klijenta</div>
            <div style="background:#fef3c7;border-left:4px solid #E87B3A;padding:14px 18px;border-radius:8px;font-size:14px;color:#78350f;line-height:1.5;">
              ' . nl2br(esc_html($napomena)) . '
            </div>
          </div>' : '') . '

          <div style="text-align:center;margin:30px 0 5px 0;">
            <a href="' . esc_url(admin_url('post.php?post=' . $reservation_id . '&action=edit')) . '" style="display:inline-block;background:#1A2E5A;color:#ffffff;text-decoration:none;font-weight:bold;font-size:14px;padding:14px 32px;border-radius:30px;">
              Otvori u adminu →
            </a>
          </div>

        </td>
      </tr>

      <tr>
        <td style="background:#f8f7f5;padding:18px 30px;text-align:center;border-top:1px solid #e7e5e4;font-size:12px;color:#a8a29e;">
          Automatska notifikacija sa bagdalatravel.rs
        </td>
      </tr>

    </table>

  </td></tr>
</table>

</body>
</html>';

    $customer_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $admin_email,
    ];

    $admin_headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $email,
    ];

    wp_mail($email, $customer_subject, $customer_body, $customer_headers);
    wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);
}