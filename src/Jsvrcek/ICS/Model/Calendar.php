<?php

namespace Jsvrcek\ICS\Model;

class Calendar
{
    /**
     * 
     * @var string $version
     */
    private $version;
    
    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Calendar
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

}
