<?php
require_once "./app/src/datastore.php";
use App\DataStore;

$title = "Home";
$content = "home";
$data = $data ?? [];

$datastore = new DataStore();
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
        <?php $frogs = $datastore->get_frogs()?>
        <?php for($i = 0; $i !== 4; $i++): ?>
            <div class='card'>
                <img src='/app/static/assets/broken_image.png' alt='<?= $frogs[$i]["image_description"] ?? "An error occured while getting the image description" ?>' class='card_image'>
                <div class="card_content">
                    <h3><?= $frogs[$i]["title"] ?? "Err" ?></h3>
                    <p><?= $frogs[$i]["content"] ?? "Err" ?></p>
                    <a href="/content/article?exec_action=view&id=<?= $frogs[$i]["id"] ?>" class="button">View</a>
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
            <img src='/app/static/assets/broken_image.png' alt='' class='card_image'>
            <div class="card_content">
                <h3>Frog Name</h3>
                <p>A tiny description goes here, about this frog.</p>
                <a href="/content/articles" class="button">View</a>
            </div>
        </div>
        <div>
            <p>Total frogs in the system: <?= $datastore->get_frog_count() ?></p>
            <p>Last updated: 11/06/2026</p>
        </div>
    </div>
</section>

<?php
include __DIR__."/../static/templates/page_end.php";
?>