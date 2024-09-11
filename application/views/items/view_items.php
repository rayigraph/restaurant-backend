
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Items</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">View Items</a></li>
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
                                <h4 class="card-title">View Items</h4>
                                <a href="<?= base_url() ?>/items/add_new/<?= $sub_category_id ?>" class="btn btn-primary btn-sm">Add</a>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label class="col-form-label" for="val-username">Supplier
                                            </label>
                                            <div>
                                                <select name="supplier_id" class="form-control" id="supplier">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $categories = $this->db->where("is_deleted","N")->get('tb_suppliers')->result_array();
                                                    foreach ($categories as $supplier) {
                                                        $selected = "";
                                                        if($supplier_id && $supplier_id == $supplier->id)
                                                        {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $supplier['id'] ?>" <?= $selected ?>><?= $supplier['supplier_name'] ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label class="col-form-label" for="val-username">Category
                                            </label>
                                            <div>
                                                <select name="category_id" class="form-control" id="category">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $categories = $this->db->where("is_deleted","N")->get('tb_categories')->result_array();
                                                    foreach ($categories as $category) {
                                                        $selected = "";
                                                        if($category_id && $category_id == $category->id)
                                                        {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $category['id'] ?>" <?= $selected ?>><?= $category['category_name'] ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label class="col-form-label" for="val-username">Sub Category
                                            </label>
                                            <div>
                                                <select name="sub_category_id" class="form-control" id="sub_category">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $categories = $this->db->where("is_deleted","N")->get('tb_sub_categories')->result_array();
                                                    foreach ($categories as $sub_category) {
                                                        $selected = "";
                                                        if($sub_category_id && $sub_category_id == $sub_category->id)
                                                        {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $sub_category['id'] ?>" <?= $selected ?>><?= $sub_category['sub_category_name'] ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-sm">Submit</button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Item Name</th>
                                                <th>Item Image</th>
                                                <th>Unit Price</th>
                                                <th>Sub Category Name</th>
                                                <th>Category Name</th>
                                                <th>Supplier Name</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($Items as $item)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <strong><?= $item->item_name ?></strong>
                                                    </td>
                                                    <td>
                                                        <img  width="100" src="<?= base_url() ?>uploads/item_image/<?= $item->item_image ?>" alt="">
                                                    </td>
                                                    <td>
                                                        <strong><?= $item->unit_price ?></strong>
                                                    </td>
                                                    <td>
                                                        <?= $item->sub_category_name ?>
                                                    </td>
                                                    <td>
                                                        <?= $item->category_name ?>
                                                    </td>
                                                    <td>
                                                        <?= $item->supplier_name ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $checkbox = "";
                                                        if($item->availability == 1){
                                                            $checkbox = "checked";
                                                        }
                                                        ?>
                                                        <label class="switch">
                                                            <input type="checkbox" <?= $checkbox ?> onchange="update_item_availability(this,'<?= $item->uid ?>')">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td><?= date("d-m-Y",strtotime($item->created_at)) ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="<?= base_url() ?>items/edit_item/<?= $item->uid ?>" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a data-toggle="modal" onclick="delete_item(<?= $item->uid ?>)" data-target="#delete_modal" class="btn btn-danger shadow btn-xs sharp">
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
                <form action="<?= base_url() ?>items/delete_item/<?= $sub_category_id ?>" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Warning</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" name="item_id" id="delete_id">
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
        function delete_item(item_id)
        {
            $("#delete_id").val(item_id);
        }
    </script>
        <!--**********************************
            Content body end
        ***********************************-->
    <script>
        function update_item_availability(checkbox,itemId){
            if (checkbox.checked) {
                var value = checkbox.value;
                var availability = 1;
            } else {
                var availability = 0;
            }
            $.ajax({
                url: '<?php echo site_url('items/update_item_availability'); ?>',
                type: 'POST',
                data: {"itemId":itemId,"availability":availability},
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