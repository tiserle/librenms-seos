<?php
/*
 * Copyright (c) 2017 Dave Bell <me@geordish.org>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */
if ($device['os'] == 'seos') {
    $fstype = snmp_get($device, 'rbnSRStorageMedia.41', '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $descr = snmp_get($device, 'rbnSRStorageDescr.41', '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $units  = 1024;
    $index = 0;
    $percent = snmp_get($device, 'rbnSRStorageUtilization.41', '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $total = snmp_get($device, 'rbnSRStorageSize.41', '-OQUsnv', 'RBN-SYS-RESOURCES-MIB') * $units;
    $used = $total * $percent / 100;  
    $free = $total - $used;
    //echo "$total, $used";
    if (is_numeric($free) && is_numeric($total)) {
        discover_storage($valid_storage, $device, $index, $fstype, 'seos', $descr, $total, $units, $used);
    }
}
