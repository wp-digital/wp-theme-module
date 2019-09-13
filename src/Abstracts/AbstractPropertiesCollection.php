<?php

namespace Innocode\WPThemeModule\Abstracts;

use InvalidArgumentException;

/**
 * Class AbstractLabels
 * @package Innocode\WPThemeModule
 */
abstract class AbstractPropertiesCollection
{
	/**
	 * AbstractPropertiesCollection constructor.
	 *
	 * @param array $properties
	 */
	public function __construct( array $properties = [] )
	{
		foreach ( $properties as $property => $value ) {
			$this->$property = $value;
		}
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set( $name, $value )
	{
		if ( ! property_exists( $this, $name ) ) {
			throw new InvalidArgumentException(
				sprintf(
					'Property %s doesn\'t exist in class %s',
					$name,
					get_class( $this )
				)
			);
		}
	}

	/**
	 * @return array
	 */
	public function to_array()
	{
		$properties = [];

		foreach ( (array) $this as $property => $value ) {
			if ( isset( $this->$property ) ) {
				$properties[ $property ] = $value;
			}
		}

		return $properties;
	}
}
