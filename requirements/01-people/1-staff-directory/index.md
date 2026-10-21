---
title: "EPC-01.1: Staff Directory"
---

# Epic: Staff Directory

**Code:** EPC-01.1
**Domain:** People (DOM-01)
**Description:** Let visitors browse the company's staff.

**Created:** 2026-07-28 | **Last Updated:** 2026-07-28

---

## Overview

The Staff Directory is how a visitor answers "who works here, and who do I talk
to?" It presents staff as a browseable collection at `/team/`, and each person as
a self-contained card. The directory is the reference implementation for the
theme's content patterns — new People features are expected to match its
conventions.

## Features (PRDs)

| Code | Feature | Status | Description |
|------|---------|--------|-------------|
| [PRD-01.1.01](staff-directory.prd.md) | Staff Directory | complete | Browse staff as cards and as a directory listing |

## Epic Scope

**In Scope:**
- Presenting a single staff member as a self-contained card
- Presenting the full staff collection as a listing

**Out of Scope:**
- Search by free-text name
- Per-person detail pages beyond what the card shows
- Sorting controls exposed to the visitor

## Dependencies

| Depends On | Epic/Feature | For |
|------------|--------------|-----|
| — | — | — |

| Blocks | Epic/Feature | Until |
|--------|--------------|-------|
| — | — | — |

## Success Criteria

- [x] A visitor can see every current staff member in one place
- [x] Each staff member is presented consistently (name, role, department, photo)

## Notes

PRD-01.1.01 is already shipped and is the canonical example of the theme's
dynamic-block and content-modeling patterns. Any new People feature should reuse
the existing directory rather than introduce a parallel implementation.

---

_Managed by Fueled_
