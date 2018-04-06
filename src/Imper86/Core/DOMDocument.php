<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 22.06.17
 * Time: 15:48
 */

namespace Imper86\Core;


class DOMDocument extends \DOMDocument
{
    public function __construct($version = '1.0', $encoding = 'UTF-8')
    {
        parent::__construct($version, $encoding);
    }

    public function createElementCData(string $name, string $value = null)
    {
        $element = $this->createElement($name);
        $element->appendChild($this->createCDATASection($value));
        return $element;
    }

    public function createElement($name, $value = null, array $attributes = [])
    {
        $element = parent::createElement($name, $value);

        foreach ($attributes as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $element;
    }
}