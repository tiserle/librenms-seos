<?php

if ($device['os'] == 'seos') {
    echo 'SmartEdge(SSR): ';

    $used  = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.4.1', '-OvQ');
    $free  = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.3.1', '-OvQ');
    $used = $used * 1000;
    $free = $free * 1000;
    $total = ($free + $used);
    $percent = ($used / $total * 100);
    //echo "used:$used free:$free :total:$total percent:$percent";

    if (is_numeric($total) && is_numeric($used)) {
        discover_mempool($valid_mempool, $device, 0, 'seos', 'Memory', '1', null, null);
    }
}
