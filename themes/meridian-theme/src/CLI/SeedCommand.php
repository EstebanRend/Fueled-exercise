<?php
/**
 * WP-CLI seed command.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\CLI;

use Faker\Factory;
use Faker\Generator;
use MeridianTheme\PostTypes\StaffMember;
use MeridianTheme\PostTypes\Testimonial;
use TenupFramework\Module;
use TenupFramework\ModuleInterface;
use WP_Error;
use WP_Post;

/**
 * Seeds the site with demo content for the Meridian exercise.
 *
 * Registers `wp meridian seed`, which creates staff, testimonials, and articles
 * so the reference features have something to render on a fresh install.
 *
 * Content is generated with a fixed Faker seed, so every run produces the exact
 * same people, companies, dates, and body copy. Curated titles, quotes, and job
 * titles are hand-written; only supporting prose (bios, article bodies) and
 * attribution names/companies come from Faker.
 *
 * @package MeridianTheme
 */
class SeedCommand implements ModuleInterface {

	use Module;

	/**
	 * Option flag recording that the site has been seeded.
	 *
	 * @var string
	 */
	private const SEEDED_OPTION = 'meridian_demo_seeded';

	/**
	 * Fixed Faker seed so seeding is fully deterministic across runs.
	 *
	 * @var int
	 */
	private const FAKER_SEED = 20240517;

	/**
	 * Only register under WP-CLI.
	 *
	 * @return bool
	 */
	public function can_register() {
		return defined( 'WP_CLI' ) && \WP_CLI;
	}

	/**
	 * Register the command.
	 *
	 * @return void
	 */
	public function register() {
		\WP_CLI::add_command( 'meridian seed', [ $this, 'seed' ] );
	}

	/**
	 * Seed demo content.
	 *
	 * ## OPTIONS
	 *
	 * [--force]
	 * : Seed again even if the site has already been seeded.
	 *
	 * ## EXAMPLES
	 *
	 *     wp meridian seed
	 *     wp meridian seed --force
	 *
	 * @param array<int, string>    $args       Positional arguments.
	 * @param array<string, string> $assoc_args Associative arguments.
	 * @return void
	 */
	public function seed( $args, $assoc_args ) {
		$force = isset( $assoc_args['force'] );

		if ( get_option( self::SEEDED_OPTION ) && ! $force ) {
			\WP_CLI::warning( 'Already seeded. Re-run with --force to seed again.' );
			return;
		}

		$this->require_media_dependencies();
		$this->remove_default_content();

		$faker = Factory::create();
		$faker->seed( self::FAKER_SEED );

		$staff        = $this->seed_staff( $faker );
		$testimonials = $this->seed_testimonials( $faker );
		$articles     = $this->seed_articles( $faker );

		update_option( self::SEEDED_OPTION, true );

		\WP_CLI::success(
			sprintf(
				'Seeded %d staff members, %d testimonials, and %d articles.',
				$staff,
				$testimonials,
				$articles
			)
		);
	}

