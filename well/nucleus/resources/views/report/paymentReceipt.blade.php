<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cash Receipt</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
           
            padding: 0;
            color: #000;
        }

        .receipt {
            width: 100%;
            margin: auto;
            border: 1px solid #000;
            padding: 10px;
        }

        /* HEADER */
        .header-table {
            width: 100%;
            margin-bottom: 5px;
        }
        .header-left {
            width: 70%; /* Left side বেশি জায়গা নেবে */
            font-size: 22px;
            font-weight: bold;
        }
        .header-left small {
            display: block;
            font-size: 11px;
            font-weight: normal;
        }
        .header-right {
            width: 30%; /* Right side compact */
            text-align: right;
            vertical-align: top;
        }
        .receipt-no {
            font-size: 22px;
            font-weight: bold;
        }
        .receipt-title {
            font-size: 20px;
            font-weight: bold;
        }

        /* GREY BAR */
        .bar {
            height: 14px;
            background: #cfcfcf;
            margin-bottom: 10px;
        }

        /* BODY TABLE */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table td {
            padding: 5px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 120px; /* Label width adjust */
        }
        .line {
            border-bottom: 1px solid #000;
        }

        /* FOOTER */
        .footer {
            font-size: 12px;
        }
        .sign-row {
            width: 100%;
            margin-top: 40px;
        }
        .sign-row td {
            width: 50%;
            text-align: center;
            padding-top: 50px;
        }
        .address {
            text-align: center;
            font-size: 11px;
            line-height: 1.3;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="receipt">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <td class="header-left">
                    R.K. AGRO-LIMITED
                    <small>GROWN BY NATURE</small>
                </td>
                <td class="header-right">
                    <div class="receipt-no">#{{ $paymentReceipts->payment_uid }}</div>
                    <div class="receipt-title">CASH RECEIPT</div>
                </td>
            </tr>
        </table>

        <div class="bar"></div>

        <!-- BODY -->
        <table class="content-table">
            <tr>
                <td class="label">DATE :</td>
                <td class="line">{{ $paymentReceipts->printed_at }}</td>
                <td class="label">JOB NUMBER :</td>
                <td class="line">{{ $paymentReceipts->payment_uid }}</td>
            </tr>
            <tr>
                <td class="label">AMOUNT RECEIVED :</td>
                <td class="line" colspan="3">{{ $paymentReceipts->receipt_tk ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">IN WORD :</td>
                <td class="line" colspan="3">{{ $inword ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">FROM :</td>
                <td class="line" colspan="3"></td>
            </tr>
            <tr>
                <td class="label">ADDRESS :</td>
                <td class="line" colspan="3"></td>
            </tr>
            <tr>
                <td class="label">PHONE :</td>
                <td class="line" colspan="3"></td>
            </tr>
            <tr>
                <td class="label">FOR :</td>
                <td class="line" colspan="3"></td>
            </tr>
        </table>

        <!-- FOOTER -->
        <table class="footer sign-row">
            <tr>
                <td>CUSTOMER'S SIGNATURE</td>
                <td>AUTHORISED SIGNATORY</td>
            </tr>
        </table>

        <div class="address">
            2 No. Dhakeswari, Godenail, Narayanganj-1432, (Beside R.K Spinning Mills Ltd.)<br>
            Phone : +88 019 700 20 180
        </div>

    </div>
</body>
</html>
