<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1> Edit Item</h1>
                <?php if(isset($success)): ?>
                    <div class="alert alert-success">
                        <?=$success?>
                    </div>
                <?php endif; ?>
                <?=isset($error) ? $error : ''?>
                <?=validation_errors()?>
                <?=form_open_multipart(base_url('manager/edit_category/' . $item->id))?>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $item->title) ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                <?=form_close() ?>
            </div>
        </div>
    </div>