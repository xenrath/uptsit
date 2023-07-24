@extends('layouts.web')

@section('content')
  <section class="page-title bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Kontak</span>
            <h1 class="text-capitalize mb-4 text-lg">Unit SIT</h1>
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="{{ url('/') }}" class="text-white">Home</a>
              </li>
              <li class="list-inline-item">
                <span class="text-white">/</span>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white-50">Kontak</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact form start -->
  <section class="contact-form-wrap section">
    <div class="container">
      <div class="contact-content pl-lg-5 mt-5 mt-lg-0">
        <span class="text-muted">Nomor yang dapat dihubungi</span>
        <h2 class="mb-4 mt-2">Unit Sistem Informasi dan Teknologi</h2>
        <div class="row">
          <div class="col-md-6">
            <p>Saiful Labib Marzuqi Hidayat</p>
            <a href="{{ url('hubungi') }}" class="btn btn-success">
              <i class="ti-headphone-alt mr-2"></i>Hubungi Kami
            </a>
          </div>
        </div>
        {{-- <table>
          @foreach ($anggotas as $anggota)
          <tr style="height: 40px">
            <td>{{ $anggota->nama }}</td>
            <td style="width: 24px; text-align: center;">:</td>
            <td>
              <a href="{{ url('hubungi/' . $anggota->id) }}" class="hubungi" target="_blank">0{{ $anggota->telp }}</a>
            </td>
          </tr>
          @endforeach
        </table> --}}

        <ul class="social-icons list-inline mt-5">
          <li class="list-inline-item">
            <a href="http://www.themefisher.com"><i class="fab fa-facebook-f"></i></a>
          </li>
          <li class="list-inline-item">
            <a href="http://www.themefisher.com"><i class="fab fa-twitter"></i></a>
          </li>
          <li class="list-inline-item">
            <a href="http://www.themefisher.com"><i class="fab fa-linkedin-in"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.1493300923175!2d109.11826881450067!3d-6.9916864704148365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fbef42471658d%3A0x883656d1325ef066!2sUniversitas%20Bhamada%20Slawi!5e0!3m2!1sid!2sid!4v1678760855107!5m2!1sid!2sid"
    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"></iframe>
@endsection
