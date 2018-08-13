<?php

array_map(
    function($class) {
        require_once($class . '.php');
    }, [
    'OperationalDaysEnum',
    'OperationalDaysInterface',
    'OperationalDays',
    'OperationalDaysConfigurator',
    'HasOperationalDaysInterface',
]);

$obj_operational_days = OperationalDaysConfigurator::get()
    ->setDateRange(new DateTimeImmutable('2019-01-01T00:00:00+00:00'))
    ->setWeeklyBitmask(OperationalDaysEnum::BF_WEEKDAY)
    ->addNonOperationalDate(new DateTimeImmutable('2018-08-29'))
    ->create();

print_r($obj_operational_days);
