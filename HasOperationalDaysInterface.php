<?php

/**
 * HasOperationalDaysInterface
 */
interface HasOperationalDaysInterface {

    /**
     * Returns an OperationalDaysInterface that describe the OperationalDays for the implementing entity
     * between the dates provided.
     *
     * @param DateTimeInterface $obj_until
     * @param DateTimeInterface $obj_since - If null, today is assumed
     * @return OperationalDaysInterface 
     *
     * @throws RangeException - Raised if the date range is inverted.
     */
    public function getOperationalDays(DateTimeInterface $obj_until, DateTimeInterface $obj_since = null);
}

