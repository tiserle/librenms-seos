<?php

echo 'SmartEdge(SSR): ';

// Fan Tray 1
$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2.1';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3.1';
$temp_descr = snmpwalk_cache_numerical_oid($device, $fan_descr_oid, [], null, null, '-OQUsn');
$temp_speed = snmpwalk_cache_numerical_oid($device, $fan_speed_oid, [], null, null, '-OQUsn');

// Fan Tray 2
$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2.2';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3.2';
$fans_descr = snmpwalk_cache_numerical_oid($device, $fan_descr_oid, [], null, null, '-OQUsn');
$fans_speed = snmpwalk_cache_numerical_oid($device, $fan_speed_oid, [], null, null, '-OQUsn');

$fans_descr = array_merge($temp_descr, $fans_descr);
$fans_speed = array_merge($temp_speed, $fans_speed);

$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3';

$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3';

if (is_array($fans_speed) && !empty($fans_speed)) {
    foreach ($fans_speed as $index => $entry) {
        $leading = floor($index/7)+1;
        $remainder = $index%7;
        $append = $leading.".".$remainder;
        $oid = $fan_speed_oid . '.' . $append;
        $fan_oid = $fan_descr_oid . '.' . $append;
        $fan_speed = $entry[$oid];
        $fan_serial = $fans_descr[$index][$fan_oid];
        if ($fan_speed) {
            discover_sensor($valid['sensor'], 'fanspeed', $device, $oid, $index, 'snmp', $fan_serial, '1', '1', null, null, null, null, $fan_speed);
        }

    }
}

unset(
    $fans_descr,
    $fans_speed
);
