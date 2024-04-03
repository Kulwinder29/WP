<?php

add_action('wp_footer', function () {
?>
    <script>
        $(document).ready(function() {
            jQuery(document).on('wpf_ajax_success', function() {
                $('.woocommerce-LoopProduct-link.woocommerce-loop-product__link').each(function(index, element) {
                    var product_url = $(element).attr('href');
                    var queryString = window.location.search;
                    var params = new URLSearchParams(queryString);
                    var size = params.get('wpf_product-size');

                    var new_url = product_url + "?wpf_product-size=" + size;

                    $(element).attr('href', new_url);
                });
            })
            $('.woocommerce-LoopProduct-link.woocommerce-loop-product__link').each(function(index, element) {
                var product_url = $(element).attr('href');
                var queryString = window.location.search;
                var params = new URLSearchParams(queryString);
                var size = params.get('wpf_product-size');

                var new_url = product_url + "?wpf_product-size=" + size;

                $(element).attr('href', new_url);
            });
        })


        $(document).ready(function() {
            var queryString = window.location.search;
            var params = new URLSearchParams(queryString);
            var size = params.get('wpf_product-size');

            size = size.split(',');

            var selectElement = document.getElementById('pa_size');

            // console.log(size);

            for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];

                if (option.value === size[size.length - 1]) {
                    option.selected = true;
                    break;
                }
            }
        })
    </script>
<?php
});


function adjust_price_based_on_size($price, $product)
{
    if ($product->is_type('variable')) {
        global $product;

        $selected_size = isset($_REQUEST['wpf_product-size']) ? $_REQUEST['wpf_product-size'] : '';

        if (!empty($selected_size)) {
            $variation_id = find_variation_id_by_size($product, $selected_size);

            if (!empty($variation_id)) {
                $variation = wc_get_product($variation_id);
                if ($variation) {
                    $price = $variation->get_price();
                    $product = $variation;
                    // echo 'p' . $price;
                }
            }
        }
    }
    // return $price;
    return $product;
}
add_filter('woocommerce_product_get_price', 'adjust_price_based_on_size', 10, 2);
add_filter('woocommerce_product_get_regular_price', 'adjust_price_based_on_size', 10, 2);
add_filter('woocommerce_product_get_sale_price', 'adjust_price_based_on_size', 10, 2);


function find_variation_id_by_size($product, $selected_size)
{
    $variation_id = null;

    $variations = $product->get_available_variations();
    foreach ($variations as $variation) {
        $attributes = $variation['attributes'];

        $selected_size_arr = explode(",", $selected_size);
        // print_r($selected_size_arr);
        // die();
        foreach ($selected_size_arr as $val) {
            if (isset($attributes['attribute_pa_size']) && $attributes['attribute_pa_size'] === $val) {
                $variation_id = $variation['variation_id'];
                break;
            }
        }
        if ($variation_id !== null) {
            break;
        }
    }
    return $variation_id;
}
