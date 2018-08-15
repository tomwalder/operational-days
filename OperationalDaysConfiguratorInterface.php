<?php

/**
 * OperationalDaysConfiguratorInterface
 *
 * Expected interface for configurators of OperationalDays implementations. The intention is that implemetnations allow
 * fluent construction of OperationalDays immutable instance, either from scratch or by taking an existng template
 * instance and modifying it.
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
     * @param  int $int_weekly_bitmask  - Logically OR'd combination of OperationalDaysEnum::BF_XYZ flags
     * @return $this
     * @throws InvalidArgumentException - raised if the bitmask contains any undefined bits.
     */
    public function setRecurrentWeeklyPattern($int_weekly_bitmask);

    /**
     * Set a particular day of week as a recurrent operational day.
     *
     * @param  int $int_day_of_week - One of the OperationalDaysEnum::DOW_XYZ enumerated set.
     * @return $this
     * @throws InvalidArgumentException - raised if the day of week is not one of the expected enumerated set.
     */
    public function setRecurrentDay($int_day_of_week);

    /**
     * Clear a particular day of week as a recurrent operational day.
     *
     * @param  int $int_day_of_week - One of the OperationalDaysEnum::DOW_XYZ enumerated set.
     * @return $this
     * @throws InvalidArgumentException - raised if the day of week is not one of the expected enumerated set.
     */
    public function clearRecurrentDay($int_day_of_week);

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
    public function setSpecificOperationalDates(array $arr_dates, $bol_reset = false);

    /**
     * Clears a set specific operational dates. Accepts an array of DateTimeInterface implementors or string values
     * that can be coerced into DateTimeImmutable instances. The string use case is to satisfy loading values out of
     * persistent storage.
     *
     * @param DateTimeInterface|string[] $arr_dates
     * @return $this
     * @throws InvalidArgumentException - raised by the construction of DateTimeImmutable from an unsupported input.
     */
    public function clearSpecificOperationalDates(array $arr_dates);

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
    public function setSpecificNonOperationalDates(array $arr_dates, $bol_reset = false);

    /**
     * Clears a set specific non operational dates. Accepts an array of DateTimeInterface implementors or string values
     * that can be coerced into DateTimeImmutable instances. The string use case is to satisfy loading values out of
     * persistent storage.
     *
     * @param DateTimeInterface|string[] $arr_dates
     * @return $this
     * @throws InvalidArgumentException - raised by the construction of DateTimeImmutable from an unsupported input.
     */
    public function clearSpecificNonOperationalDates(array $arr_dates);

    /**
     * Adds a single specific operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function addSpecificOperationalDate(DateTimeInterface $obj_date);

    /**
     * Removes a single specific operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function removeSpecificOperationalDate(DateTimeInterface $obj_date);

    /**
     * Adds a single specific non-operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function addSpecificNonOperationalDate(DateTimeInterface $obj_date);

    /**
     * Removes a single specific non-operational date
     *
     * @param DateTimeInterface $obj_date
     * @return $this
     */
    public function removeSpecificNonOperationalDate(DateTimeInterface $obj_date);

    /**
     * Creates a new instance of OperationalDaysInterface from the current configuration.
     *
     * @return OperationalDaysInterface
     */
    public function create();

}

