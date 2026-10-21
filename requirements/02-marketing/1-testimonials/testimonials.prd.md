---
title: Testimonials
status: complete
domain: Marketing
epic: Testimonials
dependencies: []
created: 2026-07-28
updated: 2026-07-30
version: 1.1
---

# Testimonials

> **Scope of this PRD.** This documents the testimonial **content type** as it is
> built and live today. Presenting a testimonial on a marketing surface (a block
> an editor can place) is **not** built — that is separate ticket work and is not
> specified here.

## Problem Statement

Prospective clients evaluating the company want reassurance from people like
them — existing clients — not just from the company's own marketing copy.
Previously, testimonials (when we had them) lived as ad-hoc text baked into a
page: they could not be curated, reused, or kept consistent.

The company needs testimonials to be **structured content that Marketing can
manage** — created once, edited in one place, and reusable wherever a
testimonial is later surfaced.

## Target Users

| Persona | Description | Pain Point |
|---------|-------------|------------|
| Marketing editor | Curates social proof | Had no structured way to record and maintain testimonials |
| Prospective client | Deciding whether to trust the company | (Downstream) benefits when curated testimonials can be surfaced |

## Success Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Testimonials stored as structured content | Yes | Yes | Admin audit |
| Consistency of the testimonial record | Uniform (title + body + attribution meta) | Uniform | Content review |

## Description

A testimonial is a short quotation from a client, attributed to a named person
and — where available — their role and company. Testimonials are managed in the
admin as their own content type, independent of any page they might later appear
on.

**Key Features (shipped):**
- Testimonials are a dedicated, first-class content type
- Each testimonial carries a quotation and an attributed name, plus optional role
  and company
- Testimonials are curated (chosen by reference), so they are not published as
  their own public pages or archive

## User Stories

### US-006: Manage testimonials as content

**As a** marketing editor, **I want** testimonials to be first-class content
**so that** I can add, edit, and reuse them without re-typing.

**Acceptance Criteria:**
- [x] AC-015: Testimonials can be created and edited as their own content type
- [x] AC-016: A testimonial holds a quotation, an attributed name, and optional
  role and company
- [x] AC-017: Testimonials are curated content — they do not surface as their own
  public pages or archive

## Business Rules

| ID | Rule | Rationale |
|----|------|-----------|
| BR-006 | A testimonial must have a quote and an attributed name | An unattributed quote is not persuasive social proof |
| BR-007 | Role and company are optional | We do not always have or want to show them |

## Technical Approach

_High-level direction only._

Testimonials are a dedicated content type: the quotation is the body, the
attributed name is the title, and role and company are optional single meta
values. The type is curated and chosen by reference, so it is not publicly
queryable on its own. This mirrors the content-modeling conventions of the
shipped Staff Directory (PRD-01.1.01); see
[`decision-log.md`](../../decision-log.md).

## Dependencies

| Dependency | Type | Status | Notes |
|------------|------|--------|-------|
| Staff Directory patterns (PRD-01.1.01) | optional | exists | Reference implementation mirrored for the content type |

## Edge Cases

| Scenario | Expected Behavior |
|----------|-------------------|
| Testimonial has a name but no role/company | The record is valid; role and company are simply empty |
| Testimonial is unpublished | It is no longer available to be referenced by a placement |

## Out of Scope

| Feature | Reason |
|---------|--------|
| A block/placement that surfaces a testimonial on a page | Separate ticket work; not specified by this PRD |
| Client-submitted testimonial form | Testimonials are curated by Marketing |
| Carousel/rotation of multiple testimonials | Not part of the content model |
| Star ratings | Not part of the social-proof model we want |

## Risks

| ID | Risk | Likelihood | Impact | Mitigation |
|----|------|------------|--------|------------|
| R-003 | Optional attribution is mishandled by a later placement ("— , ") | med | low | Any placement should handle each attribution part independently |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| US-006 | Shipped | complete |

**Coverage:**
- Total requirements: 1
- Mapped to phases: 1
- Unmapped: 0

---

## Approval

| Role | Name | Date | Status |
|------|------|------|--------|
| Product | — | 2026-07-28 | approved |
| Engineering | — | 2026-07-28 | approved |
| Design | — | 2026-07-28 | approved |

---

_Document version: 1.1 | Created via Fueled_
_Last updated: 2026-07-30 — narrowed to the shipped content type_
