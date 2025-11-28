<?php

if (!defined('ABSPATH')) {
    exit;
}

class Seasonal_Effects_Main{

    public function __construct()
    {
        
        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Frontend effects
        add_action('wp_footer', array($this, 'render_effect'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Seasonal Effects Settings', 'seasonal-effects'),
            __('Seasonal Effects', 'seasonal-effects'),
            'manage_options',
            'seasonal-effects',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting(
            'seasonal_effects_group',
            'seasonal_effects_settings',
            array($this, 'sanitize_settings')
        );
        
        add_settings_section(
            'seasonal_effects_main_section',
            __('Effect Settings', 'seasonal-effects'),
            array($this, 'section_callback'),
            'seasonal-effects'
        );
        
        add_settings_field(
            'effect_type',
            __('Effect Type', 'seasonal-effects'),
            array($this, 'effect_type_callback'),
            'seasonal-effects',
            'seasonal_effects_main_section'
        );
        
        add_settings_field(
            'effect_intensity',
            __('Effect Intensity', 'seasonal-effects'),
            array($this, 'effect_intensity_callback'),
            'seasonal-effects',
            'seasonal_effects_main_section'
        );
        
        add_settings_field(
            'effect_color',
            __('Effect Color', 'seasonal-effects'),
            array($this, 'effect_color_callback'),
            'seasonal-effects',
            'seasonal_effects_main_section'
        );
        
        add_settings_field(
            'enable_mobile',
            __('Enable on Mobile', 'seasonal-effects'),
            array($this, 'enable_mobile_callback'),
            'seasonal-effects',
            'seasonal_effects_main_section'
        );
        
        add_settings_field(
            'z_index',
            __('Z-Index', 'seasonal-effects'),
            array($this, 'z_index_callback'),
            'seasonal-effects',
            'seasonal_effects_main_section'
        );
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();
        
        $sanitized['effect_type'] = sanitize_text_field($input['effect_type']);
        $sanitized['effect_intensity'] = sanitize_text_field($input['effect_intensity']);
        $sanitized['effect_color'] = sanitize_hex_color($input['effect_color']);
        $sanitized['enable_mobile'] = isset($input['enable_mobile']) ? true : false;
        $sanitized['z_index'] = absint($input['z_index']);
        
        return $sanitized;
    }

    /**
     * Section callback
     */
    public function section_callback() {
        echo '<p>' . esc_html__('Configure your seasonal effects below.', 'seasonal-effects') . '</p>';
    }

    
    
    /**
     * Effect type callback
     */
    public function effect_type_callback() {
        $options = get_option('seasonal_effects_settings');
        $value = isset($options['effect_type']) ? $options['effect_type'] : 'none';
        
        $effects = array(
            'none' => __('None', 'seasonal-effects'),
            'snow' => __('Snow', 'seasonal-effects'),
            'rain' => __('Rain', 'seasonal-effects'),
            'autumn' => __('Autumn Leaves', 'seasonal-effects'),
            'fireworks' => __('Fireworks', 'seasonal-effects'),
            'hearts' => __('Hearts (Valentine)', 'seasonal-effects'),
            'sakura' => __('Sakura (Cherry Blossoms)', 'seasonal-effects'),
            'confetti' => __('Confetti', 'seasonal-effects'),
            'stars' => __('Stars', 'seasonal-effects'),
            'summer' => __('Hot Summer (Bright Sun)', 'seasonal-effects')
        );
        
        echo '<select name="seasonal_effects_settings[effect_type]" id="effect_type">';
        foreach ($effects as $key => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($key),
                selected($value, $key, false),
                esc_html($label)
            );
        }
        echo '</select>';
        echo '<p class="description">' . esc_html__('Select the effect to display on your site.', 'seasonal-effects') . '</p>';
    }
    
    /**
     * Effect intensity callback
     */
    public function effect_intensity_callback() {
        $options = get_option('seasonal_effects_settings');
        $value = isset($options['effect_intensity']) ? $options['effect_intensity'] : 'medium';
        
        $intensities = array(
            'light' => __('Light', 'seasonal-effects'),
            'medium' => __('Medium', 'seasonal-effects'),
            'heavy' => __('Heavy', 'seasonal-effects')
        );
        
        echo '<select name="seasonal_effects_settings[effect_intensity]" id="effect_intensity">';
        foreach ($intensities as $key => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($key),
                selected($value, $key, false),
                esc_html($label)
            );
        }
        echo '</select>';
        echo '<p class="description">' . esc_html__('Control the number of particles.', 'seasonal-effects') . '</p>';
    }
    
