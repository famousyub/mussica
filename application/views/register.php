<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-6 offset-md-3 text-center">
                <h1 class="mb-3">Register</h1>
                <?php if(isset($success) && $success): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success">
                                Registiration completed successfuly <br>
                                <a href="<?=base_url()?>">Home</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?=validation_errors()?>
                    <?=form_open(base_url('home/register'))?>

                        <div class="form-group">
                            <input type="text" class="form-control" id="first_name" required name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="last_name" required name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>">
                        </div>

                        <div class="form-group">
                            <textarea type="text" class="form-control" id="address" required name="address" placeholder="Address" value="<?= set_value('address') ?>"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" id="email" required name="email" placeholder="Email" value="<?= set_value('email') ?>">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" required name="password" placeholder="Password" value="<?= set_value('password') ?>">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="passconf" required name="passconf" placeholder="Password Confirm" value="<?= set_value('password') ?>">
                        </div>

                        <button type="submit" class="btn btn-block btn-primary">Register</button>
                    <?=form_close() ?>
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <a class="mt-4 text-succes" href="<?=base_url('home/login')?>"> Back to login </a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>