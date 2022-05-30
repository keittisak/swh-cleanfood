<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label Print</title>
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
            font-size: 20px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 0 14mm;
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
            margin-bottom: 10px;
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

        .border1{
            
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

        .masonry-with-columns {
            columns: 2;
            column-gap: 1rem;
          }
          .masonry-with-columns div {
            position: relative;
            padding:5px;
            margin: 0 1rem 1rem 0;
            display: inline-block;
            width: 100%;
            border: 1px dashed #000;
          }

    </style>
</head>
<body>
    <div class="pick-print">

        @php
        $counter = 1;
        @endphp

        {{-- @foreach($orders as $order) --}}
        {{-- @if($counter%8 === 1) --}}
        <div class="page">
            <div class="subpage">
                <div class="masonry-with-columns">
        {{-- @endif --}}
                 @foreach($orders as $order)
                    <div>
                        <p style="font-weight: bold;">{{$order['order']->shipping_name}}</p>
                        <p @if(!empty($order['order']->shipping_location_url)) style="width: 11.5em;" @endif>#{{$order['order']->shipping_phone}} ที่อยู่: {{$order['order']->shipping_address}}</p>
                        <p>โซนจัดส่ง: {{$shippingZone[$order['order']->shipping_zone]['short_title']}}</p>
                        {{-- <p>กล่องใส่อาหาร: {{($order['order']->packing_charge)?'ไมโครเวฟ':'ธรรมดา'}}</p> --}}
                        @if(!empty($order['order']->shipping_location_url))
                        <span style="position:absolute;top:0;right:0;">{!! QrCode::size(100)->generate($order['order']->shipping_location_url) !!}</span>
                        @endif
                        <table @if(!empty($order['order']->shipping_location_url))style="margin-top:26px"@endif>
                                <thead>
                                    <tr>
                                        <th>เมนูอาหาร</th>
                                        <th width="10%">จำนวน</th>
                                    </tr>
                                </thead>
                                @foreach($order['details'] as $detail)
                                <tr>
                                <td>{{$detail->name}} {{($detail->menu_name)?$detail->menu_name:''}} {{($detail->remark)?'('.$detail->remark.')':''}}</td>
                                    <td class="text-center">{{$detail->quantity}}</td>
                                </tr>
                                @endforeach
                            </table>
                    </div>
                @php
                $counter ++;
                @endphp
                @endforeach
        {{-- @if($counter%8 === 0) --}}
                </div>
            </div>
        </div> <!--endpage-->
        {{-- @endif --}}
        {{-- @php
        $counter ++;
        @endphp --}}

        {{-- @endforeach --}}


        

    </div>
</body>
</html>