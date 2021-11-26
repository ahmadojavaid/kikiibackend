<div
  class="main-menu menu-fixed menu-light menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="dashboard-analytics">
          <div class="brand-logo"></div>
          <h2 class="brand-text mb-0">Kikii</h2>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
          <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
            data-ticon="icon-disc">
          </i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
    @can('isAdmin')
      <li class="navigation-header">
        <span>Dashboard</span>
      </li>
      <li class="nav-item {{(request()->url()==route('home'))?'active':''}}">
        <a href="{{ route('home') }}">
        <i class="feather icon-home"></i>
          <span class="menu-title">Home</span>
        </a>
      </li>

      <!-- <li class="nav-item  {{ (request()->is(route('user-show'))) ? 'active' : '' }}">
        <a href="{{ route('user-show') }}">
        <i class="feather icon-user"></i>
          <span class="menu-title">User</span>
        </a>
      </li> -->

        <li class=" nav-item {{(strpos(request()->url(), 'user') || strpos(request()->url(), 'show'))?'active open':''}}" ><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="User">User</span></a>
          <ul class="menu-content">
              <li><a href="{{route('user-show')}}"><i class="feather icon-circle {{(request()->url()==route('user-show'))?'active':''}}"></i><span class="menu-item" data-i18n="List">User Listing</span></a>
              </li>
              <li><a href="{{route('user.reports')}}"><i class="feather icon-circle {{(request()->url()==route('user.reports'))?'active':''}}"></i><span class="menu-item" data-i18n="View">User Reporting</span></a>
              </li>
              <li><a href="{{route('user.matches')}}"><i class="feather icon-circle {{(request()->url()==route('user.matches'))?'active':''}}"></i><span class="menu-item" data-i18n="Edit">Matches</span></a>
              </li>
          </ul>
        </li>

      
  

      <li class="nav-item  {{ (request()->url()==route('moderator.index'))? 'active' : '' }}">
        <a href="{{ route('moderator.index') }}">
        <i class="ficon feather icon-users"></i>
          <span class="menu-title">Moderator</span>
        </a>
      </li>

      @endcan

      @can('isModerator')

      <li class="nav-item  {{ (request()->url()==route('moderator.index'))? 'active' : '' }}">
        <a href="{{ route('moderator.index') }}">
        <i class="ficon feather icon-check-square"></i>
          <span class="menu-title">Community Post</span>
        </a>
      </li>

      @endcan

      @can('isAdmin')

      <li class="nav-item  {{ (request()->url()==route('events.index')) ? 'active' : '' }}">
        <a href="{{ route('events.index') }}">
        <i class="ficon feather icon-check-square"></i>
          <span class="menu-title">Events</span>
        </a>
      </li>

      <li class="nav-item  {{ (request()->url()==route('reports.index'))  ? 'active' : '' }}">
        <a href="{{ route('reports.index') }}">
        <i class="ficon feather icon-file"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>

     
      @endcan 

      <li class=" nav-item {{( 
      request()->url()==route('privacy.create') || 
      request()->url()==route('terms.create') ||
      request()->url()==route('Post.index')       
      )?'active open':''}}"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="User">Kikki support</span></a>
          <ul class="menu-content">
              <li><a href="{{route('privacy.create')}}"><i class="feather icon-circle {{ (request()->url()==route('privacy.create'))  ? 'active' : '' }}"></i><span class="menu-item" data-i18n="List">Privacy Policy</span></a>
              </li>
              <li><a href="{{route('terms.create')}}"><i class="feather icon-circle {{ (request()->url()==route('terms.create'))  ? 'active' : '' }}"></i><span class="menu-item" data-i18n="View">Terms and Conditions</span></a>
              </li>
            <li><a href="{{route('Post.index')}}"><i class="feather icon-circle {{ (request()->url()==route('Post.index'))  ? 'active' : '' }}"></i><span class="menu-item" data-i18n="View">Kikii Post</span></a>
            </li>
              
          </ul>
        </li>

        <li class=" nav-item {{( 
      request()->url()==route('category-create') || 
      request()->url()==route('value.create')     
      )?'active open':''}}"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="User">Admin settings</span></a>
          <ul class="menu-content">
              {{--<li><a href="{{route('category-create')}}"><i class="feather icon-circle {{ (request()->url()==route('category-create'))  ? 'active' : '' }}"></i><span class="menu-item" data-i18n="List">Add category</span></a>
              </li>--}}
              <li><a href="{{route('value.create')}}"><i class="feather icon-circle {{ (request()->url()==route('value.create'))  ? 'active' : '' }}"></i><span class="menu-item" data-i18n="View">Add Category Values</span></a>
              </li>
              
          </ul>
        </li>

    </ul>
  </div>
</div>
<!-- END: Main Menu-->