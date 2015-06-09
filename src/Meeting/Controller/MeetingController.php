<?php

namespace Meeting\Controller;
use Exception;
use Meeting\Helper\MeetingHelper;
use Meeting\Helper\CsvHelper;

/**
 * Generate meetings report
 * Generate CSV report
 *
 * Class MeetingController
 * @package Meeting\Controller
 */
class MeetingController
{
    public function __construct($cmdArgs)
    {
        try
        {
            $this->checkCmdArgs($cmdArgs);
            $meetingHelperArgs = array(
                'timeZone' => 'Europe/London',
                'midMeetingDay' => 14,
                'midMeetingNextWeekday' => 'Monday',
                'testingPreviousDay' => 'Thursday',
                'testingSkipDay' => 'Friday',
                'monthCount' => 6,
                'outputDirectory' => 'output',
                'outputFilename' => $cmdArgs[1]
            );

            $this->generateCsvReport($meetingHelperArgs);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Generate CSV report
     * @param $args
     */
    public function generateCsvReport($args)
    {
        $csv = new CsvHelper();
        $csv->setFilename($args['outputFilename']);
        $csv->setOutputDirectory($args['outputDirectory']);
        $csv->setHeader(
            array(
                'Month',
                'Mid Month Meeting Date',
                'End of Month Testing Date'
            )
        );

        $meetingHelper = new MeetingHelper(
            $args['timeZone'],
            $args['midMeetingDay'],
            $args['midMeetingNextWeekday'],
            $args['testingPreviousDay'],
            $args['testingSkipDay']
        );
        $reportData = $meetingHelper->processMonths($args['monthCount']);
        $csv->storeCsvReport($reportData);
    }

    /**
     * Check if there are enough arguments from command line
     *
     * @param $args
     * @return bool
     * @throws Exception
     */
    public function checkCmdArgs($args)
    {
        if(count($args) == 1)
            throw new Exception('Not enough arguments! - USAGE php meetings.php outputFilename.csv');

        return true;
    }
}