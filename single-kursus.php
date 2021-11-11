<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package OceanWP WordPress theme
 */

get_header(); ?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'ocean_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'ocean_before_content' ); ?>

			<div id="content" class="site-content clr">

				<?php do_action( 'ocean_before_content_inner' ); ?>

				<?php
				// Elementor `single` location.
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

					// Start loop.
					while ( have_posts() ) :
						the_post();

						if ( is_singular( 'download' ) ) {

							// EDD Page.
							get_template_part( 'partials/edd/single' );

						} elseif ( is_singular( 'page' ) ) {

							// Single post.
							get_template_part( 'partials/page/layout' );

						} elseif ( is_singular( 'oceanwp_library' ) || is_singular( 'elementor_library' ) ) {

							// Library post types.
							get_template_part( 'partials/library/layout' );

						} else {

							// All other post types.
							get_template_part( 'partials/single/layout', get_post_type() );

						}

					endwhile;

				}
				?>

				<main id="main" class="single-kursus-main">
					<section id="kursus-oversigt">
						<button id="back_knap">Tilbage til katalog</button>
						<article id="hoved_info">
							<h2 class="navn"></h2>
							<p class="beskrivelse"></p>
							<button>Book kursus</button>
							<p></p>
							<img src="" alt="" class="billede" />
						</article>

						<article id="info_box_outer">
						<div id="info_box_inner">
							<p class="niveau"></p>
							<p>Faglighed:<span class="faglighed"></span> </p>
							<p class="varighed">Varighed 09:00 - 14:00</p>
							<p class="antal_deltager">Min. 12 elever - max. 28 elever</p>
							<p class="forberedelse">Ingen forberedelse</p>
							<p class="pris">i alt 2500 kr,-</p>
							<button>Book kurset</button>
						</div>

						<article>
							<h2></h2>
							<p></p>
						</article>


						<article id="speogsmaal">
							<hr>
							<h3>Har du spørgsmål til vores kurser og tilbud?</h3>
							<button>Kontakt os</button>
						</article>

					</section>
				</main><!-- #main -->

				<script>
					// const urlParams = new URLSearchParams(window.location.search);
					// const id = urlParams.get("id");
					
					let kursus;

					const url = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/kursus/" + <?php echo get_the_ID() ?>;

					async function getJSON() {
						const response = await fetch(url);
						kursus = await response.json();
						visKursus();
						console.log(kursus);
					}

					function visKursus() {
							document.querySelector(".navn").textContent = kursus.titel;
							document.querySelector(".billede").src = kursus.billede.guid;
							document.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
							document.querySelector(".niveau").textContent = kursus.niveau;
							document.querySelector(".faglighed").textContent = kursus.faglighed;
						}

					

					document.querySelector("#back_knap").addEventListener("click", () => {
					window.history.back();
					});

					getJSON();
				</script>

			<?php do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>

