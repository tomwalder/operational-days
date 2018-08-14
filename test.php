<?php

error_reporting(-1);

// This is terrible...
array_map(
    function($class) {
        require_once($class . '.php');
    }, [
    'OperationalDaysEnum',
    'OperationalDaysInterface',
    'OperationalDaysConfiguratorInterface',
    'HasOperationalDaysInterface',
    'SimpleOperationalDays',
    'SimpleOperationalDaysConfigurator',
]);

// Example

class FakeWarehouseThatWorksMonToSat implements HasOperationalDaysInterface {

    /**
     * @implements HasOperationalDaysInterface::getOperationalDays()
     */
    public function getOperationalDays(DateTimeInterface $obj_until, DateTimeInterface $obj_since = null) {
        return SimpleOperationalDaysConfigurator::get()
            ->setDateRange($obj_until, $obj_since)
            ->setRecurrentWeeklyPattern(
                OperationalDaysEnum::BF_WEEKDAY|OperationalDaysEnum::BF_SAT
            )
            ->setNonOperationalDates([
                '2018-08-29',
                new DateTimeImmutable('2018-12-25'),
                'next wednesday + 7 days'
            ])
            ->addOperationalDate(new DateTimeImmutable('next sunday + 7 days'))
            ->create();
    }
}

$obj_warehouse = new FakeWarehouseThatWorksMonToSat();
$obj_days      = $obj_warehouse->getOperationalDays(new DateTimeImmutable('2019-01-01T00:00:00+00:00'));

print_r($obj_days);

$arr_test_dates = [
    'next monday',
    'next tuesday',
    'next wednesday',
    'next thursday',
    'next friday',
    'next saturday',
    'next sunday',
    'next monday + 7 days',
    'next tuesday + 7 days',
    'next wednesday + 7 days',
    'next thursday + 7 days',
    'next friday + 7 days',
    'next saturday + 7 days',
    'next sunday + 7 days',
    '2018-08-29',
    '2018-12-25'
];

foreach ($arr_test_dates as $str_date) {
    $obj_date = new DateTimeImmutable($str_date);
    echo
        "Testing ", $str_date,
        "\n\t(", $obj_date->format('Y-m-d'),
        ") : ", ($obj_days->isOperationalDate($obj_date) ? "True" : "False"),
        "\n\n";
}
