<?php

namespace Innocode\WPThemeModule\Abstracts;

use Innocode\WPThemeModule\Interfaces\InitializationInterface;
use Innocode\WPThemeModule\PostType\PostType;
use Innocode\WPThemeModule\Taxonomy\Taxonomy;
use ReflectionMethod;
use ReflectionException;

/**
 * Class AbstractInitialization
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractInitialization implements InitializationInterface
{
    /**
     * @var PostType[]
     */
    protected $_post_types = [];
    /**
     * @var Taxonomy[]
     */
    protected $_taxonomies = [];

    public function run()
    {
        $this->_execute_hooks();

        add_action( 'init', function () {
            $this->_register_post_types();
            $this->_register_taxonomies();
        }, 0 );
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

    private function _register_post_types()
    {
        foreach ( $this->get_post_types() as $post_type ) {
        	$this->_register_post_type( $post_type );
        }
    }

	/**
	 * @param PostType $post_type
	 */
    private function _register_post_type( PostType $post_type )
    {
	    $name = $post_type->get_name();

	    if ( taxonomy_exists( $name ) ) {
		    trigger_error( sprintf(
		    	'Post type %s already exists', $name
		    ), E_USER_WARNING );
	    }

	    register_post_type( $name, $post_type->get_args() );
	    $this->_post_types[ $name ] = $post_type;
    }

    private function _register_taxonomies()
    {
        foreach ( $this->get_taxonomies() as $taxonomy ) {
			$this->_register_taxonomy( $taxonomy );
        }
    }

	/**
	 * @param Taxonomy $taxonomy
	 */
    private function _register_taxonomy( Taxonomy $taxonomy )
    {
	    $name = $taxonomy->get_name();

	    if ( taxonomy_exists( $name ) ) {
	    	trigger_error( sprintf(
	    		'Taxonomy %s already exists', $name
		    ), E_USER_WARNING );
	    }

	    register_taxonomy( $name, $taxonomy->get_object_types(), $taxonomy->get_args() );
	    $this->_taxonomies[ $name ] = $taxonomy;
    }
}
