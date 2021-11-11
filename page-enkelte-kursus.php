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

		<head>
			<style>
				#ret-oversigt {
					grid-column: 2/3;
				}

				button {
					border-radius: 0;
				}

				h1:not(.site-title):before, h2:before {
					background: #767676;
					content: "\020";
					display: none;
					height: 2px;
					margin: 1rem 0;
					width: 1em;
				}
				
				article.single-ret {
					padding: 0.5rem;
					border: 1px solid #000;
					background-color: rgb(176, 217, 255);
				}
			</style>
		</head>

				<main id="main" class="single-ret-main">
					<h2>Samme tekst</h2>
					<section id="ret-oversigt">
						<article class="single-ret">
							<button id="back_knap">Tilbage!</button>
							<h2><span class="navn"></span></h2>
							<img src="" alt="" class="billede" />
							<p><b>Kategori: </b><span class="kategorier"></span></p>
							<p><b>Beskrivelse: </b><span class="beskrivelse"></span></p>
							<p><b>Pris: </b><span class="pris"></span></p>
							<p>
							<b>Kontakt venlist personalet,<br />hvis du har allergier m.m.</b>
							</p>
						</article>
					</section>
				</main><!-- #main -->

				<script>
					const urlParams = new URLSearchParams(window.location.search);
						const id = urlParams.get("id");
					
					let kursus;

					const url = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/kursus/" + <?php echo get_the_ID() ?>;

					async function getJSON() {
						const response = await fetch(url);
						kursus = await response.json();
						visKursus();
					}

				function visKursus() {
						console.log(kursus);
						document.querySelector(".navn").textContent = kursus.title.rendered + "DET VIRKER";
						// document.querySelector(".billede").src = kursus.billede.guid;
						// document.querySelector(".kategorier").textContent = kursus.kategorier;
						// document.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
						// document.querySelector(".pris").textContent = kursus.pris + " kr.-";
					}

				getJSON();

				document.querySelector("#back_knap").addEventListener("click", () => {
				window.history.back();
				});
				</script>

			<?php do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>

