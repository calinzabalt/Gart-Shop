<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
	?>
    <style>
        .qty-controls input[type="number"]::-webkit-inner-spin-button,
        .qty-controls input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
	<div class="quantity gart-quantity-wrapper">
        <label class="qty-label" for="<?php echo esc_attr( $input_id ); ?>"><?php echo gart_t('CANTITATE'); ?></label>
        <div class="qty-controls">
            <button type="button" class="minus" onclick="var qty=this.nextElementSibling; var val=parseInt(qty.value); if(val>qty.min){qty.value=val-1; qty.dispatchEvent(new Event('change', {bubbles: true}));}">-</button>
            <?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
            <input
                type="number"
                id="<?php echo esc_attr( $input_id ); ?>"
                class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
                step="<?php echo esc_attr( $step ); ?>"
                min="<?php echo esc_attr( $min_value ); ?>"
                max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                name="<?php echo esc_attr( $input_name ); ?>"
                value="<?php echo esc_attr( $input_value ); ?>"
                title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
                size="4"
                placeholder="<?php echo esc_attr( $placeholder ); ?>"
                inputmode="<?php echo esc_attr( $inputmode ); ?>"
                autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
                style="border:none; text-align:center; width: 70px; padding: 0; margin: 0; -moz-appearance: textfield; pointer-events: none;"
            />
            <?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
            <button type="button" class="plus" onclick="var qty=this.previousElementSibling; var val=parseInt(qty.value); var max=parseInt(qty.max); if(!max || val<max){qty.value=val+1; qty.dispatchEvent(new Event('change', {bubbles: true}));}">+</button>
        </div>
	</div>
	<?php
}
