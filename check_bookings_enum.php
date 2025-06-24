<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Show the status column enum values
$result = DB::select('SHOW COLUMNS FROM bookings WHERE Field = "status"');

echo "Status Column Details:\n";
print_r($result);

echo "\nAvailable Values for Status:\n";
if (!empty($result) && isset($result[0]->Type)) {
    preg_match('/enum\((.*)\)/', $result[0]->Type, $matches);
    if (!empty($matches[1])) {
        $values = str_getcsv($matches[1], ',', "'");
        print_r($values);
    }
}
