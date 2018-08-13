<?php

/**
 * OperationalDaysInterface
 *
 * Immutable
 */
interface OperationalDaysInterface {

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
    public function isOperationalDate(DateTimeInterface $obj_date);

    /**
     * Get the start of the date range that this instance covers.
     *
     * @return DateTimeInterface
     */
    public function getOperationalDateRangeStart();

    /**
     * Get the end of the date range that this instance covers.
     *
     * @return DateTimeInterface
     */
    public function getOperationalDateRangeEnd();

}

