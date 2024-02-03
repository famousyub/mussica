<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <br>
                <h1> My Profile</h1>
                <br>
                <?=validation_errors()?>
                <?=form_open(base_url('home/profile/'.$user->id))?>

                    <div class="form-group">
                    <label for="firs_name">First name</label>
                        <input type="text" class="form-control" id="first_name" required name="first_name" placeholder="First Name" value="<?= set_value('first_name', $user->first_name) ?>">
                    </div>
                    <div class="form-group">
                    <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" required name="last_name" placeholder="Last Name" value="<?= set_value('last_name', $user->last_name) ?>">
                    </div>

                    <div class="form-group">
                    <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" required name="address" placeholder="Address" value="<?= set_value('address', $user->address) ?>"></input>
                    </div>

                    <div class="form-group">
                    <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" required name="email" placeholder="Email" value="<?= set_value('email', $user->email) ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password"  name="password" placeholder="Password" value="<?= set_value('password') ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                <?=form_close() ?>
            </div>
        </div>
    </div>