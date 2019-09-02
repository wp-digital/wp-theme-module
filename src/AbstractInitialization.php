<?php

namespace Innocode\WPThemeModule;

use ReflectionMethod;
use ReflectionException;

/**
 * Class AbstractInitialization
 * @package Innocode\WPThemeModule
 */
abstract class AbstractInitialization
{
    public function run()
    {
        $this->_execute_hooks();
    }

    private function _execute_hooks()
    {
        $methods = get_class_methods( $this );

        foreach ( $methods as $method ) {
            try {
                $reflection = new ReflectionMethod( $this, $method );
            } catch ( ReflectionException $exception ) {
                continue;
            }

            if ( ! $reflection->isPublic() ) {
                continue;
            }

            $hooks = [];

            foreach ( [
                'add_filter_',
                'add_action_',
            ] as $hook ) {
                $hooks[ $hook ] = substr( $method, 0, strlen( $hook ) ) === $hook;
            }

            if ( ! $hooks[ 'add_filter_' ] && ! $hooks[ 'add_action_' ] ) {
                continue;
            }

            $tag = str_replace( array_keys( $hooks ), '', $method );
            $params_count = $reflection->getNumberOfParameters();
            $pattern = '/^((?!__).)+__(\d+)$/';
            $priority = preg_match( $pattern, $method, $matches )
                ? $matches[ 2 ]
                : 10;

            if ( $hooks[ 'add_filter_' ] ) {
                add_filter( $tag, [ $this, $method ], $priority, $params_count );
            }

            if ( $hooks[ 'add_action_' ] ) {
                add_action( $tag, [ $this, $method ], $priority, $params_count );
            }
        }
    }
}
