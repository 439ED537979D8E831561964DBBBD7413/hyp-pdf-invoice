<?php
/**
 * The Template for invoice details
 *
 * Override this template by copying it to [your theme]/woocommerce/invoice/ywpi-invoice-details.php
 *
 * @author        Yithemes
 * @package       yith-woocommerce-pdf-invoice-premium/Templates
 * @version       1.0.0
 */

/** @var YITH_Document $document */

$invoice_details = new YITH_Invoice_Details( $document );
/** @var WC_Order_Refund $order */

$order   = $document->order;
$parent_order   = wc_get_order( $order->get_parent_id() );
$invoice_details = new YITH_Invoice_Details( $document );
$wc_ge_3 = version_compare( WC()->version, '3.0', '>=' );

?>
<table class="credit-note-details">
    <thead>
    <tr>
        <th class="column-product"><?php _e('Product', 'yith-woocommerce-pdf-invoice'); ?></th>

        <th class="column-quantity"><?php _e('Qty', 'yith-woocommerce-pdf-invoice'); ?></th>

        <th class="column-refund-text"><?php _e('Description', 'yith-woocommerce-pdf-invoice'); ?></th>

        <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
            <th class="column-amount"><?php _e('Subtotal', 'yith-woocommerce-pdf-invoice'); ?></th>
        <?php endif; ?>

        <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
            <th class="column-amount"><?php _e('Total tax', 'yith-woocommerce-pdf-invoice'); ?></th>
        <?php endif; ?>

        <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
            <th class="column-amount"><?php _e( 'Shipping', 'yith-woocommerce-pdf-invoice' ); ?></th>
        <?php endif; ?>

        <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
            <th class="column-amount"><?php _e('Total', 'yith-woocommerce-pdf-invoice'); ?></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>

    <?php

    /** @var WC_Product $_product */
    foreach ( $parent_order->get_items() as $item_id => $item ) {
        $_product = $invoice_details->get_item_product( $item );

        if ( $order->get_total() == ($parent_order->get_total() * -1) ) {
        ?>
        <tr>
            <td class="column-product" style="color: red"><?php echo apply_filters('woocommerce_order_product_title', $item['name'], $_product); ?></td>

            <td class="column-quantity" style="color: red; text-align: center"><?php echo (isset($item['qty'])) ? '-' . esc_html($item['qty']) : '' ; ?></td>

            <td class="column-refund-text" style="color: red"><?php echo ''; ?></td>

            <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
                <td class="column-amount" style="color: red">
                    <?php echo '-' . $invoice_details->get_order_currency_new($item['subtotal']); ?>
                </td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
                <td class="column-amount" style="color: red">
                    <?php echo '-' . $invoice_details->get_order_currency_new($item['total_tax']); ?>
                </td>
            <?php endif; ?>

            <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
                <td class="column-amount">
                    <?php echo ''; ?>
                </td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
                <td class="column-amount" style="color: red">
                    <?php echo '-' . $invoice_details->get_order_currency_new($item['subtotal'] + $item['total_tax']); ?>
                </td>
            <?php endif; ?>
        </tr>
        <?php }
        else{ ?>
            <tr>
                <td class="column-product"><?php echo apply_filters('woocommerce_order_product_title', $item['name'], $_product); ?></td>

                <td class="column-quantity" style="text-align: center"><?php echo (isset($item['qty'])) ? esc_html($item['qty']) : '' ; ?></td>

                <td class="column-refund-text"><?php echo ''; ?></td>

                <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
                    <td class="column-amount">
                        <?php echo $invoice_details->get_order_currency_new($item['subtotal']); ?>
                    </td>
                <?php endif; ?>

                <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
                    <td class="column-amount">
                        <?php echo $invoice_details->get_order_currency_new($item['total_tax']); ?>
                    </td>
                <?php endif; ?>

                <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
                    <td class="column-amount">
                        <?php echo ''; ?>
                    </td>
                <?php endif; ?>

                <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
                    <td class="column-amount">
                        <?php echo $invoice_details->get_order_currency_new($item['subtotal'] + $item['total_tax']); ?>
                    </td>
                <?php endif; ?>
            </tr>



        <?php }
        foreach ( $order->get_items() as $refund_item_id => $refund_item ) {
            $_refund_product = $invoice_details->get_item_product( $refund_item );

            if ( $_product->get_id() == $_refund_product->get_id() ){
                ?>


                <tr>
                    <td class="column-product" style="color: red"><?php echo apply_filters('woocommerce_order_product_title', $refund_item['name'], $_refund_product); ?></td>

                    <td class="column-quantity" style="color: red; text-align: center"><?php echo (isset($refund_item['qty'])) ? esc_html($refund_item['qty']) : '' ; ?></td>

                    <td class="column-refund-text"><?php echo ''; ?></td>

                    <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
                        <td class="column-amount" style="color: red">
                            <?php echo $invoice_details->get_order_currency_new($refund_item['subtotal']); ?>
                        </td>
                    <?php endif; ?>

                    <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
                        <td class="column-amount" style="color: red">
                            <?php echo $invoice_details->get_order_currency_new($refund_item['total_tax']); ?>
                        </td>
                    <?php endif; ?>

                    <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
                        <td class="column-amount">
                            <?php echo ''; ?>
                        </td>
                    <?php endif; ?>

                    <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
                        <td class="column-amount" style="color: red">
                            <?php echo $invoice_details->get_order_currency_new($refund_item['subtotal'] + $refund_item['total_tax']); ?>
                        </td>
                    <?php endif; ?>
                </tr>


            <?php }
        }
    }

    ?>
    
    <tr><td class="column-product"><b><?php echo ' '; ?></b></td></tr>
    <tr><td class="column-product"><b><?php echo ' '; ?></b></td></tr>
    <tr><td class="column-product"><b><?php echo ' '; ?></b></td></tr>
    <tr><td class="column-product"><b><?php echo ' '; ?></b></td></tr>

    <?php

    /* REFUNDED ROW #####################*/

    if ( $order->get_total() == ($parent_order->get_total() * -1) ) {
        ?>
        <tr style="background-color: #CBCBCB">
            <td class="column-product"><b><?php echo 'Order totals:  '; ?></b></td>

            <td class="column-quantity"><?php echo ''; ?></td>

            <td class="column-refund-text"><?php
                $refund_text = get_option('ywpi_credit_note_refund_text', '');
                echo $refund_text ? $refund_text : __('Your refund', 'yith-woocommerce-pdf-invoice');

                if (ywpi_is_enabled_credit_note_reason_column($document)) : ?>
                    <br>
                    <i><?php echo $wc_ge_3 ? $order->get_reason() : $order->get_refund_reason(); ?></i>
                <?php endif; ?></td>

            <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo '-' . $invoice_details->get_order_currency_new( $parent_order->get_subtotal() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo '-' . $invoice_details->get_order_currency_new( $parent_order->get_total_tax() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
                <td class="column-amount"><b>
                        <?php echo '-' . $invoice_details->get_order_currency_new( $parent_order->get_shipping_total() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo $invoice_details->get_order_currency_new( $order->get_total() ); ?>
                    </b></td>
            <?php endif; ?>
        </tr>

    <?php }
    else{ ?>
        <tr style="background-color: #CBCBCB">
            <td class="column-product"><b><?php echo 'Refunded:  '; ?></b></td>

            <td class="column-quantity"><?php echo ''; ?></td>

            <td class="column-refund-text"><?php
                $refund_text = get_option('ywpi_credit_note_refund_text', '');
                echo $refund_text ? $refund_text : __('Your refund', 'yith-woocommerce-pdf-invoice');

                if (ywpi_is_enabled_credit_note_reason_column($document)) : ?>
                    <br>
                    <i><?php echo $wc_ge_3 ? $order->get_reason() : $order->get_refund_reason(); ?></i>
                <?php endif; ?></td>

            <?php if (ywpi_is_enabled_credit_note_subtotal_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo $invoice_details->get_order_currency_new( $order->get_subtotal() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_tax_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo $invoice_details->get_order_currency_new( $order->get_total_tax() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if ( ywpi_is_enabled_credit_note_total_shipping_column( $document ) ) : ?>
                <td class="column-amount"><b>
                        <?php echo $invoice_details->get_order_currency_new( $order->get_shipping_total() ); ?>
                    </b></td>
            <?php endif; ?>

            <?php if (ywpi_is_enabled_credit_note_total_column($document)) : ?>
                <td class="column-amount"><b>
                        <?php echo $invoice_details->get_order_currency_new( $order->get_total() ); ?>
                    </b></td>
            <?php endif; ?>
        </tr>

    <?php } ?>

    </tbody>
</table>
