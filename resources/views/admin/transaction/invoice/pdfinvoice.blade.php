<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    @page {
      size: A4;
      margin: 0;
      /* Adjust page-specific styles here */
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.5;
    }

    .header {
      background-color: #6a7cbd;
      padding: 10px;
      text-align: center;
    }

    .header-logo {
      margin-bottom: 10px;
    }

    .header-logo img {
      max-width: 200px;
    }

    .content {
      padding: 20px;
    }

    .section {
      margin-bottom: 20px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .section-content {
      /* Add your specific section styles here */
    }
    .section-footer {

    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }

    th, td {
      padding: 8px;
      border: 1px solid #ccc;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-10{
        width: 10%;
    }

    .w-25{
        width: 25%;
    }

    .w-75{
        width: 75%;
    }

    .mt-20{
        margin-top: 20px;
    }

    .no-border{
        border: 0px;
    }
  </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
        </div>
        <h1 style="color:#FFF;">INVOICE</h1>
        <h2 style="color:#FFF;">{{ $invoice->data->invoice->id }}</h2>
    </div>
    <div class="content">
        <div class="section">
        <div class="section-content">
            <div>
                <table class="w-100">
                    <tr>
                        <td class="w-25 no-border">
                            <table class="w-100" style="text-align:left;">
                                <tr>
                                    <th class="w-10 no-border" style="font-size:14px;text-align:left;">Bill to</th>
                                    <td class="w-10 no-border" style="text-align:left;text-transform: capitalize;">{{ $invoice->data->invoice->customerId }} - ({{ $invoice->data->invoice->organizationName }})</td>
                                </tr>
                                <tr>
                                    <th class="w-10 no-border" style="font-size:14px;text-align:left;">Address</th>
                                    <td class="w-10 no-border" style="text-align:left;">{{ $invoice->data->invoice->addresses }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25 no-border" style="font-size:14px;text-align:left;">Phone</th>
                                    <td class="w-25 no-border" style="text-align:left;">{{ $invoice->data->invoice->telephoneNumber }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="w-25 no-border">
                            <table class="w-100" style="text-align:left;">
                                <tr>
                                    <th class="w-25 no-border" style="font-size:14px;text-align:left;">Issue date</th>
                                    <td class="w-25 no-border" style="text-align:left;">{{ \Carbon\Carbon::parse($invoice->data->invoice->createdDate)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25 no-border" style="font-size:14px;text-align:left;">Period</th>
                                    <td class="w-25 no-border" style="text-align:left;">{{ \Carbon\Carbon::parse($invoice->data->invoice->periodStartDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($invoice->data->invoice->periodEndDate)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25 no-border" style="font-size:14px;text-align:left;">Due date</th>
                                    <td class="w-25 no-border" style="text-align:left;">{{ \Carbon\Carbon::parse($invoice->data->invoice->dueDate)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25 no-border" style="font-size:14px;text-align:left;">Total Amount</th>
                                    <td class="w-25 no-border" style="text-align:left;">{{ "Rp" . number_format($invoice->data->invoice->grandTotal, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
    <div class="section">
      <div class="section-content">
        <table>
          <thead>
            <tr>
              <th>API Name</th>
              <th>Application Name</th>
              <th>Business Plan</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Tax</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoice->data->invoiceItems as $item)
                <tr>
                    <td>{{ $item->apiName }}</td>
                    <td>{{ $item->applicationName }}</td>
                    <td>{{ $item->tierId }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ "Rp " . number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->discount }} %</td>
                    <td>{{ $item->tax }} %</td>
                    <td>{{ "Rp " . number_format($item->grandTotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="section">
        <div class="section-content">
            <p><b>Additional Comments</b> : Mohon melakukan pembayaran dalam waktu ({{ $days }}) hari </p>
        </div>
        <div class="w-50" style="margin-top: 30px; margin-bottom:30px;">
            <p style="font-weight:bold; font-size:18px;">Swamedia <span style="color:#FFA41C;">X</span><span style="color:#003399;">10S</span></p>
            <p>Jl. Sido Mulyo No.29, Sukaluyu, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40123</p>
            <p>(022) 2500442</p>
            <p>swamedia@x10s.co.id</p>
        </div>
        <div style="text-align:center; position:fixed; bottom:0; left:0px; width:100%;">
            <p style="font-weight:bold;">Thank you for your business !</p>
            <p>If you have any question or inqueries please contact : </p>
            <p>Contact Name : Admin  (022) 892-0987 or swamedia@x10s.co.id</p>
        </div>
    </div>
  </div>
</body>
</html>
