<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1> Edit Page</h1>

                <?=validation_errors()?>
                <?=form_open_multipart(base_url('manager/edit_page/'.$item->id))?>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $item->title) ?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <?= '<textarea class="form-control" id="content" name="content"'.set_value('content', $item->content).'>'. $item->content . '</textarea>' ?> 
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                <?=form_close() ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>CKEDITOR.replace( 'content' );</script>
