<?php
use const App\DIRECTORY;

$title = "Article";
$content = "article";
$data = $data ?? [];
include __DIR__."/../../static/templates/page_start.php";
?>

<?php if(($data["found_result"] ?? false)): ?>
    <section class="article_content">
        <div class="card">
            <img src='<?= $data["result"]["image"] ?? (DIRECTORY."/app/static/assets/broken_image.png") ?>' alt='<?= $data["result"]["image_description"] ?? "Failed to load image description" ?>' class='card_image'>
            <a href="<?= ($data["result"]["image_source"] ?? $data["result"]["image"]) ?? "/error" ?>" target="_blank">Image Source</a>
        </div>
        <div>
            <h2><?= $data["result"]["title"] ?? "Failed to load title" ?></h2>
            <hr class="separator">
            <p><?= $data["result"]["description"] ?? "Failed to load description" ?></p>
            <hr class="separator">
            <p><?= $data["result"]["content"] ?? "Failed to load content" ?></p>
        </div>
    </section>
<?php else:?>
    <p>Whoops, there's nothing here</p>
    <img src="<?= DIRECTORY ?>/app/static/assets/error_duck.webp" alt="A yellow duckling" width="128" height="128">
<?php endif; ?>

<?php
include __DIR__."/../../static/templates/page_end.php";
?>