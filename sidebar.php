<?php

if ( ! is_active_sidebar(  'sidebar-1' ) ) {
    return;
}

?>

<!-- Shop Sidebar Start -->
<div class="cot-md-4 woostudy-sidebar">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
<!-- Shop Sidebar End -->