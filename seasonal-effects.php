<?php
/**
 * Plugin Name: Seasonal Effects
 * Plugin URI: https://codesocials.com/seasonal-effects
 * Description: Add beautiful seasonal effects to your WordPress site including snow, rain, autumn leaves, fireworks, and more.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: Nitya Saha
 * Author URI: https://codesocials.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: seasonal-effects
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SEASONAL_EFFECTS_VERSION', '1.0.0');
define('SEASONAL_EFFECTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SEASONAL_EFFECTS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class Seasonal_Effects {
    
    /**
     * Instance of this class
     */
    private static $instance = null;

    private $plugin_basename;
    
    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        require_once SEASONAL_EFFECTS_PLUGIN_DIR . 'includes/global-functions.php';
        require_once SEASONAL_EFFECTS_PLUGIN_DIR . 'includes/class-main.php';
        new Seasonal_Effects_Main();

        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
        $this->plugin_basename = plugin_basename( __FILE__ );
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Activation and deactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Admin scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));


        // Add settings link on the plugins page.
        add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'insert_view_logs_link' ) );
        add_filter( 'plugin_row_meta', array( $this, 'addon_plugin_links' ), 10, 2 );
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $defaults = array(
            'effect_type' => 'none',
            'effect_intensity' => 'medium',
            'effect_color' => '#ffffff',
            'enable_mobile' => true,
            'z_index' => 9999
        );
        
        if (!get_option('seasonal_effects_settings')) {
            add_option('seasonal_effects_settings', $defaults);
        }
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up if needed
    }
    
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ('settings_page_seasonal-effects' !== $hook) {
            return;
        }
        
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // Initialize color picker
        wp_add_inline_script('wp-color-picker', '
            jQuery(document).ready(function($){
                $("#effect_color").wpColorPicker();
            });
        ');
    }

    /**
     * Add a settings link to the plugin's action links.
     *
     * @param array $links
     * @return array
     */
    public function insert_view_logs_link( $links ) {
        $settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=share_cart_url' ) ) . '">' . esc_html__( 'Settings', 'seasonal-effects' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function addon_plugin_links( $links, $file ) {
        if ( $file === $this->plugin_basename ) {
            $links[] = __( '<a href="https://buymeacoffee.com/nityasaha" style="font-weight:bold;color:#00d300;font-size:15px;">Donate</a>', 'seasonal-effects' );
            $links[] = __( 'Made with Love ❤️', 'seasonal-effects' );
        }

        return $links;
    }
    
}

// Initialize plugin
function seasonal_effects_init() {
    return Seasonal_Effects::get_instance();
}

add_action('plugins_loaded', 'seasonal_effects_init');