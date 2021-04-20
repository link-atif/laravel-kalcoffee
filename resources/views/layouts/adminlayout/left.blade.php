<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="admin" class="site_title header_logo" style="background-color:#2a3f54; margin-bottom:10px; height:75px;">
                <span class="big_logo">Kal-Coffee</span>
                <span class="small_logo" style="display:none; padding-left:10px"><img src="assets/images/admin/fav.png" /></span>
            </a>
        </div>
        <div class="clearfix"></div>
        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic"><a href="{{ url('dashboard') }}">
                <img src="{{ asset('images/admin/img.jpg') }}" alt="..." class="img-circle profile_img"></a>
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Admin</h2>
            </div>
        </div>
        <!-- /menu prile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>&nbsp;</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="{{ url('admin/contact-us') }}"><i class="fa fa-envelope"></i>Contact Us</a></li>
                    <li><a href="{{ url('admin/requested-solution') }}"><i class="fa fa-envelope"></i>Solutions</a></li>
                    <li><a><i class="fa fa-newspaper-o"></i>Plan Tools<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/plans') }}">Manage Plans Requests</a></li>
                        </ul>
                    </li>
                     <li><a><i class="fa fa-newspaper-o"></i>Orders<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route('view.orders') }}">Orders</a></li>
                            <li><a href="{{ url('admin/requested') }} ">Requested Orders</a></li>
                        </ul>
                    </li>
                   
                    <li><a href="{{ route('view.enrollments') }}"><i class="fa fa-list"></i> Training Enrollments</a></li>
                    <!-- <li><a><i class="fa fa-newspaper-o"></i>News<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-news') }}">Manage News</a></li>
                            <li><a href="{{ url('admin/add-news') }}">Add News</a></li>
                        </ul>
                    </li> -->
                    <li><a><i class="fa fa-newspaper-o"></i>Categories<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-categories') }}">Manage Categories</a></li>
                            <li><a href="{{ url('admin/add-category') }} ">Add Categories</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Coffee Notes<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('/admin/view-coffee-notes') }}">Manage Coffee Notes</a></li>
                            <li><a href="{{ url('/admin/add-coffee-note') }} ">Add Coffee Note</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Processes<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route('view.processes') }}">Manage Processes</a></li>
                            <li><a href="{{ route('add.process') }} ">Add Process</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Varieties<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-varieties') }}">Manage Varieties</a></li>
                            <li><a href="{{ url('admin/add-variety') }} ">Add Variety</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Certifications<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-certificates') }}">Manage Certificates</a></li>
                            <li><a href="{{ url('admin/add-certificate') }} ">Add Certificate</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Products<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-products') }}">Manage Products</a></li>
                            <li><a href="{{ url('admin/add-product') }}">Add Products</a></li>
                            <li><a href="{{ url('admin/') }}">Detail Products</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Training Courses<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route('view.courses') }}">Manage Training</a></li>
                            <li><a href="{{ route('add.course') }} ">Add Training</a></li>
                            <li><a href="{{ route('view.levels') }}">Manage Levels</a></li>
                            <li><a href="{{ route('add.level') }} ">Add Level</a></li>
                            <li><a href="{{ route('view.schedules') }}">Manage Schedules</a></li>
                            <li><a href="{{ route('add.schedule') }} ">Add Schedule</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file"></i> Pages<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-pages') }}">Pages</a></li>
                            <li><a href="{{ url('admin/add-pages') }}">Add Page</a></li>
                        </ul>
                    </li> 
                    <li><a><i class="fa fa-file"></i> Coupons<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('/admin/view-coupons') }}">Coupons</a></li>
                            <li><a href="{{ url('/admin/add-coupons') }}">Add Coupons</a></li>
                        </ul>
                    </li> 
					<li><a><i class="fa fa-image"></i> Slider Images <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-slider') }}">Manage Slider Images</a></li>
                            <li><a href="{{ url('admin/add-slider') }}">Add Slider Images</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-image"></i>FAQ <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-faqs') }}">Manage FAQ</a></li>
                            <li><a href="{{ url('admin/add-faq') }}">Add FAQ</a></li>
                        </ul>
                    </li> 
                    <li><a><i class="fa fa-image"></i>Services<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-services') }}">Manage Services</a></li>
                            <li><a href="{{ route('add.service') }}">Add Service</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-image"></i>Clients<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-clients') }}">Manage Clients</a></li>
                            <li><a href="{{ route('add.client') }}">Add Client</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-newspaper-o"></i>Media<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-media') }}">Manage Media</a></li>
                            <li><a href="{{ url('admin/add-media') }}">Add Media</a></li>
                        </ul>
                    </li>
					<li><a><i class="fa fa-asterisk"></i> Preferences <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route('preferences') }}">Preferences</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-users') }}">Manage Users</a></li>
                            <li><a href="{{ url('/admin/adduser') }}">Add User</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> Trainers <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route('show.trainee') }}">Manage Trainers</a></li>
                            <li><a href="{{ route('view.trainee') }}">Add Trainers</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i>Trainee Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/view-trainee-users') }}">Manage Trainee Users</a></li>
                           <!--  <li><a href="{{ url('admin/addUser') }}">Add User</a></li> -->
                        </ul>
                    </li>
                    <li><a><i class="fa fa-gear"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ url('admin/settings') }}">Change Password</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="admin/login/logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>