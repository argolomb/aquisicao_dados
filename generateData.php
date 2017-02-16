<?php

echo json_encode(['action' => 'serialAvailable', 'data' => ['com1', 'com2', 'tty/tl']]).PHP_EOL;

while (true) {
    $data = [];
    $sensor1 = [];
    $sensor2 = [];
    $sensor3 = [];
    $sensor1['sensorId'] = 1;
    $sensor1['timestamp'] = (new DateTime('now', new DateTimeZone('UTC')))->getTimestamp()*1000;
    $sensor1['value'] = rand(0, 10);
    $data[] = $sensor1;
    echo json_encode(['action' => 'serialRead', 'data' => $data]).PHP_EOL;
    usleep(2000000);
}