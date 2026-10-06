# Status

## In main

| PR | What |
|---|---|
| — | Initial commit: README, .gitignore |

## Next

1. Theme scaffold: MAMP setup, classic theme base, SCSS build, `theme.json` tokens, CI, docs ← current
2. Navbar and Footer (`header.php`, `footer.php`, newsletter form markup)
3. Content model: `author` CPT, category icon field, post → author relationship
4. Blog Post template (`single.php`)
5. Blog page and Category archive
6. Author page
7. Home page blocks
8. About Us blocks
9. Contact page and form handler, newsletter handler
10. Privacy Policy, 404, search
11. Responsive pass, accessibility pass
12. Deploy to InfinityFree via FTP

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

- `main` is protected: PR only, linear history, no force pushes; squash merge only.
- PRs open as drafts, CI must be green before merge.
