<div class="footer_main">
   <div class="container">
       <div class="col-md-3">
           <div class="foot_col">
               <h6>Coffee</h6>
               <ul>
                <!-- <li><a href="{{ route('training') }}">Training</a></li> -->
                <li><a href="{{ route('plan.tool') }}">Plan Tool</a></li>
                <li><a href="{{ route('plan.tool.new') }}">Plan Tool(New Cafe)</a></li>
                <li><a href="{{ route('plan.request') }}">Plan Tool Solution</a></li>
                @if(!empty($coffee))
                  @foreach($coffee as $cof)
                    <li><a href="{{ route('pages',$cof->slug) }}">{{ $cof->title }}</a></li>
                  @endforeach
                @endif
               </ul>
           </div>
       </div>
       
       <div class="col-md-3">
           <div class="foot_col">
               <h6>Company</h6>
               <ul>
                  <li><a href="{{ route('register.trainee') }}">Register as Trainee</a></li>
                  <li><a href="{{ route('about-us') }}">About Kal Coffee</a></li>
                  <li><a href="{{ route('faq') }}">FAQ</a></li>
               </ul>
           </div>
       </div>
       
       <div class="col-md-3">
           <div class="foot_col">
               <h6>Quick Links</h6>
               <ul>
                  @foreach($quickLinks as $quick)
                   <li><a href="{{ route('pages',$quick->slug) }}">{{ $quick->title }}</a></li>
                  @endforeach
               </ul>
           </div>
       </div>
       
       <div class="col-md-3 padd_0">
           <div class="foot_col">
               <div class="footer_info">
                   <p><span>Toll Free</span>   {{ $toll_free }}</p>
                   <p><span>Open</span>    {{ $open }}</p>
                   <p><span>Email</span>    <a href="#">{{ $email }}</a></p>
               </div>
               
               <div class="social_footer">
                   <p><span>Connect</span></p>
                   <a href="http://{{ $facebook }}"><i class="fab fa-facebook-f"></i></a>
                   <a href="http://{{ $twitter }}"><i class="fab fa-twitter"></i></a>
                   <a href="http://{{ $linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                   <a href="http://{{ $google }}"><i class="fab fa-google-plus-g"></i></a>
               </div>
               
           </div>
       </div>
       
       <div class="copyright">
           <p>{{ $copyright }}</p>
       </div>
       
   </div>
</div>