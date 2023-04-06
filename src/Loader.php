<?php

namespace Innocode\WPThemeModule;

use ArrayAccess;
use IteratorAggregate;
use Countable;
use DirectoryIterator;
use Traversable;
use ArrayIterator;

/**
 * Class Loader
 * @package Innocode\WPThemeModule
 */
final class Loader implements ArrayAccess, IteratorAggregate, Countable
{
	/**
	 * Modules storage
	 *
	 * @var array
	 */
	private $_modules = [];
	/**
	 * Current theme directory which is a root of modules directory. Specially needed for child themes
	 *
	 * @var string
	 */
	private $_theme_dir;
	/**
	 * Whether it's a child modules
	 *
	 * @var bool
	 */
	private $_is_child = false;

	/**
	 * Loader constructor.
	 *
	 * @param array|null $modules
	 */
	public function __construct( array $modules = [] )
	{
		foreach ( $modules as $module ) {
			$this[ $module ] = null;
		}

		$this->use_template_directory();
	}

	/**
	 * @param string $theme_dir
	 *
	 * @return void
	 */
	public function set_theme_dir( string $theme_dir )
	{
		$this->_theme_dir = $theme_dir;
	}

	/**
	 * @return string
	 */
	public function get_theme_dir() : string
	{
		return $this->_theme_dir;
	}

	/**
	 * @return void
	 */
	public function use_template_directory()
	{
		$this->set_theme_dir( get_template_directory() );
	}

	/**
	 * @return void
	 */
	public function use_stylesheet_directory()
	{
		$this->set_theme_dir( get_stylesheet_directory() );
	}

	/**
	 * @param bool $is_child
	 * @return void
	 */
	public function set_child( bool $is_child )
	{
		if ( $is_child ) {
			$this->use_stylesheet_directory();
		} else {
			$this->use_template_directory();
		}

		$this->_is_child = $is_child;
	}

	/**
	 * @return bool
	 */
	public function is_child() : bool
	{
		return $this->_is_child;
	}

	/**
	 * Returns modules directory
	 *
	 * @return string
	 */
	public function get_modules_dir() : string
	{
		return "{$this->get_theme_dir()}/modules";
	}

	/**
	 * Initializes loader
	 */
	public function run()
	{
		if ( 0 === count( $this ) ) {
			$this->scan_modules_dir();
		}

		foreach ( $this as $name => $null ) {
			$this[ $name ] = $this->create_module( $name );
		}

		if ( $this->is_child() ) {
			if ( ! isset( $this['Child'] ) ) {
				trigger_error( 'Missing Child module.', E_USER_ERROR );
			}
		} else {
			if ( ! isset( $this['Theme'] ) ) {
				trigger_error( 'Missing Theme module.', E_USER_ERROR );
			}
		}

		foreach ( $this as $module ) {
			$this->load( $module );
		}
	}

	/**
	 * Finds modules in directory and adds them to loader
	 *
	 * @return void
	 */
	public function scan_modules_dir()
	{
		$modules_dir = $this->get_modules_dir();
		$dir_iterator = new DirectoryIterator( $modules_dir );

		foreach ( $dir_iterator as $file ) {
			if ( $file->isDot() || ! $file->isDir() ) {
				continue;
			}

			$this[ $file->getFilename() ] = null;
		}
	}

	/**
	 * @param string $name
	 *
	 * @return Module
	 */
	public function create_module( string $name ) : Module
	{
		return new Module( $this->get_modules_dir(), $name );
	}

	/**
	 * Loads module classes and initializes
	 *
	 * @param Module $module
	 */
	public function load( Module $module )
	{
		$module->load_required_classes();
		$module->init();
	}

	/**
	 * Retrieve an external iterator
	 * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator(): Traversable
	{
		return new ArrayIterator( $this->_modules );
	}

	/**
	 * Whether a offset exists
	 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists( $offset ): bool
	{
		return isset( $this->_modules[ $offset ] );
	}

	/**
	 * Offset to retrieve
	 * @link https://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet( $offset )
	{
		return $this->_modules[ $offset ] ?? null;
	}

	/**
	 * Offset to set
	 * @link https://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet( $offset, $value ): void
	{
		$this->_modules[ $offset ] = $value;
	}

	/**
	 * Offset to unset
	 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset( $offset ): void
	{
		unset( $this->_modules[ $offset ] );
	}

	/**
	 * Count elements of an object
	 * @link https://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count(): int
	{
		return count( $this->_modules );
	}
}
