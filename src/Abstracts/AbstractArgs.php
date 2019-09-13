<?php

namespace Innocode\WPThemeModule\Abstracts;

use Innocode\WPThemeModule\Interfaces\ArgsInterface;

/**
 * Class AbstractArgs
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractArgs implements ArgsInterface
{
	/**
	 * @var array
	 */
	protected $_args = [];
	/**
	 * @var AbstractPropertiesCollection
	 */
	protected $_labels;
	/**
	 * @var AbstractPropertiesCollection
	 */
	protected $_capabilities;
	/**
	 * @var AbstractPropertiesCollection|bool
	 */
	protected $_rewrite;

	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set( $name, $value )
	{
		switch ( $name ) {
			case 'labels':
			case 'capabilities':
			case 'rewrite':
				$this->{"set_$name"}( $value );

				break;
			default:
				$this->_args[ $name ] = $value;

				break;
		}
	}

	/**
	 * @param string $name
	 * @return mixed|null
	 */
	public function __get( $name )
	{
		switch ( $name ) {
			case 'labels':
			case 'capabilities':
			case 'rewrite':
				return $this->{"get_$name"}();
			default:
				return array_key_exists( $name, $this->_args )
					? $this->_args[ $name ]
					: null;
		}
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function __isset( $name )
	{
		return isset( $this->_args[ $name ] );
	}

	/**
	 * @param string $name
	 */
	public function __unset( $name )
	{
		unset( $this->_args[ $name ] );
	}

	/**
	 * @return array
	 */
	public function get_args() : array
	{
		foreach ( [
			'labels',
			'capabilities',
			'rewrite',
		] as $arg ) {
			if ( isset( $this->{"_$arg"} ) ) {
				if ( $this->{"_$arg"} instanceof AbstractPropertiesCollection ) {
					$properties = $this->{"_$arg"}->to_array();

					if ( ! empty( $properties ) ) {
						$this->_args[ $arg ] = $properties;
					}
				} else {
					$this->_args[ $arg ] = $this->{"_$arg"};
				}
			}
		}

		return $this->_args;
	}
}
