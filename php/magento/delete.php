<?php

set_time_limit(0);

$directories = array("app", "downloader", "errors", "js", 
                     "lib", "media", "skin", "pkginfo", 
                      "includes","shell", "var/cache");

foreach ($directories as $directory) {
    $myDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . $directory;
    $result = @unlinkRecursive($myDir, TRUE);
    echo $result;
}

function unlinkRecursive($dir, $deleteRootToo) {
    if (!$dh = @opendir($dir)) {
        return "$dir this is not a directy \n";
    }
    while (false !== ($obj = readdir($dh))) {
        if ($obj == '.' || $obj == '..') {
            continue;
        }
        if (!@unlink($dir . '/' . $obj)) {
            unlinkRecursive($dir . '/' . $obj, true);
        }
    }
    closedir($dh);
    if ($deleteRootToo) {
        @rmdir($dir);
    }
    return "sucessfully  \n";
}

