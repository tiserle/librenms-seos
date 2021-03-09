<?php
/*
 * LibreNMS QNAP NAS Fanspeeds information module
 *
 * Copyright (c) 2016 Cercel Valentin <crc@nuamchefazi.ro>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

echo 'SmartEdge(SSR): ';

$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2.1';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3.1';

$fans_descr = snmpwalk_cache_numerical_oid($device, $fan_descr_oid, [], null, null, '-OQUsn');
$fans_speed = snmpwalk_cache_numerical_oid($device, $fan_speed_oid, [], null, null, '-OQUsn');

if (is_array($fans_speed) && !empty($fans_speed)) {
    foreach ($fans_speed as $index => $entry) {
        $tmp = $fan_speed_oid . '.' . $index;
        $oid[] = $fan_speed_oid . '.' . $index;
        $fan_oid = $fan_descr_oid . '.' . $index;
        $fan_speed[] = $entry[$tmp];
        $fan_serial[] = $fans_descr[$index][$fan_oid];
	$temp[] = $index;
    }
}

$fan_descr_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.2.2';
$fan_speed_oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3.2';

$fans_descr = snmpwalk_cache_numerical_oid($device, $fan_descr_oid, [], null, null, '-OQUsn');
$fans_speed = snmpwalk_cache_numerical_oid($device, $fan_speed_oid, [], null, null, '-OQUsn');

if (is_array($fans_speed) && !empty($fans_speed)) {
    foreach ($fans_speed as $index => $entry) {
        $tmp = $fan_speed_oid . '.' . $index;
        $oid[] = $fan_speed_oid . '.' . $index;
        $fan_oid = $fan_descr_oid . '.' . $index;
        $fan_speed[] = $entry[$tmp];
        $fan_serial[] = $fans_descr[$index][$fan_oid];
	$temp[] = $index+7;
    }
}
/*
print_r($oid);
print_r($fan_speed);
print_r($fan_serial);
print_r($temp);
*/
$count = count($oid);
for($i=0;$i<$count;$i++)
{
 discover_sensor($valid['sensor'], 'fanspeed', $device, $oid[$i], $temp[$i], 'snmp', $fan_serial[$i], '1', '1', null, null, null, null, $fan_speed[$i]);

}

unset(
    $fans_descr,
    $fans_speed
);
