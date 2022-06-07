<?php namespace Modules\Marketing\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
	public function index()
	{
	    
	   // echo "Hello";
		return view('\Modules\Marketing\Views\Template\pages\index');
	}

	public function index2()
	{
		return view('Template/pages/index2');
	}

	public function index3()
	{
		return view('Template/pages/index3');
	}

	public function index4()
	{

		return view('Template/pages/index4');
	}

	public function index5()
	{

		return view('Template/pages/index5');
	}

	public function error400()
	{

		return view('Template/pages/error400');
	}

	public function error401()
	{
		
		return view('Template/pages/error401');
	}

	public function error403()
	{

		return view('Template/pages/error403');
	}

	public function error404()
	{

		return view('Template/pages/error404');
	}

	public function error500()
	{

		return view('Template/pages/error500');
	}

	public function error503()
	{

		return view('Template/pages/error503');
	}

	public function accordion()
	
	{

		return view('Template/pages/accordion');
	}

	public function advanced_forms() {

		return view('Template/pages/advanced-forms');
	}

	public function alerts()
	{

		return view('Template/pages/alerts');
	}

	public function avatars()
	{

		return view('Template/pages/avatars');
	}

	public function badge()
	{

		return view('Template/pages/badge');
	}

	public function blog()
	{

		return view('Template/pages/blog');
	}

	public function blog_2()
	{

		return view('Template/pages/blog-2');
	}

	public function blog_3()
	{

		return view('Template/pages/blog-3');
	}

	public function breadcrumbs()
	{

		return view('Template/pages/breadcrumbs');
	}

	public function blog_styles()
	{

		return view('Template/pages/blog-styles');
	}

	public function buttons()
	{

		return view('Template/pages/buttons');
	}

	public function calendar()
	{

		return view('Template/pages/calendar');
	}

	public function cards()
	{

		return view('Template/pages/cards');
	}

	public function cards_image()
	{

		return view('Template/pages/cards-image');
	}

	public function carousel()
	{

		return view('Template/pages/carousel');
	}

	public function cart()
	{

		return view('Template/pages/cart');
	}

	public function chart_apex() {

		return view('Template/pages/chart-apex');
	}

	public function chart_c3() {

		return view('Template/pages/chart-c3');
	}

	public function chart_chartist() {

		return view('Template/pages/chart-chartist');
	}

	public function chart_echart() {

		return view('Template/pages/chart-echart');
	}

	public function chart_flot() {

		return view('pages/chart-flot');
	}

	public function chart_morris() {

		return view('pages/chart-morris');
	}

	public function chart_peity() {

		return view('pages/chart-peity');
	}

	public function chat() {

		return view('pages/chat');
	}

	public function chat2() {

		return view('pages/chat2');
	}

	public function chat3() {

		return view('pages/chat3');
	}

	public function coming() {

		return view('pages/coming');
	}

	public function construction() {

		return view('pages/construction');
	}

	public function contact_list() {

		return view('pages/contact-list');
	}

	public function contact_list2() {

		return view('pages/contact-list2');
	}

	public function cookies() {

		return view('pages/cookies');
	}

	public function counters() {

		return view('pages/counters');
	}

	public function datatable() {

		return view('pages/datatable');
	}

	public function dragula() {

		return view('pages/dragula');
	}

	public function dropdown() {

		return view('pages/dropdown');
	}

	public function editprofile() {

		return view('pages/editprofile');
	}

	public function element_colors() {

		return view('pages/element-colors');
	}

	public function element_flex() {

		return view('pages/element-flex');
	}

	public function element_height() {

		return view('pages/element-height');
	}

	public function elements_border() {

		return view('pages/elements-border');
	}

	public function elements_display()
	{

		return view('pages/elements-display');
	}

	public function elements_margin()
	{

		return view('pages/elements-margin');
	}

	public function elements_paddning()
	{

		return view('pages/elements-paddning');
	}

	public function element_typography()
	{

		return view('pages/element-typography');
	}

	public function element_width()
	{

		return view('pages/element-width');
	}

	public function email_compose()
	{

		return view('pages/email-compose');
	}

	public function email_inbox()
	{

		return view('pages/email-inbox');
	}

	public function email_read()
	{

		return view('pages/email-read');
	}

	public function empty()
	{

		return view('pages/empty');
	}

	public function faq()
	{

		return view('pages/faq');
	}

	public function file_manager()
	{

		return view('pages/file-manager');
	}

	public function file_manager_list()
	{

		return view('pages/file-manager-list');
	}

	public function footers()
	{

		return view('pages/footers');
	}

	public function forgot_password_1()
	{

		return view('pages/forgot-password-1');
	}

	public function forgot_password_2()
	{

		return view('pages/forgot-password-2');
	}

	public function forgot_password_3()
	{

		return view('pages/forgot-password-3');
	}

	public function form_elements()
	{

		return view('pages/form-elements');
	}

	public function form_sizes()
	{

		return view('pages/form-sizes');
	}

		public function form_treeview()
	{

		return view('pages/form-treeview');
	}

	public function form_wizard()
	{

		return view('pages/form-wizard');
	}

		public function gallery()
	{

		return view('pages/gallery');
	}

	public function headers()
	{

		return view('pages/headers');
	}

	public function horizontal_dark()
	{

		return view('pages/horizontal-dark');
	}

	public function horizontal_dark_boxed()
	{

		return view('pages/horizontal-dark-boxed');
	}

	public function horizontal_dark_centerlogo()
	{

		return view('pages/horizontal-dark-centerlogo');
	}

	public function horizontal_dark_centerlogo_boxed()
	{

		return view('pages/horizontal-dark-centerlogo-boxed');
	}

	public function horizontal_light()
	{

		return view('pages/horizontal-light');
	}

	public function horizontal_light_boxed()
	{

		return view('pages/horizontal-light-boxed');
	}

	public function horizontal_light_centerlogo()
	{

		return view('pages/horizontal-light-centerlogo');
	}

	public function horizontal_light_centerlogo_boxed()
	{

		return view('pages/horizontal-light-centerlogo-boxed');
	}

	public function icons()
	{

		return view('pages/icons');
	}

	public function icons2()
	{

		return view('pages/icons2');
	}

	public function icons3()
	{

		return view('pages/icons3');
	}

	public function icons4()
	{

		return view('pages/icons4');
	}

	public function icons5()
	{

		return view('pages/icons5');
	}

	public function icons6()
	{

		return view('pages/icons6');
	}

	public function icons7()
	{

		return view('pages/icons7');
	}

	public function icons8()
	{

		return view('pages/icons8');
	}

	public function icons9()
	{

		return view('pages/icons9');
	}

	public function icons10()
	{

		return view('pages/icons10');
	}

	public function icons11()
	{

		return view('pages/icons11');
	}

	public function image_comparison()
	{

		return view('pages/image-comparison');
	}

	public function img_crop()
	{

		return view('pages/img-crop');
	}

	public function invoice_1() {

		return view('pages/invoice-1');
	}

	public function invoice_2() {

		return view('pages/invoice-2');
	}

	public function invoice_3() {

		return view('pages/invoice-3');
	}

	public function invoice_add() {

		return view('pages/invoice-add');
	}

	public function invoice_edit() {

		return view('pages/invoice-edit');
	}

	public function invoice_list() {

		return view('pages/invoice-list');
	}

	public function jumbotron() {

		return view('pages/jumbotron');
	}

	public function list() {

		return view('pages/list');
		
	}

	public function loaders()
	{

		return view('pages/loaders');
	}

	public function lockscreen_1() {

		return view('pages/lockscreen-1');
	}

	public function lockscreen_2() {

		return view('pages/lockscreen-2');
	}

	public function lockscreen_3() {

		return view('pages/lockscreen-3');
	}

	public function login_1() {

		return view('pages/login-1');
	}

	public function login_2() {

		return view('pages/login-2');
	}

	public function login_3() {

		return view('pages/login-3');
	}

	public function maps() {

		return view('pages/maps');
	}

	public function maps2() {

		return view('pages/maps2');
	}

	public function maps3() {

		return view('pages/maps3');
	}

	public function media_object() {

		return view('pages/media-object');
	}
	
	public function modal() {

		return view('pages/modal');
	}

	public function navigation() {

		return view('pages/navigation');
	}

	public function notify() {

		return view('pages/notify');
	}

	public function page_sessiontimeout() {

		return view('pages/page-sessiontimeout');
	}

	public function pagination() {

		return view('pages/pagination');
	}

	public function panels() {

		return view('pages/panels');
	}

	public function popover() {

		return view('pages/popover');
	}


	public function pricing() {

		return view('pages/pricing');
	}

	public function pricing_2() {

		return view('pages/pricing-2');
	}


	public function pricing_3() {

		return view('pages/pricing-3');
	}

	public function profile_1() {

		return view('pages/profile-1');
	}


	public function profile_2() {

		return view('pages/profile-2');
	}

	public function profile_3() {

		return view('pages/profile-3');
	}

	public function progress() {

		return view('pages/progress');
	}

	public function rangeslider() {

		return view('pages/rangeslider');
	}

	public function rating() {

		return view('pages/rating');
	}

	public function register_1() {

		return view('pages/register-1');
	}

	public function register_2() {

		return view('pages/register-2');
	}

	public function register_3() {

		return view('pages/register-3');
	}

	public function reset_password_1() {

		return view('pages/reset-password-1');
	}

	public function reset_password_2() {

		return view('pages/reset-password-2');
	}

	public function reset_password_3() {

		return view('pages/reset-password-3');
	}

	public function search() {

		return view('pages/search');
	}

	public function shop() {

		return view('pages/shop');
	}

	public function shop_des() {

		return view('pages/shop-des');
	}

	public function sidemenu_closed_dark_boxed() {

		return view('pages/sidemenu-closed-dark-boxed');
	}

	public function sidemenu_closed_dark() {

		return view('pages/sidemenu-closed-dark');
	}

	public function sidemenu_closed_light_boxed() {

		return view('pages/sidemenu-closed-light-boxed');
	}

	public function sidemenu_closed_light() {

		return view('pages/sidemenu-closed-light');
	}

	public function sidemenu_hoversubmenu_dark() {

		return view('pages/sidemenu-hoversubmenu-dark');
	}

	public function sidemenu_hoversubmenu_dark_boxed() {

		return view('pages/sidemenu-hoversubmenu-dark-boxed');
	}

	public function sidemenu_hoversubmenu_dark_style1() {

		return view('pages/sidemenu-hoversubmenu-dark-style1');
	}

	public function sidemenu_hoversubmenu_dark_style1_boxed() {

		return view('pages/sidemenu-hoversubmenu-dark-style1-boxed');
	}

	public function sidemenu_hoversubmenu_light() {

		return view('pages/sidemenu-hoversubmenu-light');
	}

	public function sidemenu_hoversubmenu_light_boxed() {

		return view('pages/sidemenu-hoversubmenu-light-boxed');
	}

	public function sidemenu_hoversubmenu_light_style1() {

		return view('pages/sidemenu-hoversubmenu-light-style1');
	}

	public function sidemenu_hoversubmenu_light_style1_boxed() {

		return view('pages/sidemenu-hoversubmenu-light-style1-boxed');
	}

	public function sidemenu_icon_dark() {

		return view('pages/sidemenu-icon-dark');
	}

	public function sidemenu_icon_dark_boxed() {

		return view('pages/sidemenu-icon-dark-boxed');
	}

	public function sidemenu_icon_light() {

		return view('pages/sidemenu-icon-light');
	}

	public function sidemenu_icon_light_boxed() {

		return view('pages/sidemenu-icon-light-boxed');
	}

	public function sidemenu_iconoverlay_dark() {

		return view('pages/sidemenu-iconoverlay-dark');
	}

	public function sidemenu_iconoverlay_dark_boxed() {

		return view('pages/sidemenu-iconoverlay-dark-boxed');
	}

	public function sidemenu_iconoverlay_light() {

		return view('pages/sidemenu-iconoverlay-light');
	}

	public function sidemenu_iconoverlay_light_boxed() {

		return view('pages/sidemenu-iconoverlay-light-boxed');
	}

	public function sidemenu_icontext_dark() {

		return view('pages/sidemenu-icontext-dark');
	}

	public function sidemenu_icontext_dark_boxed() {

		return view('pages/sidemenu-icontext-dark-boxed');
	}

	public function sidemenu_icontext_light() {

		return view('pages/sidemenu-icontext-light');
	}

	public function sidemenu_icontext_light_boxed() {

		return view('pages/sidemenu-icontext-light-boxed');
	}

	public function sidemenu_toggle_dark() {

		return view('pages/sidemenu-toggle-dark');
	}

	public function sidemenu_toggle_dark_boxed() {

		return view('pages/sidemenu-toggle-dark-boxed');
	}

	public function sidemenu_toggle_light() {

		return view('pages/sidemenu-toggle-light');
	}

	public function sidemenu_toggle_light_boxed() {

		return view('pages/sidemenu-toggle-light-boxed');
	}

	public function sweetalert() {

		return view('pages/sweetalert');
	}

	public function tables() {

		return view('pages/tables');
	}

	public function tabs() {

		return view('pages/tabs');
	}

	public function tags() {

		return view('pages/tags');
	}

	public function terms() {

		return view('pages/terms');
	}

	public function time_line() {

		return view('pages/time-line');
	}

	public function todo_list() {

		return view('pages/todo-list');
	}

	public function todo_list2() {

		return view('pages/todo-list2');
	}

	public function todo_list3() {

		return view('pages/todo-list3');
	}

	public function tooltip() {

		return view('pages/tooltip');
	}

	public function users_list_1() {

		return view('pages/users-list-1');
	}

	public function users_list_2() {

		return view('pages/users-list-2');
	}

	public function users_list_3() {

		return view('pages/users-list-3');
	}

	public function users_list_4() {

		return view('pages/users-list-4');
	}

	public function widgets_1() {

		return view('pages/widgets-1');
	}

		public function widgets_2() {

		return view('pages/widgets-2');
	}

	public function wysiwyag() {

		return view('pages/wysiwyag');
	}
}

	//--------------------------------------------------------------------
