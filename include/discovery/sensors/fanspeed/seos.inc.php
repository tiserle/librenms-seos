<?php

/*
 * LibreNMS Ericsson SSR Fanspeeds information module
 *
 * Copyright (c) 2021 Kuang-Li Ting <tiserle@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */


echo 'SmartEdge(SSR): ';
$fans_descr = snmpwalk_cache_multi_oid($device, 'rbnFanUnitDescr', [], 'RBN-ENVMON-MIB');
$fans_speed = snmpwalk_cache_multi_oid($device, 'rbnFanSpeedCurrent', [], 'RBN-ENVMON-MIB');

if (is_array($fans_speed) && !empty($fans_speed)) {
    foreach ($fans_speed as $index => $entry) {
        $fan_serial = $fans_descr[$index]["rbnFanUnitDescr"];
        $fan_speed = $fans_speed[$index]["rbnFanSpeedCurrent"];
        $oid = '.1.3.6.1.4.1.2352.2.4.1.5.1.3';
        $oid = $oid .".$index";
        if ($fan_speed) {
            discover_sensor($valid['sensor'], 'fanspeed', $device, $oid, $index, 'snmp', $fan_serial, '1', '1', null, null, null, null, $fan_speed);
        }

    }
}

unset(
    $fans_descr,
    $fans_speed
);
