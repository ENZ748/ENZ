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
            background-color: #f8f8f8;
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
        .container {
            padding: 20px;
            background-color: white;
            margin: 10px auto;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        .history-table th, .history-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            line-height: 1.2;
        }
        .history-table th {
            background-color: #173753;
            color: white;
            font-weight: bold;
            padding: 8px;
        }
        .history-table td {
            background-color: #f9f9f9;
            padding: 8px;
        }
        .history-table tr:nth-child(even) td {
            background-color: #f1f1f1;
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
    
    <div class="container">
        <div class="header">
            <h2>ASSET RETURN FORM</h2>
            <p><strong>Name of Item Holder:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
            <p><strong>Department:</strong> {{ $employee->department }}</p>
            <p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>
            <p><strong>Reason for Returning Assets:</strong> Returned items as per company policy</p>
            <p><strong>Total Assets Returned:</strong> {{ count($history_items) }} Asset(s)</p>
        </div>

        @if(count($history_items) > 0)
            <table class="history-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Category & Brand</th>
                        <th style="width: 15%;">Unit</th>
                        <th style="width: 15%;">Serial Number</th>
                        <th style="width: 15%;">Assigned Date</th>
                        <th style="width: 15%;">Return Date</th>
                        <th style="width: 25%;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history_items as $history_item)
                        <tr>
                            <td>
                                {{ $history_item->item->category->category_name }} - 
                                {{ $history_item->item->brand->brand_name }}
                            </td>
                            <td>{{ $history_item->item->unit->unit_name }}</td>
                            <td>{{ $history_item->item->serial_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="status">
                                    {{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                @if($history_item->notes)
                                    <div class="notes">
                                        {{ Str::limit($history_item->notes, 50) }}
                                    </div>
                                @else
                                    <span>No Notes</span>
                                @endif
                            </td>
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
                <div class="signature-label">Signiture over printed name of the Returnes</div>
            </div>

            <div class="signature-box">
                <div class="signature-space"></div>
                <div class="signature-label">Signiture over printed name of the Reciever</div>
            </div>
        </div>

        <div class="hr-section">
            <p><strong>For HR Use Only:</strong></p>
            <p><strong>Accountability Number:</strong> ________________________</p>
            <p><strong>Items Date Received:</strong> ________________________</p>
            <p><strong>Assets Date Validated:</strong> ________________________</p>
            <p><strong>Items Transferred To:</strong> ________________________</p>
            <div class="transfer-date">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</body>
</html>