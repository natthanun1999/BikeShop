<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order</title>

    <style>
        body {
            font-family: "Garuda", sans-serif;
        }

        table tr th {
            padding: 5px;
            background-color: #f7f7f7;
        }

        table tr td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td colspan="2" align="center">
                <h1>ใบสั่งซื้อ</h1>
                <h2>(Purchase Order)</h2>
            </td>
        </tr>
    
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>ชื่อลูกค้า :</strong></td>
                        <td>{{ $cust_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>อีเมล์ :</strong></td>
                        <td>{{ $cust_email }}</td>
                    </tr>
                </table>
            </td>
    
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>เลขที่ :</strong></td>
                        <td>{{ $po_no }}</td>
                    </tr>
                    <tr>
                        <td><strong>วันที่ :</strong></td>
                        <td>{{ $po_date }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    
        <tr>
            <td colspan="2">
                <table border="1" width="100%" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th style="text-align: center">ลำดับ</th>
                            <th style="text-align: center">ชื่อสินค้า</th>
                            <th style="text-align: center">ราคา/หน่วย</th>
                            <th style="text-align: center">จำนวน</th>
                            <th style="text-align: center">รวมเงิน</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($cart_items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td align="right">{{ number_format($item['price'], 0) }}</td>
                                <td align="right">{{ number_format($item['qty'], 0) }}</td>
                                <td align="right">{{ number_format($item['price'] * $item['qty'], 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    
        <tr>
            <td>
                <h4>หมายเหตุ</h4>
                <ul>
                    <li>ชำระเงินโดยโอนเข้าบัญชี XXX ธนาคาร YYY สาขา ZZZ (ออมทรัพย์)</li>
                    <li>กรุณาชำระเงินภายใน 7 วัน หลังจากที่สั่งซื้อ</li>
                    <li>ชำระเงินแล้วส่งหลักฐานมาที่ sales@bikeshop.com หรือ LINE : @bikeshop</li>
                </ul>
            </td>
    
            <td align="right">
                <strong>จำนวนเงินรวมทั้งสิ้น</strong>
                <h1>{{ number_format($total_amount, 0) }} บาท</h1>
            </td>
        </tr>
    </table>
</body>
</html>