<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1> Add Item</h1>
            <?= isset($error) ? $error : '' ?>
            <?= validation_errors() ?>
            <?= form_open_multipart(base_url('manager/add_item')) ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title') ?>">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                        <option type="number" id="category_id" name="category_id" value="7">Piano-Org</option>
                        <option type="number" id="category_id" name="category_id" value="6">Music at Home</option>
                        <option type="number" id="category_id" name="category_id" value="5">Drums</option>
                        <option type="number" id="category_id" name="category_id" value="4">Dj Equipments</option>
                        <option type="number" id="category_id" name="category_id" value="3">Wind Instruments</option>
                        <option type="number" id="category_id" name="category_id" value="2">Violin</option>
                        <option type="number" id="category_id" name="category_id" value="1">Guitar</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" min="0" step="0.1" id="price" name="price" value="<?= set_value('price') ?>">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" value="<?= set_value('image') ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control" id="description" name="description" value="<?= set_value('description') ?>"></input>
            </div>
            <div class="form-group">
                <label for="qty">Qty</label>
                <input type="number" class="form-control" id="qty" name="qty" value="<?= set_value('qty') ?>"></input>
            </div>
            <button type="submit" class="btn btn-success">Add New</button>
            <?= form_close() ?>
        </div>
    </div>
</div>
