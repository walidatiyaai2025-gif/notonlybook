# NotOnlyBook Modern WordPress Theme

A custom WordPress theme product family originating from **notonlybook.com**, designed around the existing educational-resource database and its IGCSE/Cambridge taxonomy.

## Product family and worker routing

This repository is governed as a **Product Family** with two owner-declared active variants:

- `NOTONLYBOOK` — primary product variant.
- `ARABIASWONDERS` — client variant derived from the same family.

Workers must not guess which variant a request belongs to. Before implementation, read `AGENTS.md` and `.pcc/project-family.json` and obtain an authoritative routing packet from `walidatiyaai2025-gif/project-control-center` identifying `TARGET_SCOPE` and, for client-specific work, `TARGET_VARIANT`.

The physical code/deployment boundary between the variants is currently evidence-driven and must be discovered and recorded; branch names are not authoritative variant identity.

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

1. Obtain the build/package for the intended routed variant; do not use an ambiguous family artifact for production.
2. In WordPress: **Appearance → Themes → Add New → Upload Theme**.
3. Activate the routed theme build.
4. Go to **Appearance → Menus** and assign your main menu to **Primary navigation**.
5. Go to **Appearance → Customize → AdSense placements** only if you want manual ad units.
6. Keep Google Site Kit / AdSense Privacy & messaging configured for consent and account-level integration.
7. Open **Appearance → Content Health** and review content warnings before requesting AdSense review.

## Important monetization note

A theme can make ad placement, navigation, performance and trust pages much safer, but it cannot guarantee AdSense approval. Approval also depends on content originality/value, copyright/licensing, account status, traffic quality and current Google Publisher policies.

See:
- `AGENTS.md`
- `.pcc/project-family.json`
- `docs/ADSENSE-CHECKLIST.md`
- `docs/DATA-AUDIT.md`
