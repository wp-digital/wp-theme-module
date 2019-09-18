<?php

namespace Innocode\WPThemeModule\Interfaces;

/**
 * Interface ArgsInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface ArgsInterface
{
	/**
	 * Sets labels
	 *
	 * @param array $labels
	 */
	public function set_labels( array $labels );

	/**
	 * Returns labels instance
	 *
	 * @return mixed
	 */
	public function get_labels();

	/**
	 * Sets capabilities
	 *
	 * @param array $capabilities
	 */
	public function set_capabilities( array $capabilities );

	/**
	 * Returns capabilities instance
	 *
	 * @return mixed
	 */
	public function get_capabilities();

	/**
	 * Sets rewrite rules
	 *
	 * @param $rewrite
	 */
	public function set_rewrite( $rewrite );

	/**
	 * Returns rewrite rules
	 *
	 * @return mixed
	 */
	public function get_rewrite();
}
