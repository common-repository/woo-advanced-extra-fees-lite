<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Advanced_Extra_Fees_Lite
 * @subpackage Woocommerce_Advanced_Extra_Fees_Lite/admin
 * @author     IDOMIT <info@idomit.com>
 */
class Woocommerce_Advanced_Extra_Fees_Lite_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->waef_plugin_name = WAEF_LITE_FEES_NAME;
		$this->version = $version;
		$this->option_group = 'woocommerce-advanced-extra-fees-lite';
		$this->id = 'advanced_extra_fees';
		$this->title              = esc_html__( 'Fees (configurable per rate)', 'woocommerce-advanced-extra-fees' );
		$this->method_title       = esc_html__( 'Advanced Extra Fees', 'woocommerce-advanced-extra-fees' );
		$this->method_description = esc_html__( 'Configure WooCommerce Fees', 'woocommerce-advanced-extra-fees' );
		
		/**
		 * Load condition object
		*/
		require_once plugin_dir_path( __FILE__ ) . 'partials/settings/conditions/class-waef-condition.php';

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) :
			/**
			 * Load ajax methods
			 */
			require_once plugin_dir_path( __FILE__ ) . '/partials/class-waef-ajax.php';
			$this->ajax = new WAEF_Lite_Ajax();

		endif;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Advanced_Extra_Fees_Lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Advanced_Extra_Fees_Lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-advanced-extra-fees-lite-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Advanced_Extra_Fees_Lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Advanced_Extra_Fees_Lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( ( isset( $_REQUEST['post'] ) && 'waef' == get_post_type( $_REQUEST['post'] ) ) || ( isset( $_REQUEST['post_type'] ) && 'waef' == $_REQUEST['post_type'] ) ||
		 ( isset( $_REQUEST['section'] ) && 'waef_advanced_extra_fees_method' == $_REQUEST['section'] || isset($_GET['page']) == 'waef' )) :
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-advanced-extra-fees-lite-admin.js', array(  'jquery', 'jquery-ui-sortable', 'jquery-blockui' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'waef', array(
				'nonce' => wp_create_nonce( 'waef-ajax-nonce' ),
				'ajax_url'=> admin_url('admin-ajax.php')
			) );
			wp_enqueue_script( 'freemius-checkout', 'https://checkout.freemius.com/checkout.min.js', array(), '1', true );
			
		endif;

	}

	/**
	 * Screen IDs.
	 *
	 * Add 'waef' to the screen IDs so the WooCommerce scripts are loaded.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $screen_ids List of existing screen IDs.
	 * @return array             List of modified screen IDs.
	 */
	public function add_waef_screen_ids( $screen_ids ) {

		$screen_ids[] = 'waef';

		return $screen_ids;

	}

	/**
	 * Keep menu open.
	 *
	 * Highlights the correct top level admin menu item for post type add screens.
	 *
	 * @since 1.0.0
	 */
	public function menu_highlight() {
                
		global $parent_file, $post_type; //$parent_file, $submenu_file, $post_type

		if ( 'waef' == $post_type ) :
			$parent_file  = 'waef';
		endif;

	}
	/**
	 * Post type.
	 *
	 * Register the 'waef' post type.
	 *
	 * @since 1.0.0
	 */
	public function waef_register_post_type() {

		$labels = array(
			'name'               => esc_html__( 'Advanced Extra Fees', 'woocommerce-advanced-extra-fees' ),
			'singular_name'      => esc_html__( 'Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'add_new'            => esc_html__( 'Add New', 'woocommerce-advanced-extra-fees' ),
			'add_new_item'       => esc_html__( 'Add New Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'edit_item'          => esc_html__( 'Edit Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'new_item'           => esc_html__( 'New Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'view_item'          => esc_html__( 'View Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'search_items'       => esc_html__( 'Search Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'not_found'          => esc_html__( 'No Advanced Fees', 'woocommerce-advanced-extra-fees' ),
			'not_found_in_trash' => esc_html__( 'No Advanced Fees found in Trash', 'woocommerce-advanced-extra-fees' ),
		);

		register_post_type( 'waef', array(
			'label'           => 'waef',
			'show_ui'         => true,
			'show_in_menu'    => false,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
			'rewrite'         => array( 'slug'=> 'waef', 'with_front'=> true ),
			'_builtin'        => false,
			'query_var'       => true,
			'supports'        => array( 'title' ),
			'labels'          => $labels,
		) );

	}

	/**
	 * Messages.
	 *
	 * Modify the notice messages text for the 'waef' post type.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $messages Existing list of messages.
	 * @return array           Modified list of messages.
	 */
	function waef_custom_post_type_messages( $messages ) {

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['waef'] = array(
			0 => '',
			1 => esc_html__( 'Advanced fees updated.', 'woocommerce-advanced-extra-fees' ),
			2 => esc_html__( 'Custom field updated.', 'woocommerce-advanced-extra-fees' ),
			3 => esc_html__( 'Custom field deleted.', 'woocommerce-advanced-extra-fees' ),
			4 => esc_html__( 'Advanced fees updated.', 'woocommerce-advanced-extra-fees' ),
			5 => isset( $_GET['revision'] ) ?
				sprintf( esc_html__( 'Advanced fees restored to revision from %s', 'woocommerce-advanced-extra-fees' ), wp_post_revision_title( (int) $_GET['revision'], false ) )
				: false,
			6 => esc_html__( 'Advanced fees published.', 'woocommerce-advanced-extra-fees' ),
			7 => esc_html__( 'Advanced fees saved.', 'woocommerce-advanced-extra-fees' ),
			8 => esc_html__( 'Advanced fees submitted.', 'woocommerce-advanced-extra-fees' ),
			9 => sprintf(
				esc_html__( 'Advanced fees scheduled for: <strong>%1$s</strong>.', 'woocommerce-advanced-extra-fees' ),
				date_i18n( esc_html__( 'M j, Y @ G:i', 'woocommerce-advanced-extra-fees' ), strtotime( $post->post_date ) )
			),
			10 => esc_html__( 'Advanced fees draft updated.', 'woocommerce-advanced-extra-fees' ),
		);
		$allowed_tags = wp_kses_allowed_html( 'post' );
		$permalink     = admin_url( '/admin.php?page=waef#tab-managefee' );
		$overview_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), wp_kses( __( 'Return to Fees overview.', 'woocommerce-advanced-extra-fees' ), $allowed_tags ) );
		$messages['waef'][1] .= $overview_link;
		$messages['waef'][6] .= $overview_link;
		$messages['waef'][9] .= $overview_link;
		$messages['waef'][8] .= $overview_link;
		$messages['waef'][10] .= $overview_link;

		return $messages;

	}

	

	/**
	 * Meta boxes.
	 *
	 * Add two meta boxes to the 'waef' post type.
	 *
	 * @since 1.0.0
	 */
	public function waef_post_type_meta_box() {

		add_meta_box( 'waef_conditions', esc_html__( 'Advanced Fees conditions', 'woocommerce-advanced-extra-fees' ), array( $this, 'render_waef_conditions' ), 'waef', 'normal' );
		add_meta_box( 'waef_settings', esc_html__( 'Fees settings', 'woocommerce-advanced-extra-fees' ), array( $this, 'render_waef_settings' ), 'waef', 'normal' );

	}

	
	/**
	 * Render meta box.
	 *
	 * Get conditions meta box contents.
	 *
	 * @since 1.0.0
	 */
	public function render_waef_conditions() {
		
		/**
		 * Load meta box conditions view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'partials/settings/meta-box-conditions.php';

	}


	/**
	 * Render meta box.
	 *
	 * Get settings meta box contents.
	 *
	 * @since 1.0.0
	 */
	public function render_waef_settings() {

		/**
		 * Load meta box settings view
		 */
		require_once plugin_dir_path( __FILE__ ) . 'partials/settings/meta-box-settings.php';

	}


	/**
	 * Save meta.
	 *
	 * Validate and save post meta. This value contains all
	 * the normal fees settings (no conditions).
	 *
	 * @since 1.0.0
	 *
	 * @param int/numberic $post_id ID of the post being saved.
	 */
	public function waef_save_meta( $post_id ) {

		if ( ! isset( $_POST['waef_settings_meta_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['waef_settings_meta_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'waef_settings_meta_box' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return $post_id;
		}

		$waef_method = $_POST['_waef_shipping_method'];
		$waef_method['fees_title'] 	= sanitize_text_field( $waef_method['fees_title'] );
		$waef_method['fees_cost'] 	= preg_replace( '/[^0-9\%\.\,\-]/', '', $waef_method['fees_cost'] );
		$waef_method['tax'] 		= 'taxable' == $waef_method['tax'] ? 'taxable' : 'not_taxable';

		update_post_meta( $post_id, '_waef_shipping_method', $waef_method );

		do_action( 'waef_save_shipping_settings', $post_id );

	}


	/**
	 * Save meta.
	 *
	 * Validate and save condition meta box conditions meta. This
	 * value contains all the fees conditions.
	 *
	 * @since 1.0.0
	 *
	 * @param int/numberic $post_id ID of the post being saved.
	 */
	public function waef_save_condition_meta( $post_id ) {

		if ( ! isset( $_POST['waef_conditions_meta_box_nonce'] ) ) :
			return $post_id;
		endif;

		$nonce = $_POST['waef_conditions_meta_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'waef_conditions_meta_box' ) ) :
			return $post_id;
		endif;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return $post_id;
		endif;

		if ( ! current_user_can( 'manage_woocommerce' ) ) :
			return $post_id;
		endif;

		$conditions = $_POST['_waef_conditions'];

		update_post_meta( $post_id, '_waef_conditions', $conditions );

		do_action( 'waef_save_shipping_conditions', $post_id );

	}


	/**
	 * Redirect trash.
	 *
	 * Redirect user after trashing a WAEF post.
	 *
	 * @since 1.0.0
	 */
	public function waef_redirect_after_trash() {

		$screen = get_current_screen();

		if ( 'edit-waef' == $screen->id ) :

			if ( isset( $_GET['trashed'] ) && intval( $_GET['trashed'] ) > 0 ) :

				$redirect = admin_url( '/admin.php?page=waef#tab-dashboard' );
				wp_redirect( $redirect );
				exit();

			endif;

		endif;

	}
	/**
	 * Plugin Menu.
	 *
	 * Add 'waef' to the screen IDs so the WooCommerce scripts are loaded.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $screen_ids List of existing screen IDs.
	 * @return array List of modified screen IDs.
	 */
	
	public function add_waef_menu_item() {
        if ( ! has_nav_menu( 'waef' ) ) {      
			add_menu_page( 'Advanced Extra Fees', 'Advanced Extra Fees', 'manage_options', 'waef', array($this,'settings_page_content'), plugins_url( '/images/waeficon.png',__FILE__ ) , 5);
		}	
	}

	


	/**
	 * Settings waef Page Content
	 */
	public function settings_page_content() {
		?>
		<div class="waef-settings waef-settings--<?php echo esc_attr( $this->option_group ); ?>">
			<div class="progress"><div class="progress-bar"></div></div>
			<?php $this->settings_header(); ?>
			<div class="waef-settings__content">
				<?php $this->settings(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Settings waef Header.
	 */
	public function settings_header() {
		?>
		<div class="waef-settings__header">
			<h2><?php echo $this->waef_plugin_name; ?></h2>
			<span style="margin: 0 0 0 auto; background: #f0f0f1; display: inline-block; padding: 0 10px; border-radius: 13px; height: 26px; line-height: 26px; white-space: nowrap; box-sizing: border-box; color: #656565;"><span style="background: green;color: #fff;padding: 2px;border-radius: 2px;" class="freemium">Free</span> v<?php echo $this->version?></span>
		</div>
		<?php
	}
	/**
	 * Output the settings form
	 */
	public function settings() {
		
		do_action( 'waef_before_settings_' . $this->option_group );
		
		?>
		<ul class="waef-nav">
				<li class="waef-nav__item ">
					<a class="waef-nav__item-link" href="#tab-dashboard"><?php _e( 'Dashboard', 'woocommerce-advanced-extra-fees' ); ?></a>
				</li>
				<li class="waef-nav__item">
					<a class="waef-nav__item-link managefee" href="#tab-managefee"><?php _e( 'Manage Fees', 'woocommerce-advanced-extra-fees' ); ?></a>
				</li>
				<li class="waef-nav__item">
					<a class="waef-nav__item-link freevspro" href="#tab-freevspro"><?php _e( 'Free vs. Premium', 'woocommerce-advanced-extra-fees' ); ?></a>
				</li>
				<li class="waef-nav__item">
					<a class="waef-nav__item-link freevspro" href="#tab-howworks"><?php _e( 'How It Works?', 'woocommerce-advanced-extra-fees' ); ?></a>
				</li>
				<li class="waef-nav__item">
					<a class="waef-nav__item-link addnew" href="#tab-addnewfee" style="opacity: 0; display:none"><?php _e( 'Add New Fees', 'woocommerce-advanced-extra-fees' ); ?></a>
				</li>
				<li class="waef-nav__item waef-nav__item--last">
				<a href="https://checkout.freemius.com/mode/dialog/plugin/8791/plan/17078/" class="button-primary button idomit-buy-now idomit-button idomit-button--small"  data-plugin-id="8791" data-plan-id="17078" data-public-key="pk_9e2cdb2a2dcc0324313c11e5c598d" data-type="premium" ><?php _e( 'Buy Premium', 'woocommerce-advanced-extra-fees' ); ?></a>
			</li>
		</ul>
		
		<div class="idomit-plugin-sidebar">
			<div class="idomit-settings-sidebar__widget idomit-settings-sidebar__widget--works-well">
					<h3><?php _e( 'Our WordPress Plugin', 'woocommerce-advanced-extra-fees' ); ?></h3>
						<div class="idomit-product">
							<div class="idomit-product__image">
								<img width="1200" height="720" src="<?php echo WAEF_PLUGIN_ADMIN_URLPATH?>images/easy-shipping.png" class="attachment-full size-full" alt="Advanced Easy Shipping For WooCommerce" loading="lazy">
							</div>
							<div class="idomit-product__content">
								<h4 class="idomit-product__title"><a target="_blank" href="https://store.idomit.com/product/advanced-easy-shipping-for-woocommerce/?utm_source=Idomit-plugin&amp;utm_medium=Plugin&amp;utm_campaign=idomit-extrafees&amp;utm_content=cross-sell"><?php _e( 'Advanced Easy Shipping For WooCommerce', 'woocommerce-advanced-extra-fees' ); ?></a></h4>
								<p class="idomit-product__description"><?php _e( 'WooCommerce Advanced Easy Shipping Plugin helps make Shipping process easy and convenient for E-commerce Store owners. The plugin makes it easier by offering different options to decide shipping rates based on different criteria.', 'woocommerce-advanced-extra-fees' ); ?></p>
							<div class="idomit-product__buttons">
								<p><a href="https://checkout.freemius.com/mode/dialog/plugin/8790/plan/14731/" class="button idomit-buy-now idomit-button idomit-button--small"  data-plugin-id="8790" data-plan-id="14731" data-public-key="pk_2a55465e285686f167dda32ce0750" data-type="premium" ><?php _e( 'Buy Plugin', 'woocommerce-advanced-extra-fees' ); ?></a></p>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="idomit-plugin-setting">
			<?php 
			do_action( 'waef_before_settings_fields_' . $this->option_group ); ?>
			<?php $this->generate_waef_fees_table_html_view(); ?>
			<?php do_action( 'waef_do_settings_sections_' . $this->option_group ); ?>
			<span class="waef_loader"></span>
		</div>
		<?php
		do_action( 'waef_after_settings_' . $this->option_group );
	}

	/**
	 * Settings tab table.
	 *
	 * Load and render the table on the Advanced Fees settings tab.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	
	public function generate_waef_fees_table_html_view() {
		// ob_start();
				/**
				 * Load conditions table file
				 */
				if (!in_array('woocommerce-advanced-extra-fees/woocommerce-advanced-extra-fees.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
					require plugin_dir_path( __FILE__ ) . 'partials/views/waef-fees-table.php';
				}

		return;
		
		// ob_get_clean();

	}

	

	/**
	 * Plugin action links.
	 *
	 * Add links to the plugins.php page below the plugin name
	 * and besides the 'activate', 'edit', 'delete' action links.
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $links List of existing links.
	 * @param  string $file  Name of the current plugin being looped.
	 * @return array         List of modified links.
	 */
	public function waef_lite_add_plugin_action_links( $links, $file ) {

		if ( $file == WAEF_LITE_PLUGIN_BASENAME ) :
			$links = array_merge( array(
				'<a href="' . esc_url( admin_url( '/admin.php?page=waef#tab-dashboard' ) ) . '">' . __( 'Settings', 'woocommerce-advanced-extra-fees' ) . '</a>'
			), $links );
			
		endif;

		return $links;

	}
	
	/**
	 * Plugin review notice.
	 *
	 * Add plugin review notice in wordpress dashboard.
	 *
	 * @since 1.0.0
	 *
	 */
	public function waef_add_plugin_notice() {


		global $pagenow; 
		if (!in_array('woocommerce-advanced-extra-fees/woocommerce-advanced-extra-fees.php', apply_filters('active_plugins', get_option('active_plugins')), true)) { ?>
			
		<?php
		if ( get_option( 'waef_review_notice_dismissed' ) !== false ) {
			return;
		} else {
		    if ( isset( $_GET['waef_dismis_review'] ) ) {
				update_option( 'waef_review_notice_dismissed', true );
				return;
			}
		}
		?>
		<div class="notice notice-info is-dismissible waef-review-notice">
			<p><?php _e( 'You are currently using the Community version of the WooCommerce Advanced Extra Fees Plugin. Premium users are provided with an additional features and priority support. Upgrade to Premium today to reap all the benefits.' ); ?></p><p><a style="background: #0176b2;padding: 7px;color: #fff;border-radius: 3px;cursor: pointer;text-decoration: none;" href="https://bit.ly/3IQsLKu">Buy Now</a></p>
		</div>
		<div class="notice notice-info is-dismissible waef-review-notice">
					
				<p><?php _e( 'It would mean a lot to us if you would quickly give our plugin a 5-star rating. Your Review is very important to us as it helps us to grow more!', 'woocommerce-advanced-extra-fees' ); ?></p>
				<ul>
					<li><a href="https://wordpress.org/support/plugin/woo-advanced-extra-fees-lite/reviews/?rate=5#new-post" class="button"><?php _e( 'Yes you deserve it!', 'woocommerce-advanced-extra-fees' ); ?></span></a></li>
					<li><a href="<?php echo esc_url( add_query_arg( 'waef_dismis_review', true ) ); ?>" class="waef-dismiss"><?php _e( 'Hide this message', 'woocommerce-advanced-extra-fees' ); ?> / <?php _e( 'Already did!', 'woocommerce-advanced-extra-fees' ); ?></a></li>
					<li><a href="mailto:info@idomit.com?Subject=Here%20is%20how%20I%20think%20you%20can%20do%20better"><?php _e( 'Actually, I need a help...', 'woocommerce-advanced-extra-fees' ); ?></a></li>
				</ul>
		</div>
			<?php
		}
	}

	

}
