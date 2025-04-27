<?php
require '_base.php';

$title = 'Home';
include '_head.php';
?>

<section class="slideshow">
    <!-- <img src="assets/img/badminton-player.jpg" alt="Photo of a badminton player" /> -->
    <div class="caption">
        <h1>Bold. Energetic. Swift.</h1>
        <h2>Badminton will never be the same again.</h2>
    </div>
</section>
<section class="main-section">
    <h1> Categories </h1>
    <div class="categories">
        <div class="categ-black"><a href="/pages/product/searchResult.php?search=AeroSharp">AeroSharp</a></div>
        <div class="categ-gray"><a href="/pages/product/searchResult.php?search=Phantom">Phantom</a></div>
        <div class="categ-black"><a href="/pages/product/searchResult.php?search=Shadow">Shadow</a></div>
        <div class="categ-gray"><a href="/pages/product/searchResult.php?search=TurboSmash">TurboSmash</a></div>
        <div class="categ-black"><a href="/pages/product/searchResult.php?search=ThunderStrike">ThunderStrike</a></div>
    </div>
    
</section>

<?php
include '_foot.php';