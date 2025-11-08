# Xeader Plugin - WordPress Plugin Framework

A comprehensive WordPress plugin framework that provides the foundation for building robust, maintainable WordPress plugins. This base plugin offers event management, routing, shortcode handling, and data rendering capabilities that other plugins can extend and customize.

## Overview

The Xeader Plugin serves as an abstract base that other WordPress plugins can extend. It provides a structured architecture with:

- **Event Management System** - Clean WordPress hook management
- **Routing System** - Custom URL routing with rewrite rules
- **Shortcode Framework** - Standardized shortcode implementation
- **Data Rendering System** - Flexible meta data display components
- **Autoloading** - Automatic class loading with custom naming conventions

## Architecture

### Core Components

#### 1. Plugin Base Class (`XeaderPlugin_Plugin`)
The main plugin orchestrator that manages:
- Plugin lifecycle (loading, initialization)
- Event subscribers registration
- Route setup and processing
- Shortcode registration

#### 2. Event Management System
- **`XeaderPlugin_EventManagement_EventManager`** - WordPress hook wrapper
- **`XeaderPlugin_EventManagement_SubscriberInterface`** - Interface for event subscribers
- **`XeaderPlugin_EventManagement_SubscriberAbstract`** - Abstract base for subscribers

#### 3. Routing System
- **`XeaderPlugin_Routing_Router`** - Route registration and matching
- **`XeaderPlugin_Routing_Route`** - Individual route definition
- **`XeaderPlugin_Routing_Processor`** - WordPress integration for routing

#### 4. Shortcode System
- **`XeaderPlugin_Shortcode_ShortcodeInterface`** - Shortcode contract

#### 5. Data Rendering System
- **`XeaderPlugin_Data_Meta_Renderer_Interface`** - Renderer contract
- Built-in renderers: `Text`, `YesNo`, `EnabledDisabled`, `Product\Attribute`

## Installation

1. Download and install as a WordPress plugin
2. The framework is now available for extension by other plugins

## Usage as Base Plugin

### Basic Plugin Structure

Create a new plugin that extends Xeader Plugin:

```php
<?php
/*
Plugin Name: My Custom Plugin
Description: Extends Xeader Plugin framework
Author: Your Name
Version: 1.0.0
*/

// Include Xeader Plugin autoloader
require_once WP_PLUGIN_DIR . '/xeader-plugin/src/XeaderPlugin/Autoloader.php';
XeaderPlugin_Autoloader::register();

// Your custom plugin class
class MyCustomPlugin_Plugin extends XeaderPlugin_Plugin {

    protected function get_subscribers() {
        return array_merge(parent::get_subscribers(), array(
            new MyCustomPlugin_Subscriber_PostTypeSubscriber(),
            new MyCustomPlugin_Subscriber_AdminMenuSubscriber(),
        ));
    }

    protected function get_routes() {
        return array_merge(parent::get_routes(), array(
            'my-custom-page' => new XeaderPlugin_Routing_Route(
                'my-custom-page',
                'my_custom_plugin_page_hook',
                'my-custom-template.php'
            ),
        ));
    }

    protected function get_shortcodes() {
        return array_merge(parent::get_shortcodes(), array(
            new MyCustomPlugin_Shortcode_CustomShortcode(),
        ));
    }
}

// Initialize your plugin
$myCustomPlugin = new MyCustomPlugin_Plugin(__FILE__);
add_action('init', array($myCustomPlugin, 'load'));
```

### Event Subscribers

Create event subscribers to hook into WordPress actions and filters:

```php
class MyCustomPlugin_Subscriber_PostTypeSubscriber implements XeaderPlugin_EventManagement_SubscriberInterface {

    public static function get_subscribed_events() {
        return array(
            'init' => array('register_post_types', 10, 1),
            'admin_menu' => 'add_admin_menu',
        );
    }

    public function register_post_types() {
        register_post_type('my_custom_post', array(
            'labels' => array('name' => 'Custom Posts'),
            'public' => true,
        ));
    }

    public function add_admin_menu() {
        add_menu_page('My Plugin', 'My Plugin', 'manage_options', 'my-plugin-menu');
    }
}
```

### Custom Routes

Define custom routes for your plugin:

```php
// In your plugin's get_routes() method
return array(
    'product-list' => new XeaderPlugin_Routing_Route(
        'products/?$',           // URL pattern
        'my_plugin_products',    // Hook to call
        'products-template.php'  // Template to load
    ),
    'product-detail' => new XeaderPlugin_Routing_Route(
        'products/([^/]+)/?$',
        'my_plugin_product_detail',
        'product-detail-template.php'
    ),
);
```

### Shortcodes

Implement custom shortcodes:

```php
class MyCustomPlugin_Shortcode_CustomShortcode implements XeaderPlugin_Shortcode_ShortcodeInterface {

    public static function get_name() {
        return 'my_custom_shortcode';
    }

    public function generate_output($attributes, $content = '') {
        // Process shortcode logic
        return '<div class="my-custom-output">' . $content . '</div>';
    }
}
```

### Data Renderers

Create custom data renderers for meta fields:

```php
class MyCustomPlugin_Data_Meta_Renderer_CustomRenderer implements XeaderPlugin_Data_Meta_Renderer_Interface {

    public function render($display_value, $meta) {
        // Custom rendering logic
        return '<span class="custom-meta">' . esc_html($display_value) . '</span>';
    }
}
```

## Advanced Features

### Event Management

The event manager provides a clean interface to WordPress hooks:

```php
$event_manager = $plugin->get_event_manager();

// Add callback
$event_manager->add_callback('wp_loaded', array($this, 'my_callback'));

// Execute action
$event_manager->execute('my_custom_action', $param1, $param2);

// Apply filters
$result = $event_manager->filter('my_custom_filter', $value, $param1);
```

### Routing System

The routing system integrates with WordPress rewrite API:

```php
// Routes are automatically compiled to rewrite rules
// Access via: /products/ or /products/123/
add_action('my_plugin_products', function() {
    // Handle products page
});

add_action('my_plugin_product_detail', function() {
    // Handle individual product page
    $product_id = get_query_var('product_id');
});
```

## Best Practices

### Naming Conventions
- Use plugin prefix for all hooks: `my_plugin_`
- Class names: `MyPlugin_ClassName`
- Constants: `ALL_CAPS_WITH_UNDERSCORES`

### Security
- Always sanitize input data
- Escape output data
- Use nonces for forms
- Validate user capabilities

### Performance
- Use WordPress transients for caching
- Minimize database queries
- Load assets conditionally

## Examples

See the commented examples in the main Plugin class for:
- Custom post type registration
- Admin menu creation
- Settings page implementation
- Shortcode registration

## Requirements

- WordPress 4.0+
- PHP 5.3+

## License

This plugin framework is proprietary software. See LICENSE.txt for details.

## Support

For support and documentation, visit [xeader.com](https://xeader.com)