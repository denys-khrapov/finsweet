# Status

## In main

| PR | What |
|---|---|
| — | Initial commit: README, .gitignore |
| #1 | Theme scaffold: classic theme base, `theme.json` design tokens (px only), SCSS build with `@wordpress/scripts`, PHPCS / stylelint / eslint, CI, docs |
| #2 | Project plan in the status docs |
| #3 | Header and footer: logo from the Customizer, menus, mobile navigation, newsletter block, contacts and social links from the "Finsweet" options page |
| #4 | Content model: `blog_author` post type, category icon, post → author relationship, field groups in `acf-json` |
| #5 | Block infrastructure: auto-registered field-based blocks in `theme/blocks/`, "Finsweet" category, per-block styles, editor preview, first block "Join our team" |
| #6 | Shared components: horizontal and vertical post cards, category card and badge, author card, section heading, stripe, pagination, minimal `page.php` |
| #7 | Templates, part 1: single post, blog page, search, 404, Privacy Policy page template, Join our team partial with fields on the settings page |
| #8 | Templates, part 2: category archive and author page, breadcrumbs, sidebar with categories and tags |
| #9 | Docs for the category and author templates |
| #10 | Home blocks, part 1: hero post, featured and latest posts, categories, authors |

## Plan

Every step is a separate PR. ✅ done, ⏭ next.

### Development

1. ✅ **Scaffold** — classic theme base, design tokens, SCSS build, linters, CI (#1)
2. ✅ **Header and footer** — logo from the Customizer, menus, mobile navigation, newsletter block, contacts and social links from an options page (#3)
3. ✅ **Content model** — `blog_author` post type, category icons, post → author relationship, field groups in `acf-json` (#4)
4. ✅ **Block infrastructure** — field-based blocks with `block.json`, auto-registration, per-block styles (#5)
5. ✅ **Shared components** — post, category and author cards, section headings, stripe, pagination (#6)
6. ✅ **Templates** — single post, blog, search, 404, Privacy Policy (#7); category and author pages (#8)
7. ⏭ **Home page blocks** — hero, featured and latest posts, categories, authors (#10); about and mission, why we started, logos; testimonials slider
8. **About page blocks** — hero, stats, mission and vision, image + text sections, authors grid
9. **Contact form and newsletter** — form handler with validation and spam protection, stored submissions, SMTP
10. **Privacy Policy** template
11. **Final pass** — responsive layout, accessibility, performance, basic SEO

### Deployment

12. **Hosting** — InfinityFree account, PHP 8, MySQL, SSL
13. **WordPress on the server** — Secure Custom Fields, permalinks
14. **Automatic deploy** — GitHub Actions builds the assets and uploads `theme/` over FTP on every merge to `main`
15. **Content** — pages, categories, authors, posts
16. **Launch** — final check on production, README with the live link and screenshots

## How to run

Local site: MAMP, WordPress in `/Applications/MAMP/htdocs/finsweet`, theme symlinked from `theme/`,
http://localhost:8888/finsweet. Full setup steps are in the README.

```bash
npm install
composer install
npm start                # watch src/ and rebuild theme/assets/build/
npm run build            # production build
```

## Checks (same as CI)

```bash
npm run lint:css         # stylelint for src/**/*.scss
npm run lint:js
npm run lint:php         # PHPCS via MAMP PHP + Composer
```

## GitHub

- `main` is protected: PR only, linear history, no force pushes, squash merge only.
- Required checks: **PHP lint**, **SCSS/JS lint and build** (branch must be up to date with `main`).
- PRs open as drafts; merge only after approval.
