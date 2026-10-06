# Status

## In main

| PR | What |
|---|---|
| — | Initial commit: README, .gitignore |
| #1 | Theme scaffold: classic theme base, `theme.json` design tokens (px only), SCSS build with `@wordpress/scripts`, PHPCS / stylelint / eslint, CI, docs |

## Plan

Every step is a separate PR. ✅ done, ⏭ next.

### Development

1. ✅ **Scaffold** — classic theme base, design tokens, SCSS build, linters, CI (#1)
2. ⏭ **Header and footer** — menus, mobile navigation, newsletter block, contacts and social links from an options page
3. **Content model** — `author` post type, category icons, post → author relationship, field groups in `acf-json`
4. **Block infrastructure** — field-based blocks with `block.json`, auto-registration, per-block styles
5. **Shared components** — post, category and author cards, buttons, section headings, pagination
6. **Templates** — single post, blog, category, author, page, 404, search
7. **Home page blocks** — hero, featured posts, categories, authors, logos, testimonials slider, call to action
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
