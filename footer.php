</div>
<!--Wrap end-->

<?php if ( is_active_sidebar('secondary_widget_area') ) : ?>
    <div id="siteinfo" class="widget-area">
        <ul class="xoxo">
            <?php dynamic_sidebar('secondary_widget_area'); ?>
        </ul>
    </div><!-- #secondary .widget-area -->
<?php endif; ?>

<div id="footer">
  <p> Copyright &copy;&nbsp;<?php echo date('Y');?> <?php bloginfo('name'); ?></p>
  <p>Powered by WordPress and <a href="http://sudarmuthu.com/wordpress" title="Bright Light Theme" target="_blank"><?php _e('Bright Light Theme', 'bright-light');?></a></p>
<?php wp_footer(); ?>
</div>
</body>
</html>
