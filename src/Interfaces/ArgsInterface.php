<?php

namespace Innocode\WPThemeModule\Interfaces;

/**
 * Interface ArgsInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface ArgsInterface
{
	/**
	 * @param array $labels
	 */
	public function set_labels( array $labels );

	public function get_labels();

	/**
	 * @param array $capabilities
	 */
	public function set_capabilities( array $capabilities );

	public function get_capabilities();

	/**
	 * @param $rewrite
	 */
	public function set_rewrite( $rewrite );

	public function get_rewrite();
}
