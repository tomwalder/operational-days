<?php

/**
 * OperationalDaysConfiguratorInterface
 *
 * Expected interface for configurators of OperationalDays implementations.
 */
interface OperationalDaysConfiguratorInterface {

    /**
     * Take an existing OperationalDays instance and use it prepopulate this configurator.
     * OperationalDaysConfigurators that are coupled to a corresponding OperationalDays realisation should be
     * namespaced together. 
     *
     * @param OperationalDaysInterface $obj_input
     * @return $this
     * @throws InvalidArgumentException. 
     */
    public function startingWith(OperationalDaysInterface $obj_input);

    /**
     * Set the date range that the OperationalDays instance will cover. The start date is given as an optional
     * second parameter so that it can default to today.
     *
     * @param DateTimeInterface $obj_date_until
     * @param DateTimeInterface $obj_date_since - if null, assumes today.
     * @return $this
     * @throws RangeException - raised if the until date is less than the (implicit) from date.
     */
    public function setDateRange(DateTimeInterface $obj_date_until, DateTimeInterface $obj_date_since = null);

    /**
     * Set the weekly recurring operational day pattern the OperationalDays instance will cover.
     *
     * @return $this
     * @throws InvalidArgumentException - raised if the bitmask contains any undefined bits.
     */
    public function setRecurrentWeeklyPattern($int_weekly_bitmask);

    /**
     * Sets the specific operational dates array, optionally clearing out any existing definitions. Accepts an array
     * of DateTimeInterface implementors or string values that can be coerced into DateTimeImmutable instances. The
     * string use case is to satisfy loading values out of persistent storage.
     *
     * @param DateTimeInterface|string[] $arr_dates
     * @param bool $bol_reset
     * @return $this
     * @throws InvalidArgumentException - raised by the construction of DateTimeImmutable from an unsupported input.
     */
    public function setOperationalDates(array $arr_dates, $bol_reset = false);

    /**
     * Sets the specific non operational dates array, optionally clearing out any existing definitions. Accepts an array
     * of DateTimeInterface implementors or string values that can be coerced into DateTimeImmutable instances. The
     * string use case is to satisfy loading values out of persistent storage.
     *
     * @param DateTimeInterface|string[] $arr_dates
     * @param bool $bol_reset
     * @return $this
     * @throws InvalidArgumentException - raised by the construction of DateTimeImmutable from an unsupported input.
     */
    public function setNonOperationalDates(array $arr_dates, $bol_reset = false);

    /**
     * Adds a single specific operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function addOperationalDate(DateTimeInterface $obj_date);

    /**
     * Adds a single specific non-operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function addNonOperationalDate(DateTimeInterface $obj_date);

    /**
     * Creates a new instance of OperationalDaysInterface from the current configuration.
     *
     * @return OperationalDaysInterface
     */
    public function create();

}

