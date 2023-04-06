<?php

namespace Innocode\WPThemeModule\Abstracts;

use Innocode\WPThemeModule\Interfaces\InitializationInterface;
use Innocode\WPThemeModule\PostType\PostType;
use Innocode\WPThemeModule\Taxonomy\Taxonomy;

/**
 * Class AbstractInitialization
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractInitialization extends AbstractRegistrar implements InitializationInterface
{
    /**
     * Post types storage
     *
     * @var PostType[]
     */
    protected $_post_types = [];
    /**
     * Taxonomies storage
     *
     * @var Taxonomy[]
     */
    protected $_taxonomies = [];

	/**
	 * Initializes module
	 */
    public function run()
    {
        parent::run();

        add_action( 'init', function () {
            $this->_register_post_types();
            $this->_register_taxonomies();
        }, 0 );
    }

	/**
	 * @return PostType[]
	 */
	public function get_post_types() : array
	{
		return [];
	}

	/**
	 * @return Taxonomy[]
	 */
	public function get_taxonomies() : array
	{
		return [];
	}

	/**
	 * Registers all module post types
	 */
    private function _register_post_types()
    {
        foreach ( $this->get_post_types() as $post_type ) {
        	$this->_register_post_type( $post_type );
        }
    }

	/**
	 * Registers WordPress post type
	 *
	 * @uses register_post_type()
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

	/**
	 * Registers all module taxonomies
	 */
    private function _register_taxonomies()
    {
        foreach ( $this->get_taxonomies() as $taxonomy ) {
			$this->_register_taxonomy( $taxonomy );
        }
    }

	/**
	 * Registers WordPress taxonomy
	 *
	 * @uses register_taxonomy()
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
