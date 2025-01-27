<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WAEF meta box conditions.
 *
 * Display the fees conditions in the meta box.
 *
 * @author		multisquares
 * @package		WooCommerce Advanced Extra Fees Lite
 * @version		1.0.0
 */

wp_nonce_field( 'waef_conditions_meta_box', 'waef_conditions_meta_box_nonce' );
global $post;
$conditions = false;

if($post)
{
	$conditions = get_post_meta( $post->ID, '_waef_conditions', true );

}
elseif(isset($_POST['fee_id']) && $_POST['fee_id'] != '')
{
	$fee_id = $_POST['fee_id'];
	$conditions = get_post_meta( $fee_id, '_waef_conditions', true );
	echo '<input type="hidden" name="fee_id" value="'.$fee_id.'" >';
}

?>
<div class='waef waef_conditions waef_meta_box waef_conditions_meta_box'>

	<p><strong><?php _e( 'Match all of the following rules to allow this fees:', 'woocommerce-advanced-extra-fees' ); ?></strong></p>

	<?php
	$i = 0;
	if ( ! empty( $conditions ) ) :
		foreach ( $conditions as $condition_group => $conditions ) :

			$group_id = ++$i;
			?><div class='condition-group condition-group-<?php echo absint( $i ); ?>' data-group='<?php echo absint( $i ); ?>'>

				<p class='or-match'><?php _e( 'Or match all of the following rules to allow this shipping method:', 'woocommerce-advanced-extra-fees' );?></p><?php

				foreach ( $conditions as $condition_id => $condition ) :
					new WAEF_Lite_Condition( $condition_id, $i, $condition['condition'], $condition['operator'], $condition['value'] );
				endforeach;

			?></div>

			<p class='or-text'><strong><?php _e( 'Or', 'woocommerce-advanced-extra-fees' ); ?></strong></p><?php

		endforeach;

	else :

		?><div class='condition-group condition-group-0 no-rule-message' data-group='0'>
		<p><?php esc_html_e( 'No conditions were found. Click the add button to create a new rule.', 'woocommerce-advanced-extra-fees' );?></p>	
		<?php // new WAEF_Condition(); ?>
		</div><?php

	endif;

?></div>

<a class='button condition-group-add' href='javascript:void(0);'><?php _e( 'Add \'Or\' group', 'woocommerce-advanced-extra-fees' ); ?></a>
