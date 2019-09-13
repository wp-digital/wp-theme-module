<?php

namespace Innocode\WPThemeModule\PostType;

use Innocode\WPThemeModule\Abstracts\AbstractPropertiesCollection;

/**
 * Class Capabilities
 * @package Innocode\WPThemeModule\PostType
 */
final class Capabilities extends AbstractPropertiesCollection
{
	/**
	 * @var string
	 */
	public $edit_post;
	/**
	 * @var string
	 */
	public $read_post;
	/**
	 * @var string
	 */
	public $delete_post;
	/**
	 * @var string
	 */
	public $edit_posts;
	/**
	 * @var string
	 */
	public $edit_others_posts;
	/**
	 * @var string
	 */
	public $publish_posts;
	/**
	 * @var string
	 */
	public $read_private_posts;
	/**
	 * @var string
	 */
	public $read;
	/**
	 * @var string
	 */
	public $delete_posts;
	/**
	 * @var string
	 */
	public $delete_private_posts;
	/**
	 * @var string
	 */
	public $delete_published_posts;
	/**
	 * @var string
	 */
	public $delete_others_posts;
	/**
	 * @var string
	 */
	public $edit_private_posts;
	/**
	 * @var string
	 */
	public $edit_published_posts;
	/**
	 * @var string
	 */
	public $create_posts;
}
