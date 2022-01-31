<?php

namespace Innocode\WPThemeModule\Abstracts;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class AbstractRegistrar
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractRegistrar
{
	/**
	 * Registrars methods storage
	 *
	 * @var ReflectionMethod[]
	 */
	private $_registrars = [];
	/**
	 * Registrars methods for admin area storage
	 *
	 * @var ReflectionMethod[]
	 */
	private $_admin_registrars = [];
	/**
	 * WordPress filters storage
	 *
	 * @var ReflectionMethod[]
	 */
	private $_filters = [];
	/**
	 * WordPress actions storage
	 *
	 * @var ReflectionMethod[]
	 */
	private $_actions = [];

	/**
	 * Initializes module
	 */
	public function run()
	{
		$this->_sort_methods();
		$this->_call_registrars();
		$this->_add_filters();
		$this->_add_actions();
	}

	/**
	 * Returns all class methods with public access
	 *
	 * @return ReflectionMethod[]
	 */
	private function _get_public_methods() : array
	{
		$reflection = new ReflectionClass( $this );

		return $reflection->getMethods( ReflectionMethod::IS_PUBLIC );
	}

	/**
	 * Sorts methods by categories
	 */
	private function _sort_methods()
	{
		$public_methods = $this->_get_public_methods();

		foreach ( $public_methods as $method ) {
			switch ( true ) {
				case $this->_method_starts_with( $method, 'register_' ):
					$this->_registrars[] = $method;
					break;
				case $this->_method_starts_with( $method, 'admin_register_' ):
					$this->_admin_registrars[] = $method;
					break;
				case $this->_method_starts_with( $method, 'add_filter_' ):
					$this->_filters[] = $method;
					break;
				case $this->_method_starts_with( $method, 'add_action_' ):
					$this->_actions[] = $method;
					break;
			}
		}
	}

	/**
	 * Checks if method starts with string
	 *
	 * @param ReflectionMethod $method
	 * @param string           $prefix
	 * @return bool
	 */
	private function _method_starts_with( ReflectionMethod $method, string $prefix ) : bool
	{
		return substr( $method->getName(), 0, strlen( $prefix ) ) === $prefix;
	}

	/**
	 * Calls all registrars including admin if needed
	 */
	private function _call_registrars()
	{
		$registrars = $this->_registrars;

		if ( is_admin() ) {
			$registrars = array_merge( $registrars, $this->_admin_registrars );
		}

		foreach ( $registrars as $registrar ) {
			try {
				$registrar->invoke( $this );
			} catch ( ReflectionException $exception ) {
				trigger_error( $exception->getMessage(), E_USER_ERROR );
			}
		}
	}

	/**
	 * Adds WordPress filters
	 */
	private function _add_filters()
	{
		foreach ( $this->_filters as $filter ) {
			$this->_add_hook( 'add_filter', $filter );
		}
	}

	/**
	 * Adds WordPress actions
	 */
	private function _add_actions()
	{
		foreach ( $this->_actions as $action ) {
			$this->_add_hook( 'add_action', $action );
		}
	}

	/**
	 * Adds WordPress hook
	 *
	 * @param string           $function
	 * @param ReflectionMethod $method
	 */
	private function _add_hook( string $function, ReflectionMethod $method )
	{
		$tag = str_replace( "{$function}_", '', $method->getName() );
		$params_count = $method->getNumberOfParameters();
		$priority_pattern = '/^(.*?)__(\d+)$/';
		$priority = preg_match( $priority_pattern, $method->getName(), $matches )
			? intval( $matches[ 2 ] )
			: 10;
		$function( $tag, [ $this, $method->getName() ], $priority, $params_count );
	}
}
