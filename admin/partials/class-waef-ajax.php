<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WAEF_Lite_Ajax.
 *
 * Initialize the AJAX class.
 *
 * @class		WAEF_Lite_Ajax
 * @author		idomit
 * @package		WooCommerce Advanced Extra Fees
 * @version		1.0.0
 */
class WAEF_Lite_Ajax {


	/**
	 * Constructor.
	 *
	 * Add ajax actions in order to work.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Add elements
		add_action( 'wp_ajax_waef_add_condition', array( $this, 'waef_add_condition' ) );
		add_action( 'wp_ajax_waef_add_condition_group', array( $this, 'waef_add_condition_group' ) );

		// Update elements
		add_action( 'wp_ajax_waef_update_condition_value', array( $this, 'waef_update_condition_value' ) );
		add_action( 'wp_ajax_waef_update_condition_description', array( $this, 'waef_update_condition_description' ) );

		// Save fees method ordering
		add_action( 'wp_ajax_waef_save_fees_list_table', array( $this, 'save_fees_list_table' ) );

		//Add metabox content
		add_action( 'wp_ajax_save_waef_post', array( $this, 'save_waef_post' ) );
		add_action( 'wp_ajax_load_meta_data', array( $this, 'load_meta_data' ) );
		add_action( 'wp_ajax_delete_fee_data', array( $this, 'delete_fee_data' ) );

	}

	/**
	 * Add condition box.
	 *
	 * @since 1.0.0
	 */
	public function save_waef_post() {

		if ( ! isset( $_POST['waef_post_save_nonce_field'] ) ) {
			return false;
		}

		$nonce = $_POST['waef_post_save_nonce_field'];

		if ( ! wp_verify_nonce( $nonce, 'waef_post_save_action' ) ) {
			return $false;
		}

		$post_title = isset($_POST['_waef_shipping_method']['fees_title']) ? $_POST['_waef_shipping_method']['fees_title'] : '';

		$my_post = array(
		  'post_title'    => wp_strip_all_tags( $post_title ),
		  'post_status'   => 'publish',
		  'post_type'   => 'waef',
		  
		);
		$action = 'add';
		if(isset($_POST['fee_id']) && $_POST['fee_id'] != '')
		{
			$my_post['ID'] = $_POST['fee_id'];
			$action = 'edit';
		}

		// Insert the post into the database
		$insert = wp_insert_post( $my_post );
		if($insert)
		{
			$method_details = get_post_meta( $insert, '_waef_shipping_method', true );
			$conditions     = get_post_meta( $insert, '_waef_conditions', true );
				
				ob_start();	
				
				?><tr>

					<td class='sort'>
						<input type='hidden' name='sort[]' value='<?php echo absint( $insert ); ?>' />
					</td>
					<td>
						<strong>
							<a href='<?php echo get_edit_post_link( $insert ); ?>' data-id="<?php echo $insert; ?>" class='edit_fees row-title' title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'><?php
								echo _draft_or_post_title( $insert );
							?></a><?php
							echo _post_states( $insert );
						?></strong>
						<div class='row-actions'>
							<span class='edit'>
								<a href='<?php echo get_edit_post_link( $insert ); ?>' class='edit_fees' data-id="<?php echo $insert; ?>" title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'>
									<?php _e( 'Edit', 'woocommerce-advanced-extra-fees' ); ?>
								</a>
								|
							</span>
							<span class='trash'>
								<a href='<?php echo get_delete_post_link( $insert ); ?>' class='delete_fees' data-id="<?php echo $insert; ?>" title='<?php _e( 'Delete Method', 'woocommerce-advanced-extra-fees' ); ?>'>
									<?php _e( 'Delete', 'woocommerce-advanced-extra-fees' ); ?>
								</a>
							</span>
						</div>
					</td>
					<td><?php
						if ( empty( $method_details['fees_title'] ) ) :
							_e( 'Advanced Extra Fees', 'woocommerce-advanced-extra-fees' );
						else :
							echo wp_kses_post( $method_details['fees_title'] );
						endif;
					?></td>
					<td><?php echo isset( $method_details['fees_cost'] ) ? wp_kses_post(  preg_replace( '/[^0-9\%\.\,\-]/', '',$method_details['fees_cost'] ) ) : ''; ?></td>
					<td><?php echo absint( count((array)$conditions) ); ?></td>						

				</tr><?php
				$html = ob_get_clean();
			echo json_encode(array('status'=>1,'html'=>$html,'action'=>$action));
			exit;
		}
		echo json_encode(array('status'=>0));
		exit;
	}

	/**
	 * Add condition box.
	 *
	 * @since 1.0.0
	 */
	public function load_meta_data() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		include  plugin_dir_path( __FILE__ ) . 'settings/meta-box-conditions.php';
		include  plugin_dir_path( __FILE__ ) . 'settings/meta-box-settings.php';
		wp_reset_postdata();
		wp_die();

	}

	public function delete_fee_data() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		if(isset($_POST['fee_id']) && $_POST['fee_id'] != '')
		{
			wp_delete_post($_POST['fee_id'],true);
			echo json_encode(array('status'=>1));
			exit;
		}
		echo json_encode(array('status'=>0));
		exit;


	}


	/**
	 * Add condition.
	 *
	 * Create a new WAEF_Lite_Condition class and render.
	 *
	 * @since 1.0.0
	 */
	public function waef_add_condition() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		new WAEF_Lite_Condition( null, $_POST['group'] );
		wp_die();

	}


	/**
	 * Condition group.
	 *
	 * Render new condition group.
	 *
	 * @since 1.0.0
	 */
	public function waef_add_condition_group() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		?><div class='condition-group condition-group-<?php echo ($_POST['group']) ? $_POST['group'] : ''; ?>' data-group='<?php echo ($_POST['group']) ? $_POST['group'] : ''; ?>'>

			<p class='or-match'><?php esc_html_e( 'Or match all of the following rules to allow this shipping method:', 'woocommerce-advanced-extra-fees' );?></p><?php

			new WAEF_Lite_Condition( null, $_POST['group'] );

		?></div>

		<p class='or-text'><strong><?php esc_html_e( 'Or', 'woocommerce-advanced-extra-fees' ); ?></strong></p><?php

		wp_die();

	}


	/**
	 * Update values.
	 *
	 * Retreive and render the new condition values according to the condition key.
	 *
	 * @since 1.0.0
	 */
	public function waef_update_condition_value() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		waef_lite_condition_values( $_POST['id'], $_POST['group'], $_POST['condition'] );
		wp_die();

	}


	/**
	 * Update description.
	 *
	 * Render the corresponding description for the condition key.
	 *
	 * @since 1.0.0
	 */
	public function waef_update_condition_description() {

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		waef_lite_condition_description( $_POST['condition'] );
		wp_die();

	}


	/**
	 * Save order.
	 *
	 * Save the shipping method order.
	 *
	 * @since 1.0.4
	 */
	public function save_fees_list_table() {

		global $wpdb;

		check_ajax_referer( 'waef-ajax-nonce', 'nonce' );

		$args = wp_parse_args( $_POST['form'] );

		// Save order
		$menu_order = 0;
		foreach ( $args['sort'] as $sort ) :

			$wpdb->update(
				$wpdb->posts,
				array( 'menu_order' => $menu_order ),
				array( 'ID' => $sort ),
				array( '%d' ),
				array( '%d' )
			);

			$menu_order++;

		endforeach;

		wp_die();

	}


}
