<li class="nav-item">
    <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : 'bg-secondary' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li
    class="nav-item {{ request()->is('admin/identitas*') || request()->is('admin/anggota*') || request()->is('admin/visi-misi*') || request()->is('admin/tupoksi*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/identitas*') || request()->is('admin/anggota*') || request()->is('admin/visi-misi*') || request()->is('admin/tupoksi*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Tampilan Website
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/identitas') }}"
                class="nav-link {{ request()->is('admin/identitas*') ? 'active' : '' }}">
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
            <a href="{{ url('admin/tupoksi') }}" class="nav-link {{ request()->is('admin/tupoksi*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>
                    Tupoksi Unit
                </p>
            </a>
        </li>
    </ul>
</li>
<li
    class="nav-item {{ request()->is('admin/pengaduan-masuk*') || request()->is('admin/pengaduan-selesai*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/pengaduan-masuk*') || request()->is('admin/pengaduan-selesai*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Pengaduan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/pengaduan-masuk') }}"
                class="nav-link {{ request()->is('admin/pengaduan-masuk*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-circle-notch"></i>
                <p>
                    Pengaduan Masuk
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/pengaduan-selesai') }}"
                class="nav-link {{ request()->is('admin/pengaduan-selesai*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-circle-notch"></i>
                <p>
                    Pengaduan Selesai
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ request()->is('admin/hosting*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('admin/hosting*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Permohonan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('admin/hosting') }}"
                class="nav-link {{ request()->is('admin/hosting*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-circle-notch"></i>
                <p>
                    Permohonan Hosting
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ url('admin/peminjaman-cbt') }}"
        class="nav-link {{ request()->is('admin/peminjaman-cbt*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Peminjaman CBT
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/perbaikan') }}" class="nav-link {{ request()->is('admin/perbaikan*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Perbaikan
        </p>
    </a>
</li>
<li class="nav-header">Lainnya</li>
<li class="nav-item">
    <a href="{{ url('admin/prodi') }}" class="nav-link {{ request()->is('admin/prodi*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Prodi
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/unit') }}" class="nav-link {{ request()->is('admin/unit*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Unit
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/bagian') }}" class="nav-link {{ request()->is('admin/bagian*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Bagian
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/karyawan') }}" class="nav-link {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Karyawan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/spesifikasi') }}"
        class="nav-link {{ request()->is('admin/spesifikasi*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Spesifikasi
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/sparepart') }}" class="nav-link {{ request()->is('admin/sparepart*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Sparepart
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/perangkat') }}" class="nav-link {{ request()->is('admin/perangkat*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Data Perangkat
        </p>
    </a>
</li>
