<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Users</h1>
            </div>
        </div>
        <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Level</th>
                        <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item):?>
                            <tr>
                            <th scope="row"><?=$item->id?></th>
                            <td><?=$item->email?> </td>
                            <td><?=$item->first_name?> <?=$item->last_name?></td>
                            <td><?=$item->address?></td>
                            <td><?=$item->level?></td>
                            <td> <a class="btn btn-danger delete" href="<?=base_url('manager/delete_user/' . $item->id)?>"> Del</a> <a class="btn btn-primary" href="<?=base_url('manager/edit_user/' . $item->id)?>"> Edit</a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?=$pagination?>
            </div>
        </div>
    </div>