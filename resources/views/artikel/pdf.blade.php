@php

    $meta = [
        'Kategori'       => $artikel->kategori->nama_kategori ?? '-',
        'Tanggal terbit' => $artikel->tanggal_publikasi->translatedFormat('d F Y'),
        'Penulis'        => $artikel->user->nama ?? '-',
        'Waktu baca'     => $artikel->waktu_baca . ' menit',
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $artikel->judul }}</title>
    <style>
        @page { margin: 2cm 2cm 2.4cm 2cm; }

        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5pt; line-height: 1.7; color: #222222; }

        .merek { font-size: 10pt; font-weight: bold; color: #e0004d; letter-spacing: 1px; margin: 0 0 4pt 0; }
        h1 { font-size: 21pt; line-height: 1.25; margin: 0 0 12pt 0; color: #111111; }

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 14pt; }
        table.info th, table.info td { text-align: left; padding: 4pt 8pt; border: 1px solid #dddddd; font-size: 9.5pt; }
        table.info th { width: 28%; background-color: #fdf1f5; color: #444444; }

        .sampul { width: 100%; margin-bottom: 14pt; }

        .isi h1, .isi h2, .isi h3 { color: #111111; line-height: 1.3; margin: 16pt 0 6pt 0; }
        .isi h1 { font-size: 16pt; }
        .isi h2 { font-size: 14pt; }
        .isi h3 { font-size: 12pt; }
        .isi p { margin: 0 0 9pt 0; }
        .isi ul, .isi ol { margin: 0 0 9pt 0; padding-left: 18pt; }
        .isi li { margin-bottom: 3pt; }
        .isi img { max-width: 100%; }
        .isi blockquote { margin: 0 0 9pt 0; padding-left: 10pt; border-left: 3px solid #f3c1d3; color: #666666; font-style: italic; }
        .isi a { color: #e0004d; }

        .catatan { margin-top: 18pt; padding: 8pt 10pt; background-color: #fdf1f5; border: 1px solid #f3c1d3; font-size: 9pt; color: #555555; }

        .kaki { position: fixed; bottom: -1.5cm; left: 0; right: 0; text-align: center; font-size: 8pt; color: #888888; }
    </style>
</head>
<body>

    <p class="merek">MENTALCARE</p>
    <h1>{{ $artikel->judul }}</h1>

    <table class="info">
        @foreach ($meta as $label => $nilai)
            <tr>
                <th>{{ $label }}</th>
                <td>{{ $nilai }}</td>
            </tr>
        @endforeach
    </table>

    @if ($thumbnail)
        <img src="{{ $thumbnail }}" class="sampul" alt="">
    @endif

    {{-- Isi artikel berupa HTML dari rich editor (hanya ditulis admin) --}}
    <div class="isi">
        {!! $artikel->isi !!}
    </div>

    <p class="catatan">
        Artikel ini bersifat edukatif dan bukan pengganti diagnosis atau perawatan profesional.
    </p>

    <div class="kaki">
        MentalCare &middot; Diunduh pada {{ now()->translatedFormat('d F Y') }}
    </div>

</body>
</html>