<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Proxy;

class Proxy
{
    private $subject;


    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }


    public function result()
    {
        return $this->subject->result();
    }
}
