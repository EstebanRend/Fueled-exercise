# Meridian — take-home exercise

Welcome, and thanks for taking the time. This is a small but real WordPress block
theme for **Meridian**, a (fictional) private wealth and advisory firm. You'll
pick up a few tickets against it, just as you would on a live project.

- **Getting the site running:** [`setup.md`](setup.md)
- **Your work items:** [`tickets/README.md`](tickets/README.md)

## The scenario

You've just joined the team maintaining Meridian's website. There's a small
backlog waiting for you: three feature tickets and one bug. You'll work them the
way you'd work real tickets — in a codebase you didn't write, against team
conventions that already exist.

This is deliberately close to the actual job. We're less interested in whether
you can produce a clever one-off and more in how you operate inside an existing
system: reading the context, matching the house style, making sound calls, and
explaining them.

## Your task

Open [`tickets/`](tickets/README.md) and **complete between two and four
tickets**:

- **MER-482** — build a testimonial block for marketing surfaces
- **MER-497** — add department filtering to the staff directory
- **MER-513** — fix a bug in related-article recommendations
- **MER-528** — add a market snapshot to the homepage from a public data source

Do them in whatever order you like. Each ticket gives you the user story and what
"done" looks like — **how you implement it is your call.** The
[decision log](requirements/decision-log.md) records the conventions the codebase
commits to, and it's binding context.

**Complete at least two — ideally all four.** Four isn't required; two is the
floor. Quality matters more than count, so if you're short on time, do fewer well
and use your PR to note what you'd tackle with more. We read that as a positive
signal, not a gap.

## How to submit

1. **Create a private Git repository** for your work (GitHub is easiest for us to
   review) and **add the provided reviewers as collaborators** — they were sent to
   you in the message alongside this code. If you're unsure who to add, ask.
2. **Open a separate pull request for each ticket you complete.** One PR per
   ticket, scoped to that ticket, with commits that tell the story of your work.
3. **The PR description is your primary deliverable** — it's where we read your
   reasoning. For each ticket, tell us what you did, why, what you assumed, and
   where you made a judgment call.

Before you submit, a quick self-check per ticket:

- The site builds (`npm run build`) and runs (`npx @wordpress/env start`).
- Lint/static pass for what you touched (`npm run lint-js`, `npm run lint-style`,
  `composer lint`, `composer static`).
- You've verified the behavior in the browser.

## What we're looking for

Across the work and the write-up:

- **It does what was asked** — the behavior matches the ticket, including the edge
  cases, not just the happy path.
- **It's good WordPress** — idiomatic, secure, and performant use of the platform
  and the block editor.
- **It fits the codebase** — consistent with the existing patterns and the
  documented conventions, not a parallel way of doing things bolted on.
- **You can debug** — for the bug ticket especially: you find the real cause, fix
  it at the root, and confirm the fix.
- **You communicate** — your PR and commits make your reasoning legible.

We're not looking for gold-plating or extra features. Scope to the tickets.

## On AI tools

**You're welcome to use any AI tools** — we do too. Two expectations:

- **You own everything you submit.** Be ready to explain any line of it and the
  reasoning behind it as if you'd written it by hand — because in the follow-up
  conversation, we'll treat it as though you did.
- **Judgment is the point.** These tickets reward reading the existing code and
  conventions and making deliberate calls. Output that ignores the house patterns
  or misdiagnoses the bug reads the same whether a person or a tool produced it —
  and it's the main thing we're evaluating.

## Questions

If something is genuinely ambiguous or blocking, reach out — asking a good
question is a positive signal, not a strike against you. If it's a smaller
assumption, just make a reasonable call and note it in your PR.

Good luck — we're looking forward to reading your work.
