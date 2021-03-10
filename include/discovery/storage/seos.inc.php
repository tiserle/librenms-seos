<?php

if ($device['os'] == 'seos') {
    $dsktable_array = snmpwalk_cache_oid($device, 'rbnSRStorageDescr', null, 'RBN-SYS-RESOURCES-MIB'); 
    foreach($dsktable_array as $key => $line)
    {
     if(preg_match("/Var Disk/",$line[rbnSRStorageDescr]))
     {
      $disk = $key;
     }
    }
    $fstype = snmp_get($device, "rbnSRStorageMedia.$disk", '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $descr = snmp_get($device, "rbnSRStorageDescr.$disk", '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $units  = 1024;
    $percent = snmp_get($device, "rbnSRStorageUtilization.$disk", '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $total = snmp_get($device, "rbnSRStorageSize.$disk", '-OQUsnv', 'RBN-SYS-RESOURCES-MIB') * $units;
    $used = $total * $percent / 100;  
    $free = $total - $used;
    $index = 0;
    if (is_numeric($free) && is_numeric($total)) {
        discover_storage($valid_storage, $device, $index, $fstype, 'seos', $descr, $total, $units, $used);
    }
}
