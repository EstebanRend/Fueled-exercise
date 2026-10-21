# Insight: Performance characteristics we design around

_Discovery note. Context, not specification._

## Traffic shape

The site's traffic is dominated by two kinds of page:

- **Article reading pages** (Editorial). High volume, long tail, frequently the
  entry point from search. These are our hottest pages.
- **The homepage** (Marketing). High volume, but a single cached surface.

The Staff Directory (People) is comparatively low traffic.

## Where cost concentrates

The expensive work on this site is not rendering a single post — it is the
queries that reason **across** the article archive. Anything that, for each page
view, asks "what else on the site relates to this?" multiplies a non-trivial
query by our highest-traffic surface. Related-content recommendations are the
clearest example.

Our standing approach is to cache those cross-content queries rather than
recompute them on every request. Caching is the right lever here because the
inputs change slowly relative to how often the pages are viewed.

## Takeaway for new work

Fast is a feature, but "it returned quickly" is not the same as "it returned the
right thing." On the hot paths, confirm both.
