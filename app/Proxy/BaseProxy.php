<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Proxy;

class BaseProxy implements Subject
{
    protected $action;
    protected $data;


    public function __construct($action, $data = [])
    {
        $this->action = $action;
        $this->data = $data;

        if (!in_array($action, array_keys($this->actions))) {
            //log
            return $this;
        }
    }


    public function result()
    {
        return (new $this->actions[$this->action])($this->data);
    }
}
