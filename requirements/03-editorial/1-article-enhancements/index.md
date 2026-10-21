---
title: "EPC-03.1: Article Enhancements"
---

# Epic: Article Enhancements

**Code:** EPC-03.1
**Domain:** Editorial (DOM-03)
**Description:** Enhancements to the single-article reading experience that keep
readers engaged.

**Created:** 2026-07-28 | **Last Updated:** 2026-07-28

---

## Overview

Once a reader finishes an article, the most valuable thing the site can do is
point them to another article worth reading. This epic covers on-article
enhancements toward that goal, beginning with related-content recommendations.

## Features (PRDs)

| Code | Feature | Status | Description |
|------|---------|--------|-------------|
| [PRD-03.1.01](related-content.prd.md) | Related Content | complete | Show articles related to the one being read |

## Epic Scope

**In Scope:**
- Surfacing other articles relevant to the current one
- Doing so performantly on a high-traffic surface

**Out of Scope:**
- Personalized recommendations based on reader identity or history
- Cross-domain recommendations (e.g. recommending staff or testimonials)

## Dependencies

| Depends On | Epic/Feature | For |
|------------|--------------|-----|
| — | — | — |

| Blocks | Epic/Feature | Until |
|--------|--------------|-------|
| — | — | — |

## Success Criteria

- [x] A reader on an article sees other articles relevant to it
- [x] The feature performs acceptably on high-traffic article pages

## Notes

Related Content (PRD-03.1.01) is shipped. It is query-heavy and therefore caches
its result.

---

_Managed by Fueled_
