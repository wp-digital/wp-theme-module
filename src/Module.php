<?php

namespace Innocode\WPThemeModule;

use Innocode\WPThemeModule\Abstracts\AbstractInitialization;
use Innocode\WPThemeModule\Abstracts\AbstractRegistrar;
use Innocode\WPThemeModule\Abstracts\AbstractThemeInitialization;

/**
 * Class Module
 * @package Innocode\WPThemeModule
 */
class Module
{
    /**
     * Path to module
     *
     * @var string
     */
    private $_path;
    /**
     * Module name
     *
     * @var string
     */
    private $_name;
    /**
     * Module initialization object
     *
     * @var AbstractInitialization|AbstractThemeInitialization
     */
    private $_initialization;

	/**
	 * Module constructor.
	 *
	 * @param string $path
	 * @param string $name
	 */
    public function __construct( string $path, string $name )
    {
        $this->_name = $name;
        $this->_path = $path;
    }

    /**
     * Returns module path
     *
     * @return string
     */
    public function get_path() : string
    {
        return $this->_path;
    }

    /**
     * Returns module name
     *
     * @return string
     */
    public function get_name() : string
    {
        return $this->_name;
    }

    /**
     * Returns initialization object
     *
     * @return AbstractInitialization|AbstractThemeInitialization
     */
    public function get_initialization() : AbstractRegistrar
    {
        return $this->_initialization;
    }

    /**
     * Returns initialization class name
     *
     * @return string
     */
    public function get_initialization_class() : string
    {
        return "\\Module\\$this->_name\\Initialization";
    }

    /**
     * Returns functions class name
     *
     * @return string
     */
    public function get_functions_class() : string
    {
        return "\\Module\\$this->_name\\Functions";
    }

    /**
     * Checks if initialization class name exists and loads it
     *
     * @return bool
     */
    public function initialization_class_exists() : bool
    {
        return class_exists( $this->get_initialization_class() );
    }

    /**
     * Checks if functions class name exists and loads it
     *
     * @return bool
     */
    public function functions_class_exists() : bool
    {
        return class_exists( $this->get_functions_class() );
    }

	/**
	 * Loads initialization and functions classes
	 */
    public function load_required_classes()
    {
        if ( ! $this->initialization_class_exists() ) {
            trigger_error( sprintf(
	            'Missing class %s in module %s at %s.',
	            $this->get_initialization_class(),
	            $this->get_name(),
	            $this->get_path()
            ), E_USER_ERROR );
        }

        if ( ! $this->functions_class_exists() ) {
	        trigger_error( sprintf(
		        'Missing class %s in module %s at %s.',
		        $this->get_functions_class(),
		        $this->get_name(),
		        $this->get_path()
	        ), E_USER_ERROR );
        }
    }

	/**
	 * Initializes module
	 */
    public function init()
    {
        $initialization_class = $this->get_initialization_class();
        $this->_initialization = new $initialization_class;

        if ( $this->get_name() == 'Theme' ) {
	        if ( ! ( $this->_initialization instanceof AbstractThemeInitialization ) ) {
		        $abstract_theme_initialization_class = __NAMESPACE__ . '\\AbstractThemeInitialization';
		        trigger_error( sprintf(
			        'Class %s should extends %s in module %s at %s.',
			        $initialization_class,
			        $abstract_theme_initialization_class,
			        $this->get_name(),
			        $this->get_path()
		        ), E_USER_ERROR );
	        }
        } elseif ( ! ( $this->_initialization instanceof AbstractInitialization ) ) {
            $abstract_initialization_class = __NAMESPACE__ . '\\AbstractInitialization';
			trigger_error( sprintf(
				'Class %s should extends %s in module %s at %s.',
				$initialization_class,
				$abstract_initialization_class,
				$this->get_name(),
				$this->get_path()
			), E_USER_ERROR );
        }

        $this->_initialization->run();
    }
}
