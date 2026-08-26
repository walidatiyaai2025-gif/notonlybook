<?php
/**
 * Static production contract checks for the NOTONLYBOOK theme variant.
 * Runs without a WordPress bootstrap so CI can fail fast on packaging,
 * placeholder, security and user-facing template regressions.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];
$passes = [];

$assert = static function (bool $condition, string $message) use (&$failures, &$passes): void {
    if ($condition) {
        $passes[] = $message;
        return;
    }
    $failures[] = $message;
};

$requiredRuntimeFiles = [
    'style.css',
    'functions.php',
    'header.php',
    'footer.php',
    'front-page.php',
    'index.php',
    'archive.php',
    'single.php',
    'page.php',
    'search.php',
    '404.php',
    'comments.php',
    'sidebar.php',
    'theme.json',
    'assets/js/theme.js',
    'assets/images/post-placeholder.svg',
    'inc/adsense.php',
    'inc/content-compat.php',
    'inc/content-health.php',
    'inc/seo.php',
    'inc/template-tags.php',
    'template-parts/content-card.php',
];

foreach ($requiredRuntimeFiles as $path) {
    $assert(is_file($root . '/' . $path), 'runtime file exists: ' . $path);
}

$read = static function (string $path) use ($root): string {
    $content = file_get_contents($root . '/' . $path);
    return $content === false ? '' : $content;
};

$style = $read('style.css');
$functions = $read('functions.php');
$header = $read('header.php');
$footer = $read('footer.php');
$front = $read('front-page.php');
$single = $read('single.php');
$comments = $read('comments.php');
$adsense = $read('inc/adsense.php');
$seo = $read('inc/seo.php');
$contentCompat = $read('inc/content-compat.php');
$contentHealth = $read('inc/content-health.php');
$js = $read('assets/js/theme.js');
$themeJson = $read('theme.json');

$assert(str_contains($style, 'Theme Name: NotOnlyBook Modern'), 'theme identity is NOTONLYBOOK');
$assert(str_contains($style, 'Text Domain: notonlybook-modern'), 'theme text domain declared');
$assert(str_contains($style, 'rtl-language-support'), 'theme declares RTL support');
$assert(!preg_match('/fonts\.(googleapis|gstatic)\.com/i', $style . $functions . $themeJson), 'no remote Google-font dependency');
$assert(str_contains($functions, "add_theme_support( 'title-tag' )"), 'WordPress title-tag support');
$assert(str_contains($functions, "add_theme_support( 'post-thumbnails' )"), 'featured image support');
$assert(str_contains($functions, "add_theme_support( 'responsive-embeds' )"), 'responsive embed support');
$assert(str_contains($functions, 'register_nav_menus'), 'navigation registration');
$assert(str_contains($functions, 'nob_fallback_menu'), 'safe fallback navigation');
$assert(str_contains($functions, 'nob_add_automatic_toc'), 'automatic TOC capability');
$assert(str_contains($functions, 'nob_insert_incontent_ads'), 'in-content ad placement engine');
$assert(str_contains($functions, '$cumulative_words < 300'), 'ads respect 300-word content safety threshold');

$assert(str_contains($header, 'wp_body_open()'), 'wp_body_open hook present');
$assert(str_contains($header, 'href="#main"'), 'skip-to-content link present');
$assert(str_contains($header, 'aria-expanded="false"'), 'menu/search disclosure ARIA state present');
$assert(str_contains($header, 'aria-controls="nob-mobile-panel"'), 'mobile navigation control wired');
$assert(str_contains($header, 'aria-controls="nob-header-search"'), 'search control wired');
$assert(str_contains($js, "event.key==='Escape'"), 'Escape closes disclosure UI');
$assert(str_contains($js, 'field.focus()'), 'opened search receives keyboard focus');

$assert(str_contains($footer, 'nob_legal_links()'), 'footer exposes trust/policy links');
$assert(str_contains($front, 'role="search"'), 'homepage search is semantic');
$assert(str_contains($front, 'wp_count_posts'), 'homepage statistics derive from real WordPress data');
$assert(str_contains($single, 'comments_template()'), 'single post exposes native comments when enabled');
$assert(str_contains($comments, 'wp_list_comments'), 'comments have theme-owned rendering');
$assert(str_contains($comments, 'comment_form'), 'comment form has theme-owned rendering');
$assert(str_contains($comments, 'the_comments_pagination'), 'comment pagination supported');

$assert(str_contains($adsense, 'nob_sanitize_adsense_client'), 'AdSense publisher ID sanitized');
$assert(str_contains($adsense, 'nob_sanitize_ad_slot'), 'AdSense slot ID sanitized');
$assert(str_contains($adsense, 'is_search() || is_404()'), 'ads excluded from search/404');
$assert(str_contains($adsense, 'is_cart() || is_checkout() || is_account_page()'), 'ads excluded from commerce-sensitive screens');
$assert(str_contains($seo, 'nob_has_seo_plugin'), 'SEO output yields to installed SEO plugins');
$assert(str_contains($seo, "'@context' => 'https://schema.org'"), 'structured data uses schema.org');
$assert(str_contains($contentCompat, "add_filter( 'wp_robots'"), 'robots compatibility implemented');
$assert(str_contains($contentCompat, 'noopener noreferrer'), 'external links receive opener protection');
$assert(str_contains($contentHealth, 'current_user_can'), 'Content Health admin surface checks capability');
$assert(str_contains($contentHealth, 'Read-only checks'), 'Content Health is explicitly non-mutating');
$assert(str_contains($contentHealth, 'demo_links'), 'Content Health detects demo/template links');
$assert(str_contains($contentHealth, 'nested_document'), 'Content Health detects nested document markup');
$assert(str_contains($contentHealth, 'downloads'), 'Content Health flags downloadable-material review');

$runtimeGlobs = [
    '*.php',
    'inc/*.php',
    'template-parts/*.php',
    'assets/js/*.js',
];
$runtimeFiles = [];
foreach ($runtimeGlobs as $glob) {
    foreach (glob($root . '/' . $glob) ?: [] as $file) {
        if (is_file($file)) {
            $runtimeFiles[] = $file;
        }
    }
}
$runtimeFiles = array_values(array_unique($runtimeFiles));

$forbiddenPatterns = [
    '/href\s*=\s*["\']#["\']/i' => 'dead href=# control',
    '/javascript\s*:/i' => 'javascript: URL',
    '/demosoledad\.pencidesign\.net/i' => 'Soledad demo domain',
    '/\bexample\.com\b/i' => 'example.com placeholder domain',
    '/\b(var_dump|print_r)\s*\(/i' => 'PHP debug output',
    '/console\.log\s*\(/i' => 'JavaScript debug output',
    '/\b(TODO|FIXME)\b/' => 'unresolved TODO/FIXME marker',
];

foreach ($runtimeFiles as $file) {
    $relative = ltrim(str_replace($root, '', $file), '/');
    $content = file_get_contents($file) ?: '';
    foreach ($forbiddenPatterns as $pattern => $label) {
        if ('inc/content-health.php' === $relative && in_array($label, ['Soledad demo domain', 'example.com placeholder domain'], true)) {
            continue; // These signatures are intentionally used by the read-only detector.
        }
        $assert(!preg_match($pattern, $content), $relative . ': no ' . $label);
    }
}

$directInputPatterns = [
    '/\$_GET\s*\[/',
    '/\$_POST\s*\[/',
    '/\$_REQUEST\s*\[/',
    '/\$_COOKIE\s*\[/',
    '/\$_FILES\s*\[/',
];
foreach ($runtimeFiles as $file) {
    $relative = ltrim(str_replace($root, '', $file), '/');
    $content = file_get_contents($file) ?: '';
    foreach ($directInputPatterns as $pattern) {
        $assert(!preg_match($pattern, $content), $relative . ': no raw superglobal input handling');
    }
}

$assert(!str_contains($front, 'href="#"'), 'homepage has no inert anchor control');
$assert(!str_contains($single, 'href="#"'), 'single post has no inert anchor control');
$assert(!str_contains($header, 'javascript:'), 'header has no javascript URL');
$assert(str_contains($style, 'overflow-wrap:anywhere'), 'long content/URLs have overflow protection');
$assert(str_contains($style, 'overflow-x:auto'), 'tables receive horizontal overflow containment');
$assert(str_contains($style, '.screen-reader-text:focus'), 'skip-link keyboard focus is visible');
$assert(str_contains($style, ':focus'), 'theme contains explicit focus styling');

printf("NOTONLYBOOK theme contract: %d passed, %d failed\n", count($passes), count($failures));
if ($failures !== []) {
    foreach ($failures as $failure) {
        fwrite(STDERR, "FAIL: {$failure}\n");
    }
    exit(1);
}

exit(0);
