<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAEF_Lite_Match_Conditions.
 *
 * The WAEF Match Conditions class handles the matching rules for fees.
 *
 * @class		WAEF_Lite_Match_Conditions
 * @author		idomit
 * @package 	WooCommerce Advanced Extra Fees
 * @version	1.0.0
 */
class WAEF_Lite_Match_Conditions {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'waef_match_condition_subtotal', array( $this, 'waef_match_condition_subtotal' ), 10, 4 );
		add_filter( 'waef_match_condition_tax', array( $this, 'waef_match_condition_tax' ), 10, 4 );
		add_filter( 'waef_match_condition_contains_product', array( $this, 'waef_match_condition_contains_product' ), 10, 4 );
		add_filter( 'waef_match_condition_weight', array( $this, 'waef_match_condition_weight' ), 10, 4 );
		add_filter( 'waef_match_condition_country', array( $this, 'waef_match_condition_country' ), 10, 4 );
		add_filter( 'waef_match_condition_width', array( $this, 'waef_match_condition_width' ), 10, 4 );
		add_filter( 'waef_match_condition_stock_status', array( $this, 'waef_match_condition_stock_status' ), 10, 4 );
	
	}


	/**
	 * Subtotal.
	 *
	 * Match the condition value against the cart subtotal.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of fees package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_subtotal( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		// Make sure its formatted correct
		$value = str_replace( ',', '.', $value );

		// WPML multi-currency support
		$value = apply_filters( 'wpml_fees_price_amount', $value );

		$subtotal = WC()->cart->subtotal;

		if ( '==' == $operator ) :
			$match = ( $subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $subtotal <= $value );
		endif;

		return $match;

	}




	/**
	 * Taxes.
	 *
	 * Match the condition value against the cart taxes.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_tax( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) ) :
			return $match;
		endif;

		$taxes = array_sum( (array) WC()->cart->get_taxes() );
		
		// WPML multi-currency support
		$value = apply_filters( 'wpml_fees_price_amount', $value );

		if ( '==' == $operator ) :
			$match = ( $taxes == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $taxes != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $taxes >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $taxes <= $value );
		endif;

		return $match;

	}

	/**
	 * Contains product.
	 *
	 * Matches if the condition value product is in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_contains_product( $match, $operator, $value, $package ) {

		foreach ( $package->cart_contents as $product ) :
			$product_ids[] = $product['product_id'];
		endforeach;

		if ( '==' == $operator ) :
			$match = ( in_array( $value, $product_ids ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $product_ids ) );
		endif;

		return $match;

	}


	/**
	 * Weight.
	 *
	 * Match the condition value against the cart weight.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_weight( $match, $operator, $value, $package ) {

		$weight = 0;
		foreach ( $package->cart_contents as $key => $item ) :
			if(is_numeric($item['data']->get_weight())){
			   $weight += $item['data']->get_weight() * $item['quantity'];
			}
		endforeach;

		$value = (string) $value;

		// Make sure its formatted correct
		$value = str_replace( ',', '.', $value );

		if ( '==' == $operator ) :
			$match = ( $weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $weight <= $value );
		endif;

		return $match;

	}



/******************************************************
 * User conditions
 *****************************************************/


	/**
	 * Country.
	 *
	 * Match the condition value against the users shipping country.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_country( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->customer ) ) :
			return $match;
		endif;

		if ( '==' == $operator ) :
			$match = ( preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_country() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( '/^' . preg_quote( $value, '/' ) . "$/i", WC()->customer->get_shipping_country() ) );
		endif;

		return $match;

	}


/******************************************************
 * Product conditions
 *****************************************************/


	/**
	 * Width.
	 *
	 * Match the condition value against the widest product in the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */
	public function waef_match_condition_width( $match, $operator, $value, $package ) {

		if ( ! isset( WC()->cart ) || empty( WC()->cart->cart_contents ) ) :
			return $match;
		endif;

		foreach ( WC()->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_width ) :
				$width[] = ( get_post_meta( $product['data']->variation_id, '_width', true ) );
			else :
				$width[] = ( get_post_meta( $product['product_id'], '_width', true ) );
			endif;

		endforeach;

		$max_width = max( (array) $width );

		if ( '==' == $operator ) :
			$match = ( $max_width == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_width != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_width >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_width <= $value );
		endif;

		return $match;

	}

	/**
	 * Stock status.
	 *
	 * Match the condition value against all cart products stock statuses.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool   $match    Current match value.
	 * @param  string $operator Operator selected by the user in the condition row.
	 * @param  mixed  $value    Value given by the user in the condition row.
	 * @param  array  $package  List of shipping package details.
	 * @return BOOL             Matching result, TRUE if results match, otherwise FALSE.
	 */

	public function waef_match_condition_stock_status( $match, $operator, $value, $package ) {

		if ( '==' == $operator ) :

			$match = true;
			// $package['contents']
			foreach ( WC()->cart->get_cart() as $item ) :

				if ( $item['data']->get_stock_status() != $value ) :
					return false;
				endif;

			endforeach;

		elseif ( '!=' == $operator ) :

			$match = true;
			// $package['contents']
			foreach ( WC()->cart->get_cart() as $item ) :

				if ( $item['data']->get_stock_status() == $value ) :
					return false;
				endif;

			endforeach;

		endif;

		return $match;

	}


}
