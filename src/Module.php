<?php

namespace Innocode\WPThemeModule;

use WP_Error;

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

    public function __construct( $path, $name )
    {
        $this->_name = $name;
        $this->_path = $path;
    }

    /**
     * @return string
     */
    public function get_path()
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * @return AbstractInitialization
     */
    public function get_initialization()
    {
        return $this->_initialization;
    }

    /**
     * @return string
     */
    public function get_initialization_class()
    {
        return "\\Module\\$this->_name\\Initialization";
    }

    /**
     * @return string
     */
    public function get_functions_class()
    {
        return "\\Module\\$this->_name\\Functions";
    }

    /**
     * @return bool
     */
    public function initialization_class_exists()
    {
        return class_exists( $this->get_initialization_class() );
    }

    /**
     * @return bool
     */
    public function functions_class_exists()
    {
        return class_exists( $this->get_functions_class() );
    }

    /**
     * @return bool|WP_Error
     */
    public function load_required_classes()
    {
        if ( ! $this->initialization_class_exists() ) {
            return new WP_Error( 'theme_module_missing_class', sprintf(
                'Missing class %s in module %s at %s.',
                $this->get_initialization_class(),
                $this->get_name(),
                $this->get_path()
            ), [
                $this->get_initialization_class(),
                $this->get_name(),
                $this->get_path()
            ] );
        }

        if ( ! $this->functions_class_exists() ) {
            return new WP_Error( 'theme_module_missing_class', sprintf(
                'Missing class %s in module %s at %s.',
                $this->get_functions_class(),
                $this->get_name(),
                $this->get_path()
            ), [
                $this->get_functions_class(),
                $this->get_name(),
                $this->get_path()
            ] );
        }

        return true;
    }

    /**
     * @return bool|WP_Error
     */
    public function init()
    {
        $initialization_class = $this->get_initialization_class();
        $this->_initialization = new $initialization_class;

        if (
            $this->get_name() == 'Theme' &&
            ! ( $this->_initialization instanceof AbstractThemeInitialization )
        ) {
            $abstract_theme_initialization_class = __NAMESPACE__ . '\\AbstractThemeInitialization';

            return new WP_Error( 'theme_module_invalid_initialization', sprintf(
                'Class %s should extends %s in module %s at %s.',
                $initialization_class,
                $abstract_theme_initialization_class,
                $this->get_name(),
                $this->get_path()
            ), [
                $initialization_class,
                $abstract_theme_initialization_class,
                $this->get_name(),
                $this->get_path()
            ] );
        } elseif ( ! ( $this->_initialization instanceof AbstractInitialization ) ) {
            $abstract_initialization_class = __NAMESPACE__ . '\\AbstractInitialization';

            return new WP_Error( 'theme_module_invalid_initialization', sprintf(
                'Class %s should extends %s in module %s at %s.',
                $initialization_class,
                $abstract_initialization_class,
                $this->get_name(),
                $this->get_path()
            ), [
                $initialization_class,
                $abstract_initialization_class,
                $this->get_name(),
                $this->get_path()
            ] );
        }

        $this->_initialization->run();

        return true;
    }
}
