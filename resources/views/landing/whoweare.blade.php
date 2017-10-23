@extends('landing.master')
@section('title','BloodPlus')

@section('additional_css') 
  <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')

    <header id="who">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-content">
                        <div class="header-content-inner">
                            <h1>We help people help people.</h1>
                            <a href="#team" class="btn btn-default-home btn-xl ">Team</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <img src="landing/img/bg-drop.png" class="img-responsive sr-headings" style="position: relative;" alt="">
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
 
    <section class="bg-mission" id="mission">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="sr-headings">Our Mission</h2>
            <hr align="right" class="sr-headings2">
            <h3 class="section-heading sr-headings3">Together, let's save lives.</h3>
       
          </div>
          <div class="col-md-6 col-md-6 col-md-offset-6">

           <p class="text-fadedmission">We seek to address one of the health industry's primary problems - having limited supply of blood in blood banks for the people in need thereof. We digitize the search for blood requesters and blood donors in the community by utilizing modern technology to increase public awareness, encourage support, ease the process, and help patients.</p>
        </div>
      </div>
    </section>


    <section class="bg-vision" id="vision">
      <div class="container">
        <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <h2 class="sr-headings">Our Vision</h2>
            <hr align="left" class="sr-headings2">
           
            <h3 class="section-heading sr-headings3">Together, let's save lives.</h3>
     
        </div>
        <div class="col-md-6">
            <p class="text-fadedvision">We envision BloodPlus to be the world's largest and most useful platform for individuals to request for blood and be alerted about blood donation needs; to build an interactive community where patients, donors, and medical institutions can communicate, help, and build one another up.</p>       
          </div>
          
        </div>
      </div>
    </section>



    <!-- TEAM -->
 
<section class="main-section team" id="team"><!--main-section team-start-->
  <div class="container ">
        <h2>The Team</h2>
        <hr align="text-center" class="team sr-headings2">
        <!-- <h6>Take a closer look into our amazing team. We won’t bite.</h6> -->
        <div class="team-leader-block clearfix">
        <div class="container">
          <div class="row">
            
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-leader sr-icons"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="landing/img/sept.jpg" alt="">
                        <ul>
                            <li><a href="https://www.facebook.com/sept.lozada" class="fa-facebook"></a></li>
                            <li><a href="https://www.linkedin.com/in/sept-joshua-rey-lozada-843646136/" class="fa-linkedin"></a></li>
                            <li><a href="https://plus.google.com/u/0/100485141049917690040" class="fa-google-plus"></a></li>
                        </ul>
                    </div>
                    <h3 class="wow fadeInDown delay-09s">Sept Joshua Rey Lozada</h3>
                    <span class="wow fadeInDown delay-09s">Project Manager </span>
                    <p class="wow fadeInDown delay-09s"> <br>"Start small, end big."</p> 
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-leader sr-icons"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="landing/img/kirster.jpg" alt="">
                        <ul>
                            <li><a href="https://www.facebook.com/kirsterkyle.quinio" class="fa-facebook"></a></li>
                            <li><a href="https://www.linkedin.com/in/kirster-kyle-quinio-290570146/" class="fa-linkedin"></a></li>
                        </ul>
                    </div>
                    <h3 class="wow fadeInDown delay-09s">Kirster Kyle <br>Quinio</h3>
                    <span class="wow fadeInDown delay-09s">Chief Tech Officer</span> <br>
                    <p class="wow fadeInDown delay-09s"> <br>"Baby steps to giant strides."</p>
                </div>

                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-leader sr-icons"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="landing/img/alyzza.jpg" alt="">
                        <ul>
                            <li><a href="https://www.facebook.com/iamalyzzav" class="fa-facebook"></a></li>
                            <li><a href="https://www.linkedin.com/in/alyzza-villahermosa-26a04b116/" class="fa-linkedin"></a></li>
                            <li><a href="https://plus.google.com/u/0/114642343547151921120" class="fa-google-plus"></a></li>
                        </ul>
                    </div>
                    <h3 class="wow fadeInDown delay-09s">Alyzza<br> Villahermosa</h3>
                    <span class="wow fadeInDown delay-09s">Communications and Public  Relatins</span>
                    <p class="wow fadeInDown delay-09s">"We're given only one life, make it the best. Make it different. Be an inspiration."</p>
                </div>  

                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-leader sr-icons"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="landing/img/har.jpg" alt="">
                        <ul>
                            <li><a href="https://www.facebook.com/harniel.salmeron" class="fa-facebook"></a></li>
                            <li><a href="https://www.linkedin.com/in/harniel-salmeron-027118134/" class="fa-linkedin"></a></li>
                            <li><a href="https://plus.google.com/u/0/103504272158719717434" class="fa-google-plus"></a></li>
                        </ul>
                    </div>
                    <h3 class="wow fadeInDown delay-03s">Harniel <br>Salmeron</h3>
                    <span class="wow fadeInDown delay-03s">Mobile Applications Head Developer</span>
                    <p class="wow fadeInDown delay-03s">"Start saving the world by saving one person at a time."</p>
                </div>
                 <div class="col-lg-3 text-center" id="mark">
                    <div class="team-leader sr-icons"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="landing/img/sirmarks.jpg" alt="">
                        <ul>
                            <li><a href="https://www.facebook.com/mastercedi.antonino" class="fa-facebook"></a></li>
                            <li><a href="https://www.linkedin.com/in/markcedrickantonino/" class="fa-linkedin"></a></li>
                            <li><a href="https://plus.google.com/u/0/+MarkCedrickAntoninoPH" class="fa-google-plus"></a></li>
                        </ul>
                    </div>
                    <h3 class="wow fadeInDown delay-03s">Mark Cedrick Antonino</h3>
                    <span class="wow fadeInDown delay-03s">Project Adviser</span>
                    <p class="wow fadeInDown delay-03s"> "Always be proactive." </p>
                </div>
              </div>
            </div>
        </div>
    </div>
</section><!--main-section team-end-->
  <section>
      <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <blockquote class="quote-box">
            <p class="quotation-mark sr-headings">
              “
            </p>
            <p class="text-fadedquote">We are driven by the passion to help people by doing whatever we can to contribute aid to societal problems. We have come up with the idea of BloodPlus because we have witnessed and experienced firsthand the difficulties in searching for eligible blood donors for our loved ones, and the effects of the lack of awareness for the need of the same.  With the diverse skills we have, we work hand-in-hand in using each other's strengths to create something that would matter for the world. </p>
            <hr class="sr-headings"> 
            <div class="blog-post-actions">
              <p class="blog-post-bottom pull-left">
                Abraham Lincoln
              </p>
            <!--   <p class="blog-post-bottom pull-right">
                <span class="badge quote-badge">896</span>  ❤
              </p> -->
            </div>
          </blockquote>
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

@stop