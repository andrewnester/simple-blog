<?php include_once __DIR__ . '/header.php'; ?>

<?php if(count($posts) === 0): ?>
    <div class="row text-center">
        <div class="col-lg-12">
            There is no posts found. Please create one.
        </div>
    </div>
<?php endif; ?>

<?php foreach($posts as $post): ?>
<div class="row">
    <div class="col-lg-12">
        <h2>
            <a href="./posts/<?= $post->getAttribute('id'); ?>">
                <?= $post->getAttribute('title'); ?>
            </a>
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <?= $post->getAttribute('body'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                Created: <?= $post->getAttribute('created'); ?>
            </div>
            <div class="col-lg-4">
                Updated: <?= $post->getAttribute('updated'); ?>
            </div>
            <div class="col-lg-4">
                <form action="/posts/<?= $post->getAttribute('id') ?>/delete" method="POST">
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<div class="row">
    <div class="col-lg-12">
        <a href="./posts/create" class="btn btn-success">Create New Post</a>
    </div>
</div>

<?php include_once __DIR__ . '/footer.php'; ?>
