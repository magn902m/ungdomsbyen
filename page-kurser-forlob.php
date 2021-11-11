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

<head>
	<style>
		nav#filtrering {
			display: flex;
			justify-content: center;
			gap: 0.5rem;
			margin: 1.5rem;
		}	

		#speogsmaal {
			display: flex;
			justify-content: center;
			flex-direction: column;
			align-items: center;
			margin-top: 3rem;
		}

	</style>
</head>


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

				<main id="main">
				<nav id="filtrering">
					<button data-tema="alle">Alle</button>
				</nav>
				<section id="tema-oversigt">
					<article id="tema-article"></article>
				</section>

				<section id="speogsmaal">
				<hr>
				<h3>Har du spørgsmål til vores kurser og tilbud?</h3>
				<button>Kontakt os</button>
				</section>

				<template>
					<article>
						<img src="" alt="">
						<h2 class="title"></h2>
						<p class="niveau"></p>
						<p class="faglighed"></p>
						<p class="beskrivelse"></p>
						<button class="videre">Læs mere</button>
					</article>
				</template>

					

				</main><!-- #main -->

					<script>
						let kurser = [];
						let temaer = [];
						let ctema = [];
						let categories;
						let filter = "alle";
						const liste = document.querySelector("#tema-oversigt article");
						const skabelon = document.querySelector("template");

						const temaUrl = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/tema?per_page=100";	
						
						const catUrl = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/categories";
						const ctemaUrl = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/wp-json/wp/v2/ctema";

						// let ctema;

						async function getJSON() {
							const temaResponse = await fetch(temaUrl);
							const catResponse = await fetch(catUrl);
							const ctemaResponse = await fetch(ctemaUrl);
							temaer = await temaResponse.json();
							categories = await catResponse.json();
							ctemaer = await ctemaResponse.json();
							console.log(ctemaer);
							
							// console.log(categories);
							visTemaer();
							filterKnapper();
							
						}

						function filterKnapper (){
							categories.forEach(cat =>{
								document.querySelector("#filtrering").innerHTML += `<button class="filter" data-tema="${cat.id}">${cat.name}</button>`
							})
							addEventListenersToButton();

							// ctemaer.forEach(tema =>{
							// 	document.querySelector("#filtrering").innerHTML += `<button class="filter" data-tema="${tema.id}">${tema.name}</button>`
							// })
							// addEventListenersToButton();
						}

						function addEventListenersToButton(){
							document.querySelectorAll("#filtrering button").forEach(elm =>{
								elm.addEventListener("click", filtrering);
							})
						}

						function filtrering(){
							filter = this.dataset.tema;
							console.log(parseInt(filter));
							// console.log(filter);
							visTemaer();
						}

						function visTemaer() {
							console.log(temaer);
							liste.textContent = "";
							
							temaer.forEach(tema => {
								// console.log(tema.categories);
								
								if (filter == "alle" || tema.categories.includes(parseInt(filter))) {
								let klon = skabelon.cloneNode(true).content;

								klon.querySelector("img").src = tema.billede.guid;
								klon.querySelector(".title").textContent = tema.title.rendered;
								// klon.querySelector(".niveau").textContent = tema.title.rendered;
								// klon.querySelector(".faglighed").textContent = tema.title.rendered;
								// klon.querySelector(".beskrivelse").textContent = tema.title.rendered;


								klon.querySelector(".videre").addEventListener("click", () => {
								location.href = "https://designbymagnus.dk/kea/2_semester/tema9/ungdomsbyen/forside/kurser-forlob/" + tema.slug + "?id=" + tema.ctema;

								});
								// klon.querySelector("img").addEventListener("click", () => {
								// location.href = tema.link;
								// });
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
