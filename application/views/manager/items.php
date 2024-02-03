<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Products <a class="btn btn-warning" href="<?=base_url('manager/add_item')?>" role="button">Add New Item</a></h1>
            </div>
        </div>
        <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item):?>
                            <tr>
                            <th scope="row"><?=$item->id?></th>
                            <td><?=$item->title?></td>
                            <td><?=$item->description?></td>
                            <td><img src="<?=base_url('uploads/'.$item->image)?>" class="img-thumbnail"></td>
                            <td><?=$item->price?> ₺</td>
                            <td><?=$item->qty?></td>
                            <td> <a class="btn btn-danger delete" href="<?=base_url('manager/delete_item/' . $item->id)?>"> Del</a> <a class="btn btn-primary" href="<?=base_url('manager/edit_item/' . $item->id)?>"> Edit</a></td>
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