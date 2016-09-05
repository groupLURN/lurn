<?php

$this->assign('title', 'Sign-in!');
$this->Html->scriptStart(['block' => 'script-inline', 'safe' => false]);

$imageUrl = $this->Url->image('login-bg.jpg');
echo '$.backstretch("'.$imageUrl.'", {speed: 500})';
$this->Html->scriptEnd();

?>

<div id="login-page">
    <div class="container">
        <?= $this->Form->create(null, ['class' => 'form-login']); ?>
            <h2 class="form-login-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
                <br>
                <input type="password" name="password" class="form-control" placeholder="Password">
                <hr>
                <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
            </div>

        <?= $this->Form->end(); ?>

    </div>
</div>