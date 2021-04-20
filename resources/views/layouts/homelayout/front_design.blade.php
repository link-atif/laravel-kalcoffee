<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <title>{{ (isset($page_title)) ? $page_title : "" }}</title>
        <!-- Applying Css-->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/calender.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/calendar.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/calendar2.css') }}" rel="stylesheet">
        <!--fonts-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <!--fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link href="{{ asset('css/admin_css/select2.min.css') }}" rel="stylesheet"/>
        <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>

        <!--fonts-->
        <!--css file end-->
    </head>

    <body>
        @if(isset($page) && $page=="home")
    	   @include('layouts.homelayout.main_header')
    	@else
            @include('layouts.homelayout.header')
        @endif
    	@yield('content')
    	
    	@include('layouts.homelayout.front_footer')
        <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/js/quantity-script.js') }}"></script>
        <script src="{{ asset('frontend/js/range-slider.js') }}"></script>
        <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/admin_js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var owl = $("#owl-demo14");
                owl.owlCarousel({
                    itemsCustom: [
                        [0, 1],
                        [450, 1],
                        [600, 1],
                        [700, 1],
                        [1000, 1],
                        [1200, 1],
                        [1400, 1],
                        [1600, 1]
                    ],
                    navigation: true,
                    autoPlay: 4000,
                    rtl: true
                });
            });
        </script>
        <script>
         $('.panel-collapse').on('show.bs.collapse', function () {
            $(this).siblings('.panel-heading').addClass('active');
          });

          $('.panel-collapse').on('hide.bs.collapse', function () {
            $(this).siblings('.panel-heading').removeClass('active');
          });
       </script>
        @yield('script')
    </body>
</html>