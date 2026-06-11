<?php
$title = "Home";
$content = "home";
$data = $data ?? [];
include __DIR__."/../static/templates/page_start.php";
?>

<section>
    <p>Welcome to FrogInfo, a small website of curated frog related information.</p>
    <p>Fun frog fact of the day: <span style="color: var(--primary-color);">(insert frog fact)</span></p>
    <br>
    <h2>Search</h2>
    <form class="search_form" action="" method="get">
        <input type="hidden" name="exec_action" value="search">
        <input class="textbox" type="search" name="searchbar" placeholder="Try: poison dart frog" value="<?= htmlspecialchars($data["search_query"] ?? "") ?>">
        <input class="button" type="submit" value="Search">
    </form>
</section>
<?php if ($data ?? [] && !$data["found_result"]): ?>
    <hr class="separator">
    <p>No results found :(</p>
<?php endif; ?>

<hr class="separator">
<section>
    <h2>Featured Frogs</h2>
    <div class="featured_cards">
        <?php for($i = 0; $i !== 4; $i++): ?>
            <div class='card'>
                <img src='/app/static/assets/frog_background.webp' alt='' class='card_image'>
                <div class="card_content">
                    <h3>Frog Name</h3>
                    <p>A tiny description goes here, about this frog.</p>
                </div>
            </div>
        <?php endfor;?>
    </div>
</section>
<hr class="separator">
<section>
    <h2>Frogstistics</h2>
    <div class="frogstistics">
        <div class='card'>
            <img src='/app/static/assets/frog_background.webp' alt='' class='card_image'>
            <div class="card_content">
                <h3>Frog Name</h3>
                <p>A tiny description goes here, about this frog.</p>
            </div>
        </div>
        <div>
            <p>Total frogs in the system: 0</p>
            <p>Last updated: 11/06/2026</p>
        </div>
    </div>
</section>

<?php
include __DIR__."/../static/templates/page_end.php";
?>