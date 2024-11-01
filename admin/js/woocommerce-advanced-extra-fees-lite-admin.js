jQuery( function( $ ) {
	"use strict";

	let current_tr = false;
	// on add click for new post
	// Add condition
	$(document).on('click','.waef_new_fee',function(event){
		event.preventDefault();
		current_tr = false;
		
		var data = {
			action: 'load_meta_data',
			nonce: 	waef.nonce
		};
		jQuery.ajax({
		xhr : function() {
			jQuery('.progress').show();
			jQuery('.progress-bar').fadeIn();
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					jQuery(".progress-bar").animate({'width': Math.round(percentComplete) + '%'}, 1000).fadeOut(500);
					//jQuery(".progress-bar").width(Math.round(percentComplete) + '%');
					//jQuery(".progress-bar").html(Math.round(percentComplete)+'%');
				}
			}, false);
			return xhr;
		},
		url:ajaxurl,
		type:"POST",
		data:data,
		beforeSend: function(){
			$(".progress-bar").width('0%');
			$(".waef_loader").show();
		},
		success : function(response){
			jQuery('.progress').hide();
			jQuery(".progress-bar").width('0%');
			if(response){
				$('ul.waef-nav').find('.waef-nav__item-link.addnew').trigger('click');
				$('#tab-addnewfee').find('.load_meta_data').html(response);
				$('#tab-managefee').find('.empty-method').remove();
				$(".waef_loader").hide();
			}
		}
		});	
	})

	$(document).on('click','a.edit_fees',function(event){
		event.preventDefault();

		let fee_id = $(this).data('id');

		if(!fee_id) return;

		current_tr = $(this).parents('tr');

		$('ul.waef-nav').find('.waef-nav__item-link.addnew').trigger('click');
		var data = {
			fee_id: fee_id,
			action: 'load_meta_data',
			nonce: 	waef.nonce
		};

		jQuery.ajax({
        xhr : function() {
            jQuery('.progress').show();
            jQuery('.progress-bar').fadeIn();
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    jQuery(".progress-bar").animate({'width': Math.round(percentComplete) + '%'}, 1000).fadeOut(500);
                    //jQuery(".progress-bar").width(Math.round(percentComplete) + '%');
                    //jQuery(".progress-bar").html(Math.round(percentComplete)+'%');
                }
            }, false);
            return xhr;
        },
		url:ajaxurl,
        type:"POST",
        data:data,
        
        beforeSend: function(){
             $(".progress-bar").width('0%');
			 $(".waef_loader").show();
        },
        success : function(response){
        	// console.log(response);
        	jQuery('.progress').hide();
        	jQuery(".progress-bar").width('0%');
            if(response){			
				$('#tab-addnewfee').find('.load_meta_data').html(response);
				$(".waef_loader").hide();
			}
        }
    	});
	})
	// Delete condition
	$(document).on('click','a.delete_fees',function(event){
		event.preventDefault();

		let fee_id = $(this).data('id');

		if(!fee_id) return;

		let delete_tr = $(this).parents('tr');

		
		var data = {
			fee_id: fee_id,
			action: 'delete_fee_data',
			nonce: 	waef.nonce
		};

		jQuery.ajax({
			xhr : function() {
				jQuery('.progress').show();
				jQuery('.progress-bar').fadeIn();
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = ((evt.loaded / evt.total) * 100);
						jQuery(".progress-bar").animate({'width': Math.round(percentComplete) + '%'}, 1000).fadeOut(500);
						//jQuery(".progress-bar").width(Math.round(percentComplete) + '%');
						//jQuery(".progress-bar").html(Math.round(percentComplete)+'%');
					}
				}, false);
				return xhr;
			},
			url:ajaxurl,
			type:"POST",
			data:data,
			dataType:"JSON",
			beforeSend: function(){
				$(".progress-bar").width('0%');
			},
			success : function(response){
				jQuery('.progress').hide();
				jQuery(".progress-bar").width('0%');
				if(response.status === 1){
					delete_tr.remove();
								
				}
			}
		});		
	})

	$(document).on('click','#waef_save_form_button',function(event){
		event.preventDefault();
		let form = $(this).parents('form');
		var datastring = form.serializeArray();
		// console.log(datastring);
		jQuery.ajax({
        xhr : function() {
            jQuery('.progress').show();
            jQuery('.progress-bar').fadeIn();
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    jQuery(".progress-bar").animate({'width': Math.round(percentComplete) + '%'}, 1000).fadeOut(500);
                    //jQuery(".progress-bar").width(Math.round(percentComplete) + '%');
                    //jQuery(".progress-bar").html(Math.round(percentComplete)+'%');
                }
            }, false);
            return xhr;
        },
        url:ajaxurl,
        type:"POST",
        data:datastring,
        dataType:"JSON",
        beforeSend: function(){
             $(".progress-bar").width('0%');
        },
        success : function(response){
        	jQuery('.progress').hide();
        	jQuery(".progress-bar").width('0%');
            if(response.status === 1)
            {
            	if(response.html)
            	{
            		if(response.action && response.action == 'edit' && current_tr)
	            	{
	            		current_tr.remove();
	            	}
	            	jQuery('#tab-managefee').find('.waef-table tbody').append(response.html);
					$('ul.waef-nav').find('.waef-nav__item-link.managefee').trigger('click');
	            	
            	}
            }
        }
    });
	});
	
	$( '.idomit-buy-now' ).on( 'click', function( e ) {
		var $button = $( this ),
			plugin_id = $button.data( 'plugin-id' ),
			plan_id = $button.data( 'plan-id' ),
			public_key = $button.data( 'public-key' ),
			type = $button.data( 'type' ),
			coupon = $button.data( 'coupon' ),
			licenses = $button.data( 'licenses' ),
			title = $button.data( 'title' ),
			subtitle = $button.data( 'title' );

		var handler = FS.Checkout.configure( {
			plugin_id: plugin_id,
			plan_id: plan_id,
			public_key: public_key,
		} );

		handler.open( {
			title: title,
			subtitle: subtitle,
			licenses: licenses,
			coupon: coupon,
			hide_coupon: true,
			// You can consume the response for after purchase logic.
			purchaseCompleted: function( response ) {
				// The logic here will be executed immediately after the purchase confirmation.                                // alert(response.user.email);
			},
			success: function( response ) {
				// The logic here will be executed after the customer closes the checkout, after a successful purchase.                                // alert(response.user.email);
			}
		} );

		e.preventDefault();
	} );

	// Add condition
	$( '#waef_conditions' ).on( 'click', '.condition-add', function() {

		var data = {
			action: 'waef_add_condition',
			group: $( this ).attr( 'data-group' ),
			nonce: waef.nonce
		};

		// Loading icon
		var loading_icon = '<div class="waef-condition-wrap loading"></div>';
		$( '.condition-group-' + data.group ).append( loading_icon ).children( ':last' ).block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });

		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group-' + data.group + ' .waef-condition-wrap.loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Delete condition
	$( '#waef_conditions' ).on( 'click', '.condition-delete', function() {
		"use strict";
		if ( $( this ).closest( '.condition-group' ).children( '.waef-condition-wrap' ).length == 1 ) {
			$( this ).closest( '.condition-group' ).fadeOut( 'normal', function() { $( this ).remove();	});
		} else {
			$( this ).closest( '.waef-condition-wrap' ).fadeOut( 'normal', function() { $( this ).remove(); });
		}

	});

	// Add condition group
	$( document ).on( 'click', '#waef_conditions .condition-group-add', function() {
		"use strict";
		var condition_group_loading = '<div class="condition-group loading"></div>';
		// Display loading icon
		$( '.waef_conditions' ).append( condition_group_loading ).children( ':last').block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });
		$('.no-rule-message').hide();
		var data = {
			action: 'waef_add_condition_group',
			group: 	parseInt( $( '.condition-group' ).length ),
			nonce: 	waef.nonce
		};

		// Insert condition group
		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group ~ .loading' ).first().replaceWith( function() {
				return $( response ).hide().fadeIn( 'normal' );
			});
		});

	});

	// Update condition values
	$( '#waef_conditions' ).on( 'change', '.waef-condition', function () {
		"use strict";
		var data = {
			action: 		'waef_update_condition_value',
			id:				$( this ).attr( 'data-id' ),
			group:			$( this ).attr( 'data-group' ),
			condition: 		$( this ).val(),
			nonce: 			waef.nonce
		};

		var replace = '.waef-value-wrap-' + data.id;

		$( replace ).html( '<span style="width: 30%; border: 1px solid transparent; display: inline-block;">&nbsp;</span>' )
			.block({ message: null, overlayCSS: { background: '', opacity: 0.6 } });
		$.post( ajaxurl, data, function( response ) {
			$( replace ).replaceWith( response );
		});

		// Update condition description
		var description = {
			action:		'waef_update_condition_description',
			condition: 	data.condition,
			nonce: 		waef.nonce
		};

		$.post( ajaxurl, description, function( description_response ) {
			$( replace + ' ~ .waef-description' ).replaceWith( description_response );
		})

	});

	// Sortable
	$( '.waef-table tbody' ).sortable({
		items:					'tr',
		handle:					'.sort',
		cursor:					'move',
		axis:					'y',
		scrollSensitivity:		40,
		forcePlaceholderSize: 	true,
		helper: 				'clone',
		opacity: 				0.65,
		placeholder: 			'wc-metabox-sortable-placeholder',
		start:function(event,ui){
			ui.item.css( 'background-color','#f6f6f6' );
		},
		stop:function(event,ui){
			ui.item.removeAttr( 'style' );
		},
		update: function(event, ui) {

			var table 	= $( this ).closest( 'table' );
			table.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
			// Update shipping method order
			var data = {
				action:	'waef_save_fees_list_table',
				form: 	$( this ).closest( 'form' ).serialize(),
				nonce: waef.nonce
			};

			$.post( ajaxurl, data, function( response ) {
				$( '.waef-table tbody tr:even' ).addClass( 'alternate' );
				$( '.waef-table tbody tr:odd' ).removeClass( 'alternate' );
				table.unblock();
			})
		}
	});

	// Streamline onboarding UI.
	$( '#screen-meta-links' ).hide();
	$( '#wpfooter' ).hide();
});
(function( $, document ) {
var waef = {
	
	waefcache: function() {
		waef.els = {};
		waef.vars = {};

		waef.els.tab_links = $('.waef-nav__item-link');
		waef.els.submit_button = $( '.waef-button-submit' );
	},

	on_ready: function() {

		// on ready stuff here
		waef.waefcache();
		waef.tabs.watch();
		// $( document.body ).on( 'change', waef.control_groups );
	},

	/**
	 * Setup the main tabs for the settings page
	 */
	 tabs: {
		/**
		 * Watch for tab clicks.
		 */
		watch: function() {
			var tab_id = waef.tabs.get_tab_id();

			if ( tab_id ) {
				waef.tabs.set_active_tab( tab_id );
			}

			waef.els.tab_links.on( 'click', function( e ) {
				// Show tab
				var tab_id = $( this ).attr( 'href' );

				// if(tab_id == '#tab-addnewfee')
				// {
				// 	$('#new_waef_post').trigger('click');
				// }

				waef.tabs.set_active_tab( tab_id );

				e.preventDefault();
			} );
		},

		/**
		 * Is storage available.
		 */
		has_storage: 'undefined' !== typeof (Storage),

		/**
		 * Store tab ID.
		 *
		 * @param tab_id
		 */
		set_tab_id: function( tab_id ) {
			if ( !waef.tabs.has_storage ) {
				return;
			}

			localStorage.setItem( waef.tabs.get_option_page() + '_waef_tab_id', tab_id );
		},

		/**
		 * Get tab ID.
		 *
		 * @returns {boolean}
		 */
		get_tab_id: function() {
			// If the tab id is specified in the URL hash, use that.
			if ( window.location.hash ) {
				// Check if hash is a tab.
				if ( $( `.waef-nav a[href="${window.location.hash}"]` ).length ) {
					return window.location.hash;
				}
			}

			if ( !waef.tabs.has_storage ) {
				return false;
			}

			return localStorage.getItem( waef.tabs.get_option_page() + '_waef_tab_id' );
		},

		/**
		 * Set active tab.
		 *
		 * @param tab_id
		 */
		set_active_tab: function( tab_id ) {
			
			var $tab = $( tab_id ),
				$tab_link = $( '.waef-nav__item-link[href="' + tab_id + '"]' );
				// console.log($tab);
			if ( $tab.length <= 0 || $tab_link.length <= 0 ) {
				// Reset to first available tab.
				$tab_link = $( '.waef-nav__item-link' ).first();
				tab_id = $tab_link.attr( 'href' );
				$tab = $( tab_id );
			}
			// console.log(waef.els.tab_links.parent());
			// Set tab link active class
			waef.els.tab_links.parent().removeClass( 'waef-nav__item--active' );
			$( 'a[href="' + tab_id + '"]' ).parent().addClass( 'waef-nav__item--active' );
			// Show tab
			$( '.waef-tab' ).removeClass( 'waef-tab--active' );
			$tab.addClass( 'waef-tab--active' );

			waef.tabs.set_tab_id( tab_id );
		},

		/**
		 * Get unique option page name.
		 *
		 * @returns {jQuery|string|undefined}
		 */
		get_option_page: function() {
			return $( 'input[name="option_page"]' ).val();
		}
	},
};
$( document ).ready( waef.on_ready );
}( jQuery, document ));