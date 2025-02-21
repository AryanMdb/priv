<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>User Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?php echo e($order?->user?->name); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td><?php echo e($order?->user?->phone); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Gender</th>
                                                            <td><?php echo e($order?->user?->gender); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="projects">
                                <h3>Order Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <td><?php echo e($order->order_id); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?php echo e($order->name); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td><?php echo e($order->phone_no); ?></td>
                                                        </tr>
                                                        <?php if($address != ''): ?>
                                                        <tr>
                                                            <th>Location</th>
                                                            <td><a href="#" id='location' data-toggle="modal" data-target="#mapModal"><?php echo e($address ?? '-'); ?></a></td>
                                                        </tr>
                                                          <?php elseif($order->location != ''): ?>
                                                        <tr>
                                                            <th>Location</th>
                                                            <td><?php echo e($order->location ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->address_from != ''): ?>
                                                        <tr>
                                                            <th>Address From</th>
                                                            <td><?php echo e($order->address_from ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->address_to != ''): ?>
                                                        <tr>
                                                            <th>Address To </th>
                                                            <td><?php echo e($order->address_to ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->property_address != ''): ?>
                                                        <tr>
                                                            <th>Property Address</th>
                                                            <td><?php echo e($order->property_address ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->expected_cost != ''): ?>
                                                        <tr>
                                                            <th>Expected Cost</th>
                                                            <td><?php echo e($order->expected_cost ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->property_details != ''): ?>
                                                        <tr>
                                                            <th>Property Details</th>
                                                            <td><?php echo e($order->property_details ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->description != ''): ?>
                                                        <tr>
                                                            <th>Description</th>
                                                            <td><?php echo e($order->description ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->phone_company != ''): ?>
                                                        <tr>
                                                            <th>Phone Company</th>
                                                            <td><?php echo e($order->phone_company ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->phone_model != ''): ?>
                                                        <tr>
                                                            <th>Phone Model</th>
                                                            <td><?php echo e($order->phone_model ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->expected_rent != ''): ?>
                                                        <tr>
                                                            <th>Expected Rent</th>
                                                            <td><?php echo e($order->expected_rent ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->preferred_location != ''): ?>
                                                        <tr>
                                                            <th>Preferred Location</th>
                                                            <td><?php echo e($order->preferred_location ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->required_property_details != ''): ?>
                                                        <tr>
                                                            <th>Required Property Details</th>
                                                            <td><?php echo e($order->required_property_details ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->date_of_journey != ''): ?>
                                                        <tr>
                                                            <th>Date of Journey</th>
                                                            <td><?php echo e(\Carbon\Carbon::parse($order->date_of_journey)->format('m/d/Y') ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->time_of_journey != '' && $order->time_of_journey != '00:00:00'): ?>
                                                        <tr>
                                                            <th>Time of Journey</th>
                                                            <td><?php echo e($order->time_of_journey ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->approximate_load != ''): ?>
                                                        <tr>
                                                            <th>Approximate Load</th>
                                                            <td><?php echo e($order->approximate_load ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->estimated_work_hours != ''): ?>
                                                        <tr>
                                                            <th>Estimated Work Hours</th>
                                                            <td><?php echo e($order->estimated_work_hours ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->no_of_passengers != ''): ?>
                                                        <tr>
                                                            <th>Number Of Passengers</th>
                                                            <td><?php echo e($order->no_of_passengers ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->estimated_distance != ''): ?>
                                                        <tr>
                                                            <th>Estimated Distance</th>
                                                            <td><?php echo e($order->estimated_distance ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->total_orchard_area != ''): ?>
                                                        <tr>
                                                            <th>Total Orchard Area/Land in Acres</th>
                                                            <td><?php echo e($order->total_orchard_area ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->age_of_orchard != ''): ?>
                                                        <tr>
                                                            <th>Age of the Orchard/Plant</th>
                                                            <td><?php echo e($order->age_of_orchard ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->type_of_fruit_plant != ''): ?>
                                                        <tr>
                                                            <th>Type of fruit plant</th>
                                                            <td><?php echo e($order->type_of_fruit_plant ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->total_estimated_weight != ''): ?>
                                                        <tr>
                                                            <th>Total Estimated Weight (in 100 Kilograms)</th>
                                                            <td><?php echo e($order->total_estimated_weight ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->expected_demanded_total_cost != ''): ?>
                                                        <tr>
                                                            <th>Expected Demanded Total Cost</th>
                                                            <td><?php echo e($order->expected_demanded_total_cost ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->product_name_model != ''): ?>
                                                        <tr>
                                                            <th>Product Name & Model</th>
                                                            <td><?php echo e($order->product_name_model ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->month_year_of_purchase != ''): ?>
                                                        <tr>
                                                            <th>Month & Year of Purchase</th>
                                                            <td><?php echo e($order->month_year_of_purchase ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->product_brand != ''): ?>
                                                        <tr>
                                                            <th>Product Brand</th>
                                                            <td><?php echo e($order->product_brand ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->expected_demanded_price != ''): ?>
                                                        <tr>
                                                            <th>Expected/Demanded Price</th>
                                                            <td><?php echo e($order->expected_demanded_price ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($order?->cart?->total_price != 0): ?>
                                                        <tr>
                                                            <th>Total Price</th>
                                                            <td>₹<?php echo e($order?->cart?->total_price); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Delivery Charges</th>
                                                            <td>₹<?php echo e($order?->cart?->deliver_charges); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Grand Total</th>
                                                            <td>₹<?php echo e($order?->cart?->grant_total); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <tr>
                                                            <th>Order Date</th>
                                                            <td><?php if(isset($order->created_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($order->created_at))); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Order Time</th>
                                                            <td><?php if(isset($order->created_at)): ?><?php endif; ?><?php echo e(date('h:i A', strtotime($order->created_at))); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>
                                                                <?php if(isset($order->status)): ?>
                                                                    <button type="button" class="btn btn-success btn-sm switch_toggle_button" style="pointer-events: none;"><?php echo e(config('constants.order_status')[$order->status] ?? ''); ?></button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($order?->cart?->grant_total != 0): ?>
                            <hr>
                            <div class="projects">
                                <h3>Cart Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">

                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="group_table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Product Name</th>
                                                                <th>Item Price</th>
                                                                <th>Item Quantity</th>
                                                                <th>No of Items</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            <?php $__currentLoopData = $order?->cart?->cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($i++); ?></td>
                                                                    <td><?php echo e($val?->product?->title); ?></td>
                                                                    <td>₹<?php echo e($val->item_price); ?></td>
                                                                    <td><?php echo e($val->item_quantity); ?></td>
                                                                    <td><?php echo e($val->no_of_items); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="mapGenerate" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    <?php $token = config('constants.google_map_token');?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($token); ?>&callback=initMap" async defer></script>
    <script>
    $(document).ready(function() {
      
        function initMap(latitude, longitude) {
            var map;
            var myLatLng = {lat: latitude, lng: longitude};
    
            map = new google.maps.Map(document.getElementById('mapGenerate'), {
                center: myLatLng,
                zoom: 14
            });
    
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: latitude + ', ' + longitude
            });
        }
    
        // Initialize the map when the modal is shown
        $('#location').on('click', function () {
            mapModalLabel
            var latitude = <?php echo e($latitude ?? 0); ?>;
            var longitude = <?php echo e($longitude ?? 0); ?>;
            
            initMap(latitude, longitude);
        });
		
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('subadmin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/subadmin/orders/view.blade.php ENDPATH**/ ?>