<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/**
 * PHPExcel_Calculation_DateTime
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category    PHPExcel
 * @package        PHPExcel_Calculation
 * @copyright    Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license        http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version        ##VERSION##, ##DATE##
 */
class PHPExcel_Calculation_DateTime
{
    /**
     * Identify if a year is a leap year or not
     *
     * @param    integer    $year    The year to test
     * @return    boolean            TRUE if the year is a leap year, otherwise FALSE
     */
    public static function isLeapYear($year)
    {
        return ((($year % 4) == 0) && (($year % 100) != 0) || (($year % 400) == 0));
    }


    /**
     * Return the number of days between two dates based on a 360 day calendar
     *
     * @param    integer    $startDay        Day of month of the start date
     * @param    integer    $startMonth        Month of the start date
     * @param    integer    $startYear        Year of the start date
     * @param    integer    $endDay            Day of month of the start date
     * @param    integer    $endMonth        Month of the start date
     * @param    integer    $endYear        Year of the start date
     * @param    boolean $methodUS        Whether to use the US method or the European method of calculation
     * @return    integer    Number of days between the start date and the end date
     */
    private static function dateDiff360($startDay, $startMonth, $startYear, $endDay, $endMonth, $endYear, $methodUS)
    {
        if ($startDay == 31) {
            --$startDay;
        } elseif ($methodUS && ($startMonth == 2 && ($startDay == 29 || ($startDay == 28 && !self::isLeapYear($startYear))))) {
            $startDay = 30;
        }
        if ($endDay == 31) {
            if ($methodUS && $startDay != 30) {
                $endDay = 1;
                if ($endMonth == 12) {
                    ++$endYear;
                    $endMonth = 1;
                } else {
                    ++$endMonth;
                }
            } else {
                $endDay = 30;
            }
        }

        return $endDay + $endMonth * 30 + $endYear * 360 - $startDay - $startMonth * 30 - $startYear * 360;
    }


    /**
     * getDateValue
     *
     * @param    string    $dateValue
     * @return    mixed    Excel date/time serial value, or string if error
     */
    public static function getDateValue($dateValue)
    {
        if (!is_numeric($dateValue)) {
            if ((is_string($dateValue)) &&
                (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_GNUMERIC)) {
                return PHPExcel_Calculation_Functions::VALUE();
            }
            if ((is_object($dateValue)) && ($dateValue instanceof DateTime)) {
                $dateValue = PHPExcel_Shared_Date::PHPToExcel($dateValue);
            } else {
                $saveReturnDateType = PHPExcel_Calculation_Functions::getReturnDateType();
                PHPExcel_Calculation_Functions::setReturnDateType(PHPExcel_Calculation_Functions::RETURNDATE_EXCEL);
                $dateValue = self::DATEVALUE($dateValue);
                PHPExcel_Calculation_Functions::setReturnDateType($saveReturnDateType);
            }
        }
        return $dateValue;
    }


    /**
     * getTimeValue
     *
     * @param    string    $timeValue
     * @return    mixed    Excel date/time serial value, or string if error
     */
    private static function getTimeValue($timeValue)
    {
        $saveReturnDateType = PHPExcel_Calculation_Functions::getReturnDateType();
        PHPExcel_Calculation_Functions::setReturnDateType(PHPExcel_Calculation_Functions::RETURNDATE_EXCEL);
        $timeValue = self::TIMEVALUE($timeValue);
        PHPExcel_Calculation_Functions::setReturnDateType($saveReturnDateType);
        return $timeValue;
    }


    private static function adjustDateByMonths($dateValue = 0, $adjustmentMonths = 0)
    {
        // Execute function
        $PHPDateObject = PHPExcel_Shared_Date::ExcelToPHPObject($dateValue);
        $oMonth = (int) $PHPDateObject->format('m');
        $oYear = (int) $PHPDateObject->format('Y');

        $adjustmentMonthsString = (string) $adjustmentMonths;
        if ($adjustmentMonths > 0) {
            $adjustmentMonthsString = '+'.$adjustmentMonths;
        }
        if ($adjustmentMonths != 0) {
            $PHPDateObject->modify($adjustmentMonthsString.' months');
        }
        $nMonth = (int) $PHPDateObject->format('m');
        $nYear = (int) $PHPDateObject->format('Y');

        $monthDiff = ($nMonth - $oMonth) + (($nYear - $oYear) * 12);
        if ($monthDiff != $adjustmentMonths) {
            $adjustDays = (int) $PHPDateObject->format('d');
            $adjustDaysString = '-'.$adjustDays.' days';
            $PHPDateObject->modify($adjustDaysString);
        }
        return $PHPDateObject;
    }


    /**
     * DATETIMENOW
     *
     * Returns the current date and time.
     * The NOW function is useful when you need to display the current date and time on a worksheet or
     * calculate a value based on the current date and time, and have that value updated each time you
     * open the worksheet.
     *
     * NOTE: When used in a Cell Formula, MS Excel changes the cell format so that it matches the date
     * and time format of your regional settings. PHPExcel does not change cell formatting in this way.
     *
     * Excel Function:
     *        NOW()
     *
     * @access    public
     * @category Date/Time Functions
     * @return    mixed    Excel date/time serial value, PHP date/time serial value or PHP date/time object,
     *                        depending on the value of the ReturnDateType flag
     */
    public static function DATETIMENOW()
    {
        $saveTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $retValue = false;
        switch (PHPExcel_Calculation_Functions::getReturnDateType()) {
            case PHPExcel_Calculation_Functions::RETURNDATE_EXCEL:
                $retValue = (float) PHPExcel_Shared_Date::PHPToExcel(time());
                break;
            case PHPExcel_Calculation_Functions::RETURNDATE_PHP_NUMERIC:
                $retValue = (integer) time();
                break;
            case PHPExcel_Calculation_Functions::RETURNDATE_PHP_OBJECT:
                $retValue = new DateTime();
                break;
        }
        date_default_timezone_set($saveTimeZone);

        return $retValue;
    }


    /**
     * DATENOW
     *
     * Returns the current date.
     * The NOW function is useful when you need to display the current date and time on a worksheet or
     * calculate a value based on the current date and time, and have that value updated each time you
     * open the worksheet.
     *
     * NOTE: When used in a Cell Formula, MS Excel changes the cell format so that it matc