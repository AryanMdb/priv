<?php


return [

  'admin_email' => 'privykart12@gmail.com',
  'firebase_token'=> 'AAAAu0MBBUU:APA91bEM2v1xTt3nvstH-d9mOJGi1FWr7aJcZLL31W27i3gtnJ6mJaZi1Lno2G5W2Sk0gXPA_ECCEYQkTuoCBRq8MG2uYfrQOwk0iqe1jr08dJ-FoPEILEZepf1WQaTqBYeuBfgQalXG',

  'text_local_token'=> 'NTk3OTUzNTU2NDQ3NDI2YjRmNDEzMjMwNTY1NzQ4NTg=',
  'text_local_base_uri' => 'https://api.textlocal.in/',
  'text_local_template_id' => '1207171308307435094',

  'google_map_token'=> 'AIzaSyDmk8i1vm58uCxf71KYMfl7D4gFg3Jw-64',
  // 'google_map_token'=> 'AIzaSyBF_NIyF8PPQK1tQlfEtzRbGutsl98XpwY',
  'google_map_url' => 'https://maps.googleapis.com/maps/api/geocode/json',

  'default_profile_image' => '/images/avatar.png',
  'default_image' => 'images/default.jpg/',

  'profile_img_upload_path' => '/public/profile/',
  'profile_img_display_path' => '/images/profile/',

  'category_img_upload_path' => '/public/category/',
  'category_img_display_path' => '/images/category/',

  'background_img_upload_path' => '/public/background_image/',
  'background_img_display_path' => '/images/background_image/',

  'gender' => [
        [ 'key' => 'male', 'name'=> 'Male'],
        [ 'key' => 'female', 'name'=> 'Female'],
        [ 'key' => 'other', 'name'=> 'Other'],
      ],
  
  'input_fields' => [
    'name' => 'Name',
    'phone' => 'Phone',
    'location' => 'Location',
    'description' => 'Description',
    'address_to' => 'Address To',
    'address_from' => 'Address From',
    'property_address' => 'Property Address',
    'property_details' => 'Property Details',
    'phone_company' => 'Phone Company',
    'phone_model' => 'Phone Model',
    'expected_rent' => 'Expected Rent',
    'preferred_location' => 'Preferred Location',
    'required_property_details' => 'Required Property Details',
    'date_of_journey' => 'Date of Journey',
    'time_of_journey' => 'Time of Journey',
    'approximate_load' => 'Approximate Load',
    'estimated_work_hours' => 'Estimated Work Hours',
    'no_of_passengers' => 'Number Of Passengers',
    'estimated_distance' => 'Estimated Distance',
    'total_orchard_area' => 'Total Orchard Area/Land in Acres',
    'age_of_orchard' => 'Age of the Orchard/Plant',
    'type_of_fruit_plant' => 'Type of fruit plant',
    'total_estimated_weight' => 'Total Estimated Weight',
    'expected_demanded_total_cost' => 'Expected Demanded Total Cost',
    'product_name_model' => 'Product Name & Model',
    'month_year_of_purchase' => 'Month & Year of Purchase',
    'product_brand' => 'Product Brand',
    'expected_demanded_price' => 'Expected/Demanded Price',
  ],

  'order_status' => [
    'order_confirmed' => 'Order Confirmed',
    'order_packed' => 'Order Packed',
    'out_for_delivery' => 'Out for delivery',
    'order_delivered' => 'Order Delivered',
    'payment_completed' => 'Payment Completed',
  ]
];