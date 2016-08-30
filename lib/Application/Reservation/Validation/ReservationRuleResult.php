<?php
/**
Copyright 2011-2015 Nick Korbel

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

class ReservationRuleResult
{
	private $_isValid;
	private $_errorMessage;

	/**
	 * @param bool $isValid
	 * @param string $errorMessage
	 */
	public function __construct($isValid = true, $errorMessage = null)
	{
		$this->_isValid = $isValid;
		$this->_errorMessage = $errorMessage;
	}

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->_isValid;
	}

	/**
	 * @return string
	 */
	public function ErrorMessage()
	{
		return $this->_errorMessage;
	}
}