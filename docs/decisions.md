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
- **"Featured in" logos and About stats** are blocks with fields; **testimonials** are a post type (see Home blocks, part 2).
- **Contact and newsletter forms** use our own handler with `wp_mail`, no form plugin.

## Blocks

- **Field-based blocks** live in `theme/blocks/<name>/`: `block.json` (name `acf/<name>`, category `finsweet`, `acf.mode: preview`, `acf.renderTemplate: render.php`), `render.php`, `style.scss`. The field group is a separate file in `theme/acf-json/` with the location `block == acf/<name>`.
- **Auto-registration:** `inc/blocks.php` registers every folder with a `block.json` on `acf/init`, so nothing is registered while Secure Custom Fields is inactive and the site keeps working without it. Adding a block does not need changes in PHP or webpack.
- **Block styles:** each `style.scss` is a separate webpack entry built to `assets/build/blocks/style-<name>.css` (wp-scripts adds the `style-` prefix to files named `style.scss`). It is registered as the style handle `finsweet-block-<name>` and set as `style` in `block.json`, so WordPress prints it only on pages that use the block. Shared components (`.button`, `.container`, `.section`) stay in `main.css`.
- **Editor:** `main.css` is loaded in the block editor (`add_editor_style`), so block previews look like the site. In `preview` mode the fields are edited in the sidebar (Block tab) or with the "Switch to Edit" toolbar button.
- **Block field helpers:** `finsweet_block_field()` and `finsweet_block_link()` read the fields of the block being rendered; render files do not call `get_field()` directly.
- **First block:** "Join our team" (Figma `533:2155`): title, text, link button. Page templates come with step 6, until then page content is not printed by `index.php`.

## Shared components

- **Partials, not blocks:** cards, category badge, section heading, stripe and pagination are PHP partials in `theme/template-parts/` that take data through `get_template_part()` arguments. Templates and blocks (steps 6-8) reuse them. Styles live in `main.css`, one SCSS file per component.
- **Post cards:** the horizontal card (category, title, excerpt) is used in lists, the vertical card (author, date, title, excerpt) in "What to read next". Both use the `finsweet-card` image size (980x636, cropped). The category on the card is the first non-default category of the post.
- **Pagination** prints `‹ Prev 1 2 … 5 Next ›` (`finsweet_pagination()`, built on `paginate_links()`); the mockup has Prev / Next only, the numbers are ours. Disabled Prev / Next stay visible.
- **Category card** turns yellow on hover, focus and with the `is-active` class (current category).
- **Layout helpers:** `.post-list`, `.post-grid`, `.category-grid`, `.author-grid` set the grids, collapsing to fewer columns on smaller screens.
- **`page.php`** is minimal (prints the content); page templates for the other types come with step 6.

## Templates

- **Thin templates:** `single.php`, `home.php`, `search.php`, `404.php` only assemble partials and helpers. `page.php` stays block-only (Home and About are built from blocks).
- **Privacy Policy** is a selectable page template (`page-privacy.php`, "Template Name: Privacy Policy"): lavender header with the title and "Last Updated on <modified date>", text in the 768 px column.
- **Featured post** on the blog is the newest sticky post, or the newest post when none is sticky; it is excluded from the "All posts" list (`pre_get_posts`). A dedicated flag is still postponed to the Home blocks step.
- **What to read next:** three posts of the same category, filled up with the latest posts (`finsweet_get_related_posts()`).
- **Join our team** is a partial (`template-parts/join-our-team.php`) used by `single.php` and `home.php`; texts and button come from the Finsweet settings page, and the block renders the same partial. The block CSS handle is enqueued by the partial, so templates get the block styles.
- **Search form** is the theme's own `searchform.php` with the `.button` component. 404 and search have no mockup: simple pages in the site style.
- **Article typography:** the column is 768 px, h1/h2/h3 get 48 px top margin, list items use the heading font (as in the mockup).
- **Category page:** hero with the category description and breadcrumbs (`template-parts/breadcrumbs.php`, Blog > Category), list of horizontal cards with a narrower image (296 px, `.post-list--compact`), sidebar (`template-parts/sidebar.php`) with compact category cards (current one highlighted) and all tags as outlined pills. The sidebar is a fixed 296 px column from 1024 px up.
- **Author page** (`single-blog_author.php`): lavender hero with photo, "Hey there, I'm <name> and welcome to my Blog", bio from the editor and the yellow/purple stripe; "My Posts" list below. Social links are not in the mockup; they are shown under the bio when filled in.
- **"My Posts":** posts whose `author` relationship contains the author (`finsweet_get_author_posts_query()`), `posts_per_page` per page, paginated at `/authors/<slug>/<n>/`. A `pre_handle_404` filter lets those URLs through (the author text has one page, so core would answer 404); empty pages still return 404. `finsweet_pagination()` takes optional `current` and `base` arguments for this.

## Home blocks (part 1)

- **Four blocks:** `hero-post`, `latest-posts` (featured post + list), `categories`, `authors`. Content comes from the site, not from per-item fields: nothing to maintain twice.
- **Hero post:** the post chosen in the block, otherwise the newest post that is not the featured one (`finsweet_get_hero_post()`). The post title is the `h1` of the Home page.
- **Featured and latest posts:** the featured post is the newest sticky post, or the newest post (same as the blog, no separate flag). The list shows the newest posts without it; "View all" links to the Blog page unless a link is set in the block.
- **Categories and authors:** all categories except Uncategorized and the authors in the order they were added, limited by a number field (4 by default). They reuse the category and author card partials and the `.category-grid` / `.author-grid` layouts.
- **Post row** (`template-parts/post-row.php`): meta and title for compact lists; highlighted on hover and focus (the mockup shows the second row highlighted).
- **Section heading** takes a `center` argument for the centered headings of the grids.
- **Block fields** are read with `finsweet_block_number()` and `finsweet_block_post_id()` next to the existing helpers. Blocks without their own CSS (categories, authors) have no `style` in `block.json`.

## Home blocks (part 2)

- **Four blocks:** `about-mission`, `why-we-started`, `featured-in`, `testimonials`. Texts and links are block fields.
- **About and mission:** lavender section with the fixed stripe on top (no field for it), two columns from 1024 px. The link is only on the "About" column.
- **Why we started:** photo 949 px and a white card 706 px (min height 584 px) overlapping it, both inside the 1280 px container; stacked on mobile. Sizes are taken from the Figma frame.
- **Featured in:** a title and five image fields (`logo_1` to `logo_5`), because the free Secure Custom Fields has no Repeater or Gallery. Empty logos are skipped.
- **Testimonials** are a `testimonial` post type without public pages (`public => false`, `show_ui`): title is the name, featured image is the photo, SCF fields `quote` and `location`. The block shows the newest N (4 by default) in a Swiper slider (Navigation, A11y, Keyboard modules), arrows hidden when there is one testimonial. Without JS the first testimonial stays visible.
- **Block scripts:** `theme/blocks/<name>/view.js` is a webpack entry built to `assets/build/blocks/view-<name>.js`, registered as the handle `finsweet-block-<name>-view` and set as `viewScript` in `block.json`, so it loads only where the block is used.
- **Block image field helper:** `finsweet_block_image_id()` next to the other `finsweet_block_*` helpers.
- **Category card icon:** the icon box has no background; the image fills the 48 px box.

## Known follow-ups

- Newsletter form in the footer is markup only; the handler comes with the forms step.
- `.button` component is minimal (header and footer needs). Hover colour of the light header button (`light-grey`) is not in the mockup.
- Author card photo is 96 px, the Home mockup suggests about 128 px; the card is shared with the About page, so it stays until that page is built.
