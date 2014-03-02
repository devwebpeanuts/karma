<?php

namespace Karma\Configuration;

use Karma\Configuration;

class InMemoryReader implements Configuration
{
    private
        $defaultEnvironment,
        $values;
    
    public function __construct(array $values = array())
    {
        $this->defaultEnvironment = 'dev';
        $this->values = $values;
    }
    
    public function read($variable, $environment = null)
    {
        if($environment === null)
        {
            $environment = $this->defaultEnvironment;
        }
        
        $key = "$variable:$environment";
        
        if(array_key_exists($key, $this->values))
        {
            return $this->values[$key];
        }
        
        return null;
    }
    
    public function setDefaultEnvironment($environment)
    {
        $this->defaultEnvironment = $environment;
        
        return $this; 
    }
    
    public function getAllVariables()
    {
        $variables = array_map(function($item){
            return explode(':', $item)[0];
        }, array_keys($this->values));
        
        return array_unique($variables);
    }
    
    public function getAllValuesForEnvironment($environment = null)
    {
        $result = array();
        
        $variables = $this->getAllVariables();
        
        foreach($variables as $variable)
        {
            $result[$variable] = $this->read($variable, $environment);
        }    
        
        return $result;
    }
    
    public function overrideVariable($variable, $value)
    {
        
    }
}