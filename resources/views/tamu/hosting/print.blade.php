<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Nota Peminjaman</title>
  <style>
    body {
      padding: 0px 24px;
      font-size: 14px;
    }

    .table-1 .td-1,
    .th-1 {
      border: 1px solid black;
    }

    .td-1 {
      text-align: left;
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
  </style>
</head>

<body>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: center;">
        <span style="font-weight: bold; font-size: 14px;">
          FORMULIR PERMOHONAN WEB HOSTING
          <br>
          SUB DOMAIN LEMBAGA/UNIT/BIRO DI LINGKUNGAN UNIVERSITAS BHAMADA SLAWI
        </span>
      </td>
    </tr>
    <hr>
  </table>
  <small style=" padding: 0;">
    <i>
      <ol style="margin: 0;">
        <li>Isilah semua data dengan menggunakan huruf balok</li>
        <li>Gunakan tanda centang [<span style="font-family: DejaVu Sans, sans-serif;">✔</span>] untuk kolom pilihan
        </li>
        <li>Formulir dilengkapi dengan surat pengantar dari instansi</li>
      </ol>
    </i>
  </small>
  <table style="width: 100%; margin-top: 10px;">
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="6" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">PILIHAN PERMOHONAN SUB DOMAIN</span>
            </td>
          </tr>
          <tr>
            <td class="td-1" colspan="3">
              <i>* Pilih salah satu</i>
            </td>
            @php
              $kategoris = ['baru', 'perubahan', 'penambahan'];
            @endphp
            @foreach ($kategoris as $kategori)
              @php
                if ($hosting->kategori == $kategori) {
                    $icon = 'check-square-regular.svg';
                } else {
                    $icon = 'square-regular.svg';
                }
              @endphp
              <td class="td-1">
                <img src="{{ asset('storage/uploads/icon/' . $icon) }}" style="width: 12px; margin-right: 6px">
                {{ ucfirst($kategori) }}
              </td>
            @endforeach
          </tr>
          <tr>
            <td class="td-1" style="width: 20%">Nama Instansi</td>
            <td class="td-1" style="width: 30%" colspan="5">{{ $hosting->nama_instansi }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="4" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">KEPALA/DIREKTUR LEMBAGA/ORGANISASI</span>
            </td>
          </tr>
          <tr>
            <td class="td-1" style="width: 20%">Nama</td>
            <td class="td-1" style="width: 30%" colspan="3">{{ $hosting->nama_kepala }}</td>
          </tr>
          <tr>
            <td class="td-1">NIPY</td>
            <td class="td-1" colspan="3">{{ $hosting->nipy_kepala }}</td>
          </tr>
          <tr>
            <td class="td-1">Jabatan</td>
            <td class="td-1" colspan="3">{{ $hosting->jabatan_kepala }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="4" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">ADMINISTRATOR/DESAINER/DEVELOPER WEBSITE</span>
            </td>
          </tr>
          <tr>
            <td class="td-1" style="width: 20%">Nama</td>
            <td class="td-1" style="width: 30%">{{ $hosting->nama_admin_1 }}</td>
            <td class="td-1" style="width: 20%">Nama</td>
            <td class="td-1" style="width: 30%">{{ $hosting->nama_admin_2 }}</td>
          </tr>
          <tr>
            <td class="td-1">NIPY</td>
            <td class="td-1">{{ $hosting->nipy_admin_1 }}</td>
            <td class="td-1">NIPY</td>
            <td class="td-1">{{ $hosting->nipy_admin_2 }}</td>
          </tr>
          <tr>
            <td class="td-1">Jabatan</td>
            <td class="td-1">{{ $hosting->jabatan_admin_1 }}</td>
            <td class="td-1">Jabatan</td>
            <td class="td-1">{{ $hosting->jabatan_admin_2 }}</td>
          </tr>
          <tr>
            <td class="td-1">Email</td>
            <td class="td-1">{{ $hosting->email_admin_1 }}</td>
            <td class="td-1">Email</td>
            <td class="td-1">{{ $hosting->email_admin_2 }}</td>
          </tr>
          <tr>
            <td class="td-1">No. Telepon</td>
            <td class="td-1">{{ $hosting->telp_admin_1 }}</td>
            <td class="td-1">No. Telepon</td>
            <td class="td-1">{{ $hosting->telp_admin_2 }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">DESKRIPSI</span>
            </td>
          </tr>
          <tr>
            <td class="td-1">{{ $hosting->deskripsi }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="3" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">NAMA SUB DOMAIN YANG DIMINTA</span>
            </td>
          </tr>
          <tr>
            <td class="td-1" style="width: 20%">Sub Domain</td>
            <td class="td-1" style="width: 45%">{{ $hosting->sub_domain }}</td>
            <td class="td-1" style="width: 35%">
              <small style="font-size: 10px">
                <i>Nama Sub Domain harus URL friendly/mudah dibaca</i>
              </small>
            </td>
          </tr>
          <tr>
            <td class="td-1">IP Address</td>
            <td class="td-1">{{ $hosting->ip_address }}</td>
            <td class="td-1">
              <small style="font-size: 10px">
                <i>Jika menggunakan server selain server lain</i>
              </small>
            </td>
          </tr>
          <tr>
            <td class="td-1">FTP / DB</td>
            <td class="td-1">{{ $hosting->ftp }}</td>
            <td class="td-1">
              <small style="font-size: 10px">
                <i>Jika ingin mengelola aplikasi secara mandiri</i>
              </small>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="3" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">PERSETUJUAN</span>
            </td>
          </tr>
          <tr>
            <td class="td-1" colspan="3">Dengan ini saya menyatakan bahwa data diatas adalah benar. Saya
              bertindak atas nama
              organisasi yang saya wakili dan saya setuju untuk mematuhi semua aturan yang ditentukan dan berlaku bagi
              seluruh pengguna fasilitas layanan Hosting Universitas Bhamada Slawi.</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid black; border-bottom: 1px solid black" colspan="2"></td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black">
              <div style="text-align: center">
                <strong>KEPALA INSTANSI</strong>
                <br>
                <br>
                <br>
                <br>
                <br>
                <strong>
                  <u>{{ $hosting->nama_kepala }}</u>
                </strong>
                <br>
                <small>{{ $hosting->nipy_kepala }}</small>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%;" class="table-1" cellspacing="0" cellpadding="4">
          <tr>
            <td class="td-1" colspan="3" style="background-color: lightgray">
              <span style="font-weight: bold; font-size: 14px;">DIISI OLEH <i>HELPDESK</i></span>
            </td>
          </tr>
          <tr>
            <td class="td-1" style="text-align: center; width: 30%">
              Diterima tanggal :
              <br>
              {{ date('d F Y', strtotime($hosting->created_at)) }}
            </td>
            <td class="td-1" style="text-align: center; width: 30%">
              Diproses dan Aktivasi tanggal :
              {{ date('d F Y', strtotime($hosting->created_at)) }}
            </td>
            <td class="td-1" style="text-align: center; width: 40%;">
              <strong>Mengetahui</strong>
            </td>
          </tr>
          <tr>
            <td class="td-1" style="text-align: center">
              <strong>Penerima</strong>
              <br>
              <br>
              <br>
              <br>
              <br>
            </td>
            <td class="td-1" style="text-align: center">
              <strong>Administrator Sistem</strong>
              <br>
              <br>
              <br>
              <br>
              <br>
            </td>
            <td class="td-1" style="text-align: center">
              <strong>KABID HUBUNGAN MEDIA, TIK</strong>
              <br>
              <br>
              <br>
              <br>
              <br>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
