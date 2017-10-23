@extends('landing.master')
@section('title','BloodPlus')

@section('content')
	
	<header id="what">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="header-content">
                        <div class="header-content-inner">
                            <h1>We bridge the gap.</h1>
                            <a href="#request" class="btn btn-default-home btn-xl ">Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
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
    

   <section class="bg-request" id="request">
      <div class="container">
        <div class="row">

         <div class="col-md-7">
              <div class="phone  sr-pics"></div>
          <!-- <img src="../img/iphone.png" alt="" /> -->
         </div>

          <div class="col-md-5 ">
            <h2 class="sr-headings">Request Blood</h2>
            <hr align="left" class="white sr-headings2">
            <h3 class="section-heading sr-headings3">In need of blood? </h3>


           <p class="text-fadedrequest">Through the BloodPlus web and mobile application, the user in need of blood can make a request by filling up a form in the application, and having it validated by the Philippine Red Cross - Cebu Chapter to avoid scamming or fraud. After the validation, the request information is then broadcasted through the BloodPlus application or through text messaging to alert eligible donors about the people they can help.<br><br> </p>


            <a class="btn btn-default-request btn-xl sr-headings" href="#services">REQUEST</a>
        </div>
      </div>
    </section>

   <section class="bg-donate" id="donate">
      <div class="container">
        <div class="row">
<!-- 
         <div class="col-md-7">
              <div class="phone text-primary sr-pics"></div>
         </div>
 -->
          <div class="col-md-5 ">
            <h2 class="sr-headings">Donate Blood</h2>
            <hr align="right" class="sr-headings2">
            <h3 class="section-heading sr-headings3">You are somebody's hero!</h3>


           <p class="text-fadeddonate">With the profile display of the individuals in need of blood, the user can find a requester matching his or her blood type.  Text messages will also be sent to only the eligible persons who match the blood type and other specifications of the certain blood transfusion. These messages are not just sent to anyone - they are filtered according to certain categories like last blood donation date, age, weight, any known complications, and others.<br><br> </p>


            <a class="btn btn-default-donate btn-xl sr-button" href="#services">DONATE</a>
        </div>

         <div class="col-md-7 ">
              <div class="phoned sr-headings"></div>
          <!-- <img src="../img/iphone.png" alt="" /> -->
         </div>
      </div>
    </section>

    <section class="bg-campaigns" id="campaigns">
          <div class="container">
          <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="sr-headings" id="contactus">Take Part</h2>
            <hr align="text-center" class="white sr-headings2">
            <h3 class="section-heading sr-headings3">Together, let's save lives.</h3>
            <p class="text-fadedcampaigns">BloodPlus aims to help build the community by always being on alert and notifying you of nearby bloodletting or other blood donation - related events so you are always informed of activities you can join to help. </p>
          </div>
          </div>

        </div>
                  <div class="img-responsive text-center phonec text-primary sr-headings" id="ph"></div>
              <!-- <img src="../img/iphone.png" alt="" /> -->

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