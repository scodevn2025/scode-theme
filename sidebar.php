<?php
/**
 * The sidebar containing the main widget area
 *
 * @package SCODE_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="sidebar no-scrollbar" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
    
    <!-- Default Sidebar Content if no widgets -->
    <?php if (!is_active_sidebar('sidebar-1')) : ?>
        <div class="widget">
            <h3 class="widget-title">Sidebar</h3>
            <p>Add widgets to this area in the WordPress admin.</p>
        </div>
    <?php endif; ?>
</aside>
