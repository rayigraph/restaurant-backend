
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Orders</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">View Orders</a></li>
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
                                <h4 class="card-title">View Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Order Id</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($Orders as $order)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <a href="<?= base_url() ?>orders/view_details/<?= $order->uid ?>" >
                                                            <strong>#<?= $order->uid ?></strong>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $order->name ?>
                                                    </td>
                                                    <td>
                                                        <?= $order->status ?>
                                                    </td>
                                                    <td><?= date("d-m-Y",strtotime($order->created_at)) ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="<?= base_url() ?>orders/view_details/<?= $order->uid ?>" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a data-toggle="modal" onclick="delete_order(<?= $order->uid ?>)" data-target="#delete_modal" class="btn btn-danger shadow btn-xs sharp">
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
                <form action="<?= base_url() ?>orders/delete_order" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Warning</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" name="order_id" id="delete_id">
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
        function delete_order(order_id)
        {
            $("#delete_id").val(order_id);
        }
    </script>
        <!--**********************************
            Content body end
        ***********************************-->