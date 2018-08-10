<?php

/**
 * OperationalDaysInterface
 */
interface OperationalDaysInterface {
  const
    /**
     * Enumerated days of week
     */
    DOW_SUN = 0,
    DOW_MON = 1,
    DOW_TUE = 2,
    DOW_WED = 3,
    DOW_THU = 4,
    DOW_FRI = 5,
    DOW_SAT = 6,

    /**
     * Bitfield values for day of week
     */
    BF_SUN     =   1,
    BF_MON     =   2,
    BF_TUE     =   4,
    BF_WED     =   8,
    BF_THU     =  16,
    BF_FRI     =  32,
    BF_SAT     =  64,
    BF_WEEKDAY =  62,
    BF_WEEKEND =  65,
    BF_ALL     = 127
  ;

  /**
   * Check if a given calendar date is an operational day. Returns true if:
   *
   * 1) The date is a specified operational day OR
   * 2) The date is not a specified non-operational day AND
   *    is on an operational day of the week.
   *
   * @param  DateTimeInterface $obj_date
   * @return bool
   */
  public function isOperational(DateTimeInterface $obj_date);

  /**
   * Set a specific date as operational. This will override all other concerns.
   *
   * @param  DateTimeInterface $obj_date
   * @return OperationalDaysInterface - fluent
   */
  public function setOperationalDate(DateTimeInterface $obj_date);

  /**
   * Clear a specific date as operational. This will not override weekly pattern.
   *
   * @param  DateTimeInterface $obj_date
   * @return OperationalDaysInterface - fluent
   */
  public function clearOperationalDate(DateTimeInterface $obj_date);

  /**
   * Clear a specific date as non-operational. This will override weekly pattern.
   *
   * @param  DateTimeInterface $obj_date
   * @return OperationalDaysInterface - fluent
   */
  public function setNonOperationalDate(DateTimeInterface $obj_date);

  /**
   * Clear a specific date as non-operational.
   *
   * @param  DateTimeInterface $obj_date
   * @return OperationalDaysInterface - fluent
   */
  public function clearNonOperationalDate(DateTimeInterface $obj_date);

  /**
   * Specify a day of the week as a recurrent operational day.
   *
   * @param int $int_dow - enumerated DOW_ constant
   * @return OperationalDaysInterface - fluent
   */
  public function setDayOfWeek($int_dow);

  /**
   * Specify a day of the week as a recurrent non-operational day.
   *
   * @param int $int_dow - enumerated DOW_ constant
   * @return OperationalDaysInterface - fluent
   */
  public function clearDayOfWeek($int_dow);
}

