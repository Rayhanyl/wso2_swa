<html>

<head>
    <title>REPORT MONTHLY API USAGE API SWAMEDIA (DETAIL)</title>
</head>
<style type="text/css">
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .first-text {
        text-align: left !important;
        font-size: 16px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .second-text {
        font-weight: bold;
        font-size: 16px;
    }

    .text-capitalize{
        text-transform: capitalize;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .my-10 {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .my-20 {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-end {
        text-align: right !important;
    }

    .text-start {
        text-align: left !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-70 {
        width: 70%;
    }

    .w-85 {
        width: 85%;
    }

    .w-30 {
        width: 30%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 45px;
        height: 45px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 2px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
        background-color: #FFFFFF;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }

</style>

<body>
    <div class="head-title">
        <h4 class="m-0 p-0">REPORT MONTHLY API USAGE API SWAMEDIA (DETAIL)</h4>
    </div>
    <div class="table-section mt-20">
        <table class="table w-100 mt-10">
            <tr>
                <th class="first-text w-50">Year</th>
                <td class="w-50">{{ $year }}</td>
            </tr>
            <tr>
                <th class="first-text w-50">Month</th>
                <td class="w-50">{{ $month }}</td>
            </tr>
            <tr>
                <th class="first-text w-50">Customer</th>
                <td class="w-50 text-capitalize">{{ $organization }}</td>
            </tr>
            <tr>
                <th class="first-text w-50">Application</th>
                <td class="w-50">{{ $app }}</td>
            </tr>
            <tr>
                <th class="first-text w-50">API</th>
                <td class="w-50">{{ $api }}</td>
            </tr>
        </table>
    </div>
    <div class="my-20">
        <p class="second-text">Response Count :<span>&nbsp; {{ $request_count }}</span></p>
        <p class="second-text">Response OK :<span>&nbsp; {{ $request_ok }}</span></p>
        <p class="second-text">Response NOK :<span>&nbsp; {{ $request_nok }}<</span></p>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Resource</th>
                    <th>Response Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $item)
                <tr>
                    <td>{{ $item->requestTimestamp }}</td>
                    <td>{{ $item->resource }}</td>
                    <td>{{ $item->proxyResponseCode }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
