<?php

namespace Innocode\WPThemeModule\Taxonomy;

use Innocode\WPThemeModule\Abstracts\AbstractPropertiesCollection;

/**
 * Class Labels
 * @see get_taxonomy_labels()
 * @package Innocode\WPThemeModule\Taxonomy
 */
final class Labels extends AbstractPropertiesCollection
{
	/**
	 * @var string
	 */
    public $name;
	/**
	 * @var string
	 */
    public $singular_name;
	/**
	 * @var string
	 */
    public $menu_name;
	/**
	 * @var string
	 */
    public $search_items;
	/**
	 * @var string
	 */
    public $popular_items;
	/**
	 * @var string
	 */
    public $all_items;
	/**
	 * @var string
	 */
    public $parent_item;
	/**
	 * @var string
	 */
    public $parent_item_colon;
	/**
	 * @var string
	 */
    public $edit_item;
	/**
	 * @var string
	 */
    public $view_item;
	/**
	 * @var string
	 */
    public $update_item;
	/**
	 * @var string
	 */
    public $add_new_item;
	/**
	 * @var string
	 */
    public $new_item_name;
	/**
	 * @var string
	 */
    public $separate_items_with_commas;
	/**
	 * @var string
	 */
    public $add_or_remove_items;
	/**
	 * @var string
	 */
    public $choose_from_most_used;
	/**
	 * @var string
	 */
    public $not_found;
	/**
	 * @var string
	 */
    public $no_terms;
	/**
	 * @var string
	 */
    public $items_list_navigation;
	/**
	 * @var string
	 */
    public $items_list;
	/**
	 * @var string
	 */
    public $most_used;
	/**
	 * @var string
	 */
    public $back_to_items;
}
