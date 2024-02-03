<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container" >
        <div class="row">
            <div class="col-12">
                <h1>Categories <a class="btn btn-warning" href="<?=base_url('manager/add_category')?>" role="button">Add New Item</a></h1>
            </div>
        </div>
        <div class="row" style="margin: 0 auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $category):?>
                            <tr>
                            <th scope="row"><?=$category->id?></th>
                            <td><?=$category->title?></td>
                            <td> <a class="btn btn-danger delete" href="<?=base_url('manager/delete_category/' . $category->id)?>"> Del</a> <a class="btn btn-primary" href="<?=base_url('manager/edit_category/' . $category->id)?>"> Edit</a></td>
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