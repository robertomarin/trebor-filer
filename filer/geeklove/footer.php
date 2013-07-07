    <?php stag_content_end(); ?>

    <?php stag_footer_before(); ?>

      <?php if(is_sidebar_active('footer')): ?>
      <div class="footer-outer">
        <!-- BEGIN .footer -->
        <footer class="footer grids" role="contentinfo">
          <?php stag_footer_start(); ?>

          <?php dynamic_sidebar('sidebar-footer'); ?>

          <?php stag_footer_end(); ?>
          <!-- END .footer -->
        </footer>
      </div>
      <?php endif; ?>

      <div class="footer-copyright-wrap">
        <footer class="footer-copyright">
          <?php echo stag_get_option('blog_footer'); ?>
        </footer>
      </div>

    <?php stag_footer_after(); ?>
  <script>window.wpurl = '<?php echo home_url(); ?>';</script>
  <?php wp_footer(); ?>
  <?php stag_body_end(); ?>
  </body>
</html>