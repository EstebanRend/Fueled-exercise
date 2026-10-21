---
title: Staff Directory
status: complete
domain: People
epic: Staff Directory
dependencies: []
created: 2026-07-28
updated: 2026-07-28
version: 1.0
---

# Staff Directory

## Problem Statement

Visitors — prospective clients, candidates, and partners — regularly want to
understand who works at the company and reach the right person. Before this
feature, staff were listed as plain text on a single hand-maintained page that
drifted out of date, looked inconsistent, and could not be reused anywhere else
on the site.

We need staff to be structured, reusable content with a consistent presentation,
so the directory stays current and individual people can be surfaced elsewhere
without re-entering their details.

## Target Users

| Persona | Description | Pain Point |
|---------|-------------|------------|
| Prospective client | Evaluating whether to engage the company | Can't tell who they'd work with or find a relevant contact |
| Job candidate | Researching the company before applying | Wants a sense of the team and its structure |
| Content editor | Maintains the site day-to-day | Updating a flat text page is error-prone and easily forgotten |

## Success Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Directory freshness | Manually updated, often stale | Reflects current staff within one business day of a change | Editorial audit |
| Presentation consistency | Ad hoc per entry | Every staff member rendered identically | Visual review |

## Description

The Staff Directory presents the company's people in two complementary ways: a
**staff card** that shows one person as a self-contained unit, and a **directory
listing** that presents the whole collection of current staff. Each person shows
their name, role/title, department, a photo, and a short bio.

**Key Features:**
- A reusable single-person card presentation
- A listing that shows all current staff
- Consistent, structured data behind every entry

## User Stories

### US-001: Browse all staff

**As a** visitor, **I want** to see all current staff in one place **so that** I
can understand who works at the company.

**Acceptance Criteria:**
- [x] AC-001: The listing shows every current staff member
- [x] AC-002: Each entry shows name, role, department, and photo
- [x] AC-003: Entries are presented in a consistent, repeating format

### US-002: Understand an individual

**As a** visitor, **I want** each person presented as a clear, self-contained
unit **so that** I can quickly read who they are and what they do.

**Acceptance Criteria:**
- [x] AC-004: A person's card is legible on its own, out of the context of the listing
- [x] AC-005: A missing photo or bio degrades gracefully rather than breaking layout

## Business Rules

| ID | Rule | Rationale |
|----|------|-----------|
| BR-001 | Only current staff appear in the directory | The directory represents who works here now |
| BR-002 | Every staff member belongs to exactly one department | Departments are how visitors and editors reason about the org |
| BR-003 | Department is drawn from a controlled list, not typed per person | Prevents drift and duplicate spellings; enables reuse |

## Technical Approach

_High-level direction only. Specific implementation details are determined at
execution time._

Staff are a dedicated content type. Department is a classification applied to
staff. Presentation follows the theme's dynamic-block conventions so the card
and listing render current data on every request. Follow 10up block development
best practices.

**Component Types:**
- A content type representing a staff member
- A classification grouping staff by department
- A single-person card presentation
- A collection/listing presentation

**Data Relationships:**
- Each staff member is classified under one department
- The listing is the collection of current staff members

**Integration Points:**
- The card presentation is reused wherever an individual is shown

_Note: Do NOT include file paths, field names, code snippets, or implementation
patterns. Those decisions happen at execution time when the actual codebase can
be read._

## ADR (Architecture Decision Records)

### Decision: Model department as a shared classification, not per-person text

**Rationale:**
- Departments are a small, controlled vocabulary owned centrally
- A shared classification prevents spelling drift and enables grouping/reuse

**Alternatives Considered:**
1. **Free-text department on each person**: Simple to enter, but drifts immediately (e.g. "Engineering" vs "Eng") and can't be reused for grouping. Rejected.
2. **A separate related content type for departments**: More power than needed for a controlled label; over-modeled for the requirement. Rejected.

**Trade-offs:**
- A controlled vocabulary means adding a department is an editorial action, not a free-form typing action — intended.

See [`decision-log.md`](../../decision-log.md) for how this decision generalizes
across the codebase.

## Dependencies

| Dependency | Type | Status | Notes |
|------------|------|--------|-------|
| — | — | — | Foundational feature |

## Edge Cases

| Scenario | Expected Behavior |
|----------|-------------------|
| Staff member has no photo | Card renders with a neutral placeholder, layout intact |
| Staff member has no bio | Card omits the bio without leaving an empty gap |
| A department has no staff | The department simply does not appear in the directory |

## Out of Scope

| Feature | Reason |
|---------|--------|
| Free-text name search | Not part of the current directory |
| Per-person detail pages | The card is sufficient for current requirements |

## Open Questions

| ID | Question | Status | Answer |
|----|----------|--------|--------|
| Q-001 | Should staff be orderable manually? | resolved | No — not required for launch |

## Risks

| ID | Risk | Likelihood | Impact | Mitigation |
|----|------|------------|--------|------------|
| R-001 | Directory grows large enough to need pagination | low | med | Revisit if headcount materially increases |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| US-001 | Shipped | complete |
| US-002 | Shipped | complete |

**Coverage:**
- Total requirements: 2
- Mapped to phases: 2
- Unmapped: 0

---

## Approval

| Role | Name | Date | Status |
|------|------|------|--------|
| Product | — | 2026-07-28 | approved |
| Engineering | — | 2026-07-28 | approved |
| Design | — | 2026-07-28 | approved |

---

_Document version: 1.0 | Created via Fueled_
_Last updated: 2026-07-28 after initial implementation_
