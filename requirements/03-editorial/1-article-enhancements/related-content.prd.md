---
title: Related Content
status: complete
domain: Editorial
epic: Article Enhancements
dependencies: []
created: 2026-07-28
updated: 2026-07-28
version: 1.0
---

# Related Content

## Problem Statement

Readers who reach the end of an article are at a decision point: keep reading on
our site, or leave. Without a relevant next step, most leave. We want to keep
engaged readers moving through the site by pointing them, at the end of an
article, to other articles genuinely related to the one they just read.

Because article pages are among our highest-traffic surfaces and the
"relatedness" query is not free, this has to be done without adding meaningful
per-request cost.

## Target Users

| Persona | Description | Pain Point |
|---------|-------------|------------|
| Returning reader | Reads several articles per visit | Has to hunt for the next relevant thing to read |
| New reader | Arrived from search on one article | Leaves after one page because nothing points them deeper |

## Success Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Onward clicks from article pages | Baseline | Increase | Analytics |
| Added per-request cost on article pages | — | Negligible under normal traffic | Query/timing review |

## Description

At the end of an article, the reader sees a small set of other articles related
to the one they are reading. Relatedness is based on what the current article is
about — articles that share its categories are stronger candidates than
unrelated ones. The set is specific to the current article: reading a different article
surfaces a different, relevant set.

**Key Features:**
- A set of related articles shown on each article
- Relatedness derived from the current article's own categories
- Performant on high-traffic article pages

## User Stories

### US-007: See related articles

**As a** reader, **I want** to see other articles related to the one I'm reading
**so that** I can easily continue reading something relevant.

**Acceptance Criteria:**
- [x] AC-017: An article shows a small set of other articles
- [x] AC-018: The related articles are relevant to **the current article** — they reflect what *this* article is about
- [x] AC-019: Two different articles surface related sets appropriate to each; the recommendations are not identical across unrelated articles
- [x] AC-020: The current article never recommends itself
- [x] AC-021: An article with no good matches degrades gracefully (shows nothing rather than something irrelevant or broken)

### US-008: Fast article pages

**As a** reader, **I want** article pages to stay fast **so that** the reading
experience is not degraded by recommendations.

**Acceptance Criteria:**
- [x] AC-022: Computing related content does not add meaningful per-request cost under normal traffic

## Business Rules

| ID | Rule | Rationale |
|----|------|-----------|
| BR-008 | Relatedness is based on the current article's categories | Category overlap is our best available relevance signal |
| BR-009 | An article never lists itself as related | Self-recommendation is a bug, not a recommendation |
| BR-010 | Only published articles are eligible as recommendations | We do not surface drafts or private content |

## Technical Approach

_High-level direction only. Specific implementation details are determined at
execution time._

Related content is computed from the current article's categories against the
pool of published articles, and rendered at the end of the article. Because the
computation is expensive and runs on high-traffic pages, its result is cached
rather than recomputed on every request.

**Component Types:**
- A computation that selects related articles for a given article
- A presentation that renders that set at the end of an article
- A cache layer over the computation

**Data Relationships:**
- Relatedness is derived from category overlap between articles
- The result set is specific to the article it was computed for

**Integration Points:**
- Rendered on the single-article reading surface

_Note: Do NOT include file paths, field names, code snippets, or implementation
patterns. Those decisions happen at execution time when the actual codebase can
be read._

## ADR (Architecture Decision Records)

### Decision: Cache the relatedness computation rather than recompute per request

**Rationale:**
- The computation is expensive; its inputs change slowly
- Article pages are high-traffic, so caching is a large, cheap win

**Alternatives Considered:**
1. **Recompute on every request:** simplest, but adds cost to the hottest pages. Rejected.
2. **Precompute and store relatedness as data:** more moving parts and its own staleness problems for the current need. Deferred.

**Trade-offs:**
- Caching introduces correctness obligations that are part of the feature.

## Dependencies

| Dependency | Type | Status | Notes |
|------------|------|--------|-------|
| Article categories | required | exists | Relatedness is derived from them |

## Edge Cases

| Scenario | Expected Behavior |
|----------|-------------------|
| Article shares categories with nothing else | Show nothing rather than filler |
| Only match would be the article itself | Exclude self; may result in showing nothing |
| Related article is unpublished after caching | Must not continue to surface it indefinitely |

## Out of Scope

| Feature | Reason |
|---------|--------|
| Personalized recommendations | Requires reader identity/history; not in scope |
| Editorially hand-picked related articles | Automatic category-based relatedness covers the need |

## Open Questions

| ID | Question | Status | Answer |
|----|----------|--------|--------|
| Q-004 | How many related articles is ideal? | resolved | A small set; exact count is a presentation detail |

## Risks

| ID | Risk | Likelihood | Impact | Mitigation |
|----|------|------------|--------|------------|
| R-004 | Recommendations could become wrong without producing any error, so a regression here is easy to miss | med | high | Verify behavior against AC-018–AC-020 directly (relevance to the current article; distinct sets across articles; no self-recommendation) rather than assuming "no error" means "correct" |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| US-007 | Shipped | complete |
| US-008 | Shipped | complete |

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
