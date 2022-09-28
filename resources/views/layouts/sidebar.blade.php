<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
  <li class="nav-item">
    <!-- <a href="{{ url('/dashboard') }}" class="nav-link"> -->
    <a href="javascript:;" link="dashboard" kind="menu" class="view_menu nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Dashboard
      </p>
    </a>
  </li>
  <?php
  $permission = new \App\Models\IbsUserPermission();
  $accessMasterMenu = ($permission::accessMasterMenu(auth()->user()->id));
  $accessSubMenu = ($permission::accessSubMenu(auth()->user()->id));
  $AccessParentSubMenu = ($permission::accessParentSubMenu(auth()->user()->id));
  ?>

  @foreach ($accessMasterMenu as $mm)
  <li class="nav-item">
    <a href="javascript:;" link="{{ $mm->url != null ? $mm->url : '#'; }}" class="{{ $mm->url != null ? 'view_menu' : '' }} nav-link">
      <i class="nav-icon {{ $mm->icon }}"></i>
      <p>
        {{ $mm->ibs_menu->name }}
      </p>
    </a>
    @if ($mm->url == null)
    @foreach ($accessSubMenu as $sm)
    <ul class="nav nav-treeview">
      @if ($sm->master_menu == $mm->id)
      <li class="nav-item">
        <a href="#" link="{{ $sm->url != null ? $sm->url : '#'; }}" class="{{ $sm->url != null ? 'view_menu' : '' }} nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>{{ $sm->name }} </p>
        </a>
        @foreach ($AccessParentSubMenu as $pm)
        <ul class="nav nav-treeview" style="background-color: black;">
          @if ($pm->main_sub_menu == $sm->id)
          <li class="nav-item">
            <a href="javascript:;" link="{{ $pm->url != null ? $pm->url : '#'; }}" class="{{ $pm->url != null ? 'view_menu' : '' }} nav-link">
              <i class="fas fa-arrow-right nav-icon"></i>
              <p>{{ $pm->name }}</p>
            </a>
          </li>
          @endif
        </ul>
        @endforeach
      </li>
      @endif
    </ul>
    @endforeach
    @endif
  </li>
  @endforeach



</ul>