<li class="nav-item">
    <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : 'bg-secondary' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">
    <hr class="m-0 bg-light">
</li>
<li class="nav-header">
    TAMPILAN WEBSITE
</li>
<li class="nav-item">
    <a href="{{ url('admin/unit') }}" class="nav-link {{ request()->is('admin/unit*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Identitas Unit
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/anggota') }}" class="nav-link {{ request()->is('admin/anggota*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Anggota Unit
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/visimisi') }}" class="nav-link {{ request()->is('admin/visimisi*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Visi dan Misi
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/tupoksi') }}" class="nav-link {{ request()->is('admin/tupoksi*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Tupoksi Unit
        </p>
    </a>
</li>
{{-- <li
    class="nav-item {{ request()->is('admin/pengaduan-masuk*') || request()->is('admin/pengaduan-selesai*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/pengaduan-masuk*') || request()->is('admin/pengaduan-selesai*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Data Pengaduan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/pengaduan-masuk') }}"
                class="nav-link {{ request()->is('admin/pengaduan-masuk*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>
                    Pengaduan Masuk
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/pengaduan-selesai') }}"
                class="nav-link {{ request()->is('admin/pengaduan-selesai*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>
                    Pengaduan Selesai
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ request()->is('admin/hosting*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('admin/hosting*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Data Permohonan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/hosting') }}"
                class="nav-link {{ request()->is('admin/hosting*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>
                    Permohonan Hosting
                </p>
            </a>
        </li>
    </ul>
</li> --}}
<li class="nav-header">
    <hr class="m-0 bg-light">
</li>
<li class="nav-header">MENU</li>
<li class="nav-item">
    <a href="{{ url('admin/peminjaman-cbt') }}"
        class="nav-link {{ request()->is('admin/peminjaman-cbt*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Peminjaman CBT
        </p>
    </a>
</li>
