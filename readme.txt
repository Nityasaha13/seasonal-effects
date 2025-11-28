=== Seasonal Effects ===
Contributors: nityasaha
Donate link: https://buymeacoffee.com/nityasaha
Tags: effects, seasonal, snow, animation, particles
Requires at least: 5.8
Tested up to: 6.8
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add beautiful seasonal effects to your WordPress site with canvas-based animations.

== Description ==

Seasonal Effects brings your WordPress website to life with stunning visual effects perfect for holidays, seasons, and special occasions. Choose from multiple professionally crafted effects that run smoothly on all devices.

= Features =

* **Multiple Effects**: Snow, Rain, Autumn Leaves, Fireworks, Hearts, Cherry Blossoms, Confetti, and Twinkling Stars
* **Customizable Intensity**: Choose between Light, Medium, or Heavy particle counts
* **Color Control**: Customize colors for applicable effects
* **Mobile Support**: Enable or disable effects on mobile devices
* **Performance Optimized**: Uses HTML5 Canvas with RequestAnimationFrame for smooth 60fps animations
* **Z-Index Control**: Adjust layering to work with any theme
* **Easy Configuration**: Simple settings page in WordPress admin
* **Lightweight**: Minimal resource usage with no external dependencies

= Available Effects =

1. **Snow** - Perfect for winter and Christmas
2. **Rain** - Realistic rainfall effect
3. **Autumn Leaves** - Falling leaves in autumn colors
4. **Fireworks** - Celebratory fireworks display
5. **Hearts** - Romantic floating hearts for Valentine's Day
6. **Sakura** - Cherry blossom petals for spring
7. **Confetti** - Party confetti for celebrations
8. **Stars** - Twinkling stars for nighttime ambiance

= Use Cases =

* Holiday decorations (Christmas, New Year, Valentine's Day)
* Seasonal themes (Spring, Summer, Autumn, Winter)
* Special events and celebrations
* Product launches
* Festive landing pages
* Event websites

= Performance =

All effects are GPU-accelerated using HTML5 Canvas and run at 60fps on modern devices. The plugin is optimized to use minimal resources and won't slow down your website.

== Installation ==

1. Upload the `seasonal-effects` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Seasonal Effects to configure your effect
4. Select an effect type, adjust intensity, and save
5. Visit your site to see the effect in action!

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Navigate to Plugins > Add New > Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin
6. Configure settings under Settings > Seasonal Effects

== Frequently Asked Questions ==

= Does this affect my site's performance? =

No, the plugin uses efficient canvas-based animations with RequestAnimationFrame, ensuring smooth performance. You can also disable effects on mobile devices if needed.

= Can I use multiple effects at once? =

Currently, only one effect can be active at a time. This ensures optimal performance and visual clarity.

= Will this work with my theme? =

Yes! The plugin uses a fixed-position canvas overlay that works with any WordPress theme. You can adjust the z-index if needed.

= Can I customize the colors? =

Yes, you can customize colors for applicable effects through the color picker in the settings page.

= Does it work on mobile devices? =

Yes, but you can choose to disable effects on mobile devices to save battery and improve performance.

= How do I disable the effect temporarily? =

Simply go to Settings > Seasonal Effects and set the Effect Type to "None".

= Can I schedule effects for specific dates? =

This feature is planned for a future update. Currently, you need to manually change effects.

== Screenshots ==

1. Settings page with effect selection and customization options
2. Snow effect in action on a website
3. Fireworks effect for celebrations
4. Autumn leaves falling effect
5. Hearts effect for Valentine's Day

== Changelog ==

= 1.0.0 =
* Initial release
* 8 different seasonal effects
* Customizable intensity levels
* Color picker for applicable effects
* Mobile device toggle
* Z-index control
* Performance optimized canvas animations

== Upgrade Notice ==

= 1.0.0 =
Initial release of Seasonal Effects plugin.

== Plugin Structure ==

```
seasonal-effects/
├── seasonal-effects.php (Main plugin file)
├── readme.txt
├── includes/
│   └── effects/
│       ├── snow.php
│       ├── rain.php
│       ├── autumn.php
│       ├── fireworks.php
│       ├── hearts.php
│       ├── sakura.php
│       ├── confetti.php
│       └── stars.php
└── languages/
    └── seasonal-effects.pot
```

== Developer Notes ==

The plugin follows WordPress coding standards and is ready for submission to the WordPress.org plugin directory. All effects use vanilla JavaScript with no external dependencies.

= Extending the Plugin =

Developers can add custom effects by creating new PHP files in the `includes/effects/` directory following the existing template structure.

== Support ==

For support, feature requests, or bug reports, please visit the plugin's support forum on WordPress.org.

== Credits ==

Developed with ❤️ for the WordPress community.