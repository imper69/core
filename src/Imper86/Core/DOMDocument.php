<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 22.06.17
 * Time: 15:48
 */

namespace Imper86\Core;


class DOMDocument extends \DOMDocument
{
    public function createElementCData(string $name, string $value = null)
    {
        $element = $this->createElement($name);
        $element->appendChild($this->createCDATASection($value));
        return $element;
    }
}