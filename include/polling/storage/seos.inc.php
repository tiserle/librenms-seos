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
    $storage['units'] = 1024;
    $storage['size'] = snmp_get($device, "rbnSRStorageSize.$disk", '-OQUsnv', 'RBN-SYS-RESOURCES-MIB') * $storage['units'];
    $percent = snmp_get($device, "rbnSRStorageUtilization.$disk", '-OvQ', 'RBN-SYS-RESOURCES-MIB');
    $storage['used'] = $storage['size'] * $percent / 100;
    $storage['free'] = $storage['size'] - $storage['used'];
}
