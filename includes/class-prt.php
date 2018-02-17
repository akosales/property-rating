<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.makler-anfragen.immo
 * @since      1.0.0
 *
 * @package    Prt
 * @subpackage Prt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Prt
 * @subpackage Prt/includes
 * @author     Andreas Konopka <info@makler-anfragen.immo>
 */
class Prt {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Prt_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prt    The string used to uniquely identify this plugin.
	 */
	protected $prt;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $settings;

	protected $styler;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRT_VERSION' ) ) {
			$this->version = PRT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->prt = 'prt';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Prt_Loader. Orchestrates the hooks of the plugin.
	 * - Prt_i18n. Defines internationalization functionality.
	 * - Prt_Admin. Defines all hooks for the admin area.
	 * - Prt_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-prt-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-prt-public.php';

		/**
		 * The class responsible for the Settings Page in the admin face
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prt-settings.php';

		/**
		 * The class responsible for the Settings Page in the admin face
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prt-styler.php';

		$this->loader = new Prt_Loader();

		// $this->debug();

		// Plugin version.
		if (!defined( 'PRT_SETTINGS_TITLE' )) define( 'PRT_SETTINGS_TITLE', 'Property Rating Tool' );
		$this->settings = new Prt_Settings(true); //true -> runSettings()

		$this->styler = new Prt_Styler();

		$toBeReplaced = [
			'$primary_color' => $this->settings->get_option('primary_color', 'prt_settings_style', '#0A0A0A'),
			'$secondary_color' => $this->settings->get_option('secondary_color', 'prt_settings_style', '#fff'),
			'$progress_color' => $this->settings->get_option('progress_color', 'prt_settings_style', '#0A0A0A'),
			'$progress_text_color' => $this->settings->get_option('progress_text_color', 'prt_settings_style', '#fff'),
			'$default_font_size' => $this->settings->get_option('default_font_size', 'prt_settings_style', '14px'),
			'$default_font_color' => $this->settings->get_option('default_font_color', 'prt_settings_style', '#0A0A0A'),
			'$default_font_weight' => $this->settings->get_option('default_font_weight', 'prt_settings_style', '400'),
			'$default_font_transform' => $this->settings->get_option('default_font_transform', 'prt_settings_style', 'none'),
			'$default_font_family' => $this->settings->get_option('default_font_family', 'prt_settings_style', 'Montserrat, "Helvetica Neue", sans-serif'),
			'$default_font_subset' => $this->settings->get_option('default_font_subset', 'prt_settings_style', 'latin'),
			'$button_prev_color' => $this->settings->get_option('button_prev_color', 'prt_settings_style', '#0A0A0A'),
			'$button_next_color' => $this->settings->get_option('button_next_color', 'prt_settings_style', '#0A0A0A'),
			'$button_finish_color' => $this->settings->get_option('button_finish_color', 'prt_settings_style', '#20bf6b'),
			'$h1_size' => $this->settings->get_option('h1_size', 'prt_settings_style', 'inherit'),
			'$h1_color' => $this->settings->get_option('h1_color', 'prt_settings_style', '#0A0A0A'),
			'$h2_size' => $this->settings->get_option('h2_size', 'prt_settings_style', 'inherit'),
			'$h2_color' => $this->settings->get_option('h2_color', 'prt_settings_style', '#0A0A0A'),
			'$h3_size' => $this->settings->get_option('h3_size', 'prt_settings_style', 'inherit'),
			'$h3_color' => $this->settings->get_option('h3_color', 'prt_settings_style', '#0A0A0A'),
			'$h4_size' => $this->settings->get_option('h4_size', 'prt_settings_style', 'inherit'),
			'$h4_color' => $this->settings->get_option('h4_color', 'prt_settings_style', '#0A0A0A'),
			'$h5_size' => $this->settings->get_option('h5_size', 'prt_settings_style', 'inherit'),
			'$h5_color' => $this->settings->get_option('h5_color', 'prt_settings_style', '#0A0A0A'),
			'$h6_size' => $this->settings->get_option('h6_size', 'prt_settings_style', 'inherit'),
			'$h6_color' => $this->settings->get_option('h6_color', 'prt_settings_style', '#0A0A0A'),
			'$custom_css' => $this->settings->get_option('custom_css', 'prt_settings_style', ''),
		];

		$sampleCss = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/prt-sample.css';
		$newCss = plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/prt-public.css';
		$this->styler->generateCss($sampleCss, $newCss, $toBeReplaced);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Prt_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Prt_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function debug() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		
		$plugin_admin = new Prt_Admin( $this->get_prt(), $this->get_version(), $this->settings );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'action_menu' );
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Prt_Public( $this->get_prt(), $this->get_version(), $this->settings);

		// register, because if shortcode will rendered
		// the styles already included to the output file.
		$plugin_public->register_styles();
		$plugin_public->enqueue_styles();
		$plugin_public->register_scripts();
		$this->loader->add_action( 'init', $plugin_public, 'replace_jquery' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action( 'wp_ajax_prt_getsteps', $plugin_public, 'ajax_prt_getsteps' );
		$this->loader->add_action( 'wp_ajax_nopriv_prt_getsteps', $plugin_public, 'ajax_prt_getsteps' );

		$this->loader->add_action( 'wp_ajax_prt_geo', $plugin_public, 'ajax_prt_geo' );
		$this->loader->add_action( 'wp_ajax_nopriv_prt_geo', $plugin_public, 'ajax_prt_geo' );

		$this->loader->add_action( 'wp_ajax_prt_submit', $plugin_public, 'ajax_prt_submit' );
		$this->loader->add_action( 'wp_ajax_nopriv_prt_submit', $plugin_public, 'ajax_prt_submit' );

		$shortcode_name = $this->settings->get_option('shortcode', 'prt_settings_general');
		$shortcode_name = empty($shortcode_name) ? 'PRT_INCLUDE' : substr($shortcode_name, 1, -1);
		$this->loader->add_shortcode($shortcode_name, $plugin_public, 'shortcode_prt_include');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_prt() {
		return $this->prt;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Prt_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
