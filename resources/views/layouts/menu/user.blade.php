<li class="nav-item">
    <a href="{{ url('user') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('user/kegiatan') }}" class="nav-link {{ request()->is('user/kegiatan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-walking"></i>
        <p>
            Kegiatan Harian
        </p>
    </a>
</li>
