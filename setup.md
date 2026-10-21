# Setup & running locally

This gets the local site running and shows you where things are. For **what the
exercise is and how to submit**, see [`README.md`](README.md).

This repository is a small but real WordPress block theme for **Meridian**, a
(fictional) private wealth and advisory firm.

> The project is already set up as `meridian-theme`. **Don't run any `scaffold`
> command** — those are for spinning up a brand-new project from the 10up
> scaffold, which isn't what you're doing here.

## 1. Prerequisites

- **Docker Desktop**, running (the local site runs in Docker via `wp-env`).
- **Node 24** and **npm ≥ 10** (`.nvmrc` pins Node 24 — `nvm use` if you use nvm).
- **PHP 8.4 + Composer** — *optional.* You don't need a local PHP to run the
  site: `start` installs the theme's Composer dependencies inside the Docker
  container (which runs PHP 8.4). A local PHP 8.4 + Composer is only needed if you
  want to run the PHP checks (`composer lint` / `composer static`) on your machine.

## 2. Get it running

```bash
nvm use                 # Node 24 (or make sure you're on 24+)
npx @wordpress/env start        # boots WordPress in Docker
```

`start` provisions everything for you. On the **first** run it installs the node
and Composer dependencies (including the theme's), builds the theme assets, then
**activates the theme and seeds demo content automatically** (6 advisors, 3
client testimonials, 9 articles with images). That first run takes a few minutes;
later starts skip the install/build steps and are quick. When it finishes:

- **Site:** http://localhost:8888
- **Admin:** http://localhost:8888/wp-admin — user `admin`, password `password`

Then, in a second terminal, rebuild theme assets on change while you work:

```bash
npm run watch           # or `npm run build` for a one-off build
```

Re-seed at any time (for example to reset after experimenting):

```bash
npx @wordpress/env run cli wp meridian seed --force
```

**If `start` ever reports "The site you have requested is not installed"** — e.g.
a previous `start` was interrupted — just run `npx @wordpress/env start` again.
The `afterStart` hook installs WordPress if it's missing, so it self-heals. If it
still won't come up, do a clean reset:

```bash
npx @wordpress/env destroy   # removes the containers and database (answer "y")
npx @wordpress/env start     # fresh install, theme activation, and seed
```

## 3. The lay of the land

```
README.md                    ← the exercise: what to do and how to submit
tickets/                     ← your work items — start at tickets/README.md
requirements/                ← product + architecture context for what's ALREADY built
  decision-log.md            ← conventions this codebase commits to (read this)
  01-people/ 02-marketing/ 03-editorial/   ← PRDs for shipped features
themes/meridian-theme/       ← the theme you'll work in
  blocks/                    ← dynamic blocks (staff-list, staff-card)
  patterns/                  ← block patterns (incl. the market-snapshot placeholder)
  src/                       ← PHP modules (post types, taxonomies, editorial, CLI)
```

Two reference points for almost every decision:

1. **[`requirements/decision-log.md`](requirements/decision-log.md)** records the
   conventions the codebase has committed to. It's binding. If you think a
   decision is wrong for your ticket, that's a conversation to raise in your PR —
   not something to work around silently.
2. **Mirror the nearest shipped feature.** The Staff Directory
   (`meridian/staff-list` and `meridian/staff-card`, plus the `staff_member` post
   type and `staff_department` taxonomy) is the pattern to follow.

## 4. Useful commands

```bash
npm run watch           # rebuild theme assets on change (dev loop)
npm run build           # one-off production build
npm run lint-js         # JS lint
npm run lint-style      # CSS/SCSS lint
composer lint           # PHP coding standards (phpcs)
composer static         # PHP static analysis (phpstan, level 9)
npx @wordpress/env run cli wp <command>    # run WP-CLI against the local site
```

There's also a helper to scaffold a new block from the house template, if you
want it: `npm run scaffold:block -w=meridian-theme`.

A pre-commit hook (Husky + lint-staged) runs `eslint`, `stylelint`, and `phpcs`
on staged files, so formatting issues are caught before they land.

---

**Next:** read [`README.md`](README.md), then open
[`tickets/README.md`](tickets/README.md).
