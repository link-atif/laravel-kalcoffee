<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
      <style type="text/css" media="all">
        body{font-family: Arial, Helvetica, sans-serif;}
        body h1{font-family: Arial, Helvetica, sans-serif;}
        body h2{font-family: Arial, Helvetica, sans-serif;}
        body h3{font-family: Arial, Helvetica, sans-serif;}
        body h4{font-family: Arial, Helvetica, sans-serif;}
        body h5{font-family: Arial, Helvetica, sans-serif;}
        body h6{font-family: Arial, Helvetica, sans-serif;}
        body p{font-family: Arial, Helvetica, sans-serif;}
        body a{font-family: Arial, Helvetica, sans-serif;}
        body span{font-family: Arial, Helvetica, sans-serif;}
        body td{font-family: Arial, Helvetica, sans-serif;}
        body tr{font-family: Arial, Helvetica, sans-serif;}
        body th{font-family: Arial, Helvetica, sans-serif;}
        body div{font-family: Arial, Helvetica, sans-serif;}
        body footer{font-family: Arial, Helvetica, sans-serif;}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 16cm;  
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #dee2e6;
}

#logo {
  float: left;
  margin: 0px 10px 0 0;
}

#logo img {
  height: 70px;
}

#company {
  float: left;
  text-align: left;
}


#details {
  margin-bottom: 50px;
}

#client {
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 16px;
  font-weight: 600;
  margin: 0;
  text-transform: capitalize;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #495057;
  font-size: 24px;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date2 {
  font-size: 1.1em;
  color: #723e0d;
  font-weight: bold;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tbody td {
  padding: 8px;
  border-bottom: 1px solid #dee2e6;
    text-align: left !important;
}

table th {
  white-space: nowrap;        
    color: #723e0d;
    padding: 6px;
    background: #fefefe;
    text-align: center;
    font-weight: bold;
    border-bottom: 1px solid #dee2e6;
    text-align: left;
}

table tbody{padding-bottom: 20px;}

table tbody tr:nth-child(even) {background: #fff;}
table tbody tr:nth-child(odd) {background: #f7f4f6}


table td {
  text-align: right;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 12px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 14px;
  white-space: nowrap;
  border-top: 1px solid #AAAAAA;
  font-weight: bold;
  color: #495057;
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  /* color: #57B223; */
  /* font-size: 1.4em; */
  /* border-top: 1px solid #57B223; */
}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  /* padding-left: 6px; */
  /* border-left: 6px solid #0087C3; */
}

#notices .notice {margin: 6px 0 0 0;}

footer {
  color: #777777;
  width: 100%;
  bottom: 0;
  padding: 8px 0;
  text-align: center;
}

#notices div{ font-size: 14px;}


footer .info_foot{text-align: center;color: #723e0d;border-top: solid 1px #723e0d;border-bottom: solid 1px #723e0d;font-size: 14px;font-weight: 600;padding: 8px 0px;margin: 70px 0 0 0;}
footer .info_foot a{ text-align: center; color: #723e0d;  font-size: 14px; font-weight: 600;}

footer p{font-size: 14px;line-height: 22px;margin: 7px 0 5px 0;color: #495057;}
footer p a{color: #495057;}

      </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{ asset('frontend/images/logo.jpg') }}">
      </div>
      <div id="company">
        <h2 class="name">KAL Coffee Co.</h2>
        <div>King Abdullah Road</div>
        <div>Jeddah 23214</div>
        <div>Saudi Arabia</div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Invoice #: {{ $invoice_number }}</div>
          <div class="to">Date: {{ $date }}</div>
          <div class="to">Name: {{ $client_name }}</div>
          <div class="to">Address: {{ $address }}</div>
        </div>
        <!-- <div id="invoice">
          <h1>Invoice # {{ $invoice_number }}</h1>
          <div class="date2">Invoice Date:</div>
          <div class="date date_fix">{{ $date }}</div>
        </div> -->
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>Description</th>
            <th>Weight</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Tax</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cartData as $d)
          <tr>
            <td>{{ $d->product_name }}</td>
            <td>{{ $d->bag_size }}</td>
            <td>{{ $d->quantity }}</td>
            <td>{{ $d->price }}</td>
            <td>{{ $v_tax }}%</td>
            <td>{{ $d->quantity*$d->price }} SR</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="3">SUBTOTAL</td>
            <td>{{ $sub_total }}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="3">TAX</td>
            <td>{{ $tax }}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="3">GRAND TOTAL</td>
            <td>{{ $grand_total }}</td>
          </tr>
        </tfoot>
      </table>
      <div id="notices">
        <div>Please use the following communication for your payment : Invoice # {{ $invoice_number }}</div>
        <div class="notice">Payment terms: Immediate Payment</div>
      </div>
    </main>
    <footer>
        <div class="info_foot"> <a href="#">info@Kalcoffee.com</a> Tax ID: 310157141300003</div>
        <p>
            Head Office: Jeddah, Saudi Arabia<br>
            P.O Box 6551 Zip 23214<br>
            Tel: +966 (2) 6503232 <a href="#">info@Ksalcoffee.com</a></p>
    </footer>
  </body>
</html>