<?php

namespace Innocode\WPThemeModule\PostType;

use Innocode\WPThemeModule\Abstracts\AbstractPropertiesCollection;

/**
 * Class Rewrite
 * @package Innocode\WPThemeModule\PostType
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
	public $feeds;
	/**
	 * @var bool
	 */
	public $pages;
	/**
	 * @var int
	 */
	public $ep_mask;
}
