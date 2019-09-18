<?php

namespace Innocode\WPThemeModule\Taxonomy;

use Innocode\WPThemeModule\Abstracts\AbstractPropertiesCollection;

/**
 * Class Capabilities
 * @see register_taxonomy()
 * @package Innocode\WPThemeModule\Taxonomy
 */
final class Capabilities extends AbstractPropertiesCollection
{
	/**
	 * @var string
	 */
	public $manage_terms;
	/**
	 * @var string
	 */
	public $edit_terms;
	/**
	 * @var string
	 */
	public $delete_terms;
	/**
	 * @var string
	 */
	public $assign_terms;
}
