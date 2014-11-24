<?php namespace MyTest\Core;

class Entity
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param array $attributes
     */
    function __construct(array $attributes = [])
    {
        foreach ($attributes as $attr => $val)
        {
            $this->attributes[$attr] = $val;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : "";
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
} 