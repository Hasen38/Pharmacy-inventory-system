<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }

        /* Invoice container */
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header styles */
        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .invoice-header h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 15px;
        }

        /* Details section */
        .invoice-details {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .invoice-details h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tfoot td {
            background: #f8f9fa;
            font-weight: bold;
        }

        /* Print button */
        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-btn {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Print media query */
        @media print {
            body {
                background: white;
            }
            .invoice-box {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <p>Invoice #: {{ $sale->id }}</p>
            <p>Date: {{ date('F d, Y', strtotime($sale->sale_date)) }}</p>
        </div>

        <div class="invoice-details">
            <h3>Customer Details</h3>
            <p>Name: {{ $sale->customer->name }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>${{ number_format($sale->price, 2) }}</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total Amount:</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="print-button">
            <button onclick="window.print()" class="print-btn">Print Invoice</button>
        </div>
    </div>

    <script>
        // Auto-print when generating PDF
        @if(isset($autoPrint) && $autoPrint)
            window.onload = function() {
                window.print();
            }
        @endif
    </script>
</body>
</html>
