<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 27.10.17
 * Time: 14:03
 */

namespace Imper86\Core;


class DateInterval extends \DateInterval
{
    public function __construct($interval_spec)
    {
        if ($interval_spec instanceof \DateInterval) {
            parent::__construct($interval_spec->format('P%yY%mM%dDT%hH%iM%sS'));
            $this->invert = $interval_spec->invert;
        } else {
            parent::__construct($interval_spec);
        }

        $from = new \DateTime();
        $to = clone $from;
        $to->add($this);
        $diff = $from->diff($to);

        foreach ($diff as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function toSeconds(): int
    {
        $from = new \DateTime();
        $to = clone $from;
        $to->add($this);

        $seconds = $to->getTimestamp() - $from->getTimestamp();

        return $seconds;
    }

    public function toMinutes(): float
    {
        return $this->toSeconds()/60;
    }

    public function toHours(): float
    {
        return $this->toSeconds()/60/60;
    }
}