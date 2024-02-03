<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-4" style="text-align: center;">
           <h2 >Shopping Cart</h2> 
        </div>
        <div class="col-12" style="justify-content: center;">
        <br><br>
            <?php if(!isset($items) || count($items) == 0 ):?>
               <p style="text-align: center;" > Your cart is empty.</p> 
               <p style="text-align: center;"><a  href="<?=site_url()?>"> Take a look at our products</a></p>
            <?php else:?>
            <?php foreach ($items as $id=>$item) :?>
                <div class="row">
                    <div class="col-2" style="justify-content: center;">
                        <img src="<?=base_url('uploads/' . $item->image)?>" class="img-thumbnail">
                    </div>
                    <div class="col-4" style="justify-content: center;" ><h3><?=$item->title?></h3></div>
                    <div class="col-3" style="justify-content: center;" ><h3><?=number_format($item->price, 2, ',', '.')?> ₺ </h3></div>
                    <div class="col-1">
                        <a class="btn btn-danger" href="<?=base_url() . 'cart?del=' . ($id+1)?>">Remove</a>
                    </div>
                </div>
                <br> <br>
            <?php endforeach;?>
            <hr>
            <div class="col-12">
                <div class="row">
                    <div class="col-12" style="text-align: center;">
                        <h2> Total : <?=number_format($total,2, ',', '.')?> ₺</h2>
                    </div>
                </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 " style="text-align: center;" >
                        <a class="btn btn-success" href="<?=base_url('checkout')?>">Checkout</a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>