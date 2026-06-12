<?php
$title = "About";
$content = "about";
include __DIR__."/../static/templates/page_start.php";
?>

<h2>About FrogInfo</h2>
<p>A small curated frog information site built under a 4-day deadline.</p>
<br>
<p>Yup I coded an average of 8h+ a day to finish this in time, since I procrastinated a bit too much and built smth else :)</p>
<hr class="separator">
<h2>Powered By</h2>
<div class="side_by_side">
    <img src="/app/static/assets/webruntime_icon.png" alt="WebRuntime, basically a box with a gear on a blue gradient and a nice shadow">
    <div>
        <h3>WebRuntime</h3>
        <p>Version: 0.1.1</p>
    </div>
    <br>
</div>
<br>
<p>Don't forget hopes and dreams too!</p>

<?php
include __DIR__."/../static/templates/page_end.php";
?>