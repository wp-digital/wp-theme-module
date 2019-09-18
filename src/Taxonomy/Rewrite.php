<?php

namespace Innocode\WPThemeModule\Taxonomy;

use Innocode\WPThemeModule\Abstracts\AbstractPropertiesCollection;

/**
 * Class Rewrite
 * @see register_taxonomy()
 * @package Innocode\WPThemeModule\Taxonomy
 */
final class Rewrite extends AbstractPropertiesCollection
{
	/**
	 * @var string
	 */
	public $slug;
	/**
	 * @var bool
	 */
	public $with_front;
	/**
	 * @var bool
	 */
	public $hierarchical;
	/**
	 * @var int
	 */
	public $ep_mask;
}
