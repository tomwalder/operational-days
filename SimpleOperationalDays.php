<?php

/**
 * SimpleOperationalDays
 *
 * We assume all days are operational until told otherwise.
 */
class SimpleOperationalDays implements OperationalDaysInterface {

    protected
        /** @var DateTimeInterface $obj_date_since */
        $obj_date_since                     = null,

        /** @var DateTimeInterface $obj_date_since */
        $obj_date_until                     = null,

        /** @var int $int_weekly_bitmask */
        $int_weekly_bitmask                 = OperationalDaysEnum::BF_ALL,

        /** @var bool[] $arr_specific_operational_dates - keyed by (a function of) date */
        $arr_specific_operational_dates     = [],

        /** @var bool[] $arr_specific_non_operational_dates - keyed by (a function of) date */
        $arr_specific_non_operational_dates = []    
    ;

    /**
     * @implements OperationalDaysInterface::getTypeOfDate(DateTimeInterface $obj_date) : int
     */
    public function getTypeOfDate(DateTimeInterface $obj_date) {
        $str_idx = SimpleOperationalDaysConfigurator::dateToIndex($obj_date);
        if (isset($this->arr_specific_operational_dates[$str_idx])) {
            return OperationalDaysEnum::TYPE_SPECIFIC_OPERATIONAL;
        }
        if (isset($this->arr_specific_non_operational_dates[$str_idx])) {
            return OperationalDaysEnum::TYPE_SPECIFIC_NON_OPERATIONAL;
        }
        return ($this->int_weekly_bitmask & SimpleOperationalDaysConfigurator::dayOfWeekToBit($obj_date->format('w'))) ?
            OperationalDaysEnum::TYPE_RECURRENT_OPERATIONAL :
            OperationalDaysEnum::TYPE_RECURRENT_NON_OPERATIONAL;
    }

    /**
     * @implements OperationalDaysInterface::isOperationalDate(DateTimeInterface $obj_date) : bool
     */
    public function isOperationalDate(DateTimeInterface $obj_date) {
        return (bool)($this->getTypeOfDate($obj_date) & 1);
    }

    /**
     * @implements OperationalDaysInterface::getOperationalDateRangeStart() : DateTimeInterface
     */
    public function getDateRangeStart() {
        return $this->obj_date_since;
    }

    /**
     * @implements OperationalDaysInterface::getOperationalDateRangeEnd() : DateTimeInterface
     */
    public function getDateRangeEnd() {
        return $this->obj_date_until;
    }

    /**
     * Get the recurrent weekly pattern (bit mask)
     *
     * @return int
     */
    public function getRecurrentWeeklyPattern() {
        return $this->int_weekly_bitmask;
    }

    /**
     * Get the specific dates that were set operational
     *
     * @return DateTimeImmutable[]
     */
    public function getSpecificOperationalDates() {
        return [];
    }

    /**
     * Get the specific dates that were set non-operational
     *
     * @return DateTimeImmutable[]
     */
    public function getSpecificNonOperationalDates() {
        return [];
    }
}


