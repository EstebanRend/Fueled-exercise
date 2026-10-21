# Insight: How the People content model was decided

_Discovery note. Context for why the codebase is shaped the way it is — not a
specification. Where this disagrees with a PRD or the decision log, those win._

## What we were deciding

When we replaced the old hand-maintained staff page, the open question was how to
model a staff member's **department**: as a field on each person, or as a shared
classification.

## What we found

- Departments are a **small, slow-moving, controlled list** (single digits),
  owned centrally by Marketing/HR — not something an editor should invent while
  entering a person.
- We already knew a near-term requirement was coming to **filter the directory by
  department**. Grouping and filtering by a value is exactly what a taxonomy is
  for.
- An early spike that stored department as a free-text field produced
  "Engineering", "Eng", and "engineering" within the first week of content entry.
  That drift alone would have broken any grouping we built later.

This is what led to **ADR-004** (department is a taxonomy, not per-post metadata).

## A note on how much structure to add

We deliberately resisted the urge to build a "staff service" or a generic
data-access layer around this. It is one content type queried in a couple of
places; WordPress core already gives us everything we need to read it. Adding a
layer would have made the code harder to follow and the queries harder to see,
for no benefit at this size. This instinct is now written down as **ADR-003** —
use core APIs directly, don't add abstraction layers by default.

## Takeaway for new work

The Staff Directory is the reference implementation. If you are building anything
in the People domain (or a similar content-backed feature elsewhere), read it
first and match its shape before reaching for something new.
