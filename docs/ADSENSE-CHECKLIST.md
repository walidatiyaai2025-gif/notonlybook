# AdSense readiness checklist

The theme is designed to reduce common layout/implementation risks, but AdSense approval cannot be guaranteed by a theme.

## Implemented in the theme

- No ad units in menus or next to navigation controls.
- No automatic ads on search, 404, cart, checkout, account or standard/legal pages.
- Manual units render only when a valid `ca-pub-*` client and slot IDs are explicitly configured.
- Three restrained manual placements only: homepage mid-content, article end, article sidebar.
- Responsive ad containers and stable surrounding layout.
- Visible `Advertisement` label.
- Privacy/terms/disclaimer/about/contact links are surfaced in the footer when those pages exist.
- Readable content-first article layout with ads separated from download CTAs.
- Mobile-first responsive layout and accessibility controls.
- No external web fonts required by the theme.

## WordPress / AdSense setup still required

1. Connect the domain in AdSense / Site Kit.
2. Verify the correct publisher ID.
3. Keep `ads.txt` valid and reachable.
4. Configure **Privacy & messaging** / a Google-certified CMP for applicable EEA, UK and Switzerland traffic.
5. Make sure the privacy policy accurately discloses Google advertising/cookie/data use.
6. Confirm ad density remains lower than publisher content.
7. Review every download for copyright/licensing rights.
8. Remove copied/demo/filler pages and add original educational value.
9. Test Core Web Vitals and mobile rendering on the production host.
10. Check Search Console indexing, broken links and crawl errors before requesting review.

## Recommended launch approach

Start with Site Kit / Auto ads or one or two manual placements, review real mobile/desktop pages, and expand only if content remains clearly dominant. Do not place ads immediately beside Download, Previous/Next, menu controls, game controls or other high-interaction UI.
