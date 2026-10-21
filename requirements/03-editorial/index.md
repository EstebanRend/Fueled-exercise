---
title: "DOM-03: Editorial"
---

# Domain: Editorial

**Code:** DOM-03
**Description:** The news/blog reading experience — how articles are presented
and how readers are guided from one article to the next.

**Created:** 2026-07-28 | **Last Updated:** 2026-07-28

---

## Overview

The Editorial domain owns the company's published articles and the experience of
reading them. Beyond presenting a single article, its job is to keep readers
engaged by surfacing other relevant articles. It is a distinct domain because
its content is time-ordered, high-volume, and read-optimized, in contrast to the
curated Marketing surfaces or the structured People directory.

## Epics

| Code | Epic | Description | PRDs | Status |
|------|------|-------------|------|--------|
| [EPC-03.1](1-article-enhancements/index.md) | article-enhancements | Enhancements to the single-article reading experience | 1 | in-progress |

## Domain Boundaries

**In Scope:**

- Presentation of individual articles
- On-article enhancements that aid discovery (e.g. related content)

**Out of Scope:**

- Marketing/homepage surfaces (see [DOM-02 Marketing](../02-marketing/index.md))
- The staff directory (see [DOM-01 People](../01-people/index.md))

## Cross-Domain Dependencies

| Depends On | For |
|------------|-----|
| — | Editorial content stands on its own |

| Depended On By | For |
|----------------|-----|
| Marketing (DOM-02) | May surface curated articles on marketing pages |

## Domain Owners

| Role | Name | Contact |
|------|------|---------|
| Product | TBD | — |
| Engineering | TBD | — |
| Design | TBD | — |

## Technical Context

Article enhancements that compute across the article archive (such as related
content) can be query-heavy, so their results are cached.

## Business Context

Article volume is significant and grows continuously. Keeping readers moving from
one article to the next is a primary engagement goal for this domain.

---

## Recent Activity

| Date | Action | Epic | Details |
|------|--------|------|---------|
| 2026-07-28 | Created | — | Domain initialized |

---

_Managed by Fueled - Documentation-Driven Development_
