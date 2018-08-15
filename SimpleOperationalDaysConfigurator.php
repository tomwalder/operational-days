<?php
/**
 * SimpleOperationalDaysConfigurator.
 *
 * Implemented as "friend" by extension
 *
 * Implements a fluent factory for creating immutable SimpleOperationalDays instances:
 *
 *
 */
class SimpleOperationalDaysConfigurator extends SimpleOperationalDays implements OperationalDaysConfiguratorInterface {

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
     * @implements OperationalDaysConfiguratorInterface::startingWith()
     */
    public function startingWith(OperationalDaysInterface $obj_input) {
        if ($obj_input instanceof SimpleOperationalDays) {
            $this->obj_date_since                     = $obj_input->obj_date_since;
            $this->obj_date_until                     = $obj_input->obj_date_until;
            $this->int_weekly_bitmask                 = $obj_input->int_weekly_bitmask;
            $this->arr_specific_operational_dates     = $obj_input->arr_specific_operational_dates;
            $this->arr_specific_non_operational_dates = $obj_input->arr_specific_non_operational_dates;
        } else {
            $this->obj_date_since     = $obj_input->getDateRangeStart();
            $this->obj_date_until     = $obj_input->getDateRangeEnd();
            $this->int_weekly_bitmask = $obj_input->getRecurrentWeeklyPattern();
            $this->setOperationalDates($obj_input->getSpecificOperationalDates(), true);
            $this->setNosnOperationalDates($obj_input->getSpecificNonOperationalDates(), true);
        }
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::setDateRange()
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
     * @implements OperationalDaysConfiguratorInterface::setRecurrentWeeklyPattern()
     */
    public function setRecurrentWeeklyPattern($int_weekly_bitmask) {
        $int_weekly_bitmask = (int)$int_weekly_bitmask;
        if ($int_weekly_bitmask & ~OperationalDaysEnum::BF_ALL) {
            throw new InvalidArgumentException("Invalid mask specification ". $int_mask);
        }
        $this->int_weekly_bitmask = $int_weekly_bitmask;
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::setRecurrentDay()
     */
    public function setRecurrentDay($int_day_of_week) {
        $this->int_weekly_bitmask |= self::dayOfWeekToBit($int_day_of_week);
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::clearRecurrentDay()
     */
    public function clearRecurrentDay($int_day_of_week) {
        $this->int_weekly_bitmask &= ~self::dayOfWeekToBit($int_day_of_week);
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::setSpecificOperationalDates()
     */
    public function setSpecificOperationalDates(array $arr_dates, $bol_reset = false) {
        if ($bol_reset) {
            $this->arr_specific_operational_dates = [];
        }
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->addSpecificOperationalDate($mix_date);
            } else {
                $this->addSpecificOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::clearSpecificOperationalDates()
     */
    public function clearSpecificOperationalDates(array $arr_dates) {
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->removeSpecificOperationalDate($mix_date);
            } else {
                $this->removeSpecificOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::setSpecificNonOperationalDates()
     */
    public function setSpecificNonOperationalDates(array $arr_dates, $bol_reset = false) {
        if ($bol_reset) {
            $this->arr_specific_non_operational_dates = [];
        }
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->addSpecificNonOperationalDate($mix_date);
            } else {
                $this->addSpecificNonOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::clearSpecificNonOperationalDates()
     */
    public function clearSpecificNonOperationalDates(array $arr_dates) {
        foreach ($arr_dates as $mix_date) {
            if ($mix_date instanceof DateTimeInterface) {
                $this->removeSpecificNonOperationalDate($mix_date);
            } else {
                $this->removeSpecificNonOperationalDate(new DateTimeImmutable($mix_date));
            }
        }
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::addSpecificOperationalDate()
     */
    public function addSpecificOperationalDate(DateTimeInterface $obj_date) {
        $this->arr_specific_operational_dates[self::dateToIndex($obj_date)] = true;
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::removeSpecificOperationalDate()
     */
    public function removeSpecificOperationalDate(DateTimeInterface $obj_date) {
        unset($this->arr_specific_operational_dates[self::dateToIndex($obj_date)]);
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::addSpecificNonOperationalDate()
     */
    public function addSpecificNonOperationalDate(DateTimeInterface $obj_date) {
        $this->arr_specific_non_operational_dates[self::dateToIndex($obj_date)] = true;
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::removeSpecificNonOperationalDate()
     */
    public function removeSpecificNonOperationalDate(DateTimeInterface $obj_date) {
        unset($this->arr_specific_non_operational_dates[self::dateToIndex($obj_date)]);
        return $this;
    }

    /**
     * @implements OperationalDaysConfiguratorInterface::create()
     */
    public function create() {
        $obj_operational_days                     = new SimpleOperationalDays();
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
    public static function dayOfWeekToBit($int_day_of_week) {
        self::assertDayOfWeek($int_day_of_week);
        return 1 << $int_day_of_week;
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
        //return pack('V', $obj_date->format(self::IDX_FORMAT));
    }

    public static function assertDayOfWeek($int_day_of_week) {
        if ($int_day_of_week < OperationalDaysEnum::DOW_SUN || $int_day_of_week > OperationalDaysEnum::DOW_SAT) {
            throw new InvalidArgumentException($int_day_of_week . " is not a valid day of week");
        }
    }
}

