# MER-482 — Testimonial block for marketing surfaces

**Type:** Feature
**Epic:** Testimonials (Marketing)

---

## User story

**As a** marketing editor, **I want** to place a chosen client testimonial on a
page **so that** prospective clients see peer validation at the moment they're
deciding whether to trust us.

## Context

Testimonials already exist as **structured content** — there's a Testimonial
content type in the admin, with a quote, an attributed name, and optional role
and company (you can see the seeded examples there). What's missing is a way for
an editor to **place a specific testimonial on a page** and have it render
consistently. Marketing wants to start with the homepage.

The homepage already has a **placeholder for this**: a static quote near the
bottom of the front page (the `meridian-quote` section in
`themes/meridian-theme/templates/front-page.html`) — a single testimonial with
its attribution, hardcoded into the template. That's the presentation to aim
for; your block should let an editor drive that layout from a chosen testimonial
instead of it being fixed markup.

The testimonial content type is documented in
[`requirements/.../testimonials.prd.md`](../requirements/02-marketing/1-testimonials/testimonials.prd.md)
(context — it describes what's already built, not what to build here).

## What "done" looks like

- An editor can drop a block onto a page and **choose which testimonial** it
  presents.
- The front end shows the **quote and its attribution** — the name, plus role
  and/or company **when those are present**.
- Missing optional attribution degrades cleanly — no stray commas, dashes, or
  empty labels.
- A block with **no testimonial chosen**, or one whose chosen testimonial is
  later **unpublished**, must not render a broken or empty unit on the front end.
- The presentation is legible and consistent wherever the block is placed.

## Out of scope

- A carousel or rotation of multiple testimonials.
- A public testimonial-submission form.
- Star ratings.
