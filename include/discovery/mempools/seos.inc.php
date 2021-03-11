<?php

if ($device['os'] == 'seos') {
    echo 'SmartEdge(SSR): ';

    $used  = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.4.1', '-OvQ');
    $free  = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.3.1', '-OvQ');
    $units = 1024;
    $used = $used * $units;
    $free = $free * $units;
    $total = ($free + $used);
    $percent = ($used / $total * 100);

    if (is_numeric($total) && is_numeric($used)) {
        discover_mempool($valid_mempool, $device, 0, 'seos', 'Memory', '1', null, null);
    }
}
