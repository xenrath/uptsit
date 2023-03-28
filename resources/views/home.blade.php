@extends('layouts.web')

@section('content')
  <!-- Slider Start -->
  <section class="slider">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-10">
          <div class="block">
            <span class="d-block mb-4 text-white">Selamat Datang di</span>
            <h1 class="animated fadeInUp mb-4">UPT Sistem Informasi<br>& Teknologi</h1>
            <p>Universitas Bhamada Slawi</p>
            <a href="#" class="btn btn-main animated fadeInUp btn-round-full" aria-label="Get started">GET
              STARTED<i class="btn-icon fa fa-angle-right ml-2"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Intro Start -->
  <section class="section intro">
    <div class="container">
      <div class="row ">
        <div class="col-lg-8">
          <div class="section-title">
            <span class="h6 text-color">Home</span>
            <h2 class="mt-3 content-title">{{ $unit->nama }}</h2>
          </div>
        </div>
      </div>
      <p class="mb-5">{!! $unit->deskripsi !!}</p>
    </div>
  </section>
  <!-- Section Intro END -->

  <!-- Section About Start -->
  <section class="section about position-relative">
    <div class="bg-about"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-6 offset-md-0">
          <div class="about-item">
            <span class="h6 text-color">Visi dan Misi</span>
            <h2 class="my-3 position-relative content-title">{{ $unit->nama }}</h2>
            <div class="about-content">
              <table>
                <tr>
                  <td class="number">
                    <span class="h6 text-color">#</span>
                  </td>
                  <td class="description">
                    <span class="h6 text-color">Visi</span>
                    <p>{{ $visimisi->visi }}</p>
                  </td>
                </tr>
                <tr>
                  <td class="number">
                    <span class="h6 text-color">#</span>
                  </td>
                  <td class="description">
                    <span class="h6 text-color">Misi</span>
                    <p>{{ $visimisi->misi }}</p>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Section About End -->

  <!-- section Counter Start -->
  <section class="section counter">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="counter-item text-center mb-5 mb-lg-0">
            <h3 class="mb-0">
              <span class="counter-stat font-weight-bold">{{ $unit->sistem }}</span>
            </h3>
            <p class="text-muted">Jumlah Sistem</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="counter-item text-center mb-5 mb-lg-0">
            <h3 class="mb-0">
              <span class="counter-stat font-weight-bold">{{ $unit->website }}</span>
            </h3>
            <p class="text-muted">Jumlah Website</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="counter-item text-center mb-5 mb-lg-0">
            <h3 class="mb-0">
              <span class="counter-stat font-weight-bold">{{ $unit->ap }}</span>
            </h3>
            <p class="text-muted">Jumlah Akses Point</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- section Counter End  -->

  {{-- <section class="section blog-wrap bg-gray">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
          <div class="section-title">
            <span class="h6 text-color">Positngan</span>
            <h2 class="mt-3 content-title">UPT Sistem Informasi dan Teknologi</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="container-blog">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/1.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Creativity</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Improve design with typography?</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/1.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Creativity</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Improve design with typography?</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/1.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Creativity</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Improve design with typography?</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/2.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Design</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Interactivity connect consumer</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/3.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Community</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Marketing Strategy to bring more affect</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="blog-item">
            <img loading="lazy" src="{{ asset('megakit/source/images/blog/4.jpg') }}" alt="blog"
              class="img-fluid rounded">
            <div class="blog-item-content bg-white p-4">
              <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                <span class="text-muted text-capitalize d-inline-block mr-3"><i
                    class="ti-pencil-alt mr-2"></i>Marketing</span>
              </div>
              <h3 class="mt-3 mb-3"><a href="blog-single.html">Marketing Strategy to bring more affect</a></h3>
              <p class="mb-4">Non illo quas blanditiis repellendus laboriosam minima animi. Consectetur accusantium
                pariatur repudiandae!</p>
              <a href="blog-single.html" class="btn btn-small btn-main btn-round-full">Learn More</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center mt-5">
        <div class="col-lg-6 text-center">
          <nav class="navigation pagination d-inline-block">
            <div class="nav-links">
              <a class="prev page-numbers" href="#">Prev</a>
              <span aria-current="page" class="page-numbers current">1</span>
              <a class="page-numbers" href="#">2</a>
              <a class="next page-numbers" href="#">Next</a>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </section> --}}
@endsection
