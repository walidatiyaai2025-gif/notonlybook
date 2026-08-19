# NotOnlyBook Modern WordPress Theme

A custom WordPress theme for **notonlybook.com**, designed around the existing educational-resource database and its IGCSE/Cambridge taxonomy.

## What this theme changes

- Replaces the legacy Xtra-dependent front end with a standalone classic WordPress theme.
- Uses the existing posts, categories, tags, attachments and menus instead of requiring a new content model.
- Builds a dynamic education portal homepage: search, school-year collections, subject collections and latest resources.
- Adds a clean single-resource template with reading time, breadcrumbs, related content and responsive Gutenberg styling.
- Adds an AdSense-oriented placement system with only three optional manual zones:
  - homepage mid-content
  - article end
  - article sidebar
- Keeps ads out of search, 404, cart, checkout, account and standard pages.
- Adds a read-only **Appearance → Content Health** audit screen.
- Normalizes legacy posts/pages that contain a full HTML document inside `post_content`.
- Provides lightweight SEO/social/schema fallbacks only when Rank Math, AIOSEO or Yoast is not active.
- Includes WooCommerce theme support because the supplied database contains WooCommerce pages/tables.

## Install

1. Download/zip the repository as `notonlybook-modern.zip`.
2. In WordPress: **Appearance → Themes → Add New → Upload Theme**.
3. Activate **NotOnlyBook Modern**.
4. Go to **Appearance → Menus** and assign your main menu to **Primary navigation**.
5. Go to **Appearance → Customize → AdSense placements** only if you want manual ad units.
6. Keep Google Site Kit / AdSense Privacy & messaging configured for consent and account-level integration.
7. Open **Appearance → Content Health** and review content warnings before requesting AdSense review.

## Important monetization note

A theme can make ad placement, navigation, performance and trust pages much safer, but it cannot guarantee AdSense approval. Approval also depends on content originality/value, copyright/licensing, account status, traffic quality and current Google Publisher policies.

See:
- `docs/ADSENSE-CHECKLIST.md`
- `docs/DATA-AUDIT.md`
