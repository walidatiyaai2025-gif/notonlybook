# Supplied database audit

Source reviewed: `notonlybook_dre.sql` generated 2026-08-19.

## Content model detected

- WordPress table prefix: `fIwjpvT7V_`
- Site URL: `https://notonlybook.com`
- Current theme in the dump: `xtra`
- Permalink structure: `/%postname%/`
- Published posts: **289**
- Draft posts: **73**
- Published pages: **19**
- Attachments: **306**
- Categories: **32**
- Tags: **293**

Notable categories include CAMBRIDGE Year 1–9, IGCSE Subjects, Past Papers, Accounting 0452, Physic-0625, Biology, Chemistry, Math, Worksheets and Topical Past Papers. The new homepage queries these taxonomies directly instead of relying on page-builder data.

## Existing trust pages detected

Privacy, Terms and Conditions, Disclaimer, About Us and Contact Us are present. The theme surfaces available trust pages in the footer.

## Legacy content issues observed

1. The old `Our Blog` page contains demo content/links from a Soledad demo domain.
2. One IGCSE page contains a complete `<!DOCTYPE html><html><head>...` document inside WordPress `post_content`.
3. The Grades page contains placeholder/filler copy.
4. Multiple resources include Google Drive/PDF/download references.
5. The database contains remnants from multiple SEO/ad/page-builder plugins even when they are not active.

## Theme mitigation

- `front-page.php` replaces the legacy static homepage with a dynamic library experience.
- `inc/content-compat.php` strips nested document wrappers from front-end rendering without altering stored content.
- **Appearance → Content Health** reports thin posts, missing featured images, demo links, nested HTML and download references.
- External links receive safer browser attributes at render time.
- The theme does not depend on Xtra/Codevz page-builder output for core navigation or homepage layout.

## Editorial actions still required

Before monetization review, manually verify that every book/paper/download is licensed for distribution; no demo/filler content remains publicly indexable; each article contains meaningful original explanation or curation; spelling/grammar is proofread; important resources have useful featured images and alt text; outdated exam-year/syllabus claims are updated; and broken links are repaired.

The theme deliberately does not rewrite educational claims or licensing statements automatically.
