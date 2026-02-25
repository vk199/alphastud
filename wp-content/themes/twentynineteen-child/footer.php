<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>
<!-- Footer Section Start -->
  <footer id="footer" class="footer-area">
  <!-- <div id="footer-top" class="container-fluid">
    <div class="row">
      <div class="col-12">
        
      </div>
    </div>
  </div> -->
    <div id="footer-body" class="container-fluid">
      <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
            <div class="widget">
            <img src="/wp-content/uploads/2020/06/alphastud-logo-f4.png" title="footer logo" alt="footer logo" style="max-height: 65px;max-width: 175px;">
            <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer',
            'menu'            => 'footer-menu',
            'menu_class'     => 'footer-menu, footer-link',
            'depth'          => 1,
          )
        );
        ?>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
    <?php if ( has_nav_menu( 'footer' ) ) : ?>
      <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentynineteen' ); ?>">				
      <!-- <h3 class="footer-title">Resources</h3> -->
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer',
            'menu'            => 'footer-menu1',
            'menu_class'     => 'footer-menu, footer-link',
            'depth'          => 1,
          )
        );
        ?>
      </nav><!-- .footer-navigation -->
    <?php endif; ?>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <!-- <h3 class="footer-title">Others</h3> -->
            <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer',
            'menu'            => 'footer-menu2',
            'menu_class'     => 'footer-menu, footer-link',
            'depth'          => 1,
          )
        );
        ?>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <h3 class="footer-title">Contact</h3>
            <ul class="address">
              <li>
                <a href="https://goo.gl/maps/jMWb4LZEYzBkau9LA" target="_blank">Richard Camilleri, Po Box 300 Gladesville NSW, 1675</a>
              </li>
              <li>
                <a href="tel:+1300078237" target="_blank">P: 1300 078 237</a>
              </li>
              <li>
                <a href="mailto:richard@alphastud.com.au">E: richard@alphastud.com.au</a>
              </li>
            </ul>
          </div>
        </div>
    </div> 
    <div id="copyright" class="container-fluid">
      <div class="row">
          <div class="col-12">
            <div class="copyright-content text-center">
              <p>Copyright © 2020 Alphastud. All Right Reserved</p>
            </div>
          </div>
        </div>
    </div>   
  </footer> 
  <!-- Footer Section End -->

  <!-- Go to Top Link -->
  <a href="#" class="back-to-top">
    <span title="Back to top">⇪</span>
  </a>
  

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
