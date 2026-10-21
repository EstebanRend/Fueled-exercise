---
title: "Meridian — Requirements Index"
---

# Meridian Requirements

Meridian is the public-facing website for a mid-sized professional-services
company. This tree is the product's requirements documentation: the domains it
is organized into, the epics inside each domain, and the feature-level PRDs.

New engineers should read this index, then the domain and epic they are working
in, then the specific PRD their ticket references. Before writing any code, also
read [`decision-log.md`](decision-log.md) — it records the architecture
conventions this codebase commits to.

## Domains

| Code | Domain | Description | Epics |
|------|--------|-------------|-------|
| [DOM-01](01-people/index.md) | People | Staff, teams, and how the organization presents its people publicly | 1 |
| [DOM-02](02-marketing/index.md) | Marketing | Homepage and marketing surfaces that build trust and convert visitors | 1 |
| [DOM-03](03-editorial/index.md) | Editorial | The news/blog reading experience and article-level enhancements | 1 |

## Features (PRDs)

These document what is **already built and live** in the theme. They are the
product context you inherit — not the work in front of you. The work items live
in [`tickets/`](../tickets/README.md); a ticket may build on a feature described
here, but the tickets themselves are the source of truth for what to do.

| Code | Feature | Domain | Status |
|------|---------|--------|--------|
| [PRD-01.1.01](01-people/1-staff-directory/staff-directory.prd.md) | Staff Directory | People | complete |
| [PRD-02.1.01](02-marketing/1-testimonials/testimonials.prd.md) | Testimonials (content type) | Marketing | complete |
| [PRD-03.1.01](03-editorial/1-article-enhancements/related-content.prd.md) | Related Content | Editorial | complete |

## Status legend

| Status | Meaning |
|--------|---------|
| `complete` | Shipped and live. Code exists in the theme today. |
| `draft` / `in-review` | Still being refined. |

## Notebooks

Discovery notes and engineering insights that informed these requirements live
in [`notebooks/insights/`](notebooks/insights/). They are context, not
specification — where a notebook and a PRD disagree, the PRD wins.

---

_Managed by Fueled — Documentation-Driven Development_
