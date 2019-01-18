<?php include ROOT.'/views/layouts/header.php'?>

    <section id="form"><!--form-->
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <?php if ($result): ?>
                        <p>Данные отредактированы!</p>
                    <?php else: ?>
                        <?php if (isset($errors) && is_array($errors)): ?>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li> - <?php $error?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="signup-form"><!--sign up form-->
                            <h2>Редактирование данных</h2>
                            <form action="#" method="post">
                                <p>Имя:</p>
                                <input type="text" name="name" placeholder="Имя" value="<?php $name?>"/>

                                <p>Пароль:</p>
                                <input type="password" name="password" placeholder="Пароль" value="<?php $password?>"/>
                                <br>
                                <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                            </form>
                        </div><!--/sign up form-->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php'?>