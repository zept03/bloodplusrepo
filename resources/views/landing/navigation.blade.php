<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <a class="navbar-brand" href="#page-top">BloodPlus</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            @if (\Request::is('/'))  
            <a class="nav-link" href="#carousel">Home</a>
            @else
            <a class="nav-link" href="{{url('/')}}">Home</a>
            @endif

          </li>
          <li class="nav-item">
            @if (\Request::is('/whoweare'))  
            <a class="nav-link" href="#mission">Who We Are</a>
            @else
            <a class="nav-link" href="{{url('/whoweare')}}">Who We Are</a>
            @endif
          </li>
          <li class="nav-item">
            @if (\Request::is('/whatwedo'))
            <a class="nav-link" href="#request">What We Do</a>
            @else
            <a class="nav-link" href="{{url('/whatwedo')}}">What We Do</a>
            @endif
          </li>
          <li class="nav-item">
            @if (\Request::is('/contact'))
            <a class="nav-link" href="#contactus">Contact</a>
            @else
            <a class="nav-link" href="{{url('/contact')}}">Contact</a>
            @endif
          </li><li class="nav-item">
            <a class="nav-link" href="{{url('/login')}}">Login</a>
          </li>
        </ul>
      </div>
</nav>