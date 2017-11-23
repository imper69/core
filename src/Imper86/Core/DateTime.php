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
    /**
     * @var StringConverter
     */
    private $stringConverter;

    const KNOWN_FORMATS = [
        'Y-m-d',
        'd-m-Y',
    ];

    const PL_MONTHS = [
        'styczeń' => 'january',
        'luty' => 'february',
        'marzec' => 'march',
        'kwiecień' => 'april',
        'maj' => 'may',
        'czerwiec' => 'june',
        'lipiec' => 'july',
        'sierpień' => 'august',
        'wrzesień' => 'september',
        'październik' => 'october',
        'listopad' => 'november',
        'grudzień' => 'december',
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

        $time = $this->convertPLMonths($time);

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

    public function addOmitingDaysOff(\DateInterval $interval)
    {
        $dateFrom = clone $this;
        $this->add($interval);

        $holidayCounter = new HolidayCounter($dateFrom, $this);
        $this->add(new \DateInterval("P{$holidayCounter->getNumberOfFreeDays(false)}D"));

        $oneDayInterval = new \DateInterval('P1D');

        while (
            !in_array($this->format('N'), HolidayCounter::WORKING_DAYS)
            || in_array($this->format('Y-m-d'), HolidayCounter::HOLIDAYS)
        ) {
            $this->add($oneDayInterval);
        }
    }

    private function convertPLMonths(string $dateString): string
    {
        $converter = $this->getStringConverter();

        foreach (self::PL_MONTHS as $plMonthName => $enMonthName) {
            $dateString = str_replace($plMonthName, $enMonthName, $dateString);
            $dateString = str_replace(substr($plMonthName, 0, 3), $enMonthName, $dateString);
            $dateString = str_replace($converter->removePolishCharacters($plMonthName), $enMonthName, $dateString);
            $dateString = str_replace(substr($converter->removePolishCharacters($plMonthName), 0, 3), $enMonthName, $dateString);
        }

        return $dateString;
    }

    private function getStringConverter(): StringConverter
    {
        if (null === $this->stringConverter) {
            $this->stringConverter = new StringConverter();
        }

        return $this->stringConverter;
    }
}