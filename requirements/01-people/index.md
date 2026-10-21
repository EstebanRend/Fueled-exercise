---
title: "DOM-01: People"
---

# Domain: People

**Code:** DOM-01
**Description:** How the organization represents its people — individual staff
members, their roles, and the departments they belong to — on the public site.

**Created:** 2026-07-28 | **Last Updated:** 2026-07-28

---

## Overview

The People domain owns the public representation of the company's staff. It
exists as a distinct domain because staff are structured, reusable content:
the same person may surface in a directory, on a department page, or as an
author elsewhere on the site. Modeling people once, well, keeps those surfaces
consistent.

## Epics

| Code | Epic | Description | PRDs | Status |
|------|------|-------------|------|--------|
| [EPC-01.1](1-staff-directory/index.md) | staff-directory | Browse the company's staff | 1 | complete |

## Domain Boundaries

**In Scope:**

- Public presentation of individual staff members (name, role, department, photo, bio)
- Grouping and classification of staff by department
- Browsing and filtering staff on the public site

**Out of Scope:**

- Internal HR data, employment records, or anything not intended for public display
- Authentication or staff self-service (staff do not log in to edit their own profiles)
- Authorship of editorial content — see [DOM-03 Editorial](../03-editorial/index.md)

## Cross-Domain Dependencies

| Depends On | For |
|------------|-----|
| — | People is a foundational domain with no upstream dependencies |

| Depended On By | For |
|----------------|-----|
| Marketing (DOM-02) | May feature individual staff in marketing surfaces |

## Domain Owners

| Role | Name | Contact |
|------|------|---------|
| Product | TBD | — |
| Engineering | TBD | — |
| Design | TBD | — |

## Technical Context

Staff are editorial content managed in WordPress. Classification (department)
is modeled as a taxonomy rather than free-text on each person — the rationale
and trade-offs are recorded in [`decision-log.md`](../decision-log.md). Presentation
follows the theme's dynamic-block conventions.

## Business Context

Staff headcount is on the order of a few dozen and changes slowly (hires,
departures, role changes). Departments are a small, controlled vocabulary owned
by Marketing/HR, not something editors invent per-person.

---

## Recent Activity

| Date | Action | Epic | Details |
|------|--------|------|---------|
| 2026-07-28 | Created | — | Domain initialized |

---

_Managed by Fueled - Documentation-Driven Development_
