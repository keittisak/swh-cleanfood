<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lists Print</title>
    <style>
        @font-face {
            font-family: 'THSarabunPSK';
             src: url('/fonts/THSarabunPSK.eot') format('embedded-opentype'),
                 url('/fonts/THSarabunPSK.svg') format('svg'),
                 url('/fonts/THSarabunPSK.ttf') format('truetype'),
                 url('/fonts/THSarabunPSK.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'THSarabunPSK', 'Tahoma';
            font-size: 20px;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 24px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 14mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            /*border: 1px solid #000;*/
            display: grid;
        }

        .wrap-row {
            width: 100%;
            float: left;
        }

        .wrap-col-50 {
            width: 50%;
            float: left;
            padding: 8px;
        }

        .wrap-col-100 {
            width: 100%;
            float: left;
            padding: 8px;
        }

        .wrap-col-80 {
            width: 100%;
            float: left;
            padding: 8px;
        }

        .wrap-col-50>h2 {
            margin: 0;
        }

        .wrap-col-80>h2 {
            margin: 0;
        }

        .wrap-col-100>h2 {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .sku-id {
            padding-left: 10px;
        }

        table {
            margin-top: 15px;
            margin-bottom: 30px;
            width: 100%;
            font-size: 18px;
        }

        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 3px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            html,
            body {
                width: 210mm;
                height: 297mm;
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="pick-print">
        <div class="page">
            <div class="subpage">
                <div class="wrap-row">
                    <div class="wrap-col-50">
                        <h2>รายการอาหาร</h2>
                        <p>{!! date("Y-m-d H:i:s") !!}</p>
                    </div>
                </div>
                <div class="wrap-row">
                    <div class="wrap-col-100">
                        <table class="picking-list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>เมนู</th>
                                    <th>จำนวน</th>
                                    <th>โซนจัดส่ง</th>
                                    {{-- <th>กล่องใส่อาหาร</th> --}}
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tobody>
                                @foreach($details as $index => $data)
                                <tr>
                                    <td class="text-center">{{($index+1)}}</td>
                                    <td>{{$data->name}} {{($data->type === 'material')?'#'.$data->menu_name:''}}</td>
                                    <td class="text-center">{{$data->quantity}}</td>
                                    <td class="text-center">{{$shippingZone[$data->shipping_zone]['short_title']}}</td>
                                    {{-- <td class="text-center">{{($data->packing_charge)?'เวฟ':'ธรรมดา'}}</td> --}}
                                    <td>{{$data->remark}}</td>
                                </tr>
                                @endforeach
                            </tobody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>