<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
    'post_type'  => 'product',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'exclude'    => array(16),
    'hide_empty' => true
);

$categories = get_terms(array('product_cat'), $args);
$taxonomy = (is_tax('product_cat')) ? get_queried_object() : '';

if (!empty($categories)) :
    $class = (!isset($_GET['category'])) ? 'btn small has-border active' : 'btn small has-border'; ?>
    <div class="news-filters">
        <ul>
            <li>
                <a href="javascript:void(0)" class="<?php echo $class; ?>" data-term="all"><span>all</span></a>
            </li>
            <?php foreach ($categories as $category) :
                $class = (isset($_GET['category']) && $category->slug == $_GET['category']) ? 'btn small has-border active' : 'btn small has-border'; ?>
                <li>
                    <a href="javascript:void(0)" class="<?php echo $class; ?>" data-term="<?php echo $category->slug; ?>"><span><?php echo $category->name; ?></span></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php /*
<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
 */ ?>
