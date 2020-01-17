<?php declare(strict_types=1);

namespace Banky\Report\GenerateReport;

use BankyFramework\Date;
use BankyFramework\Http\GetResourceResponse;

class GenerateReportController
{
    private const DAYS = 7;

    private ReportGenerator $reportGenerator;

    public function __construct(ReportGenerator $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function __invoke() : GetResourceResponse
    {
        $dailyReports = [];

        for ($day = 0; $day < self::DAYS; $day++) {
            $dailyReports[] = ($this->reportGenerator)(Date::daysAgo($day))->serialize();
        }

        return GetResourceResponse::fromResource($dailyReports);
    }
}