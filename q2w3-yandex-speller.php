<?php
/*
Plugin Name: Q2W3 Yandex Speller
Plugin URI: http://www.q2w3.ru/2010/02/18/1329/
Description: This plugin enables Russian, Ukrainian and English spelling for standard TinyMCE editor.
Version: 1.1
Author: Max Bond
Author URI: http://www.q2w3.ru/
*/

if (defined('ABSPATH') && defined('WPINC')) {

	register_activation_hook(__FILE__, array('q2w3_yandex_speller', 'activate')); 

	register_deactivation_hook(__FILE__, array('q2w3_yandex_speller', 'de_activate'));

	add_action('init', array('q2w3_yandex_speller','reg_hooks')); // reg plugin actions
	
}



if (class_exists('q2w3_yandex_speller', false)) return;

class q2w3_yandex_speller {
	
	const ID = 'q2w3_yandex_speller'; // plugin ID
	
	const PHP_VER = '5.0'; // minimal php version
	
	const WP_VER = '3.0'; // minimal wp version
	
	
	protected static $plugin_page;
	
	protected static $options;
	
	
	
	public static function activate() {
	
		if (self::php_version_check() && self::wp_version_check()) {
	
			$default_options = array('post_langs'=>array('russian'=>1,'ukrainian'=>1,'english'=>1), 'enable_comment_spelling'=>0, 'comment_langs'=>array('russian'=>1,'ukrainian'=>1,'english'=>1), 'comment_editor_buttons'=>'bold,italic,underline,|,strikethrough,|,bullist,numlist,|,undo,redo,|,link,unlink,|,removeformat');
			
			add_option(self::ID, $default_options, '', 'no');
	
		}
	
	}
	
	public static function php_version_check() {
	
		if (version_compare(phpversion(), self::PHP_VER, '<')) {
    
			deactivate_plugins(plugin_basename(__FILE__));
    
			wp_die('Текущая версия PHP' . ' ('. PHP_VERSION .') ' . ' не поддерживается. Требуется как минимум версия ' . self::PHP_VER);

		} else {
		
			return true;
		
		}
	
	}
	
	public static function wp_version_check() {
	
		global $wp_version;
		
		if (version_compare($wp_version, self::WP_VER, '<')) {
    
			deactivate_plugins(plugin_basename(__FILE__));
    
			wp_die('Текущая версия Wordpress ' . ' ('. $wp_version .') ' . ' не поддерживается. Требуется как минимум версия ' . self::WP_VER);
		
		} else {
		
			return true;
		
		}
	
	}
	
	public static function de_activate() {
	
		delete_option(self::ID);
	
	}
	
	public static function reg_hooks() {
	
		if (is_admin()) { // admin actions

			add_action('admin_menu', array(__CLASS__, 'reg_menu')); // creates admin menu entry

			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array(__CLASS__,'reg_control_links')); // chenge default plugin links
	
			add_action('admin_init', array(__CLASS__,'reg_settings')); // registers settings
			
			add_action('tiny_mce_before_init', array(__CLASS__, 'for_post_edit'), 1, 1);
			
		} else { 
		
			add_action('template_redirect', array(__CLASS__, 'for_comment_edit'));
			
		}

