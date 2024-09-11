
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Suppliers</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Supplier</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <?php 
                    if(null !==$this->session->flashdata('error'))
                    {
                    ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?=  $this->session->flashdata('error') ?>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                    <?php
                    }
                    if(null !==$this->session->flashdata('success'))
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show">
                                <?=  $this->session->flashdata('success') ?>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Suppliers</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="#" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="supplier_name">Supplier Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" value="<?= $supplier->supplier_name ?>" class="form-control" id="supplier_name" required name="supplier_name" placeholder="Enter a Supplier Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="image">Supplier Image
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" onchange="readimage(this);">
                                                <label class="custom-file-label"><i class="fa fa-camera"></i></label>
                                            </div>
                                        </div>
                                        <img  width="100" id="blah" src="<?= base_url().SUPPLIER_PATH.$supplier->supplier_image ?>" alt="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-success ">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
<script>
    
    function readimage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>