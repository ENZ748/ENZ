<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color:rgb(255, 255, 255);
        }
        .logo-header {
            text-align: center;
            padding: 20px 0;
            background-color: white;
        }
        .logo-container {
            display: inline-block;
            margin: 0 auto;
        }
        .logo {
            width: 150px;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }
        .header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #173753;
            margin: 10px 0;
        }
        .header p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 20px;
            font-size: 12px;
            table-layout: fixed;
        }
        th, td {
            padding: 6px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #173753;
            color: white;
        }
        .status {
            background-color: #6daedb;
            padding: 4px 6px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            font-size: 11px;
            display: inline-block;
        }
        .notes {
            background-color: #2892d7;
            padding: 4px 6px;
            border-radius: 4px;
            color: white;
            font-size: 11px;
            display: inline-block;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            margin-top: 50px;
        }
        .signature-box .signature-space {
            height: 60px;
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
        }
        .signature-label {
            font-size: 12px;
            color: #555;
        }
        .hr-section {
            margin-top: 30px;
            font-size: 12px;
        }
        .hr-section p {
            margin: 5px 0;
        }
        .Date {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }
    </style>
</head>
<body>
    <div class="logo-header">
        <div class="logo-container">
            <img src="{{ public_path('ENZPDF.png') }}" alt="Logo" class="logo">
        </div>
    </div>
        <div class="header">
            <h2>ASSET RETURN FORM</h2>
            <p><strong>Name of Item Holder:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
            <p><strong>Department:</strong> {{ $employee->department }}</p>
            <p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>
            <p><strong>Original Issuance Number:</strong> {{ $return_forms->first()->issuance_number ?? 'N/A' }}</p>
            <p><strong>Reason for Returning Assets:</strong> Returned items as per company policy</p>
            <p><strong>Total Assets Returned:</strong> {{ count($return_forms) }} Asset(s)</p>
        </div>

        @if(count($return_forms) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Category & Brand</th>
                        <th>Unit</th>
                        <th>Serial Number</th>
                        <th>Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($return_forms as $return_form)
                    <tr>
                        <td>
                            {{ $return_form->itemHistory->item->category->category_name ?? 'N/A' }} -
                            {{ $return_form->itemHistory->item->brand->brand_name ?? 'N/A' }}
                        </td>
                        <td>{{ $return_form->itemHistory->item->unit->unit_name ?? 'N/A' }}</td>
                        <td>{{ $return_form->itemHistory->item->serial_number ?? 'N/A' }}</td>
                        <td>{{ $return_form->asset_form->issuance_number }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @else
            <p>No asset history available.</p>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-space"></div>
                <div class="signature-label">Signature over printed name of the Returns</div>
            </div>

            <div class="signature-box">
                <div class="signature-space"></div>
                <div class="signature-label">Signature over printed name of the Reciever</div>
            </div>
        </div>

        <div class="hr-section">
            <p><i>For HR Use Only:</i></p>
            <p><strong>Accountability Number:</strong> ________________________</p>
            <p><strong>Items Date Received:</strong> ________________________</p>
            <p><strong>Assets Date Validated:</strong> ________________________</p>
            <p><strong>Items Transferred To:</strong> ________________________</p>
            <div class="transfer-date">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</p>
            </div>
        </div>
</body>
</html>