		self::$options = get_option(self::ID);
	
	}
	
	public static function reg_menu() {
	
		$plugin_page = add_options_page('Q2W3 Yandex Speller', 'Q2W3 Yandex Speller', 8, plugin_basename(__FILE__), array(__CLASS__,'settings_page')); // creates menu item under options section
		
		self::$plugin_page = $plugin_page;
		
		add_action('contextual_help_list', array(__CLASS__, 'help'));
				
	}
	
	public static function help($help_content) {
		
		$help_content[self::$plugin_page] = '<a href="http://www.q2w3.ru/2010/02/18/1329/">Домашняя страница плагина</a>';
		
		return $help_content;
		
	}
	
	public static function reg_control_links($links) {
	
		$settings_link = '<a href="options-general.php?page='.plugin_basename(__FILE__).'">'. __('Settings') .'</a>';
		
		array_unshift($links,$settings_link); // before other links
		
		return $links;
	
	}
	
	public static function reg_settings() {
	
		register_setting(self::ID, self::ID);
  	
	}
	
	public static function settings_page() {
	
		require_once('q2w3-yandex-speller-settings.php');
	
	}
	
	public static function post_handler() {
		
		static $res = '';
		
		if (!$res) $res = site_url().'/wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/post-handler.php';
		
		return $res;
		
	}
	
	public static function for_post_edit($mce_settings) {
		
		if (self::$options['post_langs']['russian']) $langs[] = '+Russian=ru';
		
		if (self::$options['post_langs']['ukrainian']) $langs[] = 'Ukrainian=uk';
		
		if (self::$options['post_langs']['english']) $langs[] = 'English=en';
		
		$mce_settings['plugins'] .= ',spellchecker';
		
		$mce_settings['spellchecker_languages'] = implode(',', $langs);
	
		$mce_settings['spellchecker_rpc_url'] = self::post_handler();
		
		$mce_settings['spellchecker_word_separator_chars'] = '\\\s!\"#$%&()*+,-./:;<=>?@[\]^_{|}§©«®±¶·¸»¼½¾¿×÷¤\xa7 \xa9\xab\xae\xb1\xb6\xb7\xb8\xbb\xbc\xbd\xbe\u00bf\xd7\xf7\xa4\u201d\u201c';
			
		return $mce_settings;
		
	}
	
	public static function for_comment_edit() {
		
		if (self::$options['enable_comment_spelling'] && is_singular()) {
	   
			if (comments_open() && (!get_option('comment_registration') || is_user_logged_in())) {
	      
				//wp_enqueue_script('tiny_mce', get_option('siteurl') . '/wp-includes/js/tinymce/wp-tinymce.php?c=1', true, '', true);
	      
	      		//wp_enqueue_script('tiny_mce_lang', get_option('siteurl') . '/wp-includes/js/tinymce/langs/wp-langs-en.js', false, '', true);
	      
				if (get_option('thread_comments')) {
					
					wp_deregister_script('comment-reply');

					wp_enqueue_script( 'comment-reply', get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/js/comment-reply.js', false, '20090102');
				
				}
	      
				add_action('wp_footer', array(__CLASS__,'tiny_mce_for_comment_init'),9999);
			
			}
	
		}
		
	}
	
	public static function tiny_mce_for_comment_init() {
	
		//var_dump($GLOBALS['wp_scripts']);
		
		if (self::$options['comment_langs']['russian']) $langs[] = '+Russian=ru';
		
		if (self::$options['comment_langs']['ukrainian']) $langs[] = 'Ukrainian=uk';
		
		if (self::$options['comment_langs']['english']) $langs[] = 'English=en';
		
		
		$initArray = array (
			'mode' => 'exact',
			'elements' => 'comment',
			'theme' => 'advanced',
			'language' => WPLANG,
			'theme_advanced_buttons1' => self::$options['comment_editor_buttons'] . ',|,spellchecker',
			'theme_advanced_buttons2' => "",
			'theme_advanced_buttons3' => "",
			'theme_advanced_toolbar_location' => "top",
			'theme_advanced_toolbar_align' => "left",
			'theme_advanced_statusbar_location' => "none",
			'theme_advanced_resizing' => "false",
			'theme_advanced_resize_horizontal' => false,
			'theme_advanced_disable' => "code",
			'force_p_newlines' => false,
			'force_br_newlines' => true,
			'forced_root_block' => "p",
			'skin' => "default",
			'content_css' => get_option('siteurl') . '/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/content.css',
			'directionality' => "ltr",
			'save_callback' => "brstonewline",
			'entity_encoding' => "raw",
			'plugins' => "spellchecker",
			'spellchecker_languages' => implode(',', $langs),
			'spellchecker_rpc_url' => self::post_handler(),
			'spellchecker_word_separator_chars' => '\\\s!\"#$%&()*+,-./:;<=>?@[\]^_{|}§©«®±¶·?»??????¤\xa7 \xa9\xab\xae\xb1\xb6\xb7\xb8\xbb\xbc\xbd\xbe\u00bf\xd7\xf7\xa4\u201d\u201c'
		);
		
		$params = array();
	
		foreach ($initArray as $k => $v) {
		
			$params[] = $k . ':"' . $v . '"	';
	
			$res = join(',', $params);
	
		}
	
		?>
<script type="text/javascript">
/* <![CDATA[ */
function brstonewline(element_id, html, body) {
	html = html.replace(/<br\s*\/>/gi, "\n");
	return html;
}
	   
function insertHTML(html) {
	tinyMCE.execCommand("mceInsertContent",false, html);
}
	   
tinyMCEPreInit = {
	  
	base : "<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce",
	suffix : "",
	query : "",
	mceInit : {<?php echo $res ?>},

	load_ext : function(url,lang) {
		var sl = tinymce.ScriptLoader;

		sl.markDone(url + '/langs/wp-langs-en.js');
		sl.markDone(url + '/langs/' + lang + '_dlg.js');
	}
};
      
var subBtn = document.getElementById("submit");
	   
if (subBtn != null) {
	subBtn.onclick=function() {
		var inst = tinyMCE.getInstanceById("comment");
	  document.getElementById("comment").value = inst.getContent();
	  document.getElementById("commentform").submit();
	  return false;
	 }
}
	   
</script>

<script type="text/javascript" src="<?php echo get_option('siteurl')?>/wp-includes/js/tinymce/wp-tinymce.php?c=1"></script>

<script type="text/javascript">
<?php $language = WPLANG; include(ABSPATH . WPINC .'/js/tinymce/langs/wp-langs.php'); echo $lang; ?>

tinyMCEPreInit.go();
tinyMCE.init(tinyMCEPreInit.mceInit);
/* ]]> */
</script>
      
<?php
	}
	
}

?>