<?php
/**
 * Кастомізація теми згідно з ТЗ
 */

// Обгорни код у функцію, яку можна вставити у functions.php.
function storefront_woocommerce_customizations() {

	// Додасть під кнопкою "Додати до кошика" повідомлення: "Товар буде доставлений протягом 2-5 днів" (лише на
	// 	сторінках товарів);
    add_action('woocommerce_after_add_to_cart_button', function() {
        if (is_product()) {
            echo '
				<p class="delivery-message" style="margin-top:10px;color:#2d7a2d;">
					Товар буде доставлений протягом 2-5 днів
				</p>
			';
        }
    });

	// Замінить стандартний напис "Немає в наявності" на "Очікується найближчим часом".
    add_filter('woocommerce_get_availability_text', function($availability, $product) {
        if (!$product->is_in_stock()) {
            return 'Очікується найближчим часом';
        }
        return $availability;
    }, 10, 2);

	// Додає клас is-new до товарів, що мають тег новинка.
    add_filter('post_class', function($classes, $class, $post_id) {
        if ('product' === get_post_type($post_id)) {

            $terms = get_the_terms($post_id, 'product_tag');
            if ($terms && !is_wp_error($terms)) {

                foreach ($terms as $term) {
                    if (mb_strtolower($term->name) === 'новинка') {
                        $classes[] = 'is-new';
                        break;
                    }
                }

            }

        }
        return $classes;
    }, 10, 3);

    // Додає стилізацію для класу is-new, щоб його було видно візуально
    add_action('wp_head', function() {
        ?>
        <style>
            .is-new {
                border: 2px solid green;
                border-radius: 4px;
                padding: 4px;
            }
        </style>
        <?php
    });

	// Зроби зручне відображення ціни: стара ціна перекреслена, нова — виділена (наприклад, кольором або жирним);
    add_filter('woocommerce_get_price_html', function($price, $product) {
        if ($product->is_on_sale()) {
            $regular_price = wc_price($product->get_regular_price());
            $sale_price = wc_price($product->get_sale_price());

            $price = '
				<span class="old-price" style="text-decoration:line-through;color:#888;">
			' . $regular_price . '</span> ';
            $price .= '
				<span class="sale-price" style="color:#e53935;font-weight:bold;">
			' . $sale_price . '</span>';

        }
        return $price;
    }, 10, 2);

	// Якщо у товару є знижка, заміни стандартний бейдж "Розпродаж" (WooCommerce Sale!) на власне зображення —
	// наприклад, картинку з написом "Акція" у кутку товару;
    add_filter('woocommerce_sale_flash', function($html, $post, $product) {
        if ($product->is_on_sale()) {

            $img_url = get_stylesheet_directory_uri() . '/assets/images/sale.png';
            $html = '
				<span class="custom-sale-badge" style="position:absolute;top:10px;left:10px;z-index:10;">
					<img src="' . esc_url($img_url) . '" alt="Акція" style="width:60px;height:auto;">
				</span>';
        }
        return $html;
    }, 10, 3);

}
add_action('after_setup_theme', 'storefront_woocommerce_customizations');