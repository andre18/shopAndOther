<?php include ROOT.'/views/layouts/header.php'?>

    <section id="form"><!--form-->
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <? if ($result): ?>
                        <p>Данные отредактированы!</p>
                    <? else: ?>
                        <? if (isset($errors) && is_array($errors)): ?>
                            <ul>
                                <? foreach ($errors as $error): ?>
                                    <li> - <?=$error?></li>
                                <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                        <div class="signup-form"><!--sign up form-->
                            <h2>Редактирование данных</h2>
                            <form action="#" method="post">
                                <p>Имя:</p>
                                <input type="text" name="name" placeholder="Имя" value="<?=$name?>"/>

                                <p>Пароль:</p>
                                <input type="password" name="password" placeholder="Пароль" value="<?=$password?>"/>
                                <br>
                                <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                            </form>
                        </div><!--/sign up form-->
                    <? endif; ?>
                </div>
            </div>
        </div>
    </section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php'?>