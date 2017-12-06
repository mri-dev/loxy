<?php
define('PROTOCOL', 'https');
define('TARGETDOMAIN', 'loxysdoghouse.ideasandbox.eu');
define('DOMAIN', $_SERVER['HTTP_HOST']);
define('IFROOT', str_replace(get_option('siteurl'), '//'.DOMAIN, get_stylesheet_directory_uri()));
define('DEVMODE', true);
define('IMG', IFROOT.'/images');
define('GOOGLE_API_KEY', 'AIzaSyA0Mu8_XYUGo9iXhoenj7HTPBIfS2jDU2E');
define('LANGKEY','hu');
define('FB_APP_ID', '');
define('DEFAULT_LANGUAGE', 'hu_HU');
define('TD', 'ldh');
define('CAPTCHA_SITE_KEY', '6LemSzsUAAAAAMo_zYX4_iZrkJflAmCdXqAnUJFv');
define('CAPTCHA_SECRET_KEY', '6LemSzsUAAAAAB3gw2paRrXodpkS8LsojL73_siW');

// Includes
require_once "includes/include.php";

$app_settings = new Setup_General_Settings();


function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css?' );
    wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?sensor=false&language='.get_locale().'&region=hu&libraries=places&key='.GOOGLE_API_KEY);
    wp_enqueue_script( 'recaptcha', '//www.google.com/recaptcha/api.js');
    wp_enqueue_script('angularjs', '//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js');    
    wp_enqueue_script('ang-colorpicker', IFROOT . '/assets/vendors/angular-colorpicker/js/color-picker.min.js' );
    wp_enqueue_script('szinvalaszto-ang', IFROOT . '/assets/js/szinvalaszto.ang.js?t=' . ( (DEVMODE === true) ? time() : '' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function app_enqueue_styles() {
    wp_enqueue_style( 'app', IFROOT . '/assets/css/style.css?t=' . ( (DEVMODE === true) ? time() : '' ) );
}
add_action( 'wp_enqueue_scripts', 'app_enqueue_styles', 100 );


function add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

function app_locale( $locale )
{
  /*
    $lang = explode('/', $_SERVER['REQUEST_URI']);
    if(array_pop($lang) === 'en'){
      $locale = 'en_US';
    }else{
      $locale = 'gr_GR';
    }*/
    //$locale = 'en_US';

    return $locale;
}

add_filter('locale','app_locale', 10);

function facebook_og_meta_header()
{
  global $wp_query;

  $title = get_option('blogname');
  $image = '';
  $desc  = get_option('blogdescription');
  $url   = get_option('site_url');

  echo '<meta property="fb:app_id" content="'.FB_APP_ID.'"/>'."\n";
  echo '<meta property="og:title" content="' . $title . '"/>'."\n";
  echo '<meta property="og:type" content="article"/>'."\n";
  echo '<meta property="og:url" content="' . $url . '/"/>'."\n";
  echo '<meta property="og:description" content="' . $desc . '/"/>'."\n";
  echo '<meta property="og:site_name" content="'.get_option('blogname').'"/>'."\n";
  echo '<meta property="og:image" content="' . $image . '"/>'."\n";

}
add_action( 'wp_head', 'facebook_og_meta_header', 5);

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/langs';
	load_child_theme_textdomain( 'rd', $lang );

  $ucid = ucid();

  $ucid = $_COOKIE['uid'];
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function ucid()
{
  $ucid = $_COOKIE['ucid'];

  if (!isset($ucid)) {
    $ucid = mt_rand();
    setcookie( 'ucid', $ucid, time() + 60*60*24*365*2, "/");
  }

  return $ucid;
}


function rd_init()
{
  date_default_timezone_set('Europe/Budapest');

  $kutyak = new PostTypeFactory( 'kutyafajtak' );
	$kutyak->set_textdomain( TD );
	$kutyak->set_icon('tag');
	$kutyak->set_name( 'Kutya fajta', 'Kutya fajták' );
	$kutyak->set_labels( array(
		'add_new' => 'Új %s',
		'not_found_in_trash' => 'Nincsenek %s a lomtárban.',
		'not_found' => 'Nincsenek %s a listában.',
		'add_new_item' => 'Új %s létrehozása',
	) );
	//$kutyak->set_metabox_cb('pp_kupon_metaboxes');
	$kutyak->create();
}
add_action('init', 'rd_init');


function rd_query_vars($aVars) {
  return $aVars;
}
add_filter('query_vars', 'rd_query_vars');

/**
* AJAX REQUESTS
*/
function ajax_requests()
{
  $ajax = new AjaxRequests();
  $ajax->contact_form();
  $ajax->szinvalaszto();
}
add_action( 'init', 'ajax_requests' );

// AJAX URL
function get_ajax_url( $function )
{
  return admin_url('admin-ajax.php?action='.$function);
}

function after_logo_content()
{

}
add_filter('avada_logo_append', 'after_logo_content');


/* GOOGLE ANALYTICS */
if( defined('DEVMODE') && DEVMODE === false ) {
	function ga_tracking_code () {
		?>
		<script>


		</script>
		<?
	}
	add_action('wp_footer', 'ga_tracking_code');
}

function memory_convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}


function admpage_szinvalaszto_konfigurator() {
	add_menu_page( 'Ajánlat színválasztó konfigurátor', 'Színválasztó', 'manage_options', 'szinvalaszto_konfigurator', 'szinvalaszto_konfigurator' );
}
add_action( 'admin_menu', 'admpage_szinvalaszto_konfigurator' );

function szinvalaszto_konfigurator() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

  $content = (new ShortcodeTemplates('adminpage_'.__FUNCTION__))->load_template();
  echo $content;
}

function admin_external_scripts( $hook )
{
  if ( $hook != 'toplevel_page_szinvalaszto_konfigurator' ) {
    return;
  }

  wp_enqueue_style('ang-colorpicker', IFROOT . '/assets/vendors/angular-colorpicker/css/color-picker.min.css' );

  wp_enqueue_script('angularjs', '//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js');
  wp_enqueue_script('ang-colorpicker', IFROOT . '/assets/vendors/angular-colorpicker/js/color-picker.min.js' );
  wp_enqueue_script('szinvalaszto-ang', IFROOT . '/assets/js/szinvalaszto.ang.js?t=' . ( (DEVMODE === true) ? time() : '' ) );
}
add_action( 'admin_enqueue_scripts', 'admin_external_scripts' );
