<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Restaurant</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>/images/favicon.png">
    <link href="<?= base_url() ?>/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-VoV0ceiWMPJz/kAdG6y/jU6w7iYlW7M1KVgjLUDwdVJpZ/v4PBVj5o7bTQOZaM7/" crossorigin="anonymous">

</head>

<style>
#ui-id-1{
    background: white;
    width: 230px !important;
    max-width: 50% !important;
    border-radius:10px !important;
}
.ui-helper-hidden-accessible{
    display: none !important;
}
#ui-id-2{
    background: white;
    width: 230px !important;
    max-width: 50% !important;
    border-radius:10px !important;
}
.authincation-content {
    background: #1d467d !important;
}
.instruction:hover{
    opacity:0.9;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
.mesg-cont{
    position: fixed;
    bottom: 0;
    z-index: 100;
    width: 100%;
    padding: 10px;
    text-align: center;
}
.no-gutters{
    margin-bottom: 50px;
}
@media screen and (max-width: 992px) {
    .no-gutters{
        margin-bottom: 80px;
    }
}
</style>
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
                                    <a href="<?= base_url() ?>"><img src="<?= base_url() ?>images/logo-full.png" alt="" style="width: 30%;max-width: 100%;"></a>
									</div>
                                    <h5 class="text-center mt-3 mb-3 text-white">Sign in for admin panel</h5>
                                    <form action="<?= base_url() ?>login/" method="POST">
                                        <span class="text-danger">
                                            <?= $message?$message:"";?>
                                        </span>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="email" name="username" class="form-control" required placeholder="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" required placeholder="Password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url() ?>/vendor/global/global.min.js"></script>
	<script src="<?= base_url() ?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url() ?>/js/custom.min.js"></script>
    <script src="<?= base_url() ?>/js/deznav-init.js"></script>
</body>

</html>