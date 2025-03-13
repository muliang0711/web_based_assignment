<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Template';
$stylesheetArray = ['example.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['example.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


$array = [1,2,3,4,5];

include '../../_head.php';
?>


<!-- Your main content starts here -->

<h1>Hi, developer 👋</h1>
<p>This is a template. To start coding your page with the same header and footer as this template page, copy the entire text of this php file (but don't delete it so other developers can use it too), paste it into your blank new file, remove these text in your new file and start coding!</p>
<p>Before you start, please read this php file properly. I've included comments so you know what should be placed where.</p>
<p>You might encounter difficulties when you copy and paste your original code here without some modification. You will likely need to modify your original styling (and even a little bit of your structure) to make sure it fits nicely in this environment. Whatever you put in here is <b>actually wrapped by a <code>&lt;main&gt;</code> element</b>, which contains styling of its own (defined in <code>/css/app.css</code>). You <i>can</i> override these stylings (e.g. using <code>margin: -100px;</code> on an element to override the left and right paddings of <code>&lt;main&gt;</code>).</i></p>
<p>这是一个模板。为了在您的页面中使用与此模板相同的 header 和 footer，复制此 PHP 文件的所有文本（但请不要删除它，以便其他开发人员也可以使用），将其粘贴到您的新文件中，删除新文件中的这些文字，然后开始编写代码！</p>
<p>开始编码之前，请先好好读过此 php 文件一遍。我加入了 comments 引导大家在对的位子放对的 code。</p>
<p>当您将您已写好的代码搬到此处时，可能会遇到一些 bug。您可能需要修改原本的 CSS（甚至稍微调整一下结构），以确保它能够在此环境中良好展示。请注意，您在此处编写的内容实际上<b>被包含在一个 <code>&lt;main&gt;</code> 元素中</b>，这个元素本身已有自己的 CSS（定义在 <code>/css/app.css</code> 中）。若有需要，您可以覆盖这些 CSS 以适应您的需求（比如使用 <code>margin: -100px;</code> 让一个 element 不受 <code>&lt;main&gt;</code> 已有的 left padding 和 right padding 影响）。</p>


<?php foreach($array as $number): ?>
    <?php if ($number > 3): ?>
        <p>Number is <?= $number ?></p>
    <?php endif ?>
<?php endforeach ?>


<!-- Your main content ends here -->


<?php
include '../../_foot.php';