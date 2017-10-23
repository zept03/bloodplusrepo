@extends('layouts.master')

@section('title','BloodPlus')

@section('content')

    <meta name ="csrf-token" content = "{{csrf_token() }}"/>
    <!-- Section: home slide -->
    <section id="intro" class="home-video text-light">
        <div class="home-video-wrapper">

        <div class="homevideo-container">
           <ul id="valera-slippry">
          <li>
            <div>
            <img class ="cover" src="{{url('/assets/img/slides/b1.jpg')}}" />
            </div>
          </li>
          <li>
            <div>
            <img class ="cover" src="{{url('/assets/img/slides/b3.jpg')}}" />
            </div>
          </li>
          <li>
            <div>
            <img class ="cover" src="{{url('/assets/img/slides/b4.jpg')}}"  />    
            </div>
          </li>
        </ul>
        </div>
        <div class="overlay">
            <div class="text-center video-caption">
                <div class="wow " data-wow-offset="0" data-wow-delay="0.8s">
                    <span><img src="{{url('/assets/img/bloodplus/logoicon.png')}}" class = "site-logo" /></span><br><br>
                    <span><img src="{{url('/assets/img/bloodplus/logoicontext.png')}}" class = "site-logo" /></span><br><br><br><br>
                    <a style ="margin-left: 8px" href="#about" class="btn btn-lg btn-skin" id="btn-scroll">About Us</a>
<!--                     <h1 class="big-heading font-light"><span>BloodPlus </span></h1> -->
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- /Section: intro -->
    
    
    <!-- Navigation -->
    <div id="navigation">
        <nav class="navbar navbar-custom" role="navigation">
                              <div class="container">
                                    <div class="row">
                                      <div class="">
                                           <div class="site-logo">
                                            <a href="{{ url('/')}}"><img src="{{url('/assets/img/bloodplus/LogoText.png')}}" alt="" style="margin-top:7px;"/></a>  
                                            </div>  
                                      </div>
                                          

                                          <div class="col-md-12">
                         
                                                      <!-- Brand and toggle get grouped for better mobile display -->
                                          <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                                                <i class="fa fa-bars"></i>
                                                </button>
                                          </div>
                                                      <!-- Collect the nav links, forms, and other content for toggling -->
                                                      <div class="collapse navbar-collapse" id="menu">
                                                            <ul class="nav navbar-nav navbar-right">
                                                                  <li><a href="#intro">Home</a></li>
                                                                  <li><a href="#about">About Us</a></li>
                                                                   <li><a href="#service">Services</a></li>
                                                                  <li><a href="#contact">Contact</a></li>
                                                                @if(Auth::user())
                                                                  <li><a href="{{url('/home')}}">{{Auth::user()->fname}}</a></li> 
                                                                  @else
                                                                  <li><a href="{{url('/login')}}">Login </a></li>
                                                                  @endif
                                                            </ul>
                                                      </div>
                                                      <!-- /.Navbar-collapse -->
                             
                                          </div>
                                    </div>
                              </div>
                              <!-- /.container -->
                        </nav>
    </div> 
    <!-- /Navigation -->  

    <!-- Section: about -->
    <section id="about" class="home-section color-dark bg-white">
        <div class="container marginbot-0">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
                    <div class="section-heading text-center">
                    <h2 class="h-bold">About</h2>
                    <div class="divider-header"></div>
                    <p>Are you in need of blood? BloodPlus helps you find blood donors immediately. You can also avail these services offered by BloodPlus.</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Section: about -->
    
    <section id="parallax2" class="donate-section parallax text-light" data-stellar-background-ratio="0.5"> 
   <div class="container appear stats">
            <div class="col-md-4">
                <div class="text-center align-center color-white txt-shadow">
                    <div style="display:inline-block">
                        <p id="counter-coffee" class="number">51</p>
                    </div>
                    <div style="display:inline-block">
                        <h2 class="number">-</h2>
                    </div>
                    <div style="display:inline-block">
                        <p id="counter-music" class="number">71</p>
                    </div>
                    <p class="desc text-center">People request for blood everyday</p><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center align-center color-white txt-shadow">
                    <div style="display:inline-block">
                        <p id="counter-wtf" class="number">86</p>
                    </div>
                    <div style="display:inline-block">
                        <h2 class="number">%</h2>
                    </div>
                    <p class="desc text-center">are eligible blood donors but only 7% are regular donors</p><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center align-center color-white txt-shadow">
                    <div style="display:inline-block">
                        <p id="counter-heart" class="number">4</p>
                    </div>
                    <div style="margin-left: 10px; margin-right: 10px;display:inline-block">
                        <h2 class="number">out of</h2>
                    </div>
                    <div style="display:inline-block">
                        <p id="counter-clock" class="number">11</p>
                    </div>
                    <p class="desc text-center">Could not receive blood</p><br>
                </div>
            </div>
