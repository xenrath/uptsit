<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Peminjaman</title>
    <style>
        body {
            padding: 0px;
            font-size: 14px;
        }

        .logo {
            width: 72px;
            z-index: 500;
            position: fixed;
        }

        .header {
            font-weight: bold;
            font-size: 16px;
        }

        .header-sm {
            font-size: 14px;
        }

        .table-1 .td-1 {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
            vertical-align: top;
        }

        * {
            font-family: 'Times New Roman', Times, serif;
            /* border: 1px solid black; */
        }

        .text-center {
            text-align: center
        }

        .text-header {
            font-size: 18px;
            font-weight: 500;
        }

        .layout-ttd {
            display: inline-flex;
            text-align: center;
        }

        .text-muted {
            font-size: 12px;
            opacity: 80%;
        }
    </style>
</head>

<body>
    <img src="{{ asset('storage/uploads/asset/logo-bhamada-sm.png') }}" alt="Bhamada" class="logo">
    <div style="height: 72px; text-align: center;">
        <span class="header">
            UNIVERSITAS BHAMADA SLAWI
            <br>
            UNIT SISTEM INFORMASI DAN TEKNOLOGI
        </span>
        <br>
        <span class="header-sm">
            Alamat : Jl. Cut Nyak Dhien No. 16, Kalisapu, Slawi - Kab. Tegal
            <br>
            Telp. (0283)6197570, 6197571 Fax. (0283)6198450
        </span>
    </div>
    <br>
    <hr style="margin: 0px;">
    <br>
    <div style="text-align: center">
        <span style="font-weight: bold; font-size: 16px;">SURAT PEMINJAMAN LABORATORIUM CBT</span>
    </div>
    <br>
    <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="10">
        <tr>
            <td class="td-1" width="120px">Peminjam</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">
                {{ $peminjaman_cbt->nama }}
                @if ($peminjaman_cbt->keperluan == 'pembelajaran')
                    ({{ $peminjaman_cbt->prodi->nama }})
                @endif
            </td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Tanggal</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">
                @if ($peminjaman_cbt->tanggal_awal == $peminjaman_cbt->tanggal_akhir)
                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}
                @else
                    {{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_awal)->translatedFormat('d F') }}-{{ Carbon\Carbon::parse($peminjaman_cbt->tanggal_akhir)->translatedFormat('d F') }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Jam</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">{{ $peminjaman_cbt->jam_awal }}-{{ $peminjaman_cbt->jam_akhir }}</td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Item</td>
            <td class="td-1" width="20px" style="text-align: center;">:</td>
            <td class="td-1">
                @if ($peminjaman_cbt->items)
                    <ul style="padding-left: 14px; padding-top: 0px; margin: 0px;">
                        @foreach ($peminjaman_cbt->items as $key => $item)
                            <li>
                                {{ $item }}
                                @if (!empty($peminjaman_cbt->jumlahs[$key]))
                                    ({{ $peminjaman_cbt->jumlahs[$key] }})
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted">(hanya pinjam ruang)</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="td-1" width="120px">Uraian Kegiatan</td>
            <td class="td-1" width="20px" style="text-align: center">:</td>
            <td class="td-1">{{ $peminjaman_cbt->keterangan }}</td>
        </tr>
    </table>
    <br>
    <table style="width: 100%;" cellspacing="0" cellpadding="8">
        <tr>
            <td style="width: 50%; padding: 0px;">
                <div class="layout-ttd">
                    <p>&nbsp;</p>
                    <p style="margin-bottom: 24px">Petugas Lab CBT</p>
                    @if ($peminjaman_cbt->status == 'disetujui')
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(60)->generate(asset('storage/uploads/ttd/masruhin.png'))) !!} ">
                        <br>
                        <p>Masruhin</p>
                    @else
                        <br><br><br><br><br>
                    @endif
                    <hr style="margin: 0px">
                </div>
            </td>
            <td style="width: 50%; padding: 0px; text-align: right;">
                <div class="layout-ttd">
                    <p>
                        Slawi,
                        @if ($peminjaman_cbt->status == 'disetujui')
                            {{ Carbon\Carbon::parse($peminjaman_cbt->updated_at)->translatedFormat('d F Y') }}
                        @endif
                    </p>
                    <p style="margin-bottom: 24px">Penanggung Jawab</p>
                    @if ($peminjaman_cbt->status == 'disetujui')
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(60)->generate(asset('storage/uploads/' . $peminjaman_cbt->ttd))) !!} ">
                        <br>
                        <p>{{ $peminjaman_cbt->pj }}</p>
                    @else
                        <br><br><br><br><br>
                    @endif
                    <hr style="margin: 0px">
                </div>
            </td>
        </tr>
    </table>
    <br><br>
    @if ($peminjaman_cbt->status == 'disetujui')
        <span class="text-muted" style="padding: 2px; border: 1px solid black;">
            Kode:
            {{ $peminjaman_cbt->kode }}
        </span>
    @endif
</body>

</html>
