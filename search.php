<?php
require 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

$company = strtolower(readline("Enter company: "));
$url = "https://data.gov.lv/dati/lv/api/3/action/datastore_search?q=$company&resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9&limit=10";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$data = json_decode($output, true);
$output = new ConsoleOutput();
if (!empty($data["result"]["records"])) {
    $table = new Table($output);
    $table->setHeaders(["ID", "Name", "Address"]);
    foreach ($data["result"]["records"] as $record) {
        $table->addRow([$record["_id"], $record["name"], $record["address"]]);
    }
    $table->setStyle('borderless');
    $table->render();
} else {
    echo "No results found" . PHP_EOL;
}

