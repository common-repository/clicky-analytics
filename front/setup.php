<?php
/**
 * Author: Alin Marcu
 * Author URI: https://deconf.com
 * Copyright 2013 Alin Marcu
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit();

if ( ! class_exists( 'CAWP_Frontend_Setup' ) ) {

	final class CAWP_Frontend_Setup {

		private $cawp;

		public function __construct() {
			$this->cawp = CAWP();
			/**
			 * Styles & Scripts
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'load_styles_scripts' ) );
		}
		/**
		 * Styles & Scripts conditional loading
		 *
		 * @param
		 *            $hook
		 */
		public function load_styles_scripts() {
			$lang = get_bloginfo( 'language' );
			$lang = explode( '-', $lang );
			$lang = $lang[0];
			/**
			 * Item reports Styles & Scripts
			 */
			if ( CAWP_Tools::check_roles( $this->cawp->config->options['access_front'] ) && $this->cawp->config->options['frontend_item_reports'] ) {

				wp_enqueue_style( 'cawp-nprogress', CAWP_URL . 'common/nprogress/nprogress'.CAWP_Tools::script_debug_suffix().'.css', null, CAWP_CURRENT_VERSION );

				wp_enqueue_style( 'cawp-frontend-item-reports', CAWP_URL . 'front/css/item-reports'.CAWP_Tools::script_debug_suffix().'.css', null, CAWP_CURRENT_VERSION );

				wp_enqueue_style( 'cawp-daterangepicker', CAWP_URL . 'common/daterangepicker/daterangepicker'.CAWP_Tools::script_debug_suffix().'.css', null, CAWP_CURRENT_VERSION );

				wp_enqueue_style( "wp-jquery-ui-dialog" );

				wp_register_script( 'googlecharts', 'https://www.gstatic.com/charts/loader.js', array(), null );

				wp_enqueue_script( 'cawp-nprogress', CAWP_URL . 'common/nprogress/nprogress'.CAWP_Tools::script_debug_suffix().'.js', array( 'jquery' ), CAWP_CURRENT_VERSION );

				wp_enqueue_script( 'cawp-moment', CAWP_URL . 'common/daterangepicker/moment'.CAWP_Tools::script_debug_suffix().'.js', array( 'jquery' ), CAWP_CURRENT_VERSION );

				wp_enqueue_script( 'cawp-daterangepicker', CAWP_URL . 'common/daterangepicker/daterangepicker'.CAWP_Tools::script_debug_suffix().'.js', array( 'jquery' ), CAWP_CURRENT_VERSION );

				wp_enqueue_script( 'cawp-frontend-item-reports', CAWP_URL . 'common/js/reports'.CAWP_Tools::script_debug_suffix().'.js', array( 'cawp-nprogress', 'cawp-moment', 'cawp-daterangepicker','googlecharts', 'jquery', 'jquery-ui-dialog' ), CAWP_CURRENT_VERSION, true );

				/* @formatter:off */
				wp_localize_script( 'cawp-frontend-item-reports', 'cawpItemData', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'cawp_frontend_item_reports' ),
					'reportList' => array(
						'visitors' => __( "Visitors", 'clicky-analytics' ),
						'actions-pageviews' => __( "Pageviews", 'clicky-analytics' ),
						'time-average' => __( "Time Average", 'clicky-analytics' ),
						'bounce-rate' => __( "Bounce Rate", 'clicky-analytics' ),
						'locations' => __( "Locations", 'clicky-analytics' ),
						'referrers' => __( "Referrers", 'clicky-analytics' ),
					),
					'i18n' => array(
							__( "A JavaScript Error is blocking plugin resources!", 'clicky-analytics' ), //0
							__( "Search ...", 'clicky-analytics' ),
							__( "Download", 'clicky-analytics' ),
							__( "", 'clicky-analytics' ),
							__( "", 'clicky-analytics' ),
				 		__( "Visitors", 'clicky-analytics' ),
						 __( "Pageviews", 'clicky-analytics' ),
				 		__( "Time Average", 'clicky-analytics' ),
					 	__( "Bounce Rate", 'clicky-analytics' ),
				 		__( "Server Errors", 'clicky-analytics' ),
							__( "Not Found", 'clicky-analytics' ),
							__( "Invalid response", 'clicky-analytics' ),
							__( "Processing data, please check again in a few days", 'clicky-analytics' ),
							__( "This report is unavailable", 'clicky-analytics' ),
							__( "report generated by", 'clicky-analytics' ), //14
							__( "This plugin needs an authorization:", 'clicky-analytics' ) . ' <strong>' . __( "authorize the plugin", 'clicky-analytics' ) . '</strong>!',
						 __( "Clicky Analytics", 'clicky-analytics' ),
					),
					'colorVariations' => CAWP_Tools::variations( $this->cawp->config->options['theme_color'] ),
					'mapsApiKey' => apply_filters( 'cawp_maps_api_key', $this->cawp->config->options['maps_api_key'] ),
					'language' => get_bloginfo( 'language' ),
					'filter' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
					'propertyList' => false,
					'scope' => 'front-item',
				 )
				);
				/* @formatter:on */
			}
		}
	}
}