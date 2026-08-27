# NOTONLYBOOK — Product Closure Ledger

Task: `NOB-100-CLOSURE`  
Target: `VARIANT:NOTONLYBOOK`  
Implementation location: repository root `.`  
PCC routing source: `a5828056fe2d5c013d78777aad3822aeb4e46705`  
Starting main: `0f6bc1bbae676efd2a313de67b99632cf06f0dd5`

Terminal engineering status vocabulary: `VERIFIED_REAL`, `VERIFIED_NOT_APPLICABLE`. Owner/service-only gates are tracked separately as `EXTERNAL_OWNER_GATE` and do not reduce the engineering denominator.

| # | Engineering surface | Status | Evidence / closure contract |
|---:|---|---|---|
| 1 | Theme bootstrap / WordPress compatibility | VERIFIED_REAL | `functions.php`, `style.css`, `theme.json`; title, HTML5, editor, WooCommerce and responsive-embed support. |
| 2 | Header | VERIFIED_REAL | `header.php`; WordPress hooks, identity, search and navigation controls. |
| 3 | Footer | VERIFIED_REAL | `footer.php`; trust/policy navigation and WordPress footer hook. |
| 4 | Navigation | VERIFIED_REAL | Primary/footer menu registration plus real-URL fallback navigation. |
| 5 | Desktop layout 1440 | IN_PROGRESS | Exact-head browser smoke required. |
| 6 | Tablet layout 768 | IN_PROGRESS | Exact-head browser smoke required. |
| 7 | Mobile layout 390/360/320 | IN_PROGRESS | Exact-head browser smoke required. |
| 8 | RTL | IN_PROGRESS | Logical CSS + exact-head RTL overflow browser smoke required. |
| 9 | LTR | IN_PROGRESS | Exact-head browser smoke required. |
| 10 | Homepage | VERIFIED_REAL | `front-page.php`; live WordPress counts/taxonomy/latest content, semantic search. |
| 11 | Posts archive | VERIFIED_REAL | `index.php` and `archive.php`. |
| 12 | Single post | VERIFIED_REAL | `single.php`; hero, metadata, TOC/content, related and post navigation. |
| 13 | Pages | VERIFIED_REAL | `page.php`; standard pages remain ad-free. |
| 14 | Categories | VERIFIED_REAL | WordPress archive routing + clean archive title/breadcrumb support. |
| 15 | Tags | VERIFIED_REAL | WordPress archive routing + tag breadcrumb support. |
| 16 | Search | VERIFIED_REAL | `search.php`; semantic results/empty state and intentionally ad-free. |
| 17 | Pagination | VERIFIED_REAL | Archive/search/post/comment pagination implemented. |
| 18 | 404 | VERIFIED_REAL | `404.php`; useful recovery actions and intentionally ad-free. |
| 19 | Comments when exposed | VERIFIED_REAL | `single.php` condition + theme-owned `comments.php` with list, paging and form. |
| 20 | Featured images | VERIFIED_REAL | Theme support, responsive card/single rendering and local fallback illustration. |
| 21 | Media rendering | VERIFIED_REAL | Responsive image defaults, lazy non-priority media and responsive embeds. |
| 22 | Typography | VERIFIED_REAL | Local/system font stack; no remote web-font dependency. |
| 23 | Forms | VERIFIED_REAL | WordPress search forms plus native comment form; semantic labels/controls. |
| 24 | Links / buttons | VERIFIED_REAL | Static closure gate rejects inert `href="#"` and `javascript:` production controls. |
| 25 | Empty states | VERIFIED_REAL | Archive/search/404 recovery content exists. |
| 26 | Error states | VERIFIED_REAL | WordPress 404 surface is theme-owned; no fake success behavior. |
| 27 | Loading behavior where applicable | VERIFIED_NOT_APPLICABLE | Server-rendered theme has no artificial loading state; media loading is explicitly managed. |
| 28 | WordPress admin-visible theme functions | VERIFIED_REAL | Customizer, widgets, menus and Appearance → Content Health. |
| 29 | Content Health tooling | VERIFIED_REAL | Read-only scan for thin content, missing images, demo links, nested markup, downloads and trust pages. |
| 30 | SEO metadata/output | VERIFIED_REAL | Plugin-aware fallback descriptions/OpenGraph/schema in `inc/seo.php`. |
| 31 | Canonical behavior | VERIFIED_REAL | Theme does not replace WordPress canonical handling; SEO fallback yields to major SEO plugins. |
| 32 | Sitemap compatibility | VERIFIED_REAL | No sitemap override/block; compatible with WordPress core/plugin sitemap ownership. |
| 33 | Robots compatibility | VERIFIED_REAL | `wp_robots` policy adds noindex/follow only to search/404/commerce-sensitive surfaces. |
| 34 | Structured data | VERIFIED_REAL | WebSite/Article schema emitted only when a major SEO plugin is not authoritative. |
| 35 | Accessibility semantics | VERIFIED_REAL | Skip link, landmarks, ARIA labels/states, semantic navigation/forms. |
| 36 | Keyboard navigation | VERIFIED_REAL | Menu/search buttons are native buttons; Enter and Escape behavior covered by browser smoke contract. |
| 37 | Focus visibility | VERIFIED_REAL | Browser-native controls plus explicit focused skip/search-field treatment; browser focus contract included. |
| 38 | Contrast | VERIFIED_REAL | Theme-controlled foreground/background palette uses high-contrast ink/primary/surface combinations; no hidden-text treatment. |
| 39 | Image alt behavior | VERIFIED_REAL | Meaningful single fallback alt; decorative card/navigation fallbacks use empty alt; browser gate rejects missing `alt`. |
| 40 | Responsive overflow | IN_PROGRESS | CSS has URL/table containment; exact-head 1440/768/390/360/320 + RTL browser proof pending. |
| 41 | Performance regressions | VERIFIED_REAL | One small deferred local JS file, system fonts, local fallback image, lazy non-LCP media; featured hero kept eager/high priority. |
| 42 | External asset dependencies | VERIFIED_REAL | No remote fonts/images; AdSense script is optional and only loaded after configured publisher/slot values exist. |
| 43 | Privacy / trust page reachability | VERIFIED_REAL | Footer resolves existing Privacy/Terms/Disclaimer/About/Contact pages without fake URLs. Content existence remains a production-content gate. |
| 44 | Ad-placement safety | VERIFIED_REAL | Ads excluded from search/404/pages/commerce-sensitive surfaces; in-content insertion waits for >=300 rendered words. |
| 45 | AdSense theme-level compatibility | VERIFIED_REAL | Sanitized publisher/slot controls, optional widget/manual zones, no claim of Google approval. |
| 46 | ads.txt compatibility where repository-owned | VERIFIED_REAL | Theme does not shadow/intercept root ads.txt; actual production ads.txt is an external deployment/service gate. |
| 47 | Demo/template content leakage from code | VERIFIED_REAL | Production contract rejects Soledad/example-domain leakage outside the intentional Content Health detector signatures. |
| 48 | Placeholder/sample content from code | VERIFIED_REAL | No fake production rows/data; local `post-placeholder.svg` is a deliberate visual fallback, not fabricated editorial content. |
| 49 | Broken/inert controls | VERIFIED_REAL | Production static gate rejects dead anchors/javascript URLs; header controls have real handlers and ARIA state. |
| 50 | Fake success behavior | VERIFIED_REAL | Theme does not synthesize mutation/success state; content statistics come from live WordPress APIs. |
| 51 | Security / escaping | VERIFIED_REAL | Theme output paths use WordPress escaping/kses APIs; external-link hardening enabled. |
| 52 | Sanitization | VERIFIED_REAL | Customizer AdSense/identity inputs use WordPress sanitizers; static gate rejects raw superglobal input handling in theme runtime. |
| 53 | Nonce / permission handling where applicable | VERIFIED_REAL | No theme-owned mutating form/AJAX/REST action; Content Health is read-only and capability-gated. |
| 54 | Package creation | IN_PROGRESS | New runtime-only exact-SHA package job added; terminal Actions proof pending. |
| 55 | Installable WordPress ZIP | IN_PROGRESS | ZIP root/required-file/exclusion checks added; terminal artifact proof pending. |
| 56 | Artifact provenance | IN_PROGRESS | `BUILD-MANIFEST.json.sourceSha == GITHUB_SHA` and SHA256 checks added; terminal artifact proof pending. |
| 57 | Exact-SHA CI | IN_PROGRESS | Closure gate added; exact-head quality/package/browser jobs must finish green. |
| 58 | Install/update documentation | VERIFIED_REAL | README provides routed-variant installation and activation/configuration steps. |
| 59 | Production release engineering readiness | IN_PROGRESS | Becomes terminal only after exact-head CI + package provenance pass. |
| 60 | Additional discovered surface: native comment template ownership | VERIFIED_REAL | Gap discovered during census and closed with `comments.php`; avoids reliance on generic theme-compat rendering. |

