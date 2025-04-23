  @include('frontend.layouts.header')
  @if (!in_array(Route::currentRouteName(), ['login', 'signup', 'home']))
    @include('frontend.layouts.menu')
  @endif
    @yield('content')
  @include('frontend.layouts.footer')