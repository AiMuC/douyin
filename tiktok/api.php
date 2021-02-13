<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:16:07 
 * LastEditor:  AiMuC
 * ModifyTime:  2021/2/13 下午12:59:18
 * Description: 
*/
require('system/init.php');
switch ($_GET['type']) {
    case "dy":
        GetDyVideo($_GET['url'], $_GET['output']);
        break;
    default:
        break;
}
