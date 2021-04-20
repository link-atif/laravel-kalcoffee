<!--header-->
 	<div class="header_main header_type_2">
        <nav class="navbar navbar-default" role="navigation">
    	  	<div class="container container_relative">
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
		      		</button>
		      		<div class="navbar-brand navbar-brand-centered">
                  		<a href="{{ url('/') }}">
                    		<img src="{{ asset('images/'.$logo) }}" alt="logo">
                  		</a>
                	</div>
		    	</div>
              	<div class="topbar_header">
                  <div class="top_search">
                        <a href="#">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.01376 1.37294C6.18305 -0.457646 3.20344 -0.457646 1.37273 1.37294C-0.457577 3.20392 -0.457577 6.18294 1.37273 8.01392C3.00303 9.64371 5.54213 9.81832 7.37164 8.54568C7.41014 8.72782 7.49824 8.90164 7.63992 9.0433L10.306 11.7092C10.6945 12.0969 11.3224 12.0969 11.7089 11.7092C12.097 11.3211 12.097 10.6933 11.7089 10.3064L9.04281 7.63971C8.90193 7.49923 8.72771 7.41074 8.54555 7.37224C9.81907 5.54245 9.64445 3.00392 8.01376 1.37294ZM7.17202 7.17224C5.80524 8.53893 3.58085 8.53893 2.21447 7.17224C0.848483 5.80555 0.848483 3.58171 2.21447 2.21502C3.58085 0.848724 5.80524 0.848724 7.17202 2.21502C8.5388 3.58171 8.5388 5.80555 7.17202 7.17224Z" fill="#EFEEED" />
                            </svg>
                        </a>
                    </div>
                  	@if(\Auth::id())
                  	<div class="top_register_sec">
                      	<a href="{{ route('logout.user') }}"><span class="signin_ico">
                          <i class="far fa-user"></i>
                          </span>Logout <span>/</span></a>
                      	  @if(\Auth::user()->type == 'trainee')
                            @php $url = url('training_cart');  @endphp
                            <a href="{{ route('my.trainings') }}">My Trainings</a>
                          @else
                            @php $url = url('cart_details');  @endphp
                            <a href="{{ route('my.account') }}">My Account</a>
                          @endif
                  	</div>
                  	@else
                    @php $url = url('cart_details');  @endphp
                  	<div class="top_register_sec">
                      	<a href="{{ route('login.user') }}"><span class="signin_ico">
                          <i class="far fa-user"></i>
                          </span>Login <span>/</span></a>
                      	<a href="{{ route('register.user') }}">Register</a>
                  	</div>
                  	@endif
                  	<div class="cart_top">
                    <a href="{{ $url }}">
                    	<svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.554916 1.3027H2.14566L4.41158 9.49695C4.47631 9.73743 4.69828 9.9039 4.94799 9.9039H11.9122C12.1342 9.9039 12.3284 9.77441 12.4208 9.57095L14.955 3.74433C15.029 3.56862 15.0104 3.3744 14.9087 3.21716C14.807 3.05993 14.6312 2.96745 14.4463 2.96745H6.75147C6.44626 2.96745 6.19655 3.21716 6.19655 3.52237C6.19655 3.82757 6.44626 4.07728 6.75147 4.07728H13.5954L11.5423 8.79407H5.36418L3.09829 0.59982C3.03356 0.359346 2.8116 0.192871 2.56188 0.192871H0.554916C0.249712 0.192871 0 0.442583 0 0.747787C0 1.05299 0.249712 1.3027 0.554916 1.3027Z" fill="#F0F0F0"/>
							<path d="M4.42186 13.8069C5.11551 13.8069 5.67966 13.2427 5.67966 12.5491C5.67966 11.8554 5.11551 11.2913 4.42186 11.2913C3.72822 11.2913 3.16406 11.8554 3.16406 12.549C3.16406 13.2427 3.72822 13.8069 4.42186 13.8069Z" fill="#F0F0F0"/>
							<path d="M12.2827 13.8068C12.3104 13.8068 12.3474 13.8068 12.3752 13.8068C12.7081 13.779 13.0133 13.6311 13.2353 13.3721C13.4572 13.1224 13.559 12.7987 13.5405 12.4565C13.4942 11.7721 12.8931 11.2449 12.1994 11.2912C11.5058 11.3374 10.9879 11.9478 11.0341 12.6322C11.0803 13.2889 11.626 13.8068 12.2827 13.8068Z" fill="#F0F0F0"/>
						</svg>Cart</a>
                  </div>
              </div>
              <div class="clearfix"></div>
              
		    <div class="collapse navbar-collapse" id="navbar-brand-centered">
		      <ul class="nav navbar-nav nav_left">
		        <li><a href="{{ route('products') }}">BUY COFFEE</a></li>
		        <li><a href="{{ route('training') }}">Training</a></li>
		        <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Services & Solution<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="javascript:" data-toggle="modal" data-target="#myModal">Plan Tool </a></li>
                      <li><a href="{{ route('solutions') }}">Solutions Request Form</a></li>
                  </ul>
            </li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="{{ route('about-us') }}">About us</a></li>
		        <li><a href="{{ route('faq') }}">FAQ</a></li>
		        <li><a href="{{ route('contactus') }}">Contact</a></li>		        
		      </ul>
		    </div>
		  </div>
		</nav>
       </div>
       <!--header-->
       <div class="modal fade login_modal_pop" id="myModal" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal">
        <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16.2819 6.52153L11.7462 11.0772L15.9645 15.277L14.4526 16.7956L10.2343 12.5957L5.69863 17.1514L4.29253 15.7515L8.82822 11.1958L4.60991 6.99598L6.12181 5.47742L10.3401 9.67725L14.8758 5.12159L16.2819 6.52153Z" fill="#000"></path>
        </svg>
      </button>
      <div class="modal-body" id="login_form_on_reg">
        <h5>{!! $plantool_popup_text !!}</h5>
        @if(\Auth::id())
            @if(\Auth::user()->type == 'business' && \Auth::user()->entity_age == 'new')
                <a href="{{ route('plan.tool.new') }}" type="button" id="login" class="login_button login_button_cus">CONTINUE</a>
            @elseif(\Auth::user()->type == 'business' && \Auth::user()->entity_age == 'existing')
                <a href="{{ route('plan.tool') }}" type="button" id="login" class="login_button login_button_cus">CONTINUE</a>
            @elseif(\Auth::user()->type == 'trainee')
            <a href="{{ route('register.plantool') }}" type="button" id="login" class="login_button login_button_cus">Register</a>
            @endif
        @else
            <a href="{{ route('register.plantool') }}" type="button" id="login" class="login_button login_button_cus">Register</a>
        @endif
      </div>
    </div>
  </div>
</div>