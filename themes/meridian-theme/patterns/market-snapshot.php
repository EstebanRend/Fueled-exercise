<?php
/**
 * Title: Market Snapshot (placeholder)
 * Slug: meridian-theme/market-snapshot
 * Description: Homepage market-snapshot band. Placeholder for ticket MER-528.
 * Inserter: false
 *
 * @package MeridianTheme
 *
 * MER-528 · This is the market snapshot placeholder, included on the homepage
 * (templates/front-page.html) as a partial. It renders the index names with
 * dashes and an "Awaiting live data" note — nothing fetches live data yet.
 * The ticket (tickets/T4-market-snapshot.md) is to replace this static content
 * with a dynamic, server-rendered snapshot from a public market-data source.
 */

?>
<!-- wp:html -->
<div class="meridian-markets__grid" role="presentation">
	<div class="meridian-markets__item">
		<span class="meridian-markets__label">Dow Jones</span>
		<span class="meridian-markets__value">—</span>
		<span class="meridian-markets__change">Awaiting live data</span>
	</div>
	<div class="meridian-markets__item">
		<span class="meridian-markets__label">S&amp;P 500</span>
		<span class="meridian-markets__value">—</span>
		<span class="meridian-markets__change">Awaiting live data</span>
	</div>
	<div class="meridian-markets__item">
		<span class="meridian-markets__label">Nasdaq</span>
		<span class="meridian-markets__value">—</span>
		<span class="meridian-markets__change">Awaiting live data</span>
	</div>
</div>
<!-- /wp:html -->
