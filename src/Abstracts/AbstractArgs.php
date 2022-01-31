<?php

namespace Innocode\WPThemeModule\Abstracts;

use Innocode\WPThemeModule\Interfaces\ArgsInterface;
use ArrayObject;

/**
 * Class AbstractArgs
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractArgs implements ArgsInterface
{
	/**
	 * Arguments storage
	 *
	 * @var array
	 */
	protected $_args = [];
	/**
	 * Labels storage
	 *
	 * @var AbstractPropertiesCollection
	 */
	protected $_labels;
	/**
	 * Capabilities storage
	 *
	 * @var AbstractPropertiesCollection
	 */
	protected $_capabilities;
	/**
	 * Rewrite rules storage
	 *
	 * @var AbstractPropertiesCollection|bool
	 */
	protected $_rewrite;

	/**
	 * Sets argument
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set( string $name, $value )
	{
		$setter = "set_$name";

		if ( method_exists( $this, $setter ) ) {
			$this->$setter( $value );
		} else {
			$this->_args[ $name ] = is_array( $value )
				? new ArrayObject( $value )
				: $value;
		}
	}

	/**
	 * Returns argument
	 *
	 * @param string $name
	 * @return mixed|null
	 */
	public function __get( string $name )
	{
		$getter = "get_$name";

		if ( method_exists( $this, $getter ) ) {
			return $this->$getter();
		}

		return array_key_exists( $name, $this->_args )
			? $this->_args[ $name ]
			: null;
	}

	/**
	 * Checks if argument set
	 *
	 * @param string $name
	 * @return bool
	 */
	public function __isset( string $name )
	{
		$getter = "get_$name";

		if ( method_exists( $this, $getter ) ) {
			$value = $this->$getter();

			return isset( $value );
		}

		return isset( $this->_args[ $name ] );
	}

	/**
	 * Unset argument
	 *
	 * @param string $name
	 */
	public function __unset( string $name )
	{
		$setter = "set_$name";

		if ( method_exists( $this, $setter ) ) {
			$this->$setter( null );
		} else {
			unset( $this->_args[ $name ] );
		}
	}

	/**
	 * Returns arguments array
	 *
	 * @return array
	 */
	public function get_args() : array
	{
		$args = [];

		foreach ( $this->_args as $name => $value ) {
			$args[ $name ] = $value instanceof ArrayObject
				? $value->getArrayCopy()
				: $value;
		}

		foreach ( [
			'labels',
			'capabilities',
			'rewrite',
		] as $name ) {
			$property = "_$name";

			if ( isset( $this->$property ) ) {
				if ( $this->$property instanceof AbstractPropertiesCollection ) {
					$properties = $this->$property->to_array();

					if ( ! empty( $properties ) ) {
						$args[ $name ] = $properties;
					}
				} else {
					$args[ $name ] = $this->$property;
				}
			}
		}

		return $args;
	}
}
