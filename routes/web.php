<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
	'namespace' => 'Frontend',

], function (){
	Route::get('/', 'HomeController@index')->name('/');
	Route::get('contactus', 'HomeController@contactus')->name('contactus');
	Route::get('solutions', 'HomeController@solutions')->name('solutions');
	Route::get('pages/{slug}', 'HomeController@pages')->name('pages');
	Route::any('add_to_cart/{id}','CartController@add_to_cart')->name('add.cart');
	Route::get('cart_details', 'CartController@index')->name('cart.details');
	Route::get('delete_item/{id}', 'CartController@delete_item')->name('delete.item');
	
	Route::any('update_quantity', 'CartController@update_quantity')->name('update.quantity');
	Route::any('order-payment','CartController@payment')->name('order.payment');
	Route::any('order-checkout','CartController@checkout')->name('order.checkout');
	Route::any('order-checkout-saler','CartController@checkoutSaler')->name('saler');

	Route::any('register-user','UsersController@register_user')->name('register.user');
	Route::any('register-trainee','UsersController@register_trainee')->name('register.trainee');
	Route::any('register-palntool','UsersController@register_as_plantool')->name('register.plantool');
	Route::any('login-user','UsersController@login')->name('login.user');
	Route::get('logout-user', 'UsersController@logout')->name('logout.user');
	Route::get('my-account', 'UsersController@dashboard')->name('my.account');
	Route::get('order.detail/{id}', 'UsersController@details')->name('order.detail');
	Route::get('my-trainings', 'UsersController@trainee_dashboard')->name('my.trainings');
	Route::get('get-cities-list', 'UsersController@getCitiesList');
	Route::any('update_user','UsersController@updateUserDetails')->name('update.user');

	Route::match(['get','post'],'checkout-page','CartController@checkout')->name('old-checkout');
	
	Route::post('contact_queries', 'HomeController@contact_queries')->name('contact.queries');
	Route::post('request_solution', 'HomeController@request_solution')->name('request.solution');

	Route::get('faq', 'HomeController@faqs')->name('faq');
	Route::get('about-us', 'HomeController@about_us')->name('about-us');

	Route::get('products', 'ProductsController@index')->name('products');
	Route::get('search', 'ProductsController@search')->name('search');
	Route::get('details/{id}', 'ProductsController@details')->name('product.details');

	Route::get('training', 'TrainingController@index')->name('training');
	Route::get('attendies', 'TrainingController@attendies')->name('attendies.show');
	Route::get('/admin/attendiesDetail/{id}', 'TrainingController@attendiesDetails')->name('attendies.detail');
	Route::get('/admin/search-attenies-user', 'TrainingController@searchAttendies')->name('search.attendies');
	Route::get('/admin/attendiesDetails/{id}', 'TrainingController@attendiesDetail')->name('attendies.detail');

	Route::get('training_cart/{id?}', 'TrainingController@training_cart')->name('training.cart');
	Route::get('delete_training/{id}', 'TrainingController@delete_training')->name('delete.training');
	Route::get('training_details/{id}/{level_id?}', 'TrainingController@training_details')->name('training.details');
	Route::any('payment','TrainingController@payment')->name('training.payment');
	Route::any('checkout','TrainingController@checkout')->name('training.checkout');
	Route::get('calendar_data', 'TrainingController@calendar_data');

	Route::get('plan_tools', 'PlantoolController@index')->name('plan.tool');
	Route::get('plan_tools_new', 'PlantoolController@planToolsNewCafe')->name('plan.tool.new');
	Route::post('plan_solution', 'PlantoolController@planSolution')->name('plan.solution');	
	Route::any('plan_request', 'PlantoolController@planToolsRequest')->name('plan.request');	
	Route::any('bulk_cart','CartController@bulkCart')->name('bulk.cart');

	Route::any('loadmore','ProductsController@loadmore');

	Route::POST('itemquantity','OrderItemRequestedController@store')->name('store.itemquantity');


});

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/
Route::group([
	'namespace' => 'Backend',
], function (){
	Route::match(['get','post'],'/admin', 'AdminController@login');
	Route::get('/logout', 'AdminController@logout');
	Route::group(['middleware'=> ['auth','check.role:admin']], function(){
		Route::get('/admin/dashboard', 'AdminController@dashboard');
		Route::get('/admin/contact-us', 'ContactsController@contact_us');
		Route::get('/admin/requested-solution', 'ContactsController@requested_solution');
		Route::get('/admin/settings', 'AdminController@settings');
		Route::get('/admin/my-profile', 'AdminController@my_profile');
		Route::get('/admin/check-pwd','AdminController@chkPassword');
		Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');
		
		Route::get('view-orders','OrdersController@viewOrders')->name('view.orders');
		Route::get('view-enrollments','OrdersController@viewEnrollments')->name('view.enrollments');
		Route::get('view-details/{id}','OrdersController@viewDetails')->name('view.details');
		Route::post('order-status', 'OrdersController@updateOrderStatus')->name('order.status');
		Route::post('attendence.search', 'OrdersController@searchAttendence')->name('attendence.search');

		Route::post('/admin/order-update', 'OrdersController@updateOrder')->name('order.update');

	

		//Categories
		Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
		Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
		Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
		Route::get('/admin/view-categories','CategoryController@viewCategories');

		//Coffee Notes
		Route::match(['get','post'],'/admin/add-coffee-note','CoffeeNotesController@add');
		Route::match(['get','post'],'/admin/edit-coffee-note/{id}','CoffeeNotesController@edit');
		Route::match(['get','post'],'/admin/delete-coffee-note/{id}','CoffeeNotesController@delete');
		Route::get('/admin/view-coffee-notes','CoffeeNotesController@view');
		Route::post('/admin/load-notes','CoffeeNotesController@loadNotes')->name('loadNotes');

		// Products Routes
		Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
		Route::get('/admin/view-products','ProductsController@viewProducts');
		Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
		Route::match(['get','post'],'/admin/delete-product/{id}','ProductsController@deleteProduct');
		// Slider Routes
		Route::match(['get','post'],'/admin/add-slider','SliderImages@addSlider');
		Route::get('/admin/view-slider','SliderImages@viewSlider');
		Route::match(['get','post'],'/admin/delete-slider/{id}','SliderImages@deleteSlider');
		Route::match(['get','post'],'/admin/edit-slider/{id}','SliderImages@editSlider');
		//Preferences
		//Route::match(['get','post'],'/admin/preferences', 'PreferencesController@add_preferences');
		Route::match(['get','post'],'/admin/preferences', 'PreferencesController@add_preferences')->name('preferences');
		//Subscription
		Route::match(['get','post'],'/admin/subscription', 'SubscriptionsController@subscription');

		//Pages
		Route::match(['get','post'],'/admin/add-pages','PagesController@addPages');
		Route::get('/admin/view-pages','PagesController@viewPages');
		Route::match(['get','post'],'/admin/edit-pages/{id}','PagesController@editPages');
		Route::match(['get','post'],'/admin/delete-pages/{id}','PagesController@deletePages');

		//coupons
		Route::match(['get','post'],'/admin/add-coupons','CouponsController@addCoupons');
		Route::get('/admin/view-coupons','CouponsController@viewCoupons');
		Route::match(['get','post'],'/admin/edit-coupons/{id}','CouponsController@editCoupons');
		Route::match(['get','post'],'/admin/delete-coupons/{id}','CouponsController@deleteCoupons');

		//locations
		Route::match(['get','post'],'/admin/add-location','LocationsController@addLocation');
		Route::get('/admin/view-locations','LocationsController@viewLocations');
		Route::match(['get','post'],'/admin/edit-location/{id}','LocationsController@editLocation');
		Route::match(['get','post'],'/admin/delete-location/{id}','LocationsController@deleteLocation');

		//News
		Route::match(['get','post'],'/admin/add-news','NewsController@addNews');
		Route::get('/admin/view-news','NewsController@viewNews');
		Route::match(['get','post'],'/admin/edit-news/{id}','NewsController@editNews');
		Route::match(['get','post'],'/admin/delete-news/{id}','NewsController@deleteNews');

		//Testimonials
		Route::match(['get','post'],'/admin/add-testimonial','TestimonialsController@addTestimonial');
		Route::get('/admin/view-testimonials','TestimonialsController@viewTestimonials');
		Route::match(['get','post'],'/admin/edit-testimonial/{id}','TestimonialsController@editTestimonial');
		Route::match(['get','post'],'/admin/delete-testimonial/{id}','TestimonialsController@deleteTestimonial');

		//Media
		Route::match(['get','post'],'/admin/add-media','MediaController@addMedia');
		Route::get('/admin/view-media','MediaController@viewMedia');
		Route::match(['get','post'],'/admin/edit-media/{id}','MediaController@editMedia');
		Route::match(['get','post'],'/admin/delete-media/{id}','MediaController@deleteMedia');

		//FAQ
		Route::match(['get','post'],'/admin/add-faq','FaqsController@addFaq');
		Route::get('/admin/view-faqs','FaqsController@viewFaqs');
		Route::match(['get','post'],'/admin/edit-faq/{id}','FaqsController@editFaq');
		Route::match(['get','post'],'/admin/delete-faq/{id}','FaqsController@deleteFaq');

		//Users
		Route::match(['get','post'],'/admin/adduser','UsersController@add');
		Route::match(['get','post'],'/admin/saveuser','UsersController@saveuser');
		Route::get('/admin/view-users','UsersController@viewUsers')->name('view.users');
		Route::match(['get','post'],'/admin/edit-user/{id}','UsersController@editUser');
		Route::match(['get','post'],'/admin/update-user','UsersController@updateUser');
		Route::any('/admin/delete-user/{id}','UsersController@deleteUser');
		Route::get('/admin/search-user', 'UsersController@search')->name('search.user');
		
		//Trainee Users

		Route::get('/admin/view-trainee-users','UsersController@viewTraineeUsers');
		Route::match(['get','post'],'/admin/adduser','UsersController@add');

		Route::any('/admin/edit-trainee-user/{id}','UsersController@editTraineeUser');
		Route::any('/admin/update-trainee-user','UsersController@updateTraineeUser');
		Route::get('/admin/search-trainee-user', 'UsersController@searchTrainee')->name('search.trainee');
		
		//Trainer
		Route::get('/admin/view-trainee','TrainerController@index')->name('view.trainee');
		Route::post('/admin/add-trainee','TrainerController@store')->name('store.trainer');
		Route::get('/admin/details-trainee','TrainerController@show')->name('show.trainee');
		Route::get('/admin/destroy-trainee/{id}','TrainerController@destroy')->name('dell.trainer');
		Route::match(['get','post'],'/admin/edit-trainer/{id}','TrainerController@edit')->name('edit.trainer');
		Route::match(['get','post'],'/admin/update-trainer/{id}','TrainerController@update')->name('update.trainer');

		
		//Trainee Users mail
		//Route::get('/admin/view-mail-users','MailController@basic_email');
        //Route::get('sendhtmlemail','MailController@html_email');

		//services
		Route::match(['get','post'],'/admin/add-service','ServicesController@addService')->name('add.service');
		Route::get('/admin/view-services','ServicesController@viewServices')->name('view.services');
		Route::match(['get','post'],'/admin/edit-service/{id}','ServicesController@editService')->name('edit.service');
		Route::match(['get','post'],'/admin/delete-service/{id}','ServicesController@deleteService')->name('delete.service');

		//Clients
		Route::match(['get','post'],'/admin/add-client','ClientsController@addClient')->name('add.client');
		Route::get('/admin/view-clients','ClientsController@viewClients')->name('view.clients');
		Route::match(['get','post'],'/admin/edit-client/{id}','ClientsController@editClient')->name('edit.client');
		Route::match(['get','post'],'/admin/delete-client/{id}','ClientsController@deleteClient')->name('delete.client');

		//Processes
		Route::match(['get','post'],'/admin/add-process','ProcessesController@addProcess')->name('add.process');
		Route::get('/admin/view-processes','ProcessesController@viewProcesses')->name('view.processes');
		Route::match(['get','post'],'/admin/edit-process/{id}','ProcessesController@editProcess')->name('edit.process');
		Route::match(['get','post'],'/admin/delete-process/{id}','ProcessesController@deleteProcess')->name('delete.process');

		//Varieties
		Route::match(['get','post'],'/admin/add-variety','VarietiesController@addVariety')->name('add.variety');
		Route::get('/admin/view-varieties','VarietiesController@viewVarieties')->name('view.varieties');
		Route::match(['get','post'],'/admin/edit-variety/{id}','VarietiesController@editVariety')->name('edit.variety');
		Route::match(['get','post'],'/admin/delete-variety/{id}','VarietiesController@deleteVariety')->name('delete.variety');

		//Certificates
		Route::match(['get','post'],'/admin/add-certificate','CertificatesController@addCertificate')->name('add.certificate');
		Route::get('/admin/view-certificates','CertificatesController@viewCertificates')->name('view.certificates');
		Route::match(['get','post'],'/admin/edit-certificate/{id}','CertificatesController@editCertificate')->name('edit.certificate');
		Route::match(['get','post'],'/admin/delete-certificate/{id}','CertificatesController@deleteCertificate')->name('delete.certificate');

		//Training
		Route::match(['get','post'],'/admin/add-course','CoursesController@addCourse')->name('add.course');
		Route::get('/admin/view-courses','CoursesController@viewCourses')->name('view.courses');
		Route::get('/admin/view-coursesDetails/{id}','CoursesController@viewCourseDetails')->name('view.coursesDetails');
		Route::match(['get','post'],'/admin/edit-course/{id}','CoursesController@editCourse')->name('edit.course');
		Route::match(['get','post'],'/admin/delete-course/{id}','CoursesController@deleteCourse')->name('delete.course');
		
		//Levels
		Route::match(['get','post'],'/admin/add-level','CoursesController@addLevel')->name('add.level');
		Route::get('/admin/view-levels','CoursesController@viewLevels')->name('view.levels');
		Route::match(['get','post'],'/admin/edit-level/{id}','CoursesController@editLevel')->name('edit.level');
		Route::match(['get','post'],'/admin/delete-level/{id}','CoursesController@deleteLevel')->name('delete.level');
		Route::post('/admin/load-level','CoursesController@loadLevel')->name('loadLevel');

		// Schedule
		Route::match(['get','post'],'/admin/add-schedule','CoursesController@addSchedule')->name('add.schedule');
		Route::get('/admin/view-schedules','CoursesController@viewSchedules')->name('view.schedules');
		Route::match(['get','post'],'/admin/edit-schedule/{id}','CoursesController@editSchedule')->name('edit.schedule');
		Route::match(['get','post'],'/admin/delete-schedule/{id}','CoursesController@deleteSchedule')->name('delete.schedule');
		//mail-schedule

        Route::match(['get','post'],'/admin/add-mail/{id}','MailController@addmail')->name('add.mail');
        Route::match(['get','post'],'/admin/savemail/','MailController@savemail')->name('savemail');
         Route::match(['get','post'],'/admin/viewmail/','MailController@viewmail')->name('viewmail');
		//plans
		Route::post('/admin/load-products','PlantoolController@loadProducts')->name('load.products');
		Route::post('/admin/store','PlantoolController@store')->name('store.plan');
		Route::get('/admin/edit/{id}','PlantoolController@edit')->name('edit.plan');
		Route::put('/admin/update/{id}','PlantoolController@update')->name('update.plan');
		Route::get('/admin/destroy/{id}','PlantoolController@destroy')->name('delete.plan');
    	Route::resource('/admin/plans', 'PlantoolController', ['as' => 'plans']);
    	//orders
		Route::get('/admin/requested','PlantoolController@requested')->name('admin.requested');
		Route::get('/admin/back','PlantoolController@back')->name('admin.back');
		//Route::get('/admin/requested','PlantoolController@requested')->name('requested.delete');
		Route::match(['get','post'],'/admin/delete-reuested/{r_id}','PlantoolController@destroyr')->name('requested.delete');
        Route::match(['get','post'],'/admin/rqeuested-showu/{user_id}','UsersController@detailsShow')->name('requested.showu');
        Route::match(['get','post'],'/admin/rqeuested-showp/{product_name}','ProductsController@detailsShow')->name('requested.showp');
        Route::match(['get','post'],'/admin/invoice-show/{id}','OrderItemRequestedController@index')->name('invoice.show');
        Route::match(['get','post'],'/admin/invoice-approved/{r_id}','OrderItemRequestedController@approved')->name('invoice.approved');
        Route::match(['get','post'],'/admin/user-approved/{id}','OrderItemRequestedController@uApproved')->name('user.approved');
		
        
    	
		

	});
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');