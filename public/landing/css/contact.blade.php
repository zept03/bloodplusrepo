@extends('landing.master')
@section('title','BloodPlus')

@section('additional_css')
  <link href="{{ asset('landing/css/contactus.css')}}" rel="stylesheet">
@stop

@section('content')

<section id="contactus">
    <div class="containers">  
      <form id="contact" method ="POST" action = "{{url('/sendinquiry')}}">
        <h3>We are  just a message away!</h3>
        <h4>Contact us for custom quote</h4>
          <div class="row">
            <div class="col-md-7 col-md-offset-1">
                {{ csrf_field() }}
                <fieldset>
                    <input  name="name" class="sr-icons" placeholder="Your name" type="text" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input  name="email" class="sr-icons" placeholder="Your Email Address" type="email" tabindex="2" required>
                </fieldset>
                <fieldset>
                    <input  name="subject" class="sr-icons" placeholder="Subject (optional)" type="tel" tabindex="3">
                </fieldset>
                <fieldset>
                   <textarea  name="message" class="sr-icons" placeholder="Type your message here...." tabindex="5" required></textarea>
                </fieldset>
                <fieldset>
                    <button  class="sr-icons" name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                </fieldset>
           </div>
               <div class="col-md-3 line contactdetails">
                 <p style="color:#111;">
                    <strong class="headlines">
                      <i class="fa fa-map-marker"></i><br> Address
                    </strong>
                        Basak, Cebu City, Philippines
                  </p>
                  <p style="color:#111;">
                    <strong class="headlines">
                        <i class="fa fa-phone"></i><br> Phone Number
                    </strong>+63 955 097 1865
                  </p>
                  <p style="color:#111;">
                       <strong class="headlines">
                              <i class="fa fa-envelope"></i> <br> Email Address
                        </strong>bloodplusph@gmail.com
                  </p>
                  <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                  <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                  <a href="#" class="google"><i class="fa fa-instagram"></i></a>
               </div>
        </div>
      </form>
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