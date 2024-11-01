<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Conditions table.
 *
 * Display table with all the user configured fees conditions.
 *
 * @author		multisquares
 * @package 	WooCommerce Advanced Extra Fees Lite
 * @version		1.0.0
 */

$methods = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'waef', 'post_status' => array( 'draft', 'publish'), 'orderby' => 'menu_order', 'order' => 'ASC' ) );

?>      
<div id="tab-dashboard" class="waef-section waef-tab waef-tab--dashboard waef-tab--active">
	<div class="postbox">
		<h2><?php _e( 'License &amp; Account Settings', 'woocommerce-advanced-extra-fees' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php _e( 'License &amp; Billing', 'woocommerce-advanced-extra-fees' ); ?><span class="waef-subtitle"><?php _e( 'Activate or sync your license, cancel your subscription, print invoices, and manage your account information.', 'woocommerce-advanced-extra-fees' ); ?></span>
						</th>
						<td>
						<a href="https://checkout.freemius.com/mode/dialog/plugin/8791/plan/17078/" class="button idomit-buy-now idomit-button idomit-button--small" data-plugin-id="8791" data-plan-id="17078" data-public-key="pk_9e2cdb2a2dcc0324313c11e5c598d" data-type="premium">Buy Premium</a>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e( 'Your Account ', 'woocommerce-advanced-extra-fees' ); ?><span class="waef-subtitle"><?php _e( 'Manage all of your idomit plugins, supscriptions, renewals, and more.', 'woocommerce-advanced-extra-fees' ); ?></span>
						</th>
						<td>
							<a href="https://store.idomit.com/account/?utm_source=idomit&amp;utm_medium=Plugin&amp;utm_campaign=idomit-extrafee&amp;utm_content=account-link" class="button button-secondary" target="_blank"><?php _e( 'Manage Your Account', 'woocommerce-advanced-extra-fees' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>
			<h2><?php _e( 'Support', 'woocommerce-advanced-extra-fees' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php _e( 'Support', 'woocommerce-advanced-extra-fees' ); ?> <span class="waef-subtitle"><?php _e( 'Get Prompt support.', 'woocommerce-advanced-extra-fees' ); ?></span>
						</th>
						<td>
							<a href="https://store.idomit.com/support/?utm_source=idomit&amp;utm_medium=Plugin&amp;utm_campaign=idomit-extrafee&amp;utm_content=support-link" class="button button-secondary" target="_blank"><?php _e( 'Submit Ticket', 'woocommerce-advanced-extra-fees' ); ?></a>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e( 'Documentation', 'woocommerce-advanced-extra-fees' ); ?> <span class="waef-subtitle"><?php _e( 'Read the plugin documentation.', 'woocommerce-advanced-extra-fees' ); ?></span>
						</th>
						<td>
							<a href="https://store.idomit.com/docs/woocommerce-advanced-extra-fees?utm_source=idomit&amp;utm_medium=Plugin&amp;utm_campaign=idomit-extrafee&amp;utm_content=documentation-link" class="button button-secondary" target="_blank"><?php _e( 'Read Documentation', 'woocommerce-advanced-extra-fees' ); ?></a>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<?php _e( 'Review', 'woocommerce-advanced-extra-fees' ); ?><span class="waef-subtitle"><?php _e( 'It would mean a lot to us if you would quickly give our plugin a 5-star rating. Your Review is very important to us as it helps us to grow more!', 'woocommerce-advanced-extra-fees' ); ?></span>
						</th>
						<td>
							<ul>
								<a href="https://wordpress.org/support/plugin/woo-advanced-extra-fees-lite/reviews/?rate=5#new-post" target="__blank" class="button"><?php _e( 'Yes you deserve it!', 'woocommerce-advanced-extra-fees' ); ?></span></a>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>					
	</div>
</div>
<div id="tab-managefee" class="waef-section waef-tab waef-tab--managefee">
	<div class="postbox">	
	<form method="post" action="#">
	<a href='<?php echo admin_url( 'post-new.php?post_type=waef' ); ?>' class='waef_new_fee top add button'>
		<span><?php _e( 'Add New Fees', 'woocommerce-advanced-extra-fees' ); ?></span>
	</a>
	<table class='form-table wp-list-table waef-table widefat'>
		
		<thead>
			<tr>
				<th style='width: 17px;'></th>
				<th style='padding-left: 10px;'><?php _e( 'Title', 'woocommerce-advanced-extra-fees' ); ?></th>
				<th style='padding-left: 10px;'><?php _e( 'Fees title', 'woocommerce-advanced-extra-fees' ); ?></th>
				<th style='padding-left: 10px; width: 100px;'><?php _e( 'Fees price', 'woocommerce-advanced-extra-fees' ); ?></th>
				<th style='width: 70px;'><?php _e( '# Groups', 'woocommerce-advanced-extra-fees' ); ?></th>
			</tr>
			
		</thead>
		<tbody><?php

			$i = 0;
			foreach ( $methods as $method ) :

				$method_details = get_post_meta( $method->ID, '_waef_shipping_method', true );
				$conditions     = get_post_meta( $method->ID, '_waef_conditions', true );
					
				$alt = ( $i++ ) % 2 == 0 ? 'alternate' : '';
				?><tr class='<?php echo $alt; ?>'>

					<td class='sort'>
						<input type='hidden' name='sort[]' value='<?php echo absint( $method->ID ); ?>' />
					</td>
					<td>
						<strong>
							<a href='<?php echo get_edit_post_link( $method->ID ); ?>' data-id="<?php echo $method->ID; ?>" class='edit_fees row-title' title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'><?php
								echo _draft_or_post_title( $method->ID );
							?></a><?php
							echo _post_states( $method );
						?></strong>
						<div class='row-actions'>
							<span class='edit'>
								<a href='<?php echo get_edit_post_link( $method->ID ); ?>' class='edit_fees' data-id="<?php echo $method->ID; ?>" title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'>
									<?php _e( 'Edit', 'woocommerce-advanced-extra-fees' ); ?>
								</a>
								|
							</span>
							<span class='trash'>
								<a href='<?php echo get_delete_post_link( $method->ID ); ?>' class='delete_fees' data-id="<?php echo $method->ID; ?>" title='<?php _e( 'Delete Method', 'woocommerce-advanced-extra-fees' ); ?>'>
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

			endforeach;

			if ( empty( $method ) ) :

				?><tr class="empty-method">
					<td colspan='6'><?php _e( 'There are no Advanced Extra Fees conditions. Yet...', 'woocommerce-advanced-extra-fees' ); ?></td>
				</tr><?php

			endif;

		?></tbody>
		<tfoot>
			<tr>
				<th colspan='6' style='padding-left: 10px;'>
					<a href='<?php echo admin_url( 'post-new.php?post_type=waef' ); ?>' class='waef_new_fee add button'>
						<?php _e( 'Add New Fees', 'woocommerce-advanced-extra-fees' ); ?>
					</a>
				</th>
			</tr>
		</tfoot>
	</table>
	</form>
	</div>
</div>
<div id="tab-freevspro" class="waef-section waef-tab waef-tab-freevspro">
	<div class="postbox">
	<div class="col-md-10 col-md-offset-1">
            <table class="waef-table-freevspro">
                <tbody>
                    <tr>
                        <td width="40%" class="waef-table-box-text">
                            <h2><?php _e( 'Plugin Features', 'woocommerce-advanced-extra-fees' ); ?></h2>
                        </td>
                        <td width="30%">
                            <div class="waef-table-box-item">
                                <div class="waef-table-box-item-head color2">
									<h2><?php _e( 'Free', 'woocommerce-advanced-extra-fees' ); ?></h2>
                                </div>
                            </div>
                        </td>
                        <td width="30%">
                            <div class="waef-table-box-item">
                                <div class="waef-table-box-item-head color2">
									<h2><?php _e( 'Premium', 'woocommerce-advanced-extra-fees' ); ?></h2>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e('Setup WooCommerce extra fees for cart/checkout.','woocommerce-advanced-extra-fees')?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e('Use of different operators to set up specific extra fee conditions','woocommerce-advanced-extra-fees')?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                      
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Combination of two or more extra fee conditions', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Set up specific products based WooCommerce extra fees.', 'woocommerce-advanced-extra-fees' ); ?></td>
						<td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                        
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Set up cart subtotal based WooCommerce additional fee.', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                     
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'WooCommerce extra fees based on the Customer\'s Country', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                        
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Add WooCommerce extra fees on Product stock status based', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Set up Weight based WooCommerce extra fees.', 'woocommerce-advanced-extra-fees' ); ?></td>
						<td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                        
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Set up Width based WooCommerce extra fees.', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-yes"></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply extra cost for WooCommerce Variable products', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Add extra fee for WooCommerce Shipping class based', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Setup extra fees based on WooCommerce Coupon code.', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Setup extra fees based on WooCommerce Cart Quantity', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Setup additional fees based on Customer\'s/ User\'s zipcode/postal code', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Add extra fees based on Customer\'s city/state', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Add extra fees based on specific User role or user', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply extra fees for WooCommerce Products category', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply extra fees for WooCommerce Products Height / Length / Stock', 'woocommerce-advanced-extra-fees' ); ?> </td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply WooCommerce extra fees <strong>Cost Per Product</strong> using cost options', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply WooCommerce extra fees <strong>Cost Per Weight</strong> using cost options', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply WooCommerce extra fees <strong>Cost Per Category</strong> using cost options', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Apply WooCommerce extra fees <strong>Cost Per Shipping Class</strong> using cost options', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
					<tr class="waef-table-box-list">
                        <td class="first-row"><span class="dashicons dashicons-arrow-right"></span> <?php _e( 'Fees can be positive or negative ( If you want to give WooCommerce cart discount, use negative sign )', 'woocommerce-advanced-extra-fees' ); ?></td>
                        <td class="second-row"><span class="dashicons dashicons-no-alt"></span></span></td>
                        <td class="third-row"><span class="dashicons dashicons-yes"></td>
                    </tr>
                    <tr class="waef-table-box-list">
                        <td class="first-row"></td>
                        <td class="second-row">
                        </td>
                        <td class="third-row">
                            <div class="waef-table-box-item-purchase">
							<a href="https://checkout.freemius.com/mode/dialog/plugin/8791/plan/17078/" class="button-primary button idomit-buy-now idomit-button idomit-button--small"  data-plugin-id="8791" data-plan-id="17078" data-public-key="pk_9e2cdb2a2dcc0324313c11e5c598d" data-type="premium" ><?php _e( 'Buy Premium', 'woocommerce-advanced-extra-fees' ); ?></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</div>
</div>
<div id="tab-howworks" class="waef-section waef-tab waef-tab-howworks">
	<div class="postbox">
		<h2><?php _e('How to charge extra fees for particular condition ?','woocommerce-advanced-extra-fees')?></h2>
		<table class="form-table" role="presentation">
			<?php _e('<span class="dashicons dashicons-arrow-right"></span> Go to Advanced Extra Fees plugin manage fees tab and click on <strong>Add New Fees</strong>. After clicking on <strong>Add New Fees</strong>. This page will be opened :','woocommerce-advanced-extra-fees')?>
			<img src="<?php echo WAEF_PLUGIN_ADMIN_URLPATH?>images/managefee.png" class="attachment-full size-full" alt="extra fee for WooCommerce" loading="lazy">
			<p><span class="dashicons dashicons-arrow-right"></span> Example :  You want to charge additional $10 if country is US and specefic product:<p>
			<p><span class="dashicons dashicons-arrow-right"></span>Select the parameter 'Countain Product' and choose specefic product equal to, And select country the value 'United States(US)'</p>
			<img src="<?php echo WAEF_PLUGIN_ADMIN_URLPATH?>images/addfee.png" class="attachment-full size-full" alt="extra fee for WooCommerce" loading="lazy">
			<p><span class="dashicons dashicons-arrow-right"></span>When that product and country match with cart then the fees will visible on cart automatically.</p>
			<img src="<?php echo WAEF_PLUGIN_ADMIN_URLPATH?>images/feeoncart.png" class="attachment-full size-full" alt="extra fee for WooCommerce" loading="lazy">
			<p><span class="dashicons dashicons-arrow-right"></span>Check out document from dashboard to learn more.</p>
		</table>
		
	</div>
</div>
<div id="tab-addnewfee" class="waef-section waef-tab waef-tab--addnewfee">
	<div id="waef_conditions" class="postbox ">
	<h2 class="hndle ui-sortable-handle"><?php _e( 'Advanced Fees conditions', 'woocommerce-advanced-extra-fees' ); ?></h2>
	<form method="post" action="" id="waef_custom_form">
		<?php wp_nonce_field( 'waef_post_save_action', 'waef_post_save_nonce_field' ); ?>
		<input type="hidden" name="action" value="save_waef_post">
		<div class="load_meta_data">
			<?php
			require_once WAEF_PLUGIN_ADMIN_PATH . 'partials/settings/meta-box-conditions.php';
			require_once WAEF_PLUGIN_ADMIN_PATH . 'partials/settings/meta-box-settings.php';
			?>
		</div>
		<p class="submit">
			<input type="button" id="waef_save_form_button" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
		</p>
	</form>
	</div>
</div>

