<?php $this->layout('layout') ;?>
<section class="hero is-dark">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Восстановление пароля.
            </h1>
            <h2 class="subtitle">
                Письмо придет вам на почту.
            </h2>
        </div>
    </div>
</section>
<div class="container main-content">
    <div class="columns">
        <div class="column"></div>
            <form action="" method="post">
                <?= flash();?>
                <div class="column is-quarter auth-form">

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="email" name="email" >  <!-- is-danger -->
                            <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                            <!-- <span class="icon is-small is-right">
                              <i class="fas fa-exclamation-triangle"></i>
                            </span> -->
                        </div>
                        <!-- <p class="help is-danger">This email is invalid</p> -->
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link" type="submit">Отправить</button>
                        </div>
                        <div class="control">
                            <a class="button is-text" href="/">Отмена</a>
                        </div>
                    </div>
                    <div class="field">
                        <p>Нет аккаунта? <b><a href="/register">Регистрация</a></b></p>
                        <p>Не пришло письмо подтверждения? <b><a href="/verify_email">Переотправить</a></b></p>
                    </div>
                </div>
            </form>
        <div class="column"></div>
    </div>
</div>
