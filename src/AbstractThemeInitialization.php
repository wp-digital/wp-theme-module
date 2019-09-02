<?php

namespace Innocode\WPThemeModule;

/**
 * Class AbstractThemeInitialization
 * @package Innocode\WPThemeModule
 */
abstract class AbstractThemeInitialization extends AbstractInitialization implements ThemeInitializationInterface
{
    public function run()
    {
        parent::run();

        add_action( 'after_setup_theme', function () {
            static::_load_theme_text_domain();
            static::_add_image_sizes();
            static::_register_nav_menus();
        }, 0 );

        add_action( 'wp_enqueue_scripts', function () {
            static::enqueue_styles();
            static::enqueue_scripts();
        } );
    }

    private static function _load_theme_text_domain()
    {
        if ( defined( 'TEXT_DOMAIN' ) && TEXT_DOMAIN ) {
            load_theme_textdomain( TEXT_DOMAIN, get_template_directory() . '/languages' );
        }
    }

    private static function _add_image_sizes()
    {
        foreach ( static::get_image_sizes() as $key => $data ) {
            $width = isset( $data[ 0 ] ) ? $data[ 0 ] : 0;
            $height = isset( $data[ 1 ] ) ? $data[ 1 ] : 0;
            $crop = isset( $data[ 2 ] ) ? $data[ 2 ] : false;

            add_image_size( $key, $width, $height, $crop );
        }
    }

    private static function _register_nav_menus()
    {
        register_nav_menus( static::get_nav_menus_locations() );
    }
}
