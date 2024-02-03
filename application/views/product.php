<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-xs-4 item-photo">
            <br><br><br>
            <img src="<?= base_url('uploads/' . $image) ?>" alt="">
        </div>
        <div>
            <p style="visibility: hidden;">
                ********************
            </p>
        </div>
        <div class="col-xs-3" style="border:0px solid gray">
            <br><br><br>

            <h3><?= $title ?></h3>
            <br>
            <h6 style="margin-top:0px;">Remaining: <b><?=$qty?></b></h6>
            <br>
            <h3 style="margin-top:0px;"><?= number_format($price, 2, ',', '.') ?> ₺</h3>
            <br><br>

            <div class="section" style="padding-bottom:20px;">
                <a href="<?= base_url('add/' . $id) ?>">
                    <button class="btn btn-success">Add to cart</button>
                </a>
            </div>
        </div>
        <div class="col-xs-10">
            <br>
            <p style="visibility: hidden;">
                **************************************************************************************
            </p>
            <div style="width:100%;border-top:1px solid silver">

                <p style="padding:15px;">
                    <?= $description ?>
                </p>
                <br><br><br><br><br><br><br>
            </div>
        </div>
    </div>
</div>