	/**
	 * Remove WordPress's canned starter content.
	 *
	 * A fresh install ships a "Hello world!" post, a "Sample Page", and a
	 * privacy-policy draft, which would otherwise pollute the demo (e.g. the
	 * stray post surfacing in the homepage insights loop with no cover image).
	 * Force-deleting the default post also removes its default comment. Safe to
	 * run repeatedly — anything already gone is simply skipped.
	 *
	 * @return void
	 */
	private function remove_default_content(): void {
		$slugs = [ 'hello-world', 'sample-page', 'privacy-policy' ];

		foreach ( $slugs as $slug ) {
			// An explicit status list (not 'any') is required: in a user-less
			// WP-CLI context 'any' omits protected statuses, so the stock
			// privacy-policy page ships as a draft and would survive.
			$posts = get_posts(
				[
					'name'        => $slug,
					'post_type'   => [ 'post', 'page' ],
					'post_status' => [ 'publish', 'draft', 'pending', 'private', 'future' ],
				]
			);

			foreach ( $posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
		}
	}

	/**
	 * Create staff members across departments.
	 *
	 * Six members are spread across the four departments. Names and bios come
	 * from Faker; job titles are curated per department. Each member gets a
	 * deterministic portrait sideloaded as the featured image.
	 *
	 * @param Generator $faker Seeded Faker generator.
	 * @return int Number of staff members created.
	 */
	private function seed_staff( Generator $faker ): int {
		/**
		 * Department and a curated, department-appropriate job title.
		 *
		 * @var array<int, array{0: string, 1: string}> $roster
		 */
		$roster = [
			[ 'Wealth Management', 'Managing Director, Wealth' ],
			[ 'Wealth Management', 'Senior Wealth Advisor' ],
			[ 'Investment Research', 'Head of Research' ],
			[ 'Investment Research', 'Portfolio Manager' ],
			[ 'Private Banking', 'Private Banker' ],
			[ 'Client Advisory', 'Financial Planner' ],
		];

		$created = 0;

		foreach ( $roster as $person ) {
			list( $department, $title ) = $person;

			$name = $faker->name();
			$bio  = $faker->sentence( 14 ) . ' ' . $faker->sentence( 10 );
			$slug = sanitize_title( $name );

			$post_id = $this->upsert_post(
				[
					'post_type'    => 'staff_member',
					'post_status'  => 'publish',
					'post_title'   => $name,
					'post_content' => $bio,
					'post_excerpt' => $bio,
				],
				$slug
			);

			if ( $post_id instanceof WP_Error ) {
				\WP_CLI::warning( sprintf( 'Could not create staff member "%s": %s', $name, $post_id->get_error_message() ) );
				continue;
			}

			update_post_meta( $post_id, StaffMember::JOB_TITLE_META_KEY, $title );
			wp_set_object_terms( $post_id, $department, 'staff_department' );

			$this->sideload_featured_image(
				$post_id,
				sprintf( 'https://i.pravatar.cc/600?u=%s', rawurlencode( $slug ) ),
				$slug . '-portrait.jpg',
				sprintf( 'Portrait of %s', $name )
			);

			++$created;
		}

		return $created;
	}

	/**
	 * Create testimonials with attribution meta.
	 *
	 * Quotes and roles are curated; the attributed person's name and company are
	 * generated with Faker.
	 *
	 * @param Generator $faker Seeded Faker generator.
	 * @return int Number of testimonials created.
	 */
	private function seed_testimonials( Generator $faker ): int {
		/**
		 * Curated quote paired with a curated role.
		 *
		 * @var array<int, array{0: string, 1: string}> $testimonials
		 */
		$testimonials = [
			[
				'Meridian brought real discipline to our portfolio and explained the reasoning behind every decision. For the first time, we feel in control of our financial future.',
				'Private Client',
			],
			[
				'They restructured our family\'s wealth and tax plan with a rigor our previous firm never showed — and the difference has been substantial.',
				'Family Office Principal',
			],
			[
				'Meridian treats our endowment\'s capital as carefully as we do: thoughtful, transparent, and genuinely aligned with our long-term goals.',
				'Chief Financial Officer',
			],
		];

		$created = 0;

		foreach ( $testimonials as $testimonial ) {
			list( $quote, $role ) = $testimonial;

			$name    = $faker->name();
			$company = $faker->company();
			$slug    = sanitize_title( $name );

			$post_id = $this->upsert_post(
				[
					'post_type'    => 'testimonial',
					'post_status'  => 'publish',
					'post_title'   => $name,
					'post_content' => $quote,
				],
				$slug
			);

			if ( $post_id instanceof WP_Error ) {
				\WP_CLI::warning( sprintf( 'Could not create testimonial for "%s": %s', $name, $post_id->get_error_message() ) );
				continue;
			}

			update_post_meta( $post_id, Testimonial::ROLE_META_KEY, $role );
			update_post_meta( $post_id, Testimonial::COMPANY_META_KEY, $company );

			++$created;
		}

		return $created;
	}

	/**
	 * Create articles across a few categories.
	 *
	 * Nine posts are split evenly across News, Insights, and Case Studies (three
	 * each) so category-driven features have candidates in every group. Titles
	 * and excerpts are curated; bodies are Faker paragraphs. Each post gets a
	 * deterministic cover image sideloaded as the featured image.
	 *
	 * @param Generator $faker Seeded Faker generator.
	 * @return int Number of articles created.
	 */
	private function seed_articles( Generator $faker ): int {
		/**
		 * Curated title, curated excerpt, and category name.
		 *
		 * @var array<int, array{0: string, 1: string, 2: string}> $articles
		 */
		$articles = [
			[
				'Meridian Surpasses $4B in Assets Under Management',
				'A milestone that reflects the trust our clients place in us — and our commitment to disciplined, long-term stewardship of their capital.',
				'News',
			],
			[
				'Meridian Opens a New Private Client Office in Chicago',
				'Our third office deepens our presence in the Midwest and brings senior advisors closer to the families and institutions we serve.',
				'News',
			],
			[
				'Welcoming Two Senior Advisors to Our Wealth Team',
				'Two seasoned practitioners join Meridian this quarter, expanding our capacity across wealth planning and investment research.',
				'News',
			],
			[
				'What the Latest Rate Decision Means for Long-Term Portfolios',
				'Short-term moves rarely justify long-term changes. Here is how we weigh a shift in rates without abandoning a disciplined plan.',
				'Insights',
			],
			[
				'The Case for Tax-Aware Investing',
				'Where you hold an asset can matter as much as what you hold. A look at how asset location quietly compounds after-tax returns.',
				'Insights',
			],
			[
				'Rebalancing Through a Volatile Quarter',
				'Volatility is the price of long-run returns, not a reason to abandon your allocation. Our framework for staying the course with intent.',
				'Insights',
			],
			[
				'Building a Multi-Generational Wealth Transfer Plan',
				'How we helped one family coordinate estate, tax, and philanthropic goals into a single plan spanning three generations.',
				'Case Studies',
			],
			[
				'Repositioning a Concentrated Stock Position',
				'A founder came to us with most of their net worth in a single stock. Here is how we diversified the risk without a punitive tax bill.',
				'Case Studies',
			],
			[
				'Endowing a Foundation for the Long Term',
				'We partnered with a nonprofit to design a spending policy and portfolio built to fund its mission in perpetuity.',
				'Case Studies',
			],
		];

		$created = 0;

		foreach ( $articles as $article ) {
			list( $title, $excerpt, $category ) = $article;

			$slug = sanitize_title( $title );

			$post_id = $this->upsert_post(
				[
					'post_type'    => 'post',
					'post_status'  => 'publish',
					'post_title'   => $title,
					'post_excerpt' => $excerpt,
					'post_content' => $this->build_article_body( $faker ),
				],
				$slug
			);

			if ( $post_id instanceof WP_Error ) {
				\WP_CLI::warning( sprintf( 'Could not create article "%s": %s', $title, $post_id->get_error_message() ) );
				continue;
			}

			wp_set_object_terms( $post_id, $category, 'category' );

			$this->sideload_featured_image(
				$post_id,
				sprintf( 'https://picsum.photos/seed/%s/1200/800', rawurlencode( $slug ) ),
				$slug . '-cover.jpg',
				sprintf( 'Cover image for %s', $title )
			);

			++$created;
		}

		return $created;
	}

	/**
	 * Build a post body of three Faker paragraphs wrapped in paragraph blocks.
	 *
	 * @param Generator $faker Seeded Faker generator.
	 * @return string Block-editor markup for the post body.
	 */
	private function build_article_body( Generator $faker ): string {
		/**
		 * Rendered paragraph blocks.
		 *
		 * @var array<int, string> $blocks
		 */
		$blocks = [];

		for ( $i = 0; $i < 3; $i++ ) {
			$blocks[] = sprintf(
				'<!-- wp:paragraph --><p>%s</p><!-- /wp:paragraph -->',
				esc_html( $faker->paragraph() )
			);
		}

		return implode( "\n\n", $blocks );
	}

	/**
	 * Insert a post, or update the existing one that shares its slug.
	 *
	 * Using a stable slug keeps a `--force` re-run idempotent: it refreshes the
	 * existing post in place rather than creating a duplicate.
	 *
	 * @param array{ID?: int, post_type?: string, post_status?: string, post_title?: string, post_content?: string, post_excerpt?: string, post_name?: string} $postarr Data for wp_insert_post().
	 * @param string                                                                                                                                           $slug    Stable slug identifying the post.
	 * @return int|WP_Error Post ID on success, WP_Error on failure.
	 */
	private function upsert_post( array $postarr, string $slug ) {
		$post_type = isset( $postarr['post_type'] ) ? $postarr['post_type'] : 'post';

		$existing = get_page_by_path( $slug, OBJECT, $post_type );

		if ( $existing instanceof WP_Post ) {
			$postarr['ID'] = $existing->ID;
		}

		$postarr['post_name'] = $slug;

		return wp_insert_post( $postarr, true );
	}

	/**
	 * Sideload an external image and set it as the post's featured image.
	 *
	 * Failures are non-fatal: a WP_Error is surfaced as a warning and seeding
	 * continues without the image, so an offline or rate-limited image service
	 * never aborts the run. Posts that already have a featured image (e.g. on a
	 * `--force` re-run) are skipped so we never sideload the same image twice.
	 *
	 * @param int    $post_id     Post to attach the image to.
	 * @param string $url         Remote image URL.
	 * @param string $filename    Filename (with extension) to store the image as.
	 * @param string $description Human-readable description for the attachment.
	 * @return void
	 */
	private function sideload_featured_image( int $post_id, string $url, string $filename, string $description ): void {
		if ( get_post_thumbnail_id( $post_id ) ) {
			return;
		}

		$temp_file = download_url( $url );

		if ( is_wp_error( $temp_file ) ) {
			\WP_CLI::warning( sprintf( 'Skipping featured image for post %d: %s', $post_id, $temp_file->get_error_message() ) );
			return;
		}

		$file_array = [
			'name'     => $filename,
			'tmp_name' => $temp_file,
		];

		$attachment_id = media_handle_sideload( $file_array, $post_id, $description );

		if ( $attachment_id instanceof WP_Error ) {
			if ( file_exists( $temp_file ) ) {
				wp_delete_file( $temp_file );
			}

			\WP_CLI::warning( sprintf( 'Skipping featured image for post %d: %s', $post_id, $attachment_id->get_error_message() ) );
			return;
		}

		set_post_thumbnail( $post_id, $attachment_id );
	}

	/**
	 * Load the core admin files that expose the media sideloading helpers.
	 *
	 * These are not loaded by default under WP-CLI, so require them once before
	 * calling download_url() / media_handle_sideload().
	 *
	 * @return void
	 */
	private function require_media_dependencies(): void {
		if ( function_exists( 'media_handle_sideload' ) ) {
			return;
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}
}
