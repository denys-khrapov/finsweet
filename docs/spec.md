# Spec

Source design: Figma file `eMtqzuYwSOEC616BSwDCg0`, page **Design** (`27:387`).
Every frame is desktop only (1440 px). Tablet and mobile layouts are ours to design (→ decisions.md).

Frame link format: `https://www.figma.com/design/eMtqzuYwSOEC616BSwDCg0/?node-id=<id with "-" instead of ":">`.

## Design tokens — Style Guide (`533:3125`)

Implemented in `theme/theme.json`.

**Colors**

| Token | Hex | Used for |
|---|---|---|
| Black | `#232536` | headings, navbar, footer |
| Dark 400 | `#111218` | — |
| Yellow | `#FFD050` | buttons, accents, active category |
| Yellow hover | `#EDC14A` | button hover |
| Purple | `#592EA9` | links, category labels, contact card |
| Dark Grey | `#4C4C4C` | — |
| Medium Grey | `#6D6E76` | body text |
| Grey | `#AFB0B9` | muted text |
| Light Grey | `#F4F4F4` | card backgrounds |
| Lavender | `#F4F0F8` | section backgrounds |
| Light Yellow | `#FBF6EA` | section backgrounds, hover cards |

**Typography** — headings Sen Bold, text Inter (→ decisions.md).

| Style | Size / line height | Letter spacing |
|---|---|---|
| Display | 56 / 64 | −2 px |
| H1 | 48 / 64 | −2 px |
| H2 | 36 / 48 | −2 px |
| H3 | 28 / 40 | −1 px |
| H4 | 24 / 32 | 0 |
| H5 | 20 / 32 | 0 |
| H6 | 16 / 24 | 0 |
| Body 1 | Inter 400, 16 / 28 | 0 |
| Body 2 | Inter 400, 14 / 20 | 0 |
| Label | Inter 500, 14 / 20 | 0 |

**Button** — Yellow background, Black text, Sen Bold 18 / 24, padding 16 × 48, no radius, hover `#EDC14A`.

## Global parts

| Part | Frame | Notes |
|---|---|---|
| Navbar (`header.php`) | `407:500` | logo, menu (Home, Blog, About Us, Contact us), white "Subscribe" button |
| Footer (`footer.php`) | `379:475` | logo, menu (+ Privacy Policy), newsletter form, address, email, phone, social icons |
| Social wrapper | `856:979` | Facebook, Twitter, Instagram, LinkedIn icons |

## Pages

| Page | Frame | WordPress | Sections |
|---|---|---|---|
| Home | `533:2153` | page built from blocks (`page.php`) | hero with a post, featured post + latest posts list, about/mission, category grid, "why we started", authors, "Featured in" logos, testimonials slider, Join our team |
| Blog | `571:498` | `home.php` (posts page) | featured post, posts list, Prev/Next pagination, category grid, Join our team |
| Blog Post | `533:2751` | `single.php` | author + date, title, category badge, cover image, content, "What to read next" (3 cards), Join our team |
| Category | `533:2623` | `category.php` | hero with breadcrumbs, posts list, sidebar: categories + all tags |
| Author | `533:3026` | `single-blog_author.php` (CPT) | photo, name, bio, social links, "My posts" |
| About Us | `533:2806` | page built from blocks | hero, stats over image, mission/vision, two image+text sections, authors grid, Join our team |
| Contact | `533:3083` | page built from blocks + contact form block | heading, working hours / contacts card, form: name, email, query select, message |
| Privacy Policy | `533:3065` | `page.php` | header with "last updated" date, text content |

## Content model (→ decisions.md)

- **Author** — custom post type `blog_author` (URL `/authors/<name>/`, → decisions.md): photo (featured image), job title, bio, social links. Posts link to an author through an SCF relationship field, not `post_author`.
- **Category** — core taxonomy + SCF icon field.
- **Testimonials, "Featured in" logos, About stats** — SCF blocks with fields.
- **Contact and newsletter forms** — own handler, `wp_mail`.

## Reusable blocks / patterns (candidates)

- Join our team (Home, Blog, Blog Post, About) — done as a block, Figma `533:2155`
- Category grid (Home, Blog)
- Author card / authors grid (Home, About)
- Horizontal post card (Blog, Category, Author)
- Vertical post card (Blog Post "What to read next")
- Two-colour stripe (yellow + purple) decoration
