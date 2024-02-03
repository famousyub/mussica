<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1> Edit Item</h1>

                <?=isset($error) ? $error : ''?>
                <?=validation_errors()?>
                <?=form_open_multipart(base_url('manager/edit_item/' . $item->id))?>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $item->title) ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" min="0" step="0.1" id="price" name="price" value="<?= set_value('price', $item->price) ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" value="<?= set_value('image') ?>">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <img src="<?=base_url('uploads/' . $item->image)?>" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" id="description" name="description" value="<?= set_value('description', $item->description) ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" value="<?= set_value('qty', $item->qty) ?>"></input>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                <?=form_close() ?>
            </div>
        </div>
    </div>