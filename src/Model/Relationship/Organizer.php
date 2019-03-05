<?php

namespace Jsvrcek\ICS\Model\Relationship;

use Jsvrcek\ICS\Utility\Formatter;

class Organizer
{
    /**
     * RFC 5545 cal-address http://tools.ietf.org/html/rfc5545#section-3.3.3
     * @var string
     */
    private $value;

    /**
     * RFC 5545 cnparam
     * @var string
     */
    private $name;

    /**
     * RFC 5545 dirparam http://tools.ietf.org/html/rfc5545#section-3.2.6
     * uri directory entry associated with the calendar user
     * @var string|null
     */
    private $directory;

    /**
     * RFC 5545 sentbyparam http://tools.ietf.org/html/rfc5545#section-3.2.18
     * email address
     * @var string|null
     */
    private $sentBy;

    /**
     * RFC 5545 languageparam
     * RFC 1766 language identifier
     * @var string|null
     */
    private $language;

    public function __construct(
        string $value,
        string $name,
        ?string $directory,
        ?string $sentBy,
        ?string $language
    ) {
        $formatter = new Formatter();

        $this->value = $formatter->getFormattedUri($value);
        $this->name = $name;
        $this->directory = $directory;
        $this->sentBy = $sentBy;
        $this->language = $language;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function getSentBy(): ?string
    {
        return $this->sentBy;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function __toString(): string
    {
        $string = 'ORGANIZER';
        
        if ($this->sentBy !== null) {
            $string .= ';SENT-BY="'.$this->sentBy.'"';
        }

        $string .= ';CN='.$this->name;

        if ($this->directory !== null) {
            $string .= ';DIR="'.$this->directory.'"';
        }
        
        if ($this->language !== null) {
            $string .= ';LANGUAGE='.$this->language;
        }
        
        $string .= ':'.$this->value;
        
        return $string;
    }
}
