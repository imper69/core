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
        parent::__construct($interval_spec);

        $from = new \DateTime();
        $to = clone $from;
        $to->add($this);
        $diff = $from->diff($to);

        foreach ($diff as $key => $value) {
            $this->{$key} = $value;
        }
    }
}