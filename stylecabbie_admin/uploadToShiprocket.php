<?php 
  include('db.php');

  // function CreateCustomOrder($order_data){

  //   //echo json_encode($order_data);
  //   //die;

  //   $order_id = $order_data['order_detail']['order_id'];
  //   $order_date = $order_data['order_detail']['order_date'];
  //   $name = $order_data['order_detail']['name'];
  //   $address = $order_data['order_detail']['address'];
  //   $email = $order_data['order_detail']['email'];
  //   $pin_code = $order_data['order_detail']['pin_code'];
  //   $country = $order_data['order_detail']['country'];
  //   $mobile = $order_data['order_detail']['mobile'];
  //   $order_type = $order_data['order_detail']['order_type'];
  //   $price = $order_data['order_detail']['price'];

  //   $product_name = $order_data['cart_detail']['product_name'];
  //   $product_price = $order_data['cart_detail']['product_price'];
  //   $qty = $order_data['cart_detail']['qty'];

  //   $request = new HttpRequest();
  //   $request->setUrl('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc');
  //   $request->setMethod(HTTP_METH_POST);

  //   $request->setHeaders(array(
  //     'postman-token' => '0f0b9aae-1ef9-378c-b884-c1b7ff5fbc3b',
  //     'cache-control' => 'no-cache',
  //     'authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjgwNDc5MiwiaXNzIjoiaHR0cHM6Ly9hcGl2Mi5zaGlwcm9ja2V0LmluL3YxL2V4dGVybmFsL2F1dGgvbG9naW4iLCJpYXQiOjE2MDc5MjIwNTMsImV4cCI6MTYwODc4NjA1MywibmJmIjoxNjA3OTIyMDUzLCJqdGkiOiIyWnpGSUdsSVJJUnVuamNuIn0.0uz-UZlsdxA_HtautplvmN67hnEy7HZJ3f0MxhJ9y_4',
  //     'content-type' => 'application/json'
  //   ));

  //   $request->setBody('{
  //       "order_id": $order_id,
  //       "order_date": $order_date,
  //       "pickup_location": "Indore",
  //       "channel_id": "123456",
  //       "comment": "dfydfy",
  //       "reseller_name": "abc",
  //       "company_name": "ems",
  //       "billing_customer_name": $name,
  //       "billing_last_name": "dfgds",
  //       "billing_address": $address,
  //       "billing_address_2": "sdg",
  //       "billing_isd_code": "sdg",
  //       "billing_city": "Indore",
  //       "billing_pincode": $pin_code,
  //       "billing_state": "MP",
  //       "billing_country": $country,
  //       "billing_email": $email,
  //       "billing_phone": $mobile,
  //       "billing_alternate_phone":"1234567891",
  //       "shipping_is_billing": "1",
  //       "shipping_customer_name": "dfh",
  //       "shipping_last_name": "dfh",
  //       "shipping_address": "dfh",
  //       "shipping_address_2": "dfh",
  //       "shipping_city": "dfh",
  //       "shipping_pincode": "452001",
  //       "shipping_country": "India",
  //       "shipping_state": "MP",
  //       "shipping_email": "ssdgsdg@gmail.com",
  //       "shipping_phone": "7893012456",
  //       "order_items": [
  //           {
  //               "name": $product_name,
  //               "sku": "dfgh",
  //               "units": $qty,
  //               "selling_price": $product_price,
  //               "discount": "10%",
  //               "tax": "18%",
  //               "hsn": "dfgdf"
  //           }
  //       ],
  //       "payment_method": $order_type,
  //       "shipping_charges": "50",
  //       "giftwrap_charges": "10",
  //       "transaction_charges": "10",
  //       "total_discount": "10%",
  //       "sub_total": $price,
  //       "length": "10",
  //       "breadth": "10",
  //       "height": "10",
  //       "weight": "10",
  //       "ewaybill_no": "123456",
  //       "customer_gstin": "123456789"
  //   }');

  //   try {
  //     $response = $request->send();

  //     echo $response->getBody();

  //   } catch (HttpException $ex) {

  //     echo $ex;

  //   }

  // } 

 
  $order_id = $_GET['order_id'];
  $dataArrayValue = array();
  $sql_con = mysqli_query($con,"SELECT * FROM `order` WHERE order_id ='".$order_id."' ");


  while($row_con = mysqli_fetch_array($sql_con)) {

    $dataArrayValue['order_detail'] = $row_con;
    $cart_ids = explode(",", $row_con['cart_id']);

    foreach ($cart_ids as $keyc => $cart_id) {
      $cartId = $cart_id;
      $cart_list = mysqli_query($con,"SELECT * FROM `cart` WHERE cart_id='".$cartId."'");

      while($cart_listData = mysqli_fetch_array($cart_list)) {
        $dataArrayValue['cart_detail'][$keyc] = $cart_listData;

      }
    }
  }

  $order_id = $order_data['order_detail']['order_id'];
  $order_date = $order_data['order_detail']['order_date'];
  $name = $order_data['order_detail']['name'];
  $address = $order_data['order_detail']['address'];
  $email = $order_data['order_detail']['email'];
  $pin_code = $order_data['order_detail']['pin_code'];
  $country = $order_data['order_detail']['country'];
  $mobile = $order_data['order_detail']['mobile'];
  $order_type = $order_data['order_detail']['order_type'];
  $price = $order_data['order_detail']['price'];

  $product_name = $order_data['cart_detail']['product_name'];
  $product_price = $order_data['cart_detail']['product_price'];
  $qty = $order_data['cart_detail']['qty'];

  //CreateCustomOrder($dataArrayValue);
  //echo json_encode($dataArrayValue);die;
  $dataArrayValue = array(  
            "order_id": $order_id,
            "order_date": $order_date,
            "pickup_location": "Indore",
            "channel_id": "123456",
            "comment": "dfydfy",
            "reseller_name": "abc",
            "company_name": "ems",
            "billing_customer_name": $name,
            "billing_last_name": "dfgds",
            "billing_address": $address,
            "billing_address_2": "sdg",
            "billing_isd_code": "sdg",
            "billing_city": "Indore",
            "billing_pincode": $pin_code,
            "billing_state": "MP",
            "billing_country": $country,
            "billing_email": $email,
            "billing_phone": $mobile,
            "billing_alternate_phone":"1234567891",
            "shipping_is_billing": "1",
            "shipping_customer_name": "dfh",
            "shipping_last_name": "dfh",
            "shipping_address": "dfh",
            "shipping_address_2": "dfh",
            "shipping_city": "dfh",
            "shipping_pincode": "452001",
            "shipping_country": "India",
            "shipping_state": "MP",
            "shipping_email": "ssdgsdg@gmail.com",
            "shipping_phone": "7893012456",
            "order_items": [
                {
                    "name": $product_name,
                    "sku": "dfgh",
                    "units": $qty,
                    "selling_price": $product_price,
                    "discount": "10%",
                    "tax": "18%",
                    "hsn": "dfgdf"
                }
            ],
            "payment_method": $order_type,
            "shipping_charges": "50",
            "giftwrap_charges": "10",
            "transaction_charges": "10",
            "total_discount": "10%",
            "sub_total": $price,
            "length": "10",
            "breadth": "10",
            "height": "10",
            "weight": "10",
            "ewaybill_no": "123456",
            "customer_gstin": "123456789"
     );

 

?>
           

