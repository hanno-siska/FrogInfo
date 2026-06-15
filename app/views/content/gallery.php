<?php
require_once "./app/src/datastore.php";
use App\DataStore;
use const App\DIRECTORY;

$title = "Gallery";
$content = "gallery";

$datastore = new DataStore();
include __DIR__."/../../static/templates/page_start.php";
?>

<section>
    <p>Welcome to the frog gallery, feel free to look around and you might find a frog you like.</p>
    <br>
    <h2>Frog Gallery</h2>
</section>

<hr class="separator">
<section class="gallery_images">
    <?php foreach($datastore->get_images() as $frog): ?>
        <form action="<?= DIRECTORY ?>/content/article" method="get" class="card">
            <input type="hidden" name="exec_action" value="view">
            <input type="hidden" name="id" value="<?= $frog["id"] ?? "" ?>">
            <button aria-label="View article about <?= $frog["title"] ?? "ERR" ?>" type="submit" class="image_button">
                <img src="<?= $frog["image"] ?? (DIRECTORY."/app/static/assets/broken_image.png") ?>" alt="<?= $frog["image_description"] ?? "Image description failed to load" ?>" class="card_image" loading="lazy">
            </button>
        </form>
    <?php endforeach;?>
</section>
<hr class="separator">
<p>Seems you've reached the end.</p>

<?php
include __DIR__."/../../static/templates/page_end.php";
?>