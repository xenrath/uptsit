<li class="nav-item">
    <a href="{{ url('user') }}" class="nav-link rounded-0 {{ request()->is('user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('user/kegiatan') }}" class="nav-link rounded-0 {{ request()->is('user/kegiatan*') ? 'active' : '' }}">
        <i class="nav-icon far fa-circle"></i>
        <p>
            Kegiatan Harian
        </p>
    </a>
</li>
@if (auth()->user()->isCbt())
    <li class="nav-item">
        <a href="{{ url('user/peminjaman-cbt') }}"
            class="nav-link rounded-0 {{ request()->is('user/peminjaman-cbt*') ? 'active' : '' }}">
            <i class="nav-icon far fa-circle"></i>
            <p>
                Peminjaman CBT
            </p>
        </a>
    </li>
@endif
@if (auth()->user()->isSupport())
    <li class="nav-item">
        <a href="{{ url('user/perbaikan') }}" class="nav-link rounded-0 {{ request()->is('user/perbaikan*') ? 'active' : '' }}">
            <i class="nav-icon far fa-circle"></i>
            <p>
                Data Perbaikan
            </p>
        </a>
    </li>
    <li class="nav-header">Lainnya</li>
    <li class="nav-item">
        <a href="{{ url('user/perangkat') }}" class="nav-link rounded-0 {{ request()->is('user/perangkat*') ? 'active' : '' }}">
            <i class="nav-icon far fa-circle"></i>
            <p>
                Data Perangkat
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('user/sparepart') }}" class="nav-link rounded-0 {{ request()->is('user/sparepart*') ? 'active' : '' }}">
            <i class="nav-icon far fa-circle"></i>
            <p>
                Data Sparepart
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('user/spesifikasi') }}"
            class="nav-link rounded-0 {{ request()->is('user/spesifikasi*') ? 'active' : '' }}">
            <i class="nav-icon far fa-circle"></i>
            <p>
                Data Spesifikasi
            </p>
        </a>
    </li>
@endif
