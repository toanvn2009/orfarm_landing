<?php 
$class = "sticky-add-to-cart " . $product->get_type();
?>
<div class="<?php echo esc_attr($class); ?> slideOutUp">
	<div class="wc-sticky-product-bar container">
<?php
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
?>
    <div class="sticky-add-to-cart-content">
        <div class="image">
            <img src="<?php echo esc_attr($image[0]) ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
        </div>
        <div class="content-product-info">
            <div class="name">
                <span><?php echo esc_html($product->get_name()); ?></span>
            </div>
            <?php if ( get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>
            <div class="rating">
                <div class="rate">
                    <span class="rate-count" style="width:<?php echo esc_attr($product->get_average_rating() / 5 * 100 ); ?>%"></span>
                </div> 
                <span class="rate-customer"><?php echo esc_html__('Customer Rating', 'orfarm'); ?></span>
            </div>
            <?php endif; ?>
            <div class="price">
                <?php echo '' . $product->get_price_html(); ?>
            </div>
        </div>
    </div>
    <div class="action">
<?php 
   if ($isInStock) {
?>	
    <div class="button">
        <a href="#" class="action-button">
            <?php echo esc_html($product->single_add_to_cart_text()); ?>
        </a>
    </div>
<?php			
	} else {
?>	
    <div class="button outofstock">
	    <span><?php echo esc_html__('Out of stock', 'orfarm'); ?></span>
	</div>
<?php 
    }
?>
    </div>
	</div>
</div>