<?php

namespace Innocode\WPThemeModule;

use WP_Error;

/**
 * Class Debugger
 * @package Innocode\WPThemeModule
 */
trait Debugger
{
    /**
     * @param WP_Error|mixed $data
     */
    public function debug( $data )
    {
        if ( is_wp_error( $data ) ) {
            $this->warn( $data );
        }
    }

    /**
     * @param WP_Error|mixed $data
     */
    public function warn( $data )
    {
        if ( static::is_wp_debug() ) {
            wp_die( $data );
        } else {
            trigger_error( $data->get_error_message(), E_USER_WARNING );
        }
    }

    /**
     * @return bool
     */
    public static function is_wp_debug()
    {
        return defined( 'WP_DEBUG' ) && WP_DEBUG;
    }
}
