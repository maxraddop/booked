<?php
/**
Copyright 2012-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class SchedulePeriodRule implements IReservationValidationRule
{
	/**
	 * @var IScheduleRepository
	 */
	private $repository;

	/**
	 * @var UserSession
	 */
	private $session;

	public function __construct(IScheduleRepository $repository, UserSession $session)
	{
		$this->repository = $repository;
		$this->session = $session;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$layout = $this->repository->GetLayout($reservationSeries->Resource()->GetScheduleId(), new ScheduleLayoutFactory($this->session->Timezone));

		$startDate = $reservationSeries->CurrentInstance()->StartDate();
		$startPeriod = $layout->GetPeriod($startDate);
		$endDate = $reservationSeries->CurrentInstance()->EndDate();
		$endPeriod = $layout->GetPeriod($endDate);
		$errors = new StringBuilder();
		if ($startPeriod == null || !$startPeriod->IsReservable() || !$startPeriod->BeginDate()->Equals($startDate))
		{
			$errors->AppendLine(Resources::GetInstance()->GetString('InvalidStartSlot'));
			$errors->AppendLine($startPeriod == null ? "NULL DATA" : "");
			$errors->AppendLine($startPeriod->IsReservable() ? "" : "CANNOT RESERVE");
			$errors->AppendLine($startPeriod->BeginDate()->Equals($startDate) ? "" : "ERROR IN DATA : " . $startPeriod->BeginDate() . " != " . $startDate);
                        // var_dump($startPeriod);
                        // var_dump($startDate);
		}

		if ($endPeriod == null || !$endPeriod->BeginDate()->Equals($endDate))
		{
			$errors->AppendLine(Resources::GetInstance()->GetString('InvalidEndSlot'));
			$errors->AppendLine($endPeriod == null ? "NULL DATA" : "");
			$errors->AppendLine($endPeriod->BeginDate()->Equals($endDate) ? "" : "ERROR IN DATA : " . $endPeriod->BeginDate() . " != " . $endDate);
		}

		$errorMessage = $errors->ToString();

		return new ReservationRuleResult(strlen($errorMessage) == 0, $errorMessage);
	}
}

?>