<?php

/**
 * OperationalDays
 *
 * We assume all days are operational until told otherwise.
 */
class OperationalDays implements OperationalDaysInterface {

    protected
        $obj_date_since                     = null,
        $obj_date_until                     = null,
        $int_weekly_bitmask                 = OperationalDaysEnum::BF_ALL,
        $arr_specific_operational_dates     = [],
        $arr_specific_non_operational_dates = []    
    ;

    /**
     * @implements OperationalDaysInterface::isOperationalDate(DateTimeInterface $obj_date)
     */
    public function isOperationalDate(DateTimeInterface $obj_date) {
        $str_idx = OperationalDaysConfigurator::dateToIndex($obj_date);
        if (isset($this->arr_specific_operational_days[$str_idx])) {
            return true;
        }
        if (isset($this->specific_non_operational_dates[$str_idx])) {
            return false;
        }
        return (bool)($this->int_weekly_bitmask & OperationalDaysConfigurator::dayOfWeekToBit($obj_date->format('w')));
    }

    public function getOperationalDateRangeStart() {
        return $this->obj_date_since;
    }

    public function getOperationalDateRangeEnd() {
        return $this->obj_date_until;
    }

}


