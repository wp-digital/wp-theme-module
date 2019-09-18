<?php

namespace Innocode\WPThemeModule\Taxonomy;

use Innocode\WPThemeModule\Abstracts\AbstractArgs;
use Innocode\WPThemeModule\PostType\PostType;

/**
 * Class Taxonomy
 * @property Labels        $labels
 * @property string        $description
 * @property bool          $public
 * @property bool          $publicly_queryable
 * @property bool          $hierarchical
 * @property bool          $show_ui
 * @property bool          $show_in_menu
 * @property bool          $show_in_nav_menus
 * @property bool          $show_in_rest
 * @property string        $rest_base
 * @property string        $rest_controller_class
 * @property bool          $show_tagcloud
 * @property bool          $show_in_quick_edit
 * @property bool          $show_admin_column
 * @property bool|callable $meta_box_cb
 * @property callable      $meta_box_sanitize_cb
 * @property Capabilities  $capabilities
 * @property Rewrite|bool  $rewrite
 * @property string        $query_var
 * @property callable      $update_count_callback
 * @see register_taxonomy()
 * @package Innocode\WPThemeModule
 */
final class Taxonomy extends AbstractArgs
{
	/**
	 * Taxonomy name
	 *
	 * @var string
	 */
    private $_name;
	/**
	 * Taxonomy object types
	 *
	 * @var array
	 */
    private $_object_types = [];

	/**
	 * Taxonomy constructor.
	 *
	 * @param string                $name
	 * @param array|PostType|string $object_types
	 */
    public function __construct( string $name, $object_types )
    {
        $this->_name = $name;

        if ( ! is_array( $object_types ) ) {
	        $object_types = [ $object_types ];
        }

        foreach ( $object_types as $object_type ) {
        	$this->add_object_type( $object_type );
        }

        $this->_labels = new Labels();
        $this->_capabilities = new Capabilities();
    }

	/**
	 * Returns name
	 *
	 * @return string
	 */
    public function get_name() : string
    {
        return $this->_name;
    }

	/**
	 * Returns object types
	 *
	 * @return array
	 */
    public function get_object_types()
    {
    	return $this->_object_types;
    }

	/**
	 * Adds object type
	 *
	 * @param PostType|string $object_type
	 */
    public function add_object_type( $object_type )
    {
    	if ( $object_type instanceof PostType ) {
		    $object_type = $object_type->get_name();
	    }

	    $this->_object_types[] = $object_type;
    }

	/**
	 * Adds post type
	 *
	 * @param PostType|string $post_type
	 */
    public function add_post_type( $post_type )
    {
    	$this->add_object_type( $post_type );
    }

	/**
	 * Returns labels object
	 *
	 * @return Labels
	 */
	public function get_labels() : Labels
    {
		return $this->_labels;
	}

	/**
	 * Sets labels
	 *
	 * @param array $labels
	 */
	public function set_labels( array $labels )
    {
		$this->_labels = new Labels( $labels );
	}

	/**
	 * Returns capabilities object
	 *
	 * @return Capabilities
	 */
	public function get_capabilities() : Capabilities
    {
		return $this->_capabilities;
	}

	/**
	 * Sets capabilities
	 *
	 * @param array $capabilities
	 */
	public function set_capabilities( array $capabilities )
    {
		$this->_capabilities = new Capabilities( $capabilities );
	}

	/**
	 * Returns rewrite rules
	 *
	 * @return Rewrite|bool
	 */
	public function get_rewrite()
    {
		return $this->_rewrite;
	}

	/**
	 * Sets rewrite rules
	 *
	 * @param array|bool $rewrite
	 */
	public function set_rewrite( $rewrite )
    {
	    $this->_rewrite = is_array( $rewrite )
		    ? new Rewrite( $rewrite )
		    : $rewrite;
	}
}
