<?php

// Simple hard-coded poller for SmartEdge

echo 'SmartEdge(SSR) MemPool'.'\n';
$used = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.4.1', '-OvQ');
$user = $used * 1000;
$free = snmp_get($device, '.1.3.6.1.4.1.2352.2.16.1.2.1.3.1', '-OvQ');
$free = $free * 1000;
$mempool['total'] = ($free + $used);
$mempool['free']  = $free;
$mempool['used']  = $used;

