@extends('landing.master')
@section('title','BloodPlus')

@section('content')
    <header id="home">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="header-content">
                        <div class="header-content-inner">
                            <h1 class="bighead">You can save 3 lives.</h1>
                            <h1>BloodPlus is a web and mobile application that connect patients that urgently needs blood and blood donors. </h1>
                            <a href="{{ url('whoweare') }}" class="btn btn-default-home btn-xl ">About Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <img src="{{asset('landing/img/bg-hand.png')}}" class="img-responsive" style="position: relative; bottom: 0px;" alt="">
                                </div>
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <section id="carousel">

      <h2 class="sr-headings2">Someone Needs You!</h2>
      <hr class="sr-headings2" id="hrhelp">
      <h3 id="carouselsub" class="sr-headings3">Donate blood, save a life. </h3>

              <div class="container">
              <div class="row">
                    <div class="col-md-12 car" data-wow-delay="0.2s">
                        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                            <ol class="carousel-indicators">
                            @forelse($requests as $request)
                            @if($counter++ == 0) 

                                <li data-target="#quote-carousel" data-slide-to="0" class="active">
                                </li>
                            @else
                                <li data-target="#quote-carousel" data-slide-to="1">  
                                </li>                                
                                
                            @endif
                            @empty
                            @endforelse

                            <?php
                              $counter = 0;
                            ?>
                            </ol>

                            </ol>
                            <div class="carousel-inner text-center" role="listbox">
                                @forelse($requests as $request) 
                                @if($counter++ == 0) 
                                <div class="carousel-item active">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                              <h3> Blood Type {{$request->details->blood_type}}</h3>

                                                <p>{{$request->diagnose}}<br>{{$request->created_at->format(' jS \\of F, Y')}}<br>{{$request->institute->institution}}<br><br><br><br></p>
                                                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat 
                                                nulla pariatur!</p> -->

                                                <a href = "{{ url('home?request='.$request->id) }} " class="btn btn-xl" href="#">Donate Now</a>
                                            </div>

                                        </div>
                                    </blockquote>

                                </div>
                                @else 
                                <div class="carousel-item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                              <h3> Blood Type {{$request->details->blood_type}}</h3>

                                                <p>{{$request->diagnose}}<br>{{$request->created_at->format(' jS \\of F, Y')}}<br>\{{$request->institute->institution}}<br></p>
                                                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur!</p> -->
                                                <a href = "{{ url('login?request='.$request->id) }} " class="btn btn-xl" href="#">Donate Now</a>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                @endif
                                @empty
                                <h1>Help people find blood and save life.</h1>
                                @endforelse
                                

<!--                              <a class="carousel-control-prev" href="#quote-carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="false"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="carousel-control-next" href="#quote-carousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="false"></span>
                                <span class="sr-only">Next</span>
                              </a> -->

                            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
                            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

          </div> 
          </section>
<!--   <section class="animation-box">
    <div class="second-text">This is another example text</div>
  </section> -->
<!-- 
  <header>

      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

      <h2>Someone Needs You!</h2>
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">

          <div class="carousel-item active">
            <div class="carousel-caption d-none d-md-block">
              <h3>First Slide</h3>
              <p>This is a description for the first slide.</p>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-caption d-none d-md-block">
              <h3>Second Slide</h3>
              <p>This is a description for the second slide.</p>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-caption d-none d-md-block">
              <h3>Third Slide</h3>
              <p>This is a description for the third slide.</p>
            </div>
          </div>
        </div>


        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="false"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="false"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>
 -->

<!--     <section class="bg-primary" id="about">
      <div class="container"> 
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <hr class="sr-headings">
            <p class="text-faded">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached! Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!<br><br><br><br><br><br></p>
            <a class="btn btn-default btn-xl sr-button" href="#services">Donate Now!</a>
          </div>
        </div>
      </div>
    </section>
 -->

    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Partners</h2>
            <hr class="sr-headings2" id="hrpartners">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x usjr text-primary sr-icons"> </i>
              <h3>University of San Jose - Recoletos</h3>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x prc text-primary sr-icons"></i>
              <h3>Philippine Red Cross <br> Cebu Chapter</h3>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x smart text-primary sr-icons"></i>
              <h3>Smart SWEEP</h3>
              <!-- <p class="text-muted">We update dependencies to keep things fresh.</p> -->
            </div>
          </div>

        </div>
      </div>
    </section>

    

    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">

   
                <h2 class="logo"><a href="#"> LOGO </a></h2>
                </div>

                <div class="col-sm-2">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                    </ul>
                </div>
                <div class="col-sm-2">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Mission</a></li>
                        <li><a href="#">Vision</a></li>
                        <li><a href="#">Team</a></li>
                    </ul>
                </div>
                <div class="col-sm-2">
                    <h5>Services</h5>
                    <ul>
                        <li><a href="#">Request</a></li>
                        <li><a href="#">Donate</a></li>
                        <li><a href="#">Join Campaign</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <div class="social-networks">
                        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="google"><i class="fa fa-instagram"></i></a>
                    </div>
                    <button type="button" class="btn btn-default-footer">Contact us</button>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2016 BloodPlus PH </p>
        </div>
    </footer> 

    <!-- Bootstrap core JavaScript -->
  

  @stop

