<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link:
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen_Child
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="profile" href="https://gmpg.org/xfn/11" />
		<link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<?php wp_head(); ?>

		<!-- Required meta tags -->
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentynineteen' ); ?></a>

			<!-- Header Area wrapper Starts -->
			<header id="header-wrap" class="site-header">
				<!-- Header top bar Start -->
				<div id="header-topbar" class="d-flex justify-content-between  align-items-center">
					<div class="align-self-center">
						<span><a href="tel:+1300078237" target="_blank" style="color: #fff;"><i class="fas fa-phone-square-alt"></i> 1300 078 237</a></span>
					</div>
					<div class="align-self-center">&nbsp;</div>
					<?php
					wp_nav_menu( array(
						// 'echo'            => true,
						// 'fallback_cb'     => 'wp_page_menu',
						// 'item_spacing'    => 'preserve',
						'menu'            => 'sociallink-menu',
						'container'       => 'div',
						'container_class' => 'align-self-center',
						'container_id'    => 'header-topbar-social',
						//'menu_id'        => '',
						'menu_class'     => 'social-links',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'          => 1,
						'fallback_cb'       => false,
						//'walker' => new Icon_Walker()
					) );

					class Icon_Walker extends Walker_Nav_Menu {
						function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
						{
							// Check the reference file for most of this

							// This is the class you set in the menu page.
							// Alternatively, you could use the any of the other inputs from the menu page
							$icon_class = $item->classes;

							//This goes before https://core.trac.wordpress.org/browser/tags/3.8.1/src//wp-includes/nav-menu-template.php#L151
							$item_output .= '<i class="' . $icon_class . '"></i>fsdgdd<br>';
							// basically copy the rest of the reference method
						}
					}
					?>
				</div>

				<!-- Navbar Start -->
				<nav class="main-nav">
					<div class="main-nav__heading">
						<?php if ( has_custom_logo() ) : ?>
						<div class="main-nav__logo">
							<?php the_custom_logo('main-nav__logo-link'); ?>
						</div>

						<?php else: ?>
						<div class="main-nav__logo">
							<a href="/" target="_blank" rel="nofollow" title="Alphastud Logo" class="main-nav__logo-link">Brand</a>
						</div>
						<?php endif; ?>

						<button id="toggle-nav">
							menu
						</button>
					</div>
					<?php
					// 						$registered_nav_menus = get_registered_nav_menus();
					// 						if ( isset( $registered_nav_menus[ 'primary' ] ) ) {
					// 							echo "a";
					// 						} else {
					// 							echo "no menu";
					// 						}

					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'menu'            => 'main-menu',
						'container'       => false,
						//'container_class' => '',
						//'container_id'    => '',
						'menu_class'      => 'main-nav__menu',
						'menu_id'         => '',
						'depth'				=> 2,
						'fallback_cb'    => false,
						'echo'           => true,
						'walker'          =>  new My_Walker_Nav_Menu()
					), );
					?> 

				</nav>
				<!-- Navbar End -->

			</header>
			<!-- Header Area wrapper End -->

			<?php if ( is_singular() && twentynineteen_can_show_post_thumbnail() ) : ?>
			<section id="hero-banner" class="<?php echo is_singular('post') && twentynineteen_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; ?>" style="min-height: 40vh!important;margin-bottom: 0rem!important;">
	
				<div class="site-featured-image">
					<?php
					twentynineteen_post_thumbnail();
					the_post();
					$discussion = ! is_page() && twentynineteen_can_show_post_thumbnail() ? twentynineteen_get_discussion_data() : null;

					$classes = 'entry-header';
					if ( ! empty( $discussion ) && absint( $discussion->responses ) > 0 ) {
						$classes = 'entry-header has-discussion';
					}
					?>
					<div class="<?php echo $classes; ?>">
						<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
					</div><!-- .entry-header -->
					<?php rewind_posts(); ?>
				</div>
			</section>
			<?php endif; ?>
			<script>
				"use strict";

				// Helper function
				function addListenerToElement(element, eventType, listener) {
					element.addEventListener(eventType, listener);
				}

				// Add "active" class to clicked element, remove it from siblings and toggle show in sub-menus
				function toggleActiveClass() {
					let parentElement = this.parentNode;
					let siblings = parentElement.parentNode.children;
					let dropDown = this.nextElementSibling;

					for (const value of siblings) {
						if (value.classList.contains("main-nav__menu-item--active")) {
							value.classList.remove("main-nav__menu-item--active");
						}
					}
					if (!parentElement.classList.contains("main-nav__menu-item--active")) {
						parentElement.classList.add("main-nav__menu-item--active");
					}
					if (dropDown !== null) {
						dropDown.classList.toggle("main-nav__sub-menu--show");
					}
				}

				// Close the open dropdow clicking everywhere
				function closeDropdown(event) {
					let dropDownShow = document.getElementsByClassName(
						"main-nav__sub-menu--show"
					)[0];

					if (
						dropDownShow !== undefined &&
						dropDownShow.previousElementSibling !== event.target
					) {
						dropDownShow.classList.remove("main-nav__sub-menu--show");
					}
				}

				// Toggle animated menu opening in mobile view, dynamically based on menu items quantity
				function toggleNav() {
					console.log( this.parentNode.nextElementSibling);
					console.log( document.getElementsByClassName("main-nav__menu-item"));
					const navBar = this.parentNode.nextElementSibling;
					const menuItem = document.getElementsByClassName("main-nav__menu-item");
					const menuItemHeight = menuItem[0].offsetHeight;
					const menuItemLength = menuItem.length;
					const menuHeight = menuItemHeight * menuItemLength;

					navBar.classList.toggle("main-nav__menu--open");

					if (navBar.classList.contains("main-nav__menu--open")) {
						navBar.animate([{ height: "0" }, { height: menuHeight + "px" }], {
							duration: 500,
							easing: "ease-in-out"
						});
					} else {
						navBar.animate([{ height: menuHeight + "px" }, { height: "0" }], {
							duration: 500,
							easing: "ease-in-out"
						});
					}
				}

				let menuItems = document.querySelectorAll(".main-nav__menu-item-link");
				let toggleButton = document.getElementById("toggle-nav");

								for (const value of menuItems) {
									addListenerToElement(value, "click", toggleActiveClass);
								}

				addListenerToElement(window, "mouseup", closeDropdown);
				addListenerToElement(toggleButton, "click", toggleNav);
			</script>