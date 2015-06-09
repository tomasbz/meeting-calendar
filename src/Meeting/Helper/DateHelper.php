<?php

namespace Meeting\Helper;

/**
 * Manipulate DateTime
 *
 * Class DateHelper
 * @package Meeting\Helper
 */
class DateHelper
{
    private $_dateTime;
    private $_timeZone;
    private $_dateFormat;

    public function __construct()
    {
        $this->_dateTime = new \DateTime();
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate($format = null)
    {
        if($format != null)
            $this->_dateFormat = $format;

        return $this->_dateTime->format($this->_dateFormat);
    }

    /**
     * Set date
     *
     * @param $year
     * @param $month
     * @param $day
     */
    public function setDate($year, $month, $day = '01')
    {
        $this->_dateTime->setDate($year, $month, $day);
    }

    /**
     * Set timezone
     */
    public function setTimeZone($timeZone)
    {
        $this->_timeZone = $this->_dateTime->setTimezone(new \DateTimeZone($timeZone));
    }

    /**
     * Set date format
     * 
     * @param $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->_dateFormat = $dateFormat;
    }

    /**
     * Check if given date is weekday
     * false if weekend
     *
     * @param $year
     * @param $month
     * @param $day
     * @return bool
     */
    public function isWeekday($year, $month, $day)
    {
        $isWeekday = true;
        $this->setDate($year, $month, $day);

        if($this->getDate('N') >= 6)
            $isWeekday = false;

        return $isWeekday;
    }

    /**
     * Get date by next weekday name
     *
     * @param $dayName
     * @return bool|string
     */
    public function getNextDayDateByName($year, $month, $day, $dayName)
    {
        $this->_dateTime->setDate($year, $month, $day);
        $this->_dateTime->modify('next '.$dayName);
    }

    /**
     * Get date previous weekday name
     *
     * @param $dayName
     * @return bool|string
     */
    public function getPrevDayDateByName($dayName)
    {
        $this->_dateTime->modify('previous '.$dayName);
    }

    /**
     * Get next month from now
     * this month + months
     *
     * @param $months
     * @param $format
     * @return string
     */
    public function getNextMonth($months, $format)
    {
        $now = new \DateTime();
        $this->_dateTime->setDate($now->format('Y'), $now->format('m'), $now->format('d'));
        $this->_dateTime->modify("+$months month");

        return $this->getDate($format);
    }

    /**
     * Get last day of month
     *
     * @return \DateTime
     */
    public function getLastDayOfMonth($year, $month, $format)
    {
        $this->setDate($year, $month);
        $this->_dateTime->modify('last day of this month');

        return $this->getDate($format);
    }

    /**
     * Get month name by date
     *
     * @param $year
     * @param $month
     * @return string
     * @internal param $format
     */
    public function getMonthName($year, $month)
    {
        $this->setDate($year, $month);
        return $this->getDate('F');
    }
}