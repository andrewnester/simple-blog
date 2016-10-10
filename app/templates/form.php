<?php include_once __DIR__ . '/header.php'; ?>
<form method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= isset($post) ? $post->getAttribute('title') : ''; ?>">
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" id="body" name="body"><?= isset($post) ? $post->getAttribute('body') : ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-default">Save</button>
</form>

<?php include_once __DIR__ . '/footer.php'; ?>
