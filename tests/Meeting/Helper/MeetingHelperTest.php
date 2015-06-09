<?php

use Meeting\Helper\MeetingHelper;

class MeetingHelperTest extends PHPUnit_Framework_TestCase
{
    private $object = null;

    protected function setUp()
    {
        $args = array(
            'timeZone' => 'Europe/London',
            'midMeetingDay' => 14,
            'midMeetingNextWeekday' => 'Monday',
            'testingPreviousDay' => 'Thursday',
            'testingSkipDay' => 'Friday'
        );

        $this->object = new MeetingHelper(
            $args['timeZone'],
            $args['midMeetingDay'],
            $args['midMeetingNextWeekday'],
            $args['testingPreviousDay'],
            $args['testingSkipDay']
        );
    }

    public function testProcessMonths()
    {
        $report = $this->object->processMonths(1);
        $this->assertNotEmpty($report);
    }

    public function testProcessMonth()
    {
        $monthReport = $this->object->processMonth(2015, 6, 'Y-m-d');
        $this->assertEquals($monthReport, array('June', '2015-06-15', '2015-06-30'));
    }

    public function testGetTestingDay()
    {
        $testDay = $this->object->getTestingDay(2015, 06, 'Y-m-d');
        $this->assertEquals($testDay, '2015-06-30');
    }

    public function testGetMidMonthMeetingDay()
    {
        $testDay = $this->object->getMidMonthMeetingDay(2015, 06, 'Y-m-d');
        $this->assertEquals($testDay, '2015-06-15');
    }
}