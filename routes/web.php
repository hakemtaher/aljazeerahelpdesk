<?php

use Illuminate\Support\Facades\Route;

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

include( 'installer.php' );


Route::group(['namespace' => 'Frontend'], function () {
	Route::get('/', 'HomeController@index')->name('home');
	
	Route::get('/search', 'HomeController@searchResults')->name('search');
	
	Route::get('frequently-asked-questions', 'HomeController@faq')->name('faq');
	
	Route::get('knowledge-bases', 'HomeController@AllCategories')->name('knowledge_bases');
	
	Route::get('knowledge-bases/all-categories', 'HomeController@AllCategories')->name('kb.all-categories');
	
	Route::get('knowledge-bases/{category_id}-{category}', 'HomeController@KnowledgeBasesCategoryDetail')->name('kb.category_detail');
	
	Route::get('knowledge-bases/{category}/{sub_category_id}-{sub_category}', 'HomeController@KnowledgeBaseSubCategory')->name('kb.sub_category_detail');
	
	Route::get('knowledge-base/{article_id}-{article_name}', 'HomeController@KbArticleDetail')->name('kb.article-detail');
	
	Route::post('knowledge-base/{article}/update_helpful', 'HomeController@KbArticleUpdateHelpfull')->name('kb.update_helpful');

	Route::get('language/{locale}', 'HomeController@setLanguage')->name('front.set_language');

	// setLanguage

    // Route::get('/new-request', 'TicketController@createTicket')->name('ticket_new');

});

/**
 * Customer Panel
 */

Route::group(['namespace' => 'CustomerPanel', 'prefix'	 => 'customer'], function () {

	Route::group(['namespace' => 'Auth'], function () {
		// Customer Login
		Route::get('login', 'LoginController@show')->middleware('guest:customer')->name('customer.login');
		Route::get('register', 'RegisterController@show')
		    ->middleware('guest:customer')->name('customer.register');

	    Route::get('/password/forget-password', 'ForgotPasswordController@showLinkRequestForm')->middleware('guest:customer')->name('customer.forget_password');
	    Route::post('/password/forget-password', 'ForgotPasswordController@sendResetLinkEmail')->middleware('guest:customer')->name('customer.send_password');

		Route::get('/password/reset-password/{token}', 'ResetPasswordController@showResetForm')
		    ->middleware('guest:customer')->name('customer.password.reset');
	    Route::post('/password/reset-password','ResetPasswordController@reset')->name('customer.password.update');
	    
		    // ResetPasswordController


		// Register & Login User
		Route::post('/do_login', 'LoginController@authenticate')->name('customer.do_login');
		Route::post('do_register', 'RegisterController@register')->name('customer.do_register');
	    
	    Route::post('/logout', 'LoginController@logout')->name('customer.logout')->middleware('auth:customer');
	});

	// Protected Routes - allows only logged in users
	Route::middleware('auth:customer')->group(function () {
	    
	    Route::get('/', 'TicketController@index')->name('customer.my-account');
	    Route::get('/tickets', 'TicketController@index')->name('customer.tickets');
	    Route::get('/tickets/{status}', 'TicketController@index')->name('customer.tickets.filter');

	    Route::get('new-ticket', 'TicketController@createTicket')->name('customer.ticket_new');
	    Route::post('new-ticket', 'TicketController@submitTicket')->name('customer.ticket_save');
	    Route::get('/tickets/view/{id}', 'TicketController@viewTicket')->name('customer.tickets_view');
	    Route::post('/tickets/{id}/reply', 'TicketController@replyTicket')->name('customer.ticket_reply');

    	Route::get('/tickets/{id}/status/{status}', 'TicketController@updateTicketStatus')->name('customer.ticket_update_status');

	    
	    Route::post('account/profile-image', 'AccountController@updateProfileImage')->name('customer.profile_update_image');

	    Route::get('account/profile', 'AccountController@profile')->name('customer.profile');
	    Route::post('account/profile', 'AccountController@updateProfile')->name('customer.profile_update');
	    
	    Route::get('account/profile-change-password', 'AccountController@changePassword')->name('customer.profile_change_password');
	    Route::post('account/profile-change-password', 'AccountController@updatePassword')->name('customer.profile_update_password');







	});

});

