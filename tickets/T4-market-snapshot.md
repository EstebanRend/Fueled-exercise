# MER-528 — Market snapshot on the homepage

**Type:** Feature
**Epic:** Markets

---

## User story

**As a** prospective client on the homepage, **I want** to see a small, current
snapshot of a few headline market indices **so that** I get a low-key signal that
the firm actually watches the markets it advises on.

## Context

Meridian advises clients on the markets, but nothing on the homepage signals it.
Marketing wants a small **market snapshot** — a few headline indices with their
latest value and change — as a credibility signal. It's informational only and
must never read as a quote, an offer, or advice.

There's already a placeholder on the homepage: a **"Markets" band** rendered from
a theme partial (a pattern) that shows the index names with dashes and an
"Awaiting live data" note. Your job is to make it real.

- Placeholder partial: `themes/meridian-theme/patterns/market-snapshot.php`
- It's included on the homepage template
  (`themes/meridian-theme/templates/front-page.html`) via a pattern reference —
  that's the seam to build against.

## Data source

Use a **public, keyless** source. Yahoo Finance's chart endpoint works without an
API key and returns JSON:

- Dow Jones — `https://query1.finance.yahoo.com/v8/finance/chart/%5EDJI`
- S&P 500 — `https://query1.finance.yahoo.com/v8/finance/chart/%5EGSPC`
- Nasdaq Composite — `https://query1.finance.yahoo.com/v8/finance/chart/%5EIXIC`

(`%5E` is the URL-encoded `^`.) In the response, the latest value and the prior
close live under `chart.result[0].meta` (e.g. `regularMarketPrice` and
`chartPreviousClose`). You're free to pick a different public, keyless source.

## What "done" looks like

- The homepage shows a **small set of named indices**, each with its latest value
  and its change (amount and/or direction).
- The values come **from the public source at runtime**, not hard-coded.
- If the source is slow, unavailable, or returns incomplete data, the homepage
  still renders cleanly — the snapshot never breaks the page.

## Out of scope

- Real-time / streaming quotes.
- Historical charts, per-user watchlists, portfolios, or anything transactional.
- Any presentation that implies a quote, an offer, or investment advice.
