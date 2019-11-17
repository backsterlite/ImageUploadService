<?php $this->layout('layout') ;?>

<section class="hero is-medium is-primary is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Самые минималистичные и элегантные обои для вашего рабочего стола!
            </h1>
            <h2 class="subtitle">
                Настроение и вдохновение в одном кадре.
            </h2>
        </div>
    </div>
</section>
<section class="section main-content">
    <div class="container">
        <div class="columns  is-multiline">
            <?php foreach($photos as $photo): ?>
            <div class="column is-one-quarter">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <a href="/photos/<?= $photo['id']?>">
                                <img src="<?php echo config('uploadsFolder') . $photo['image'] ?>" alt="Placeholder image" width="300">
                            </a>
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <p class="title is-5"><a href="/category/<?= $photo['category_id']?>"><?= getCategory($photo['category_id'])['title']?></a></p>
                            </div>
                            <div class="media-right">
                                <p  class="is-size-7">Размер: <?= $photo['dimensions']?></p>
                                <time datetime="2016-1-1" class="is-size-7">Добавлено: <?= date("d/m/Y",strtotime($photo['date']));?></time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

