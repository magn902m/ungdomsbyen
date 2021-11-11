<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
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

						get_template_part( 'partials/page/layout' );

					endwhile;

				}
				?>

				<div id="primary" class="content-area">
					
					<main id="main" class="page-Kurser-main">
					<section id="kursus-oversigt">
						<article id="kursus-article"></article>
					</section>

				<template>
					<article>
						<img class="billede" src="" alt="">
						<h2 class="title"></h2>
						<p><span class="niveau"></span> </p>
						<p><span class="faglighed"></span> </p>
						<p class="beskrivelse"></p>
						<button class="videre">Læs mere</button>
					</article>
				</template>

				</main><!-- #main -->

					<script>
						let kurser = [];
						let ctema;
						let filter = "alle";
						const liste = document.querySelector("#kursus-oversigt article");
						const skabelon = document.querySelector("template");

						const dbUrl = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/kursus?per_page=100";
						const ctemaUrl = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/ctema";

						const urlParams = new URLSearchParams(window.location.search);
						const ctemaId = urlParams.get("id");
						console.log(ctemaId);

						async function getJSON() {
							const response = await fetch(dbUrl);
							const ctemaResponse = await fetch(ctemaUrl);
							kurser = await response.json();
							ctema = await ctemaResponse.json();
							visKurser();
						}

						function visKurser() {
							console.log(kurser);
							liste.textContent = "";
							
							kurser.forEach(kursus => {
								// console.log(kursus.ctema);

								if (kursus.ctema.includes(parseInt(ctemaId))) {
								let klon = skabelon.cloneNode(true).content;

								klon.querySelector(".title").textContent = kursus.title.rendered;
								klon.querySelector(".billede").src = kursus.billede.guid;
								klon.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
								klon.querySelector(".niveau").textContent = kursus.niveau;
								klon.querySelector(".faglighed").textContent = kursus.faglighed;

								klon.querySelector(".billede").addEventListener("click", () => {
								location.href = kursus.link;
								});
								klon.querySelector(".videre").addEventListener("click", () => {
								location.href = kursus.link;
								});
								liste.appendChild(klon);
								}
							});
						}
						
						getJSON();

					</script>
				</div><!-- #primary -->

				<?php do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>