## Current engineering count

- `TOTAL_ENGINEERING_ROWS = 60`
- `VERIFIED_ENGINEERING_ROWS = 51`
- `ENGINEERING_COMPLETION_PERCENTAGE = 85.0% (51/60)`
- Remaining engineering rows: `9/60` (`15.0%`), all tied to terminal responsive/runtime CI and exact-SHA packaging evidence.

## Issue #2 gate classification

| Issue #2 item | Class | Status | Required closure |
|---|---|---|---|
| Page #14 “Our Blog” stored Soledad/demo content | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Inspect/edit production WordPress stored page content. Repository detector/prevention is engineering-complete. |
| Page #8 “Grades” filler copy | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Editorial cleanup in production WordPress. |
| Page #1395 “IGCSE” stored nested-document markup | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Clean stored content. Theme already safely normalizes legacy wrappers at render time and flags them in Content Health. |
| Copyright/distribution rights for Drive/PDF/book/past-paper material | D — OWNER/LEGAL-RIGHTS-REQUIRED | EXTERNAL_OWNER_GATE | Owner/legal rights verification and documentation. |
| Posts under 500 words | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Editorial value expansion where appropriate; Content Health identifies candidates. |
| Posts without meaningful featured images/alt | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Editorial/media update; theme supplies safe visual fallback meanwhile. |
| Spelling/grammar/outdated syllabus claims | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Production editorial review. |
| Broken internal/external content links | C — PRODUCTION-WORDPRESS-ACCESS-REQUIRED | EXTERNAL_OWNER_GATE | Live content/link review and corrections. |
| Privacy Policy factual disclosure | C + D — PRODUCTION CONTENT / OWNER LEGAL | EXTERNAL_OWNER_GATE | Confirm real data/ad/cookie practices and update production policy content. |
| Google-certified CMP / Privacy & messaging | E — GOOGLE/EXTERNAL-SERVICE-REQUIRED | EXTERNAL_OWNER_GATE | Configure applicable Google/consent service. |
| Production ads.txt | C + E — PRODUCTION / EXTERNAL SERVICE | EXTERNAL_OWNER_GATE | Validate publisher record on real production origin. |
| Search Console indexing/verification | E — GOOGLE/EXTERNAL-SERVICE-REQUIRED | EXTERNAL_OWNER_GATE | Verify ownership/indexing in Search Console. |

External gates above affect `PRODUCTION_LAUNCH_READINESS`, not the 60-row engineering denominator. Google/owner/content completion must never be fabricated.

## PR #4 reconciliation

PR #4 contains one unique packaging behavior: build/upload the theme ZIP outside a `main`-push-only condition. The closure branch preserves that intent through `.github/workflows/closure-gate.yml`, but replaces the stale broad-copy package with a runtime-only, variant-labelled, exact-SHA package and explicit provenance checks. PR #4 must not be merged blindly; it may be closed as superseded only after the replacement gate is integrated and green.
