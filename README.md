# Operational Days
Simple Operational Days Prototype

Theoretical usage pattern

```php

$obj_warehouse = new FakeWarehouseThatWorksMonToSat();

$obj_days = $obj_warehouse->getOperationalDays(
   new DateTimeImmutable('2019-01-01T00:00:00+00:00')
);
foreach($obj_days as $obj_date) {
   echo "Day is operational?" . $obj_date->isOperational();
}

// ===== SCRATCH

$obj_next_op_date = $obj_warehouse->getOperationalDays()->getNext(); // returns 24th Dec.

// Today is 24th December < 12:00 - we can dispatch today (result expected to be "24th Dec")
// Today is 25th December - expected result "27th Dec"
// Today is 24th December > 12:00, < 14:00 - we CANNOT dispatch today (result expected to be "27th Dec")

// DPD cut-off is 14:00
$obj_next_op_date->addOperationalDays(0);

// Parcelfarce cut-off is 12:00
$obj_next_op_date->addOperationalDays(1);


// DispatchDateCalculator implements HasOperationalDays
$obj_dd_calculator = new DispatchDateCalculator();

$obj_next_dpd_dispatch_date = $obj_dd_calculator->getFirstAvailable(
   
   new ShelfDate(new DateTimeImmutable),  // if the goods are available for picking NOW
   
   new CourierOperationalDaysAtHub(
      new Courier('DPD'),
      new CourierHubOperationalDays('DPD', 'Magsons'),
      new DateTimeImmutable,                 // This is for cut-off handling?
   )

   new WarehosueOperationalDays('Magsons')
);


new HubCourierDispatchDateOperationalDays(
  new Courier('DPD'),   
  new Warehouse('Magsons),
  new ShelfDate(new DateTimeImmutable),
  
);








```
