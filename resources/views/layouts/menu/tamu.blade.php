<li class="nav-item">
  <a href="{{ url('tamu') }}" class="nav-link {{ request()->is('tamu') ? 'active' : '' }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
  <a href="{{ url('tamu/hosting') }}" class="nav-link {{ request()->is('tamu/hosting*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-globe"></i>
    <p>
      Web Hosting
    </p>
  </a>
</li>
