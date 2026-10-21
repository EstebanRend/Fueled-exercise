# Tickets

These are the work items for this exercise. Treat them as you would real tickets
handed to you on a live project.

Each ticket is intentionally **high level**: it gives you the user story, the
context, and what "done" looks like — *what* and *why*, not *how*. **How you
implement it is your call.** We're evaluating your judgment: reading the existing
code, matching the house patterns, and making sound decisions.

| Ticket | Type | Title |
|--------|------|-------|
| [MER-482](T1-testimonial-block.md) | Feature | Testimonial block for marketing surfaces |
| [MER-497](T2-department-filtering.md) | Feature | Filter the staff directory by department |
| [MER-513](T3-related-content-bug.md) | Bug | Related articles are showing the wrong content |
| [MER-528](T4-market-snapshot.md) | Feature | Market snapshot on the homepage |

## How many to do

**Complete at least two — ideally all four.** Four isn't required; two is the
floor. Quality matters more than count, so if you're short on time, do fewer well
and say so in your PR, noting what you'd tackle with more. We read that as a
positive signal, not a gap.

## Ground rules

- **The ticket is the source of truth for the outcome.** It defines the user
  story and what "done" means. The implementation approach is yours to choose.
- **Match the codebase.** New work should be consistent with the existing
  patterns, not a parallel way of doing things bolted on. When in doubt, mirror
  the nearest shipped feature — the Staff Directory (`meridian/staff-list` and
  `meridian/staff-card`, the `staff_member` post type, and the `staff_department`
  taxonomy) is the reference.
- **The [decision log](../requirements/decision-log.md) is binding.** It records
  the conventions this codebase has committed to. If you think a decision is
  wrong for your ticket, raise it in your PR — don't silently work around it.
- **[`requirements/`](../requirements/index.md) is context, not a spec to
  build.** It documents what's *already* built and live. A ticket may build on a
  feature described there; where it does, the ticket says so.

How to submit your work is covered in the [main README](../README.md).
