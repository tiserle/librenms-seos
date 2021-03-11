<?php

// Simple hard-coded poller for SmartEdge

echo 'SmartEdge(SSR) MemPool'.'\n';
$used = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.4.1', '-OvQ');
$free = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.3.1', '-OvQ');
$units = 1024;
$used = $used * $units;
$free = $free * $units;
$mempool['total'] = ($free + $used);
$mempool['free']  = $free;
$mempool['used']  = $used;

