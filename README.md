# Finsweet Blog — WordPress theme

Classic WordPress theme with PHP templates and custom Gutenberg blocks built on custom fields, based on the free
[Client-First Template 12 — Blog, Community](https://www.figma.com/community) design by Finsweet.

Work in progress — see [docs/status.md](docs/status.md).

## Stack

- Classic WordPress theme (`theme/`): PHP templates, design tokens and editor settings in `theme.json`
- [Secure Custom Fields](https://wordpress.org/plugins/secure-custom-fields/) for custom fields and blocks
- SCSS compiled with `@wordpress/scripts` (webpack), sources in `src/`, output in `theme/assets/build/`
- MAMP for local development
- PHPCS with WordPress Coding Standards
- GitHub Actions CI

## Local development

Requirements: [MAMP](https://www.mamp.info/) (Apache, MySQL, PHP 8.3, Composer), Node 20+.

1. Install WordPress in `/Applications/MAMP/htdocs/finsweet` with a `finsweet` database
   (MAMP MySQL: `root` / `root`, port 8889) and install
   [Secure Custom Fields](https://wordpress.org/plugins/secure-custom-fields/) from wp.org.
2. Link the theme into WordPress and activate it:

   ```bash
   ln -s "$PWD/theme" /Applications/MAMP/htdocs/finsweet/wp-content/themes/finsweet
   ```

3. Put MAMP PHP and Composer on `PATH` (e.g. in `~/.zshrc`):

   ```bash
   export PATH="/Applications/MAMP/bin/php/php8.3.30/bin:/Applications/MAMP/bin/php:$PATH"
   ```

4. Install the tooling and build the styles:

   ```bash
   npm install
   composer install
   npm run build   # or `npm start` to rebuild on every change
   ```

Start the servers in MAMP; the site runs at http://localhost:8888/finsweet.

## Linting

```bash
npm run lint
```

## Docs

- [Spec](docs/spec.md) — pages, components and content model
- [Decisions](docs/decisions.md)
- [Status](docs/status.md)

## Credits

Design: Finsweet, Client-First Template 12. Fonts: Sen and Inter (SIL Open Font License).
