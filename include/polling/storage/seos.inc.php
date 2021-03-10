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
    $storage['units'] = 1024;
    $storage['size'] = snmp_get($device, 'rbnSRStorageSize.41', '-OQUsnv', 'RBN-SYS-RESOURCES-MIB') * $storage['units'];
    $percent = snmp_get($device, 'rbnSRStorageUtilization.41', '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $storage['used'] = $storage['size'] * $percent / 100;
    $storage['free'] = $storage['size'] - $storage['used'];
}
