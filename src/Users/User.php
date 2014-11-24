<?php namespace MyTest\Users;

use MyTest\Core\Entity;

class User extends Entity
{
    public function getGravatarUrl($size = 140)
    {
        return "http://www.gravatar.com/avatar/" . md5($this->attributes["email"]) . "?size=" . $size;
    }

    public function getName()
    {
        return $this->attributes["name"];
    }
} 