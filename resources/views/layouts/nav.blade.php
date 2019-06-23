<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route('home')}}">{{ config('app.name', 'Courses') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('course.home')}}">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <create-course> </create-course>
        <!-- <a class="nav-link" href="{{route('course.create')}}">Create new Course</a> -->
      </li>
    </ul>
    <ul class="my-2 my-lg-0">
      @guest
          <li><a href="{{ route('login') }}">Login</a></li>
      @else
      <li>
          <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

      </li>
      @endguest
    </ul>
  </div>
</nav>
