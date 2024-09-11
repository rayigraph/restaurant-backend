
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
                                        <tbody>
                                            <tr>
                                                <th>Order Id</th>
                                                <td>
                                                    <a href="<?= base_url() ?>orders/view_details/<?= $order->uid ?>" >
                                                        <strong>#<?= $order->uid ?></strong>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Customer</th>
                                                <td>
                                                    <?= $order->name ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Supplier Name</th>
                                                <td>
                                                    <?= $order_items[0]->supplier_name ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created Date</th>
                                                <td><?= date("d-m-Y",strtotime($order->created_at)) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                <?php
                                                if($order->status != 'cancelled' && $order->status != 'completed')
                                                {
                                                ?>
                                                    <form action="<?= site_url('orders/update_status/'); ?>" method="post">
                                                        <input type="hidden" name="uid" value="<?= $order->uid ?>">
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="Pending" <?= $order->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                            <option value="Processing" <?= $order->status == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                            <option value="Completed" <?= $order->status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                            <option value="Cancelled" <?= $order->status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-xs btn-success">Update Status</button>
                                                    </form>
                                                <?php
                                                }
                                                else
                                                    echo $order->status;
                                                ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>Item details</h4>
                                    <table class="table">
                                        <tr>
                                            <th>
                                                Product
                                            </th>
                                            <th>
                                                Quantity
                                            </th>
                                            <th>
                                                Unit Price
                                            </th>
                                            <th>
                                                Total
                                            </th>
                                        </tr>
                                        
                                        <?php
                                        foreach($order_items as $item){
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $item->item_name ?>
                                                </td>
                                                <td>
                                                    <?= $item->quantity ?>
                                                </td>
                                                <td>
                                                    <?= $item->unit_price ?>
                                                </td>
                                                <td>
                                                    <?= $item->total_price ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <th>
                                                Total
                                            </th>
                                            <td></td>
                                            <td></td>
                                            
                                            <td>
                                                <?= $order->total_price ?>
                                            </td>
                                        </tr>
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