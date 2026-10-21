# MER-497 — Filter the staff directory by department

**Type:** Feature
**Epic:** Staff Directory (People)

---

## User story

**As a** visitor, **I want** to narrow the `/team/` directory to a single
department (and get back to the full list) **so that** I can find the people in
the part of the firm I care about without reading past everyone else.

## Context

The staff directory has its own page: the `/team/` archive lists every current
staff member in one grid (it renders the `meridian/staff-list` block). As the
team has grown, visitors have told us the full list is hard to scan when they
only care about one part of the firm.

Departments already exist as a taxonomy (`staff_department`) — this ticket builds
on the **existing** archive listing; it is not a new, separate directory page.
The shipped directory is documented in
[`requirements/.../staff-directory.prd.md`](../requirements/01-people/1-staff-directory/staff-directory.prd.md)
(context).

## What "done" looks like

- The visitor can choose from **the departments that actually have staff** — not
  an empty or hard-coded list.
- Choosing a department shows **only** staff in that department, and the visitor
  can return to the full, unfiltered listing.
- A filter that matches no one shows a clear **"no results"** state, not a blank
  area with no explanation.
- A filtered view is **reflected in the page's address** so it can be shared and
  reloaded into the same state.
- A request for a department that doesn't exist falls back to the full directory
  rather than erroring, and the filter must not leak into other listings on the
  site.

## Out of scope

- Filtering by more than one department at once.
- Free-text name search.
