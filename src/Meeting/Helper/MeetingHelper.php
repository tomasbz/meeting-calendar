<?php

namespace Meeting\Helper;

/**
 * Class MeetingHelper
 * @package Meeting\Helper
 */
class MeetingHelper
{
    private $_midMonthMeetingDay;
    private $_midMeetingNextWeekday;
    private $_testingPreviousDay;
    private $_testingSkipDay;
    private $_dateHelper;

    public function __construct($timeZone, $midMonthMeetingDay, $midMeetingNextWeekday, $testingPreviousDay, $testingSkipDay)
    {
        $this->_dateHelper = new DateHelper();
        $this->_dateHelper->setTimeZone($timeZone);
        $this->_midMonthMeetingDay = $midMonthMeetingDay;
        $this->_midMeetingNextWeekday = $midMeetingNextWeekday;
        $this->_testingPreviousDay = $testingPreviousDay;
        $this->_testingPreviousDay = $testingPreviousDay;
        $this->_testingSkipDay = $testingSkipDay;
    }

    /**
     * Process months
     * Write data to CSV file
     *
     * @param $monthCount
     * @return array
     */
    public function processMonths($monthCount)
    {
        $monthData = array();

        for($i=1; $i<=$monthCount; $i++)
        {
            $nextMonth = $this->_dateHelper->getNextMonth($i, 'm');
            $nextMonthYear = $this->_dateHelper->getNextMonth($i,'Y');
            $monthData[] = $this->processMonth($nextMonthYear, $nextMonth, 'Y-m-d');
        }

        return $monthData;
    }

    /**
     * Process month
     * get mid month meeting day
     * get end month testing day
     *
     * @param $year
     * @param $month
     * @param $format
     * @return array
     */
    public function processMonth($year, $month, $format)
    {
        $monthName = $this->_dateHelper->getMonthName($year, $month);
        $midMonthMeetingDay = $this->getMidMonthMeetingDay($year, $month, $format);
        $testingDay = $this->getTestingDay($year, $month, $format);

        return array(
            $monthName,
            $midMonthMeetingDay,
            $testingDay
        );
    }

    /**
     * Get testing day
     * if given date is not weekend or friday
     *
     * @param $month
     * @return bool|string
     */
    public function getTestingDay($year, $month, $format)
    {
        $weekDayName = $this->_dateHelper->getLastDayOfMonth($year, $month, 'l');

        if(!$this->_dateHelper->isWeekday($year, $month, $this->_dateHelper->getDate('d')) || $weekDayName == $this->_testingSkipDay)
        {
            $this->_dateHelper->setDateFormat($format);
            $this->_dateHelper->getPrevDayDateByName($this->_testingPreviousDay);
        }

        return $this->_dateHelper->getDate($format);
    }

    /**
     * Get mid month meeting
     * if given date is weekend
     * find next weekday by name (Monday)
     *
     * @param $year
     * @param $month
     * @return string
     */
    public function getMidMonthMeetingDay($year, $month, $format)
    {
        $this->_dateHelper->setDate($year, $month, $this->_midMonthMeetingDay);

        $date = $this->_dateHelper->getDate($format);
        if(!$this->_dateHelper->isWeekday($year, $month, $this->_midMonthMeetingDay))
        {
            $this->_dateHelper->getNextDayDateByName($year, $month, $this->_midMonthMeetingDay, $this->_midMeetingNextWeekday);
            $date = $this->_dateHelper->getDate($format);
        }

        return $date;
    }

    /**
     * Set Mid Month Meeting Day
     *
     * @param $day
     */
    public function setMidMonthMeetingDay($day)
    {
        $this->_midMonthMeetingDay = $day;
    }

    /**
     * Set Mid month Meeting Next Weekday
     *
     * @param $day
     */
    public function setMidMeetingNextWeekday($day)
    {
        $this->_midMeetingNextWeekday = $day;
    }

    /**
     * Set Testing Previous Day
     *
     * @param $day
     */
    public function setTestingPreviousDay($day)
    {
        $this->_testingPreviousDay = $day;
    }

    /**
     * Set Testing Skip Day
     *
     * @param $day
     */
    public function setTestingSkipDay($day)
    {
        $this->_testingSkipDay = $day;
    }
}