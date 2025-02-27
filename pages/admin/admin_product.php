<?php
require '../../_base.php';

$title='Product';
// $stylesheetArray = [];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
// $scriptArray = [];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>

<?php
for ($i = 1; $i <= 3000; $i++) {
    echo "<div>$i time(s)</div>";
}
?>


<?php 
include '../../admin_foot.php';
?>

