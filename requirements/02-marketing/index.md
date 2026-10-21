---
title: "DOM-02: Marketing"
---

# Domain: Marketing

**Code:** DOM-02
**Description:** The homepage and marketing surfaces whose job is to build trust
with prospective clients and move them toward contact.

**Created:** 2026-07-28 | **Last Updated:** 2026-07-28

---

## Overview

The Marketing domain owns the persuasive surfaces of the site — primarily the
homepage — where the company makes its case to prospects. Content here is
curated and conversion-oriented rather than exhaustive. It is a distinct domain
because its content is chosen for impact, not completeness, and it draws on
other domains (people, editorial) as raw material.

## Epics

| Code | Epic | Description | PRDs | Status |
|------|------|-------------|------|--------|
| [EPC-02.1](1-testimonials/index.md) | testimonials | Testimonials as structured, curated content | 1 | complete |

## Domain Boundaries

**In Scope:**

- Homepage marketing sections
- Curated social proof (testimonials)
- Calls to action and trust-building content

**Out of Scope:**

- The full staff directory (see [DOM-01 People](../01-people/index.md))
- The news/blog reading experience (see [DOM-03 Editorial](../03-editorial/index.md))

## Cross-Domain Dependencies

| Depends On | For |
|------------|-----|
| People (DOM-01) | May feature individual staff as part of a marketing surface |

| Depended On By | For |
|----------------|-----|
| — | — |

## Domain Owners

| Role | Name | Contact |
|------|------|---------|
| Product | TBD | — |
| Engineering | TBD | — |
| Design | TBD | — |

## Technical Context

Marketing surfaces are composed by editors from blocks and patterns. Curated
content types (such as testimonials) follow the same dynamic-block conventions
as the rest of the theme; see [`decision-log.md`](../decision-log.md).

## Business Context

Testimonials are gathered from real clients and curated by Marketing. They are
low-volume, high-value content that changes occasionally.

---

## Recent Activity

| Date | Action | Epic | Details |
|------|--------|------|---------|
| 2026-07-28 | Created | — | Domain initialized |

---

_Managed by Fueled - Documentation-Driven Development_
