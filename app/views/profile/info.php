<?php $this->layout('layout') ;?>
<div class="container main-content">

    <div class="columns">
        <div class="column">
            <div class="tabs is-centered pt-100">
                <ul>
                    <li class="is-active">
                        <a href="/profile/info">
                            <span class="icon is-small"><i class="fas fa-user"></i></span>
                            <span>Основная информация</span>
                        </a>
                    </li>
                    <li>
                        <a href="/profile/security">
                            <span class="icon is-small"><i class="fas fa-lock"></i></span>
                            <span>Безопасность</span>
                        </a>
                    </li>
                </ul>

            </div>
            <div class="is-clearfix"></div>
            <div class="columns is-centered">
                <div class="column is-half">
                    <?= flash();?>
                    <form action="/profile/info" method="post" enctype="multipart/form-data">
                        <div class="field">
                            <label class="label">Avatar</label>
                            <img src="<?= '/public/' . $image?>" alt="" width="250"><br><br>
                            <input class="input" type="file" name="image">
                        </div>

                        <div class="field">
                            <label class="label">Ваше имя</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="text" name="username" value="<?= $info['username']?>">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="text" name="email" value="<?= $info['email']?>">
                                <span class="icon is-small is-left">
                              <i class="fas fa-user"></i>
                            </span>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-link" type="submit">Обновить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>