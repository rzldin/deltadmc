<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('admin/dist/img/DMC.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DeltaDMC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ ucwords(Auth::user()->name) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">MAIN NAVIGATION</li>
          <!--- Main menu -->
          @foreach (SiteHelpers::main_menu() as $main_menu)
            
            <li class="nav-item @if (Request::segment(1) == $main_menu->apps_menu_url) menu-open @endif">
              <a href="#" class="nav-link @if (Request::segment(1) == $main_menu->apps_menu_url) active @endif ">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ $main_menu->apps_menu_name }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach (SiteHelpers::sub_menu() as $sub_menu)
                  @if ($sub_menu->apps_menu_parent == $main_menu->id)
                    <li class="nav-item">
                      <a href="{{ url($sub_menu->apps_menu_url) }}" class="nav-link @if (Request::segment(1).'/'.Request::segment(2) == $sub_menu->apps_menu_url) active  @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ ucwords($sub_menu->apps_menu_name) }}</p>
                      </a>
                    </li>
                  @endif
                @endforeach

              </ul>
            </li>
              
          @endforeach
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>