<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 23.11.17
 * Time: 10:40
 */

namespace Imper86\Core;


class HolidayCounter
{
    const WORKING_DAYS = [1, 2, 3, 4, 5];
    const HOLIDAYS = [
        '2017-01-01',
        '2017-01-06',
        '2017-04-16',
        '2017-04-17',
        '2017-05-01',
        '2017-05-03',
        '2017-06-04',
        '2017-06-15',
        '2017-08-15',
        '2017-11-01',
        '2017-11-11',
        '2017-12-25',
        '2017-12-26',
        '2018-01-01',
        '2018-01-06',
        '2018-04-01',
        '2018-04-02',
        '2018-05-01',
        '2018-05-03',
        '2018-05-20',
        '2018-05-31',
        '2018-08-15',
        '2018-11-01',
        '2018-11-11',
        '2018-12-25',
        '2018-12-26',
    ];

    /**
     * @var \DateTime
     */
    private $dateFrom;
    /**
     * @var \DateTime
     */
    private $dateTo;

    public function __construct(\DateTime $dateFrom, \DateTime $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getNumberOfFreeDays(): int
    {
        $interval = new \DateInterval('P1D');
        $dateTo = clone $this->dateTo;
        $dateTo->add($interval);
        $periods = new \DatePeriod($this->dateFrom, $interval, $dateTo);

        $days = 0;

        foreach ($periods as $period) {
            /** @var \DateTime $period */
            if (
                in_array($period->format('N'), self::WORKING_DAYS)
                && !in_array($period->format('Y-m-d'), self::HOLIDAYS)
            ) {
                continue;
            }

            $days++;
        }

        return $days;
    }

    public function getNumberOfWorkingDays(): int
    {
        $interval = new \DateInterval('P1D');
        $dateTo = clone $this->dateTo;
        $dateTo->add($interval);
        $periods = new \DatePeriod($this->dateFrom, $interval, $dateTo);

        $days = 0;

        foreach ($periods as $period) {
            /** @var \DateTime $period */
            if (!in_array($period->format('N'), self::WORKING_DAYS)) continue;
            if (in_array($period->format('Y-m-d'), self::HOLIDAYS)) continue;

            $days++;
        }

        return $days;
    }
}