<?php
require_once "./app/src/datastore.php";
use App\DataStore;
use const App\DIRECTORY;

$title = "Home";
$content = "home";
$data = $data ?? [];

$datastore = new DataStore();
include __DIR__."/../static/templates/page_start.php";
?>

<section>
    <p>Welcome to FrogInfo, a small website of curated frog related information.</p>
    <p>Fun fact: <span style="color: var(--primary-color);">Wood frogs can freeze solid in winter and survive, then “wake up” when they thaw in spring.</span></p>
    <br>
    <h2>Search</h2>
    <form class="search_form" action="" method="get">
        <input type="hidden" name="exec_action" value="search">
        <label for="searchbar" class="sr_only">Search frogs</label>
        <input class="textbox" type="search" name="searchbar" placeholder="Try: poison dart frog" value="<?= htmlspecialchars($data["search_query"] ?? "") ?>">
        <input class="button" type="submit" value="Search">
    </form>
</section>
<?php if ($data && !$data["found_result"]): ?>
    <hr class="separator">
    <p>No results found :(</p>
<?php endif; ?>
<?php if ($data && $data["found_result"]): ?>
    <hr class="separator">
    <h2>Search Results</h2>
    <section class="featured_cards">
        <?php foreach($data["result"] as $frog): ?>
            <div class='card'>
                <img src='<?= $frog["image"] ?? (DIRECTORY."/app/static/assets/broken_image.png") ?>' alt='<?= $frog["image_description"] ?? "Failed to load image description" ?>' class='card_image'>
                <div class="card_content">
                    <h3><?= $frog["title"] ?? "ERR" ?></h3>
                    <p><?= $frog["description"] ?? "ERR" ?></p>
                    <a aria-label="View article about <?= $frog["title"] ?? "ERR" ?>" href="<?= DIRECTORY ?>/content/article?exec_action=view&id=<?= $frog["id"] ?? "" ?>" class="button">View</a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<hr class="separator">
<section>
    <h2>Featured Frogs</h2>
    <div class="featured_cards">
        <?php 
            $frogs = $datastore->get_frogs();
            shuffle($frogs);
        ?>
        <?php for($i = 0; $i !== 4; $i++): ?>
            <div class='card'>
                <img src='<?= $frogs[$i]["image"] ?? (DIRECTORY."/app/static/assets/broken_image.png") ?>' alt='<?= $frogs[$i]["image_description"] ?? "An error occured while getting the image description" ?>' class='card_image'>
                <div class="card_content">
                    <h3><?= $frogs[$i]["title"] ?? "Err" ?></h3>
                    <p><?= $frogs[$i]["content"] ?? "Err" ?></p>
                    <a aria-label="View article about <?= $frog["title"] ?? "ERR" ?>" href="<?= DIRECTORY ?>/content/article?exec_action=view&id=<?= $frogs[$i]["id"] ?? "" ?>" class="button">View</a>
                </div>
            </div>
        <?php endfor;?>
    </div>
</section>
<hr class="separator">
<h2>A Cool Video</h2>
<iframe src="https://www.youtube.com/embed/4z8kJFcmhKc" title="Frog Song: The World of Amphibians - Full Documentary" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>

<hr class="separator">
<section>
    <h2>Frogstistics</h2>
    <div class="frogstistics">
        <div class='card'>
            <?php $popular_frog = $datastore->get_popular_frog()?>
            <img src='<?= $popular_frog["image"] ?? (DIRECTORY."/app/static/assets/broken_image.png") ?>' alt='<?= $popular_frog["image_description"] ?? "Failed to load image description" ?>' class='card_image'>
            <div class="card_content">
                <h3><?= $popular_frog["title"] ?? "ERR" ?></h3>
                <p><?= $popular_frog["description"] ?? "ERR" ?></p>
                <a aria-label="View article about <?= $frog["title"] ?? "ERR" ?>" href="<?= DIRECTORY ?>/content/article?exec_action=view&id=<?= $popular_frog["id"] ?? "" ?>" class="button">View</a>
            </div>
        </div>
        <div>
            <p>Total frogs in the system: <?= $datastore->get_frog_count() ?></p>
            <p>The top frog has been viewed: <?= $popular_frog["viewed_count"] ?? 0 ?> times</p>
            <p>Last updated: 12/06/2026</p> 
        </div>
    </div>
</section>

<?php
include __DIR__."/../static/templates/page_end.php";
?>