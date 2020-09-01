
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://bootstrap.hexschool.com/favicon.ico">

    <title>Line Pay Test Form</title>

    <!-- Bootstrap core CSS -->
    <link href="https://bootstrap.hexschool.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://bootstrap.hexschool.com/docs/4.1/examples/checkout/form-validation.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@8.17.6/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="py-5 text-center">
        <h2>Line Pay Test Form</h2>
        <p class="lead">目前僅可用於沙盒環境 (Sandbox Environment)</p>
    </div>
    @error('confirm')
    <div class="py-5 text-center">
        <h4 class="mb-3" style="color: green">交易成功</h4>
        <h6 class="mb-3">Transaction ID : {{ $message }}</h6>
    </div>
    @enderror
    <div class="row">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-3">購買商品</h4>
            <form class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="lastName">Order ID </label>
                        <input type="text" class="form-control" id="order_id" placeholder="" value="{{ $order_id }}" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Package ID (Shop ID)</label>
                        <input type="text" class="form-control" id="package_id" placeholder="" value="SHOP-00000001" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Package Name (Shop Name)</label>
                        <input type="text" class="form-control" id="package_name" placeholder="" value="MY SHOP" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Product ID</label>
                        <input type="text" class="form-control" id="product_id" placeholder="" value="{{ $product_id }}" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Product Name</label>
                        <input type="text" class="form-control" id="product_name" placeholder="" value="{{ $product_name }}" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Currency</label>
                        <select class="custom-select d-block w-100" id="currency" required>
                            <option value="TWD">新台幣</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Quantity</label>
                        <input type="number" class="form-control" id="quantity" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Price</label>
                        <input type="number" class="form-control" id="price" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-success btn-lg btn-block send-btn" type="button">取得付款資訊</button>
            </form>
        </div>
    </div>

    <div class="row pt-5">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-3">退款</h4>
            <form class="needs-validation-2" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="transaction_id">Transaction ID</label>
                        <input type="text" class="form-control" id="transaction_id" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="refund_amount">退款金額 (可部分退款， 0 代表全退 )</label>
                        <input type="number" class="form-control" id="refund_amount" placeholder="" value="0" required>
                        <div class="invalid-feedback">
                            required.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-danger btn-lg btn-block send-refund-btn" type="button">確定退款</button>
            </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2020 Yu Lin Chou</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://inredis.com">Support</a></li>
        </ul>
    </footer>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>window.jQuery || document.write('<script src="https://bootstrap.hexschool.com/docs/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://bootstrap.hexschool.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
<script src="https://bootstrap.hexschool.com/docs/4.1/dist/js/bootstrap.min.js"></script>
<script src="https://bootstrap.hexschool.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.17.6/dist/sweetalert2.all.min.js"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    $(function() {
        'use strict';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.send-btn', function(){
            Swal.fire({
                title: '交易處理中',
                html: '將訂單傳送至 Line Pay... 請稍等',
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
            });
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            var validation = true;
            var args = {
                order_id : $('#order_id').val(),
                package_id : $('#package_id').val(),
                package_name : $('#package_name').val(),
                product_id : $('#product_id').val(),
                product_name : $('#product_name').val(),
                currency : $('#currency').val(),
                quantity : $('#quantity').val(),
                price : $('#price').val(),
            };

            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    validation = false;
                }
                form.classList.add('was-validated');
            });
            setTimeout(function () {
                if (validation) {
                    $.ajax({
                        type: "post",
                        url: "/line-pay/get-payment-info",
                        dataType: "json",
                        data: args,
                        success: function (result) {
                            location.assign(result.payment_url);
                        },
                        error: function () {
                            Swal.fire('Error');
                            console.log('error')
                        }
                    });
                }
            }, 1000);

        });


        $(document).on('click', '.send-refund-btn', function(){
            Swal.fire({
                title: '退款處理中',
                html: '將退款資訊傳送至 Line Pay... 請稍等',
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
            });
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation-2');
            var validation = true;
            var args = {
                refund_amount : $('#refund_amount').val(),
                transaction_id : $('#transaction_id').val(),
            };

            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    validation = false;
                }
                form.classList.add('was-validated');
            });
            setTimeout(function () {
                if (validation) {
                    $.ajax({
                        type: "post",
                        url: "/line-pay/refund",
                        dataType: "json",
                        data: args,
                        success: function (result) {
                            Swal.fire('Complete', result.message);
                        },
                        error: function () {
                            Swal.fire('Error');
                            console.log('error')
                        }
                    });
                }
            }, 1000);

        });
    });
</script>
</body>
</html>
