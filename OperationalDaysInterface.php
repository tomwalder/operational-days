<?php

/**
 * OperationalDaysInterface
 *
 * Interface for immutable realisations of the OperationalDays concept.
 * All days are operational until specified otherwise.
 */
interface OperationalDaysInterface {

    /**
     * Get the type of the date, as one of the OperationalDaysEnum::TYPE_XXX enumerations.
     *
     * @param  DateTimeInterface $obj_date
     * @return int
     */
    public function getTypeOfDate(DateTimeInterface $obj_date);

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
    public function getDateRangeStart();

    /**
     * Get the end of the date range that this instance covers.
     *
     * @return DateTimeInterface
     */
    public function getDateRangeEnd();
    
    /**
     * Get the recurrent weekly pattern (bit mask)
     *
     * @return int
     */
    public function getRecurrentWeeklyPattern();

    /**
     * Get the specific dates that were set operational
     *
     * @return DateTimeImmutable[]
     */
    public function getSpecificOperationalDates();

    /**
     * Get the specific dates that were set non-operational
     *
     * @return DateTimeImmutable[]
     */
    public function getSpecificNonOperationalDates();
}

