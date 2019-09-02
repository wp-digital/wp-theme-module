<?php

namespace Innocode\WPThemeModule;

use ReflectionClass;
use ReflectionException;

/**
 * Class AbstractFunctions
 * @package Innocode\WPThemeModule
 */
abstract class AbstractFunctions
{
    /**
     * @param string $file
     * @return string
     */
    public static function get_module_file_path( string $file = '' )
    {
        $file = static::get_file_path( $file );

        return get_theme_file_path( $file );
    }

    /**
     * @param string $file
     * @return string
     */
    public static function get_module_file_uri( string $file = '' )
    {
        $file = static::get_file_path( $file );

        return get_theme_file_uri( $file );
    }

    /**
     * @param string $file
     * @return string
     */
    public static function get_file_path( string $file = '' )
    {
        $path = 'modules';
        $file = ltrim( $file, '/' );

        if ( ! empty( $file ) ) {
            $file = "/$file";
        }

        $called_class = get_called_class();

        try {
            $reflection = new ReflectionClass( $called_class );
            $namespace = $reflection->getNamespaceName();
            $path .= '/' . str_replace( '\\', '/', $namespace );
        } catch ( ReflectionException $exception ) {}

        return "$path$file";
    }
}
