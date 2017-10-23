<script>
    var role = "User";
    var id = "{!! Auth::user()->id !!}" 


</script>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background: #D61F2B">
    
    <div class="container">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapsible">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a style ="margin-top: -3%" class="navbar-brand" href="{{url('/home')}}"><img src = "{{ asset('assets/img/bloodplus/UserLogoText.png') }}"></a>
      </div>
      <div id ="app">
      <div class="navbar-collapse collapse" id="navbar-collapsible">



        <ul class="nav navbar-nav navbar-right right-most-nav">
        <li><a class =" navlinks" href ="{{url('/home')}}"><span class="glyphicon glyphicon-home"></span></a></li>
        
        <notifications :notifications="notifications"></notifications>

          <li class="dropdown">
          @if(Auth::user())
            <a class="dropdown-toggle navlinks" data-toggle="dropdown" href="#">{{Auth::user()->fname.' '.Auth::user()->lname}}
            </a>
            @else
            <a class="dropdown-toggle navlinks" data-toggle="dropdown" href="#">{{$user->fname.' '.$user->lname}}
            @endif
            <ul class="dropdown-menu second-dropdown">   
              <li class="account-list"><a href="{{ url('/profile') }}">My Account</a></li>
              <li class="account-list"><a id = 'logout' href="#">Logout</a></li>
            </ul>
          </li>

      </ul>
      <form id="search" class="navbar-form navbar-right" method="GET" action="{{ url('/user/search') }}">
          <div class="form-group" style="display:inline;">
            <div class="input-group">
              <input type="text" id = "names" name = "term" class="form-control" placeholder="Search">
              <span class="input-group-addon">
                <button style="border: none; background: none">
                <span class="glyphicon glyphicon-search ">
                </span>
                </button>
              </span>
            </div>
          </div>
      </form>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {!! csrf_field() !!}
        </form>
        

      </div>      
        </div>          
        
    </div> <!-- /container -->
    
</nav> <!-- /navbar -->

