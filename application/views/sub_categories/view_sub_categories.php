
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Sub Categories</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">View Sub Categories</a></li>
					</ol>
                </div>
                <!-- row -->
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
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Sub Categories</h4>
                                <a href="<?= base_url() ?>/sub_categories/add_new/<?= $category_id ?>" class="btn btn-primary btn-sm">Add</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Sub Category Name</th>
                                                <th>Sub Category Image</th>
                                                <th>Category Name</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($Sub_Categories as $sub_category)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <a href="<?= base_url() ?>items/<?= $sub_category->uid ?>" >
                                                            <strong><?= $sub_category->sub_category_name ?></strong>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <img  width="100" src="<?= base_url().SUB_CATEGORY_PATH.$sub_category->sub_category_image ?>" alt="">
                                                    </td>
                                                    <td>
                                                        <?= $sub_category->category_name ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $checkbox = "";
                                                        if($sub_category->availability == 1){
                                                            $checkbox = "checked";
                                                        }
                                                        ?>
                                                        <label class="switch">
                                                            <input type="checkbox" <?= $checkbox ?> onchange="update_sub_category_availability(this,'<?= $sub_category->uid ?>')">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td><?= date("d-m-Y",strtotime($sub_category->created_at)) ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="<?= base_url() ?>sub_categories/edit_sub_category/<?= $sub_category->uid ?>" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a data-toggle="modal" onclick="delete_sub_category(<?= $sub_category->uid ?>)" data-target="#delete_modal" class="btn btn-danger shadow btn-xs sharp">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>												
                                                </tr>
                                                <?php
                                                $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    <!-- Modal -->
    <div id="delete_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?= base_url() ?>sub_categories/delete_sub_category" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Warning</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" name="sub_category_id" id="delete_id">
                        <p>Are You Sure Want to Delete ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Yes</button>
                        <a class="btn btn-default" data-dismiss="modal">No</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function delete_sub_category(sub_category_id)
        {
            $("#delete_id").val(sub_category_id);
        }
    </script>
    <script>
        function update_sub_category_availability(checkbox,subCategoryId){
            if (checkbox.checked) {
                var value = checkbox.value;
                var availability = 1;
            } else {
                var availability = 0;
            }
            $.ajax({
                url: '<?php echo site_url('sub_categories/update_sub_category_availability'); ?>',
                type: 'POST',
                data: {"subCategoryId":subCategoryId,"availability":availability},
                dataType: 'json',
                success: function(response) {
                    $('#responseMessage').text(response.message);
                },
                error: function() {
                    $('#responseMessage').text('An error occurred.');
                }
            });
        }
    </script>
        <!--**********************************
            Content body end
        ***********************************-->