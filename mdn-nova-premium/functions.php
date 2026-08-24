<?php
if (! defined('ABSPATH')) { exit; }
define('MDN_NOVA_VERSION', '1.0.0');
function mdn_nova_setup() {
    load_theme_textdomain('mdn-nova', get_template_directory() . '/languages');
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('custom-logo', ['height'=>80,'width'=>240,'flex-height'=>true,'flex-width'=>true]);
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('responsive-embeds'); add_theme_support('align-wide'); add_theme_support('editor-styles');
    register_nav_menus(['primary'=>__('القائمة الرئيسية','mdn-nova'),'footer'=>__('قائمة التذييل','mdn-nova')]);
}
add_action('after_setup_theme','mdn_nova_setup');
function mdn_nova_assets(){wp_enqueue_style('mdn-nova-font','https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap',[],null);wp_enqueue_style('mdn-nova-style',get_stylesheet_uri(),[],MDN_NOVA_VERSION);wp_enqueue_script('mdn-nova',get_template_directory_uri().'/assets/js/theme.js',[],MDN_NOVA_VERSION,true);}
add_action('wp_enqueue_scripts','mdn_nova_assets');
function mdn_nova_widgets(){register_sidebar(['name'=>__('الشريط الجانبي','mdn-nova'),'id'=>'sidebar-1','before_widget'=>'<section class="card widget">','after_widget'=>'</section>','before_title'=>'<h3>','after_title'=>'</h3>']);}
add_action('widgets_init','mdn_nova_widgets');
function mdn_nova_customize($wp_customize){
 $wp_customize->add_panel('mdn_nova_home',['title'=>__('إعدادات MDN Nova','mdn-nova'),'priority'=>30]);
 $wp_customize->add_section('mdn_nova_hero',['title'=>__('السلايدر الرئيسي','mdn-nova'),'panel'=>'mdn_nova_home']);
 for($i=1;$i<=3;$i++){foreach(['ar'=>'العربية','en'=>'English'] as $lang=>$language){foreach(['title'=>'عنوان / Title','text'=>'وصف / Description','button'=>'نص الزر / Button'] as $key=>$label){$id="mdn_slide_{$i}_{$key}_{$lang}";$titles=$lang==='ar'?['استضافة أسرع. أعمال أقوى.','بنية تحتية تثق بها','موقعك الاحترافي يبدأ هنا']:['Faster hosting. Stronger business.','Infrastructure you can trust','Your professional website starts here'];$defaults=['title'=>$titles[$i-1],'text'=>$lang==='ar'?'حلول استضافة وتصميم مواقع سريعة وآمنة مع دعم عربي متواصل.':'Fast, secure hosting and web design backed by responsive support.','button'=>$lang==='ar'?'ابدأ الآن':'Get started'];$wp_customize->add_setting($id,['default'=>$defaults[$key],'sanitize_callback'=>'sanitize_text_field']);$wp_customize->add_control($id,['label'=>"{$label} {$i} — {$language}",'section'=>'mdn_nova_hero']);}}$url="mdn_slide_{$i}_url";$wp_customize->add_setting($url,['default'=>'#plans','sanitize_callback'=>'esc_url_raw']);$wp_customize->add_control($url,['label'=>"رابط الزر / Button URL {$i}",'section'=>'mdn_nova_hero']);}
 $wp_customize->add_section('mdn_nova_contact',['title'=>__('بيانات التواصل','mdn-nova'),'panel'=>'mdn_nova_home']);
 foreach(['phone'=>'01027478913','whatsapp'=>'201027478913','email'=>'support@mdn-eg.com'] as $key=>$default){$wp_customize->add_setting("mdn_{$key}",['default'=>$default,'sanitize_callback'=>'sanitize_text_field']);$wp_customize->add_control("mdn_{$key}",['label'=>$key,'section'=>'mdn_nova_contact']);}
}
add_action('customize_register','mdn_nova_customize');
function mdn_nova_mod($key,$default=''){return get_theme_mod($key,$default);} 
function mdn_nova_lang(){if(function_exists('pll_current_language')){$code=pll_current_language('slug');return $code==='en'?'en':'ar';}if(defined('ICL_LANGUAGE_CODE'))return ICL_LANGUAGE_CODE==='en'?'en':'ar';return str_starts_with(determine_locale(),'en')?'en':'ar';}
function mdn_nova_t($ar,$en){return mdn_nova_lang()==='en'?$en:$ar;}
function mdn_nova_language_switcher(){if(function_exists('pll_the_languages')){pll_the_languages(['show_flags'=>0,'show_names'=>1,'dropdown'=>0]);return;}if(has_action('wpml_add_language_selector')){do_action('wpml_add_language_selector');return;}echo '<ul class="language-switcher"><li><span>'.esc_html(mdn_nova_lang()==='en'?'English':'العربية').'</span></li></ul>';}
function mdn_nova_excerpt_length(){return 22;} add_filter('excerpt_length','mdn_nova_excerpt_length');
function mdn_nova_schema(){if(is_admin())return;$data=['@context'=>'https://schema.org','@type'=>'Organization','name'=>get_bloginfo('name'),'url'=>home_url('/'),'logo'=>get_site_icon_url(512),'contactPoint'=>['@type'=>'ContactPoint','telephone'=>mdn_nova_mod('mdn_phone','01027478913'),'contactType'=>'customer support','availableLanguage'=>['Arabic','English']]];echo '<script type="application/ld+json">'.wp_json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';}
add_action('wp_head','mdn_nova_schema',20);
add_filter('document_title_separator',fn()=> '—');
function mdn_nova_english_front_page($template){$english=get_template_directory().'/template-parts/home-en.php';return mdn_nova_lang()==='en'&&is_readable($english)?$english:$template;}
add_filter('frontpage_template','mdn_nova_english_front_page');
