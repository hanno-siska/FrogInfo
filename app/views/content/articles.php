<?php
require_once "./app/src/datastore.php";
use App\DataStore;

$title = "Articles";
$content = "articles";

$datastore = new DataStore();
include __DIR__."/../../static/templates/page_start.php";
?>

<section>
    <p>Welcome to the frog articles page, we hope you find what you're looking for.</p>
</section>

<hr class="separator">
<h2>Top 4 Frogs</h2>
<section class="top_frogs">
    <?php foreach($datastore->get_popular_frog(false) as $frog): ?>
        <div class='card'>
            <img src='<?= $frog["image"] ?? "/app/static/assets/broken_image.png" ?>' alt='<?= $frog["image_description"] ?? "Failed to load image description" ?>' class='card_image'>
            <div class="card_content">
                <h3><?= $frog["title"] ?? "ERR" ?></h3>
                <p><?= $frog["description"] ?? "ERR" ?></p>
                <a href="/content/article?exec_action=view&id=<?= $frog["id"] ?? "" ?>" class="button">View</a>
            </div>
        </div>
    <?php endforeach;?>
</section>

<hr class="separator">
<h2>All Available Articles</h2>
<section class="top_frogs">
    <?php foreach($datastore->get_frogs() as $frog): ?>
        <div class='card'>
            <img src='<?= $frog["image"] ?? "/app/static/assets/broken_image.png" ?>' alt='<?= $frog["image_description"] ?? "Failed to load image description" ?>' class='card_image'>
            <div class="card_content">
                <h3><?= $frog["title"] ?? "ERR" ?></h3>
                <p><?= $frog["description"] ?? "ERR" ?></p>
                <a href="/content/article?exec_action=view&id=<?= $frog["id"] ?? "" ?>" class="button">View</a>
            </div>
        </div>
    <?php endforeach;?>
</section>
<hr class="separator">
<p>Seems you've reached the end.</p>

<?php
include __DIR__."/../../static/templates/page_end.php";
?>