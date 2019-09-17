<?php

namespace Innocode\WPThemeModule\PostType;

use ArrayObject;
use Innocode\WPThemeModule\Abstracts\AbstractArgs;
use Innocode\WPThemeModule\Taxonomy\Taxonomy;

/**
 * Class PostType
 * @property string       $label
 * @property Labels       $labels
 * @property string       $description
 * @property bool         $public
 * @property bool         $hierarchical
 * @property bool         $exclude_from_search
 * @property bool         $publicly_queryable
 * @property bool         $show_ui
 * @property bool         $show_in_menu
 * @property bool         $show_in_nav_menus
 * @property bool         $show_in_admin_bar
 * @property bool         $show_in_rest
 * @property string       $rest_base
 * @property string       $rest_controller_class
 * @property int          $menu_position
 * @property string       $menu_icon
 * @property string       $capability_type
 * @property Capabilities $capabilities
 * @property bool         $map_meta_cap
 * @property array        $supports
 * @property callable     $register_meta_box_cb
 * @property array        $taxonomies
 * @property bool|string  $has_archive
 * @property Rewrite|bool $rewrite
 * @property string|bool  $query_var
 * @property bool         $can_export
 * @property bool         $delete_with_user
 * @package Innocode\WPThemeModule
 */
final class PostType extends AbstractArgs
{
	/**
	 * @var string
	 */
	private $_name;

	/**
	 * PostType constructor.
	 *
	 * @param string $name
	 */
    public function __construct( string $name )
    {
        $this->_name = $name;
        $this->_labels = new Labels();
        $this->_capabilities = new Capabilities();
    }

	/**
	 * @return string
	 */
    public function get_name() : string
    {
        return $this->_name;
    }

	/**
	 * @return Labels
	 */
	public function get_labels() : Labels
	{
		return $this->_labels;
	}

	/**
	 * @param array $labels
	 */
	public function set_labels( array $labels )
	{
		$this->_labels = new Labels( $labels );
	}

	/**
	 * @return Capabilities
	 */
	public function get_capabilities() : Capabilities
	{
		return $this->_capabilities;
	}

	/**
	 * @param array $capabilities
	 */
	public function set_capabilities( array $capabilities )
	{
		$this->_capabilities = new Capabilities( $capabilities );
	}

	/**
	 * @param string $support
	 */
	public function add_support( string $support )
	{
		if ( ! isset( $this->supports ) ) {
			$this->supports = new ArrayObject();
		}

		$this->supports[] = $support;
	}

	/**
	 * @param Taxonomy|string $taxonomy
	 */
	public function add_taxonomy( $taxonomy )
	{
		if ( $taxonomy instanceof Taxonomy ) {
			$taxonomy->add_post_type( $this );

			return;
		}

		if ( ! isset( $this->taxonomies ) ) {
			$this->taxonomies = new ArrayObject();
		}

		$this->taxonomies[] = $taxonomy;
	}

	/**
	 * @return Rewrite|bool
	 */
	public function get_rewrite()
	{
		if ( ! isset( $this->_rewrite ) ) {
			$this->_rewrite = new Rewrite();
		}

		return $this->_rewrite;
	}

	/**
	 * @param array|false $rewrite
	 */
	public function set_rewrite( $rewrite )
	{
		$this->_rewrite = is_array( $rewrite )
			? new Rewrite( $rewrite )
			: $rewrite;
	}
}
