<div class="container">
    <nav class="navbar is-transparent">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
            </a>
            <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div id="navbarExampleTransparentExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/">
                    Главная
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="category.html">
                        Категории
                    </a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item" href="category.html">
                            Природа
                        </a>
                        <a class="navbar-item" href="category.html">
                            Машины
                        </a>
                        <a class="navbar-item" href="category.html">
                            Дизайн и Интерьер
                        </a>
                        <a class="navbar-item" href="category.html">
                            Животные
                        </a>
                    </div>
                </div>
            </div>
            <?php if(auth()->isLoggedIn()) :?>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="button is-primary" href="login.html">
                      <span class="icon">
                        <i class="fas fa-upload"></i>
                      </span>
                                <span>Загрузить картинку</span>
                            </a>
                        </p>
                        <div class="account control">
                            <p>
                                Здравствуйте, <b><?= auth()->getUsername()?></b>
                            </p>
                        </div>
                        <p class="control">
                            <a class="button is-info" href="login.html">
                      <span class="icon">
                        <i class="fas fa-user"></i>
                      </span>
                                <span>Профиль</span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-dark" href="login.html">
                      <span class="icon">
                        <i class="fas fa-window-close"></i>
                      </span>
                                <span>Выйти</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="button is-link" href="/login">
                      <span class="icon">
                        <i class="fas fa-user"></i>
                      </span>
                                <span>Войти</span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-primary" href="/register">
                      <span class="icon">
                        <i class="fas fa-address-book"></i>
                      </span>
                                <span>Зарегистрироваться</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endif;?>

        </div>
    </nav>
</div>