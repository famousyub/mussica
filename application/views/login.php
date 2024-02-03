<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-6 offset-md-3 text-center">
                <h1 class="mb-3">Login</h1>
                <?php if(isset($error)):?>
                    <div class="alert alert-danger"><?=$error?></div>
                <?php endif;?>
                <?=validation_errors()?>
                <?=form_open(base_url('home/login'))?>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" required name="email" placeholder="Please enter your email here" value="<?= set_value('email') ?>">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" required name="password" placeholder="Please enter your password here" value="<?= set_value('password') ?>">
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Enter</button>
                <?=form_close() ?>
                <div class="row">
                    <div class="col-12">
                        <br>

                        <a class="mt-4 text-succes" href="<?=base_url('register')?>"> Don't have an account?  Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>