Route::group(['namespace' => 'Admin', 'prefix'	 => 'admin'], function () {

	Auth::routes([
		'register'	=>	false
	]);

	
	Route::group(['middleware' => 'auth:web'], function () {

		Route::get('/', 'HomeController@index');
		
		Route::get('/home', 'HomeController@index')->name('dashboard');

		Route::resource('users', 'UserController');
		Route::resource('customers', 'CustomerController');
		Route::resource('faqs', 'FaqController');
		Route::resource('faq-category', 'FaqCategoryController');
		Route::resource('knowledge_bases', 'KnowledgeBaseController');
		Route::resource('kb_categories', 'KbCategoryController');
		
		Route::get('canned_messages/show-json', ['as' => 'canned_messages.json_data', 'uses' => 'CannedMessageController@ajaxDetailData']);
		Route::resource('canned_messages', 'CannedMessageController');
		
		Route::get('kb_sub_categories/json-data/{parent}', ['as' => 'kb_sub_categories.json_data', 'uses' => 'KbSubCategoryController@ajaxData']);
		
		Route::resource('kb_sub_categories', 'KbSubCategoryController');
		Route::resource('departments', 'DepartmentController');
		Route::resource('priorities', 'PriorityController');
		
		Route::post('tickets/reply/{ticket}', ['as' => 'tickets.add_reply', 'uses' => 'TicketController@addReply']);
		Route::get('tickets/close-ticket/{ticket}', ['as' => 'tickets.close_ticket', 'uses' => 'TicketController@closeTicket']);
		Route::get('tickets/reopen-ticket/{ticket}', ['as' => 'tickets.reopen_ticket', 'uses' => 'TicketController@reOpenTicket']);
		Route::post('tickets/assign-user', ['as' => 'tickets.assign_user', 'uses' => 'TicketController@assignTicket']);

		Route::delete('tickets/destroy-multiple', ['as' => 'tickets.destroy_multiple', 'uses' => 'TicketController@destroyMultiple']);
		Route::resource('tickets', 'TicketController');

		Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
		Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
		Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
		
		Route::post('profile/upload-image', ['as' => 'profile.uplaod_image', 'uses' => 'ProfileController@uploadImage']);

		Route::resource('roles', 'RoleController');
	
		Route::group(['prefix' => 'settings'], function () {
			
			Route::get('general', ['as' => 'settings.general', 'uses' => 'SettingsController@general']);
			Route::post('general', ['as' => 'settings.general.store', 'uses' => 'SettingsController@generalStore']);
			Route::post('general/socialmedia', ['as' => 'settings.general.store_social_media', 'uses' => 'SettingsController@generalSocialMediaStore']);

			Route::get('language', ['as' => 'settings.language', 'uses' => 'SettingsController@language']);
			Route::post('language', ['as' => 'settings.language.store', 'uses' => 'SettingsController@languageStore']);

			Route::get('api', ['as' => 'settings.api', 'uses' => 'SettingsController@api']);
			Route::post('api', ['as' => 'settings.api.store', 'uses' => 'SettingsController@apiStore']);

			Route::get('frontend', ['as' => 'settings.frontend', 'uses' => 'SettingsController@frontend']);
			Route::post('frontend', ['as' => 'settings.frontend.store', 'uses' => 'SettingsController@frontendStore']);
			Route::post('frontend/homepage', ['as' => 'settings.frontend.home.store', 'uses' => 'SettingsController@frontendHomeStore']);

			Route::get('ticket', ['as' => 'settings.ticket', 'uses' => 'SettingsController@ticket']);
			Route::post('ticket', ['as' => 'settings.ticket.store', 'uses' => 'SettingsController@ticketStore']);

			Route::get('email', ['as' => 'settings.email', 'uses' => 'SettingsController@email']);
			Route::post('email', ['as' => 'settings.email.store', 'uses' => 'SettingsController@emailStore']);
			Route::post('email/whentosend', ['as' => 'settings.email.whentosend', 'uses' => 'SettingsController@emailSettingStore']);
			
			Route::post('sendtestmail', ['as' => 'settings.email.sendtestmail', 'uses' => 'SettingsController@sendTestMail']);

			// 
			Route::get('email-templates', ['as' => 'settings.email_templates', 'uses' => 'SettingsController@emailTemplates']);
			Route::get('email-templates/{id}', ['as' => 'settings.email_templates.edit', 'uses' => 'SettingsController@emailTemplateEdit']);
			Route::post('email-templates/{id}', ['as' => 'settings.email_templates.update', 'uses' => 'SettingsController@emailTemplateUpdate']);
			
		
		});

		Route::post('/ckeditor/file-upload', ['as' => 'ckeditor.image-upload', 'uses' => 'CkeditorUploadController@upload_images']);
		

	});

});
