<?php include ROOT.'/views/layouts/header.php'?>

    <section id="form"><!--form-->
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <? if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <? foreach ($errors as $error): ?>
                                <li> - <?=$error?></li>
                            <? endforeach; ?>
                        </ul>
                    <? endif; ?>
                    <div class="signup-form"><!--sign up form-->
                        <h2>Вход на сайт</h2>
                        <form action="#" method="post">
                            <input type="email" name="email" placeholder="E-mail" value="<?=$email?>"/>
                            <input type="password" name="password" placeholder="Пароль" value="<?=$password?>"/>
                            <input type="submit" name="submit" class="btn btn-default" value="Вход">
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php'?>