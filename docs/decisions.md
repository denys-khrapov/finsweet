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

## Header and footer

- **Logo** comes from the media library and is set in Customize → Site Identity (`custom-logo` support), one logo for the header and the footer. Without a logo the site title is shown as text. Administrators may upload SVG (`upload_mimes` filter in `inc/logo.php`); the files are not sanitized, so only trusted SVGs should be uploaded.
- **Subscribe button** in the header is an anchor to the newsletter block in the footer (`#newsletter`).
- **Mobile navigation:** below 1024 px the menu becomes a burger with a full-width panel under the header (`aria-expanded`, Esc closes and returns focus, page scroll locked while open). Without JS the menu stays visible. Footer and newsletter block stack in one column below 1024 px.
- **Site settings** (contacts, social links, newsletter title) live on the SCF options page "Finsweet"; field group in `theme/acf-json/`. An empty social link hides its icon. Social icons are SVG files in `theme/assets/images/`, painted with CSS masks.

## Content model

- **Authors** are a custom post type, not WP users. The post type key is `blog_author` (`author` is reserved by WordPress); the URL base is `/authors/<name>/`, so it does not clash with the core `/author/<user>/` archives. It has no archive page, only single pages.
- **Author fields** (SCF group on `blog_author`): job title and four social links. Photo is the featured image, bio is the content.
- **Post → author** is an SCF relationship field `author` (one `blog_author`, stored as ID), not `post_author`. Helper: `finsweet_get_post_author()`.
- **Category icons** are an SCF image field `icon` on the category term (stored as attachment ID, SVG allowed). Helper: `finsweet_get_category_icon_id()`.
- **"Featured" flag** for posts is not added yet; it comes with the Home blocks step if needed.
- **Testimonials, "Featured in" logos and About stats** are blocks with fields.
- **Contact and newsletter forms** use our own handler with `wp_mail`, no form plugin.

## Blocks

- **Field-based blocks** live in `theme/blocks/<name>/`: `block.json` (name `acf/<name>`, category `finsweet`, `acf.mode: preview`, `acf.renderTemplate: render.php`), `render.php`, `style.scss`. The field group is a separate file in `theme/acf-json/` with the location `block == acf/<name>`.
- **Auto-registration:** `inc/blocks.php` registers every folder with a `block.json` on `acf/init`, so nothing is registered while Secure Custom Fields is inactive and the site keeps working without it. Adding a block does not need changes in PHP or webpack.
- **Block styles:** each `style.scss` is a separate webpack entry built to `assets/build/blocks/style-<name>.css` (wp-scripts adds the `style-` prefix to files named `style.scss`). It is registered as the style handle `finsweet-block-<name>` and set as `style` in `block.json`, so WordPress prints it only on pages that use the block. Shared components (`.button`, `.container`, `.section`) stay in `main.css`.
- **Editor:** `main.css` is loaded in the block editor (`add_editor_style`), so block previews look like the site. In `preview` mode the fields are edited in the sidebar (Block tab) or with the "Switch to Edit" toolbar button.
- **Block field helpers:** `finsweet_block_field()` and `finsweet_block_link()` read the fields of the block being rendered; render files do not call `get_field()` directly.
- **First block:** "Join our team" (Figma `533:2155`): title, text, link button. Page templates come with step 6, until then page content is not printed by `index.php`.

## Known follow-ups

- Newsletter form in the footer is markup only; the handler comes with the forms step.
- `.button` component is minimal (header and footer needs); shared components step extends it. Hover colour of the light header button (`light-grey`) is not in the mockup.