<!--           <div class="col-md-12">
            <div class="text-center">
            <div class="col-md-2">
            <div class="align-center color-white txt-shadow">`
            <p id="counter-coffee" class="number">51</p><br>
            </div>
          </div>
          <div class="col-md-1">
            <div class="align-center color-white txt-shadow">
            <br>
              <p class="divide">to</p><br />
            </div>
          </div>
          <div class="col-md-1">
            <div class="align-center color-white txt-shadow">
          
            <p id="counter-music" class="number">71</p><br>
            </div>
          </div>
          <div class="special col-md-1">
            <div class="align-center color-white txt-shadow">
            <p id="counter-clock" class="number">11</p><br>
            </div>
          </div>
          <div class="special col-md-2">
            <div class="align-center color-white txt-shadow">
            <br>
              <p class="divide">out of</p><br>
            </div>
          </div>
          <div class="special col-md-1">
            <div class="align-center color-white txt-shadow">
            <p id="counter-heart" class="number">4</p><br>
            </div>
          </div>
            </div>
          </div>        
        </div>
        <div class="row">
            <div class="align-center color-white txt-shadow">
            <p class="desc">People request for blood everyday<span class="special">Could not receive blood</span></p><br>
            </div>
        </div>
        <br><br>
      <br><br>
      <div class="row appear stats" >
          <div class="col-md-5">
            <div class="color-white txt-shadow">
            <span id="counter-wtf" class="number eligible">86</span><i class ="size">%</i>
            </div>
          </div>
      </div>
        <div class="row">
            <div class="align-center color-white txt-shadow">
            <br>
            <p class="desc1">are eligible blood donors <br>but only 7% are regular donors</p><br>
            </div>
      </div> -->

</div>
</section>
<!-- 
  </section>
    <!-- Section: services -->
    <section id="service" class="home-section color-dark bg-white">

        <div class="service text-center">
             <div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
                <div class="section-heading">
                    <h2 class="h-bold">Services</h2>
                    <div class="divider-header"></div>
                </div>
            </div>
        </div>
        <div class ="text-center">
        <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-box">
                    <div class="service-icon">
                        <span class="icon donateicon"></span> 
                    </div>
                    <div class="service-desc">                      
                        <h5>Donate</h5>
                        <p>
                        Provides a hassle-free blood donation process if you want to donate.
                        </p>
                        <a href="{{ url('donate') }}" class="btn btn-skin">Donate</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-box">
                    <div class="service-icon">
                        <span class="pe-7s-note pe-5x"></span> 
                    </div>
                    <div class="service-desc">
                    <br>
                        <h5>Request</h5>
                        <p>
                        Lets people find blood donors immediately.<br><br>
                        </p>
                        <a href="{{ url('request') }}" class="btn btn-skin">Request</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-box">
                    <div class="service-icon">
                        <span class="icon campaignicon"></span> 
                    </div>
                    <div class="service-desc">                     
                        <h5>Campaigns</h5>
                        <p>
                        Updates you in blood letting campaigns near you.<br><br>    
                        </p>
                        <a href="{{ url('campaign') }}" class="btn btn-skin">Join</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-box">
                    <div class="service-icon">
                        <span class="icon bloodbanksicon"></span> 
                    </div>
                    <div class="service-desc">
                        <h5>Blood Inventory</h5>
                        <p>
                        View the current supplies of blood in different blood banks.<br><br>
                        </p>
                        <a href="{{ url('inventory') }}" class="btn btn-skin">View</a>
                    </div>
                </div>
                </div>
            </div>
        </div>      
        </div>
        </div>
    </section>
    <!-- /Section: services -->
   <section id="parallax3" class="donate-section parallax text-light" data-stellar-background-ratio="0.5"> 
   <div class="container appear stats">
        <div class="row" >
            <div class="text-center align-center ">
            <span class="blood">Your bag of blood can save 3 lives!</span><br><br><br>
            <a href = "{{ url('donate') }}" class="btn btn-skin donateS btn-huge">Donate now</a>
          </div>

        </div>
    </div>
        
      <br><br>
    </section>
    <!-- Section: contact -->
    <section id="contact" class="home-section nopadd-bot color-dark bg-white text-center">
        <div class="container marginbot-50">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
                    <div class="section-heading text-center">
                    <br><br>
                    <h2 class="h-bold">Contact us</h2>
                    <div class="divider-header"></div>
                    <p>For inquiries and suggestions, please feel free to contact us.</p>
                    </div>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="container">

            <div class="row marginbot-80">
                <div class="col-md-8 col-md-offset-2">
                    <div id="sendmessage">Your message has been sent. Thank you!</div>
                    <div id="errormessage"></div>
                    <form action="{{ url('/') }}" method="post" role="form" class="contactForm" id = "contactForm">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" id = "message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message" required></textarea>
                            <div class="validation"></div>
                        </div>
                        
                        <div class="text-center"><button id ="contactSubmit" type="submit" class="btn btn-skin btn-lg btn-block">Send Message</button></div>
                    </form>
                </div>
            </div>  


        </div>
    </section>
    @include('layouts.footer')
    <script>

    $("#contactSubmit").on("click",function($e) {
            console.log($("#contactForm").serialize());
            $e.preventDefault();
            if($("#name").val() == "" && $("#email").val() == "")
            {
                alert("Please fill up either name or email");
            }
            else if($("#message").val() == "")
            {
                alert("Please fill up content of your message");
            }
            else
            {
                var $inquiry = $("#contactForm").serialize();
                sendInquiry($inquiry);
                $('#contactForm')[0].reset();
            }
            

    });

    function sendInquiry(data){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            method: "post",
            url: "{{ url('sendinquiry') }}",
            data: {'_token': CSRF_TOKEN,
                data},
            success:function(data) {
                console.log(data);
                alert('Thank you for sending us your feedback/inquiry');

            },
            error: function(xhr) {
                console.log(xhr.status);
            }
        });
    }
    </script>
    <!-- /Section: contact -->       
@stop