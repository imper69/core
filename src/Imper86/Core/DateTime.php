<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 22.06.17
 * Time: 15:47
 *
 * testowy update :>>
 */

namespace Imper86\Core;


use DateTimeZone;

class DateTime extends \DateTime
{
    const KNOWN_FORMATS = [
        'Y-m-d',
        'd-m-Y',
    ];

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if (substr($time, 0, 1) == '@') {
            $unixTimeStamp = substr($time, 1);
            if (!empty($unixTimeStamp)) {
                $time = date('Y-m-d H:i:s', substr($time, 1));
            } else {
                $time = date('Y-m-d H:i:s', 0);
            }
        }

        parent::__construct($time, $timezone);
    }

    public function __toString()
    {
        return $this->format();
    }

    public function formatPL(string $format = 'Y-m-d H:i:s')
    {
        $oldFormat = $format;

        foreach (self::KNOWN_FORMATS as $plFormat) $format = str_replace($plFormat, '', $format);

        $suffix = (!empty($format) ? $this->format($format) : null);

        $yesterday = new DateTime('yesterday');
        $today = new DateTime('today');

        if ($this->format('Ymd') === $yesterday->format('Ymd')) return 'wczoraj' . $suffix;
        if ($this->format('Ymd') === $today->format('Ymd')) return 'dzisiaj' . $suffix;

        return $this->format($oldFormat);
    }

    public function format($format = 'Y-m-d')
    {
        return parent::format($format);
    }
}