# MER-513 — Related articles are showing the wrong content

**Type:** Bug
**Epic:** Article Enhancements (Editorial)
**Severity:** High — visible on every article page
**Reported by:** Editorial QA

---

## User story

**As a** reader, **I want** the "Related articles" list to actually relate to the
article I'm reading **so that** I can keep reading something relevant instead of
a list that's wrong on every page.

## Summary

The "Related articles" list at the end of each article isn't behaving. Editorial
noticed it while reviewing published pieces: the recommendations don't match the
article you're reading, and they look the same no matter which article you open.

The feature is shipped and specified — see
[`requirements/.../related-content.prd.md`](../requirements/03-editorial/1-article-enhancements/related-content.prd.md)
for the intended behavior. This ticket is to make the behavior match that spec.

## Steps to reproduce

1. Open any published article and scroll to the **Related articles** list.
2. Note which articles it lists.
3. Open a **different** article — ideally in a clearly different category — and
   look at its Related articles list.
4. Compare the two.

## Expected vs. actual

**Expected:** each article recommends articles related to *that* article, two
different articles generally get different lists appropriate to each, and no
article ever lists itself.

**Actual:**
- Different articles show the **same** related list.
- The listed articles frequently have **nothing to do** with the article you're
  reading.
- On at least one article, the article **links to itself** in its own list.

No error appears anywhere — the section renders fine, it's just showing the wrong
content.

## What "done" looks like

- Find the real cause, fix it at the root, and confirm the fix against more than
  one article: different articles surface different, relevant sets, and nothing
  recommends itself.
- Make your reasoning visible in the PR: what you observed, what you concluded was
  actually wrong, and how you verified the fix holds.
