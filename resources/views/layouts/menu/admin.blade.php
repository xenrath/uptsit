<li class="nav-item">
  <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
  <a href="{{ url('admin/unit') }}" class="nav-link {{ request()->is('admin/unit*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
      Identitas Unit
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ url('admin/anggota') }}" class="nav-link {{ request()->is('admin/anggota*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      Anggota Unit
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ url('admin/visimisi') }}" class="nav-link {{ request()->is('admin/visimisi*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-bullseye"></i>
    <p>
      Visi dan Misi
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ url('admin/tupoksi') }}" class="nav-link {{ request()->is('admin/tupoksi*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-user-check"></i>
    <p>
      Tupoksi Unit
    </p>
  </a>
</li>
<li class="nav-header">Pengaduan</li>
<li class="nav-item">
  <a href="{{ url('admin/pengaduan-masuk') }}"
    class="nav-link {{ request()->is('admin/pengaduan-masuk*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-clipboard-list"></i>
    <p>
      Pengaduan Masuk
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ url('admin/pengaduan-selesai') }}"
    class="nav-link {{ request()->is('admin/pengaduan-selesai*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-clipboard-list"></i>
    <p>
      Pengaduan Selesai
    </p>
  </a>
</li>