    /**
     * Effect color callback
     */
    public function effect_color_callback() {
        $options = get_option('seasonal_effects_settings');
        $value = isset($options['effect_color']) ? $options['effect_color'] : '#ffffff';
        
        printf(
            '<input type="color" name="seasonal_effects_settings[effect_color]" value="%s" id="effect_color" />',
            esc_attr($value)
        );
        echo '<p class="description">' . esc_html__('Select color for applicable effects.', 'seasonal-effects') . '</p>';
    }
    
    /**
     * Enable mobile callback
     */
    public function enable_mobile_callback() {
        $options = get_option('seasonal_effects_settings');
        $checked = isset($options['enable_mobile']) && $options['enable_mobile'];
        
        printf(
            '<input type="checkbox" name="seasonal_effects_settings[enable_mobile]" value="1" %s id="enable_mobile" />',
            checked($checked, true, false)
        );
        echo '<label for="enable_mobile"> ' . esc_html__('Enable effects on mobile devices', 'seasonal-effects') . '</label>';
    }
    
    /**
     * Z-index callback
     */
    public function z_index_callback() {
        $options = get_option('seasonal_effects_settings');
        $value = isset($options['z_index']) ? $options['z_index'] : 9999;
        
        printf(
            '<input type="number" name="seasonal_effects_settings[z_index]" value="%s" min="0" max="999999" id="z_index" />',
            esc_attr($value)
        );
        echo '<p class="description">' . esc_html__('Adjust layering order (higher = on top).', 'seasonal-effects') . '</p>';
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <?php
            // Check if settings-updated exists and is true
            if (isset($_GET['settings-updated'])) {

                // Unslash → sanitize
                $settings_updated = sanitize_text_field(wp_unslash($_GET['settings-updated']));

                if ($settings_updated === 'true' || $settings_updated === '1') {
                    ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php esc_html_e('Settings Saved', 'seasonal-effects'); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
            
            <form action="options.php" method="post">
                <?php
                settings_fields('seasonal_effects_group');
                do_settings_sections('seasonal-effects');
                submit_button(__('Save Settings', 'seasonal-effects'));
                ?>
            </form>
            
            <div class="seasonal-effects-preview" style="margin-top: 30px; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
                <h2><?php esc_html_e('Preview', 'seasonal-effects'); ?></h2>
                <p><?php esc_html_e('Visit your site to see the effect in action!', 'seasonal-effects'); ?></p>
            </div>
        </div>
        <?php
    }

    /**
     * Render effect on frontend
     */
    public function render_effect() {
        $options = get_option('seasonal_effects_settings');
        $effect_type = isset($options['effect_type']) ? $options['effect_type'] : 'none';
        
        if ($effect_type === 'none') {
            return;
        }
        
        // Check mobile setting
        if (!isset($options['enable_mobile']) || !$options['enable_mobile']) {
            if (wp_is_mobile()) {
                return;
            }
        }
        
        $intensity = isset($options['effect_intensity']) ? $options['effect_intensity'] : 'medium';
        $color = isset($options['effect_color']) ? $options['effect_color'] : '#ffffff';
        $z_index = isset($options['z_index']) ? $options['z_index'] : 9999;
        
        // Get particle count based on intensity
        $particle_counts = array(
            'light' => 50,
            'medium' => 100,
            'heavy' => 200
        );
        $particle_count = isset($particle_counts[$intensity]) ? $particle_counts[$intensity] : 100;
        
        // Check if effect file exists
        $effect_file = SEASONAL_EFFECTS_PLUGIN_DIR . 'includes/effects/' . $effect_type . '.php';
        
        if (file_exists($effect_file)) {
            include $effect_file;
        }
    }
}