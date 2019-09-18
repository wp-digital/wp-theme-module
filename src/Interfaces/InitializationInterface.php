<?php

namespace Innocode\WPThemeModule\Interfaces;

use Innocode\WPThemeModule\PostType\PostType;
use Innocode\WPThemeModule\Taxonomy\Taxonomy;

/**
 * Interface InitializationInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface InitializationInterface
{
	/**
	 * Returns module post types
	 *
	 * @return PostType[]
	 */
    public function get_post_types() : array;

	/**
	 * Returns module taxonomies
	 *
	 * @return Taxonomy[]
	 */
    public function get_taxonomies() : array;
}
