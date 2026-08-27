<?php
/** Static production contract checks for VARIANT:NOTONLYBOOK. */
declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];
$passed = 0;
$assert = static function (bool $ok, string $message) use (&$failures, &$passed): void {
    if ($ok) { $passed++; return; }
    $failures[] = $message;
};
$read = static function (string $path) use ($root): string {
    $value = file_get_contents($root . '/' . $path);
    return false === $value ? '' : $value;
};

$required = [
    'style.css','functions.php','header.php','footer.php','front-page.php','index.php','archive.php',
    'single.php','page.php','search.php','404.php','comments.php','sidebar.php','theme.json',
    'assets/js/theme.js','assets/images/post-placeholder.svg','inc/adsense.php','inc/content-compat.php',
    'inc/content-health.php','inc/seo.php','inc/template-tags.php','template-parts/content-card.php',
];
foreach ($required as $path) $assert(is_file($root . '/' . $path), "runtime file exists: {$path}");

$style = $read('style.css');
$functions = $read('functions.php');
$header = $read('header.php');
$footer = $read('footer.php');
$front = $read('front-page.php');
$single = $read('single.php');
$sidebar = $read('sidebar.php');
$comments = $read('comments.php');
$adsense = $read('inc/adsense.php');
$seo = $read('inc/seo.php');
$compat = $read('inc/content-compat.php');
$health = $read('inc/content-health.php');
$js = $read('assets/js/theme.js');
$themeJson = $read('theme.json');

$contracts = [
    [str_contains($style, 'Theme Name: NotOnlyBook Modern'), 'NOTONLYBOOK theme identity'],
    [str_contains($style, 'Text Domain: notonlybook-modern'), 'theme text domain'],
    [str_contains($style, 'rtl-language-support'), 'declared RTL support'],
    [!preg_match('/fonts\.(googleapis|gstatic)\.com/i', $style . $functions . $themeJson), 'no remote web font'],
    [str_contains($functions, "add_theme_support( 'title-tag' )"), 'title-tag support'],
    [str_contains($functions, "add_theme_support( 'post-thumbnails' )"), 'featured image support'],
    [str_contains($functions, "add_theme_support( 'responsive-embeds' )"), 'responsive embeds'],
    [str_contains($functions, 'register_nav_menus'), 'registered menus'],
    [str_contains($functions, 'nob_fallback_menu'), 'fallback navigation'],
    [str_contains($functions, 'nob_add_automatic_toc'), 'automatic TOC'],
    [str_contains($functions, 'nob_insert_incontent_ads'), 'in-content ad engine'],
    [str_contains($functions, '$cumulative_words < 300'), '300-word ad safety threshold'],
    [str_contains($header, 'wp_body_open()'), 'wp_body_open'],
    [str_contains($header, 'href="#main"'), 'skip link'],
    [str_contains($header, 'aria-controls="nob-mobile-panel"'), 'mobile nav disclosure contract'],
    [str_contains($header, 'aria-controls="nob-header-search"'), 'search disclosure contract'],
    [str_contains($js, "event.key==='Escape'"), 'Escape keyboard handling'],
    [str_contains($js, 'field.focus()'), 'search focus transfer'],
    [str_contains($footer, 'nob_legal_links()'), 'footer trust links'],
    [str_contains($front, 'role="search"'), 'semantic homepage search'],
    [str_contains($front, 'wp_count_posts'), 'real WordPress homepage statistics'],
    [str_contains($single, 'comments_template()'), 'comments exposed intentionally'],
    [str_contains($sidebar, 'min-width:0;max-width:100%'), 'responsive sidebar may shrink below intrinsic widget width'],
    [str_contains($comments, 'wp_list_comments'), 'theme-owned comment list'],
    [str_contains($comments, 'comment_form'), 'theme-owned comment form'],
    [str_contains($comments, 'the_comments_pagination'), 'comment pagination'],
    [str_contains($adsense, 'nob_sanitize_adsense_client'), 'AdSense client sanitization'],
    [str_contains($adsense, 'nob_sanitize_ad_slot'), 'AdSense slot sanitization'],
    [str_contains($adsense, 'is_search() || is_404()'), 'search/404 ad exclusion'],
    [str_contains($adsense, 'is_cart() || is_checkout() || is_account_page()'), 'commerce ad exclusion'],
    [str_contains($seo, 'nob_has_seo_plugin'), 'SEO plugin authority compatibility'],
    [str_contains($seo, "'@context' => 'https://schema.org'"), 'schema.org structured data'],
    [str_contains($compat, "add_filter( 'wp_robots'"), 'robots policy'],
    [str_contains($compat, 'noopener noreferrer'), 'external-link opener protection'],
    [str_contains($health, 'current_user_can'), 'Content Health capability check'],
    [str_contains($health, 'Read-only checks'), 'Content Health non-mutating contract'],
    [str_contains($health, 'demo_links'), 'demo-link detection'],
    [str_contains($health, 'nested_document'), 'nested-document detection'],
    [str_contains($health, 'downloads'), 'download/licensing review detection'],
    [str_contains($style, 'overflow-wrap:anywhere'), 'long URL overflow containment'],
    [str_contains($style, 'overflow-x:auto'), 'table overflow containment'],
    [str_contains($style, '.screen-reader-text:focus'), 'focused skip link visibility'],
    [str_contains($style, ':focus'), 'explicit focus styling'],
    [!str_contains($header, 'href="#"'), 'header has no literal dead anchor'],
    [!str_contains($front, 'href="#"'), 'homepage has no literal dead anchor'],
    [!str_contains($single, 'href="#"'), 'single post has no literal dead anchor'],
];
foreach ($contracts as [$ok, $message]) $assert((bool)$ok, $message);

