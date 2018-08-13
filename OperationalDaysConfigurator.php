<?php
/**
 * OperationalDaysConfigurator.
 *
 * Implemented as "friend" by extension
 *
 * Implements a fluent factory for creating immutable OperationalDays instances:
 *
 *
 */
final class OperationalDaysConfigurator extends OperationalDays {

    const IDX_FORMAT = 'Ymd'; 

    /**
     * Do not allow external construction of this class
     */
    private function __construct() {

    }

    public static function get() {
        return new self;
    }

    /**
     * Creates a new instance of OperationalDays from the current configuration.
     *
     * @return OperationalDays
     */
    public function create() {
        $obj_operational_days                     = new OperationalDays();
        $obj_operational_days->obj_date_since     = $this->obj_date_since;
        $obj_operational_days->obj_date_until     = $this->obj_date_until;
        $obj_operational_days->int_weekly_bitmask = $this->int_weekly_bitmask;
        $obj_operational_days->arr_specific_operational_dates     = $this->arr_specific_operational_dates;
        $obj_operational_days->arr_specific_non_operational_dates = $this->arr_specific_non_operational_dates;
        return $obj_operational_days;
    }

    /**
     * Convert a Day Of Week enumerated constant to it's corresponding bitmask value. The returned bitmask
     * will be zero for any input not strictly in the enumerated set.
     *
     * @param int $int_dow
     * @return int
     */
    public static function dayOfWeekToBit($int_dow) {
        return (1 << $int_dow) & OperationalDaysEnum::BF_ALL;
    }

    /**
     * Convert a DateTimeInterface implementor into a key index format used by OperationalDays internally.
     * Do not assume anything about the returned value beyond it's type.
     *
     * @param DateTimeInterface $obj_date
     * @return string
     */
    public static function dateToIndex(DateTimeInterface $obj_date) {
        return $obj_date->format(self::IDX_FORMAT);
    }

    /**
     * Set the date range that the OperationalDays instance will cover. The start date is given as an optional
     * second parameter so that it can default to today.
     *
     * @param DateTimeInterface $obj_date_until
     * @param DateTimeInterface $obj_date_since - if null, assumes today.
     * @return $this
     * @throws RangeException - raised if the until date is less than the (implicit) from date.
     */
    public function setDateRange(DateTimeInterface $obj_date_until, DateTimeInterface $obj_date_since = null) {
        $obj_date_since = $obj_date_since ?: new DateTimeImmutable();
        if ($obj_date_since > $obj_date_until) {
            throw new RangeException();
        }
        $this->obj_date_since = $obj_date_since;
        $this->obj_date_until = $obj_date_until;
        return $this;
    }

    /**
     * Set the weekly recurring operational day pattern the OperationalDays instance will cover.
     *
     * @return $this
     * @throws InvalidArgumentException - raised if the bitmask contains any undefined bits.
     */
    public function setWeeklyBitMask($int_weekly_bitmask) {
        $int_weekly_bitmask = (int)$int_weekly_bitmask;
        if ($int_weekly_bitmask & ~OperationalDaysEnum::BF_ALL) {
            throw new InvalidArgumentException("Invalid mask specification ". $int_mask);
        }
        $this->int_weekly_bitmask = $int_weekly_bitmask;
        return $this;
    }

    public function setOperationalDates(array $arr_dates) {
        $this->arr_specific_operational_dates = [];
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->addOperationalDate($mix_date);
            } else {
                $this->addOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    public function setNonOperationalDates(array $arr_dates) {
        $this->arr_specific_non_operational_dates = [];
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->addNonOperationalDate($mix_date);
            } else {
                $this->addNonOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    public function addOperationalDate(DateTimeInterface $obj_date) {
        $this->arr_specific_operational_dates[self::dateToIndex($obj_date)] = true;
        return $this;
    }

    public function addNonOperationalDate(DateTimeInterface $obj_date) {
        $this->arr_specific_non_operational_dates[self::dateToIndex($obj_date)] = true;
        return $this;
    }

}

