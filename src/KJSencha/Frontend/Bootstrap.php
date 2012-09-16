<?php

namespace KJSencha\Frontend;

use Zend\View\Model\ViewModel;
use ArrayObject;

/**
 * Ext JS Bootstrap
 *
 * Allows PHP code to hook into the ext js bootstrap
 */
class Bootstrap
{
    protected $parameters	= array();

    /**
     * @see http://docs.sencha.com/ext-js/4-1/#!/api/Ext.Loader-cfg-paths
     * @var array
     */
    protected $paths		= array();
    protected $variables	= array();
    protected $requires		= array();
    protected $viewModel;

    protected $template     = 'kjsencha/bootstrap';

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->applications = new ArrayObject;
        $this->variabeles   = new ArrayObject;

        $this->viewModel = new ViewModel;
        $this->viewModel->setTemplate($this->template);

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Zet de opties
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    /**
     * Zet een optie
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setOption($key, $value)
    {
        switch ($key) {

            case 'applications':
                $this->applications = array();
                foreach ($value as $app) {
                    $this->addApplication($app);
                }
                break;

            // Zet paden
            case 'require':
            case 'requires':
                $this->setRequires($value);
                break;

            // Zet paden
            case 'paths':
                $this->setPaths($value);
                break;

            // Javascript variabelen
            case 'variables':
                $this->setVariables($value);
                break;

            default:
                $this->parameters[$key] = $value;
                break;
        }
    }

    /**
     * Set Ext.Loader paths
     *
     * @param array $paths
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Add javascript variables
     *
     * @param array $variables
     */
    public function addVariables(array $variables)
    {
        $this->variables = array_merge($this->variables, $variables);
    }

    /**
     * Set javascript variables
     *
     * @param array $variables
     */
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Set classnames which will be included during bootstrap
     *
     * @param array
     */
    public function setRequires(array $requires)
    {
        $this->requires = $requires;
    }

    /**
     * Get the required classes
     *
     * @return array
     */
    public function getRequires()
    {
        return $this->requires;
    }

    /**
     * Get the Ext.Loader paths
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Get custom vars
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @return ViewModel
     */
    public function getViewModel()
    {
        $this->viewModel->setVariables(array_merge($this->parameters, array(
            'variables'		=> $this->getVariables(),
            'paths'			=> $this->getPaths(),
            'requires'		=> $this->getRequires(),
        )));

        return $this->viewModel;
    }
}
