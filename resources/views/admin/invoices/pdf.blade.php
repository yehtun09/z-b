<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->invoice_code }}</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #60A7A6;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .invoice table tbody tr:nth-child(even) {
            background-color: #60A7A6;
        }

        .invoice table tbody tr:nth-child(odd) {
            background-color: grey;
        }
    </style>

</head>

<body>

    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 40%;">

                </td>
                <td align="right" style="width: 40%;">

                    <p>Date Issues : {{ date('d/m/Y', strtotime($invoice->date)) }}
                    </p>
                </td>
            </tr>

        </table>
    </div>


    <br />

    <div class="invoice">

        <table width="96%">
            <thead>
                <tr style="background-color: #60A7A6;">
                    <td align="center">Item</td>
                    <td align="center">UNIT PRICE</td>
                    <td align="center">Qty</td>
                    <td align="center">Price</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->products as $product)
                    <tr>
                        <td align="left">{{ $product->product_name }}</td>
                        <td align="right">{{ (int) $product->price }} Ks</td>
                        <td align="right">{{ $product->pivot->qty }}</td>
                        <td align="right">{{ (int) $product->price * $product->pivot->qty }} Ks</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align:left">
                        Total
                    </td>
                    <td style="text-align:right">
                        {{ $invoice->sub_total }} Ks
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
