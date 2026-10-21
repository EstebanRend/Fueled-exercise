#!/usr/bin/env bash
#
# Provision the local wp-env site.
#
# Invoked by the `afterStart` lifecycle script in .wp-env.json, so it runs on
# every `npx @wordpress/env start`. wp-env runs lifecycle scripts on the HOST
# from the repo root. The Node steps (install + build) run on the host (Node is
# the only host prerequisite); the theme's Composer install is delegated to the
# container, which runs PHP 8.4 — so the host's PHP version is irrelevant.
#
# Each host step is guarded so it only runs when its output is missing: the
# first `start` does the full install + build; later starts skip straight to the
# WordPress steps and stay fast. To force a clean rebuild, delete node_modules,
# themes/meridian-theme/vendor, or themes/meridian-theme/dist and start again.
#
# Ordering matters: the theme's vendor/ is bind-mounted into the container and
# required at runtime by functions.php, so Composer MUST succeed before the
# theme is activated below.

set -euo pipefail

# Run a WP-CLI command inside the wp-env `cli` container.
wp() { npx --yes @wordpress/env run cli wp "$@"; }

# 1. Node dependencies — needed to build the theme assets.
if [ ! -d node_modules ]; then
	npm install
fi

# 2. Theme Composer dependencies, installed INSIDE the container — which runs
#    PHP 8.4 and ships Composer — so the host's PHP version doesn't matter and no
#    local PHP/Composer is needed to run the site. vendor/ is bind-mounted back
#    to the host. dev deps are included (Faker, which `wp meridian seed` needs).
#
#    `--no-plugins` is required here: the phpcs composer-installer plugin scans
#    the just-extracted vendor/ dirs on the bind mount right after install, which
#    intermittently fails ("RecursiveDirectoryIterator ... Failed to open
#    directory") due to host<->container filesystem sync lag. That plugin only
#    wires up phpcs for linting and is irrelevant to running/seeding the site.
if [ ! -f themes/meridian-theme/vendor/autoload.php ]; then
	npx --yes @wordpress/env run cli composer install --no-plugins --no-interaction --working-dir=wp-content/themes/meridian-theme
fi

# 3. Build the theme assets (dist/).
if [ ! -d themes/meridian-theme/dist ]; then
	npm run build
fi

# 4. Install WordPress if it isn't already (self-heals an interrupted first start).
if ! wp core is-installed >/dev/null 2>&1; then
	wp core install \
		--url=http://localhost:8888 \
		--title=Meridian \
		--admin_user=admin \
		--admin_password=password \
		--admin_email=admin@example.com \
		--skip-email
fi

# 5. Activate the theme, seed demo content, flush rewrite rules.
wp theme activate meridian-theme
wp meridian seed
wp rewrite flush
