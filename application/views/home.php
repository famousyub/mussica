<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Products</h1>
        </div>
    </div>
    <div class="row">
        <?php if(count($items) == 0): ?>
            <div class="col-12">
                <div class="alert alert-danger" style="text-align: center;">
                    Product not found !!!
                </div>
            </div>
        <?php endif;?>
        <?php foreach($items as $item): ?>
            <?php if($item->qty >= 1): ?>
                <div class="col-4">
                    <div class="card-body">
                        <a href="<?=base_url()?>product/<?= $item->id ?>"> <img src="<?=base_url('uploads/'.$item->image)?>" class="card-img" alt="<?=$item->title?>"></a>
                        <a href="<?=base_url()?>product/<?= $item->id ?>">  <h5 class="card-title" ><?=$item->title?> </h5> </a>
                        <h6 style="font-weight: bold" class="card-text"><?=number_format($item->price, 2, ',', '.')?> ₺</h6>
                        <a href="<?=base_url('add/' . $item->id)?>" class="btn btn-primary">Add to cart</a>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <div class="row">
        <div class="col-12">
            <?=$pagination?>
        </div>
    </div>
</div>