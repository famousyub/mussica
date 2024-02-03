<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="py-5 text-center">
        <h2>My Orders</h2>
    </div>
    
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Price</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item):?>
                    <tr>
                    <th scope="row"><?=$item->id?></th>
                    <td><?=$item->created?></td>
                    <td><?=number_format($item->price, 2, ',', '.')?> ₺</td>
                    <td><?= $item->address?></td>
                    <td><?=$item->status?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-12">
            <?=$pagination?>
        </div>
    </div>
</div>