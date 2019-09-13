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
     * @var string
     */
    private $_path;
    /**
     * @var string
     */
    private $_name;
    /**
     * @var AbstractInitialization
     */
    private $_initialization;

    public function __construct( string $path, string $name )
    {
        $this->_name = $name;
        $this->_path = $path;
    }

    /**
     * @return string
     */
    public function get_path() : string
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function get_name() : string
    {
        return $this->_name;
    }

    /**
     * @return AbstractInitialization|AbstractThemeInitialization
     */
    public function get_initialization() : AbstractRegistrar
    {
        return $this->_initialization;
    }

    /**
     * @return string
     */
    public function get_initialization_class() : string
    {
        return "\\Module\\$this->_name\\Initialization";
    }

    /**
     * @return string
     */
    public function get_functions_class() : string
    {
        return "\\Module\\$this->_name\\Functions";
    }

    /**
     * @return bool
     */
    public function initialization_class_exists() : bool
    {
        return class_exists( $this->get_initialization_class() );
    }

    /**
     * @return bool
     */
    public function functions_class_exists() : bool
    {
        return class_exists( $this->get_functions_class() );
    }

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
