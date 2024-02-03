<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1> Orders </h1>
            </div>
        </div>
        <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Address</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item):?>
                            <tr>
                            <th scope="row"><?=$item->id?></th>
                            <td><?=$item->first_name?> <?=$item->last_name?></td>
                            <td><?=number_format($item->price, 2, ',', '.')?></td>
                            <td>
                                <form method="post" action="<?= base_url('manager/edit_order/' . $item->id)?>" class="form-inline">
                                    <input type="text" name="status" required class="form-control" value="<?= $item->status?>">
                                    <button class="btn btn-success" type="submit">Save</button>
                                </form>
                            </td>
                            <td><?=$item->created?></td>
                            <td><?= $item->address?></td>
                            <td><?= $item->paymentmethod=='on'?'Cash':'Other'?></td>
                            <td> <a class="btn btn-danger delete" href="<?=base_url('manager/delete_order/' . $item->id)?>"> Del</a></td>
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