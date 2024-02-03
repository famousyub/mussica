<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ozimusic | Home</title>
    <link rel="icon" href="<?php echo(base_url()); ?>uploads\favicon.ico" type="image/ico">
    <link rel="stylesheet" href="<?php echo(base_url()); ?>assets/css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?php echo(base_url()); ?>assets/css/style.css" >

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?=site_url()?>"> 
        <img src="<?php echo(base_url()); ?>uploads\logo.jpeg" width="200" height="60" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?=site_url()?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>page/3-about_us">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>page/4-contact_us">Contact Us</a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php foreach($categories as $category): ?>
                        <a class="dropdown-item" href="<?=base_url('category/'.$category->id)?>"><?=$category->title?></a>
                    <?php endforeach;?>
                </div>
            </li>
        </ul>
        <?php if(isset($user['logged']) && $user['logged']): ?>
            <br>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=$user['first_name']?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    
                    <a class="dropdown-item" href="<?=base_url('profile/')?><?=$user['user_id']?>">Profile</a>
                    <a class="dropdown-item" href="<?=base_url('cart')?>">Cart</a>
                    <a class="dropdown-item" href="<?=base_url('orders')?>">Orders</a>

                    <?php if($user['level'] >= 1 ):?>
                        <div class="dropdown-divider"></div>
                        <hr>
                        <a class="dropdown-item" href="<?=base_url('manager/items')?>">Product Operations</a>
                        <a class="dropdown-item" href="<?=base_url('manager/orders')?>">Order Operations</a>
                        <a class="dropdown-item" href="<?=base_url('manager/categories')?>">Category Operations</a>
                        <a class="dropdown-item" href="<?=base_url('manager/pages')?>">Page Operations</a>
                    <?php endif;?>

                    <?php if($user['level'] == 2 ):?>
                        <a class="dropdown-item" href="<?=base_url('manager/users')?>">User Operations</a>
                    <?php endif;?>

                    <div class="dropdown-divider"></div>
                    <hr>
                    <a class="dropdown-item" href="<?=base_url('home/logout')?>">Logout</a>
                </div>
            </div>
        <?php else:?>
            <a class="nav-link" href="<?=base_url('home/login')?>">Login</a>
        <?php endif;?>
        <p style="visibility: hidden;"> 
            12
        </p> 
        <form class="form-inline my-2 my-lg-0" action="" method="get">
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
