<?php

/**
 * OperationalDays
 *
 * We assume all days are operational until told otherwise.
 */
class OperationalDays implements OperationalDaysInterface {

  const IDX_FORMAT = 'Ymd';

  private
    $int_weekly_bitmask                 = self::BF_ALL,
    $arr_specific_operational_dates     = [],
    $arr_specific_non_operational_dates = []
  ;

  /**
   * @implements OperationalDaysInterface::isOperational(DateTimeInterface $obj_date)
   */
  public function isOperational(DateTimeInterface $obj_date) {
    $str_idx = $this->dateToIndex($obj_date);
    if (isset($this->arr_specific_operational_days[$str_idx])) {
       return true;
    }
    if (isset($this->specific_non_operational_dates[$str_idx])) {
       return false;
    }
    return (bool)($this->int_weekly_bitmask & (1 << (int)$obj_date->format('w')));
  }

  /**
   * @implements OperationalDaysInterface::setOperationalDate(DateTimeInterface $obj_date)
   */
  public function setOperationalDate(DateTimeInterface $obj_date) {
    $this->arr_specific_operational_dates[$this->dateToIndex($obj_date)] = true;
    return $this;
  }

  /**
   * @implements OperationalDaysInterface::clearOperationalDate(DateTimeInterface $obj_date)
   */
  public function clearOperationalDate(DateTimeInterface $obj_date) {
    unset($this->arr_specific_operational_dates[$this->dateToIndex($obj_date)]);
    return $this;
  }

  /**
   * @implements OperationalDaysInterface::setNonOperationalDate(DateTimeInterface $obj_date)
   */
  public function setNonOperationalDate(DateTimeInterface $obj_date) {
    $this->arr_specific_non_operational_dates[$this->dateToIndex($obj_date)] = true;
    return $this;
  }

  /**
   * @implements OperationalDaysInterface::clearNonOperationalDate(DateTimeInterface $obj_date)
   */
  public function clearNonOperationalDate(DateTimeInterface $obj_date) {
    unset($this->arr_specific_non_operational_dates[$this->dateToIndex($obj_date)]);
    return $this;
  }

  /**
   * @implements OperationalDaysInterface::setDayOfWeek(DateTimeInterface $obj_date)
   */
  public function setDayOfWeek($int_dow) {
    $this->int_weekly_bitmask |= $this->dowToBit($int_dow);
    return $this;
  }

  /**
   * @implements OperationalDaysInterface::clearDayOfWeek(DateTimeInterface $obj_date)
   */
  public function clearDayOfWeek($int_dow) {
    $this->int_weekly_bitmask &= ~$this->dowToBit($int_dow);
    return $this;
  }

  /**
   * Convert a DateTimeInterface into an index for array lookup.
   *
   * @param DateTimeInterface $obj_date
   * @return string
   */
  private function dateToIndex(DateTimeInterface $obj_date) {
    return $obj_date->format(self::IDX_FORMAT);
  }

  /**
   * Convert an enumerated day of week into a bitfield value.
   *
   * @param int $int_dow
   * @return int
   */
  private function dowToBit($int_dow) {
    return (1 << $int_dow) & self::BF_ALL;
  }
}


