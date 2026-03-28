<?php
/**
 * Result Count
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_get_loop_prop( 'total' ) ) {
    return;
}

$total = wc_get_loop_prop( 'total' );
?>

<p class="woocommerce-result-count" role="alert" aria-relevant="all">
    <?php
    printf( 'Se afișează %d produse', $total );
    ?>
</p>