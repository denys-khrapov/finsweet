# Decisions

## Stack and infrastructure

- **Classic theme** (`theme/`) with PHP templates (`header.php`, `single.php`, `category.php`, …). Page content is assembled on the site from custom Gutenberg blocks built on SCF; `theme.json` only holds design tokens and editor settings.
- **Secure Custom Fields** (free, wp.org) for fields and blocks. It is a dependency, not part of the repo: installed from wp.org locally and on hosting.
- **Local environment:** MAMP (Apache, MySQL 8, PHP 8.3), no Docker. WordPress lives in `/Applications/MAMP/htdocs/finsweet`, the repo's `theme/` is symlinked to `wp-content/themes/finsweet`.
- **PHP lint:** PHPCS with WordPress Coding Standards. `composer.json` and `.phpcs.xml.dist` live in the repo root, so `theme/` contains only theme files and `vendor/` never ends up in the theme. Locally it runs with MAMP's PHP and Composer (`npm run lint:php`), in CI with `setup-php`.
- **Hosting:** InfinityFree. Deploy via FTP from GitHub Actions after merge to `main` (to be added once there is something to deploy).
- **Git:** `main` is protected — changes only through PRs, linear history, squash merge only; CI checks are required.
- **Styles are written in SCSS.** Sources live in `src/` (repo root), `@wordpress/scripts` (webpack, sass, autoprefixer) compiles them to `theme/assets/build/`. No gulp/vite — the WordPress toolchain already covers it. The build folder is not committed: it is built locally with `npm start` / `npm run build` and in CI before deploy.
- **SCSS helpers** `color()`, `font-size()`, `space()` return the `theme.json` CSS variables, so tokens are defined only once, in `theme.json`. Breakpoint mixins `up()` / `down()` are mobile-first: sm 576, md 768, lg 1024, xl 1280.
- **Fonts** are self-hosted in `theme/assets/fonts` (Sen 700, Inter 400/500, latin subset, OFL), taken from Fontsource.

## Design

- **Responsive layout** is not in the mockup (desktop only); it is designed during development.
- **Body font is Inter** (the Figma variables say Inter, the Style Guide caption says Sen Regular — Inter wins).
- **Units: px and % only, no rem/em.** Fluid sizes use `clamp()` with px and vw.
- Headings and display sizes are fluid between 375 px and 1440 px viewports, body text is fixed. The `clamp()` formulas are written in `theme.json` by hand (`fluid: false`), because WordPress' own fluid typography generates rem.
- Core default font size and spacing presets are removed with the `wp_theme_json_data_default` filter: core prints their CSS variables in rem even when `theme.json` disables them. Core block CSS (e.g. `alignleft` margins) still has a few em values — not ours to change.
- Content width 768 px (articles, forms), wide width 1280 px, side padding 80 px on desktop down to 16 px on mobile.

## Content model

- **Authors** are a custom post type, not WP users.
- **Category icons** are an SCF field on the category term.
- **Testimonials, "Featured in" logos and About stats** are blocks with fields.
- **Contact and newsletter forms** use our own handler with `wp_mail`, no form plugin.

## Known follow-ups

- None yet.
