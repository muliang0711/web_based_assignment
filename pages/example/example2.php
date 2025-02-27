<?php
require '../../_base.php';

$title = 'Example Page 2';
$stylesheetArray = ['style1.css', 'style2.css'];
$scriptArray = ['product.js'];

include '../../_head.php';
?>

<h1>Hi 👋</h1>
<p>I am a paragraph.</p>
<br>
<p>Tip: Use the Inspector tool (<code>Ctrl + Shift + I</code> in Chrome) to see which stylesheet &lt;link&gt; elements have been added in the &lt;head&gt;.</p>

<?php
include '../../_foot.php';