$runtime = [];
foreach (['*.php','inc/*.php','template-parts/*.php','assets/js/*.js','style.css','assets/images/*.svg'] as $glob) {
    foreach (glob($root . '/' . $glob) ?: [] as $file) if (is_file($file)) $runtime[] = $file;
}
$runtime = array_values(array_unique($runtime));
$forbidden = [
    '/javascript\s*:/i' => 'javascript: URL',
    '/href\s*=\s*(["\x27])#\1/i' => 'literal dead href',
    '/\b(var_dump|print_r)\s*\(/i' => 'PHP debug output',
    '/console\.log\s*\(/i' => 'JavaScript debug output',
    '/\b(TODO|FIXME)\b/' => 'unresolved TODO/FIXME',
    '/\bNotImplemented\b/i' => 'NotImplemented residue',
    '/\bARABIASWONDERS\b/i' => 'cross-variant ARABIASWONDERS residue',
    '/\bwp_redirect\s*\(/i' => 'unsafe WordPress redirect primitive',
    '/header\s*\(\s*["\x27]Location\s*:/i' => 'raw Location redirect',
];
$rawInputs = ['/\$_GET\s*\[/','/\$_POST\s*\[/','/\$_REQUEST\s*\[/','/\$_COOKIE\s*\[/','/\$_FILES\s*\[/'];
foreach ($runtime as $file) {
    $relative = ltrim(str_replace($root, '', $file), '/');
    $content = file_get_contents($file) ?: '';
    foreach ($forbidden as $pattern => $label) $assert(!preg_match($pattern, $content), "{$relative}: no {$label}");
    foreach ($rawInputs as $pattern) $assert(!preg_match($pattern, $content), "{$relative}: no raw superglobal input handling");
    if ('inc/content-health.php' !== $relative) {
        $assert(!preg_match('/demosoledad\.pencidesign\.net|\bexample\.com\b/i', $content), "{$relative}: no demo/example domain leakage");
    }
}

printf("NOTONLYBOOK theme contract: %d passed, %d failed\n", $passed, count($failures));
if ($failures) {
    foreach ($failures as $failure) fwrite(STDERR, "FAIL: {$failure}\n");
    exit(1);
}
