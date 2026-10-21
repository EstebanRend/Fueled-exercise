# Meridian — Architecture Decision Log

This log records the architecture conventions the Meridian codebase commits to.
It is the shortest path to understanding "how we do things here." Read it before
writing code — several of these decisions are load-bearing, and changes that
quietly contradict them are the most common source of review churn.

Each entry is a decision we have already made and are living with. If you think a
decision is wrong for your ticket, that is a conversation to have in the pull
request — not something to silently work around.

**Baseline standard:** adhere to the
[10up Engineering Best Practices](https://gutenberg.10up.com/reference/). Where
this log is silent, those practices are the default.

---

## ADR-001 — Block theme with Full Site Editing

**Status:** Accepted · 2026-07-28

**Decision:** Meridian is a block theme built on the 10up scaffold and 10up
Toolkit. Templates and parts are block markup; global styling flows through
`theme.json`.

**Rationale:** Editors compose pages from blocks; keeping the theme block-native
avoids a split-brain between classic PHP templates and the block editor.

**Consequences:** New presentation is delivered as blocks and patterns, not as
bespoke page templates, unless there is a specific reason a template is required.

---

## ADR-002 — Output that depends on live data is rendered on the server

**Status:** Accepted · 2026-07-28

**Decision:** Any surface whose output depends on site data (queries, meta,
terms) is rendered on the server at request time, not baked into saved content.
For a block-composed surface that means a dynamic block with a server render —
the staff blocks are the model. Where a block is not the right fit, the same
principle is met with server-side PHP (for example, related content is appended
to an article via a `the_content` filter). Where a block does show an editor
preview, that preview is built natively in the editor rather than with
`ServerSideRender`.

**Rationale:** Directory listings, related content, and similar surfaces must
reflect the current state of the site on every request. Baking markup into saved
content would serve stale data and force re-saves to refresh.

**Consequences:** Expect data-backed output to have a server render step. Static,
purely presentational blocks may still save markup.

---

## ADR-003 — Use WordPress core APIs directly; do not add abstraction layers

**Status:** Accepted · 2026-07-28

**Decision:** Data access and queries use the WordPress core APIs directly, in the
place that needs them (render callbacks, template functions, query hooks). We do
**not** introduce repository/service/gateway wrapper layers, generic "data
provider" classes, or an ORM-style indirection over core.

**Rationale:** This is a WordPress theme of moderate size, maintained by
engineers who know WordPress. Core already provides the data-access abstraction.
Home-grown wrappers on top of it add indirection, obscure what query is actually
running (a real performance-debugging cost), and drift out of sync with core's
capabilities. The cost of the abstraction has consistently outweighed its benefit
on projects this size.

**Consequences:** Prefer the smallest correct use of a core API over a "reusable"
abstraction built for a single caller. Shared logic is fine as a plain function
when there are genuinely multiple callers; it is not a reason to introduce a
layer. If you believe a ticket genuinely warrants new indirection, make that case
explicitly in the PR rather than introducing it by default.

---

## ADR-004 — Department is a taxonomy, not per-post metadata

**Status:** Accepted · 2026-07-28

**Decision:** A staff member's department is modeled as a taxonomy term, not as a
free-text or select metadata field on the staff member.

**Rationale:** Department is a shared, controlled vocabulary owned centrally, and
we need to group and filter staff by it. A taxonomy gives us term management,
grouping, and archive/query support for free, and prevents the spelling drift
that free-text metadata invites ("Engineering" vs "Eng" vs "engineering").

**Alternatives considered:**
- **Free-text/select meta field:** simplest to write, but no controlled
  vocabulary, no first-class grouping, and duplicate-spelling drift. Rejected.

**Consequences:** Filtering and grouping staff by department is a taxonomy query,
not a metadata comparison. Any feature that narrows staff by department builds on
the taxonomy rather than reading a field off each person.

---

## ADR-005 — Follow existing patterns before introducing new ones

**Status:** Accepted · 2026-07-28

**Decision:** New work matches the conventions of the nearest existing feature.
The Staff Directory (PRD-01.1.01) is the reference implementation for content
modeling and dynamic blocks; mirror it.

**Rationale:** Consistency is worth more than local cleverness on a codebase
maintained by a rotating team. A reviewer should be able to predict where things
live and how they are shaped.

**Consequences:** Before building, read the analogous shipped feature. Introducing
a new dependency, a new architectural pattern, or a second way of doing something
that already has an established pattern is a decision to justify in the PR, not a
default.

---

_Managed by Fueled — Documentation-Driven Development_
