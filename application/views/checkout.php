<div class="container">
    <div class="py-5 text-center">
        <h2>Checkout</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">Billing address:</div>
            <div class="d-block my-3">
                <?=form_open_multipart(base_url('home/checkout'))?>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" required name="first_name" placeholder="First Name" value="<?= set_value('first_name', $user['first_name']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="first_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" required name="last_name" placeholder="Last Name" value="<?= set_value('last_name', $user['last_name']) ?>">
                    </div>

                    <div class="form-group">
                    <label for="first_name">Address</label>
                        <input type="text" class="form-control" id="address" required name="address" placeholder="Address" value="<?= set_value('address', $user['address']) ?>"></input>
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">Payment</h4>
                    <div class="d-block my-3">
                        <div class="custom-control">
                            <input type="radio" id="cash" name="paymentmethod" class="custom-control-input" required>
                            <label class="custom-control-label" for="cash">Cash on delivery</label>
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block " type="submit">Confirm</button>


                <?= form_close(); ?>

            </div>
        </div>
    </div>
</div>
