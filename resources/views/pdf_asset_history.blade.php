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
        .container {
            padding: 30px;
            background-color: white;
            margin: 20px auto;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .header h2 {
            font-size: 28px;
            font-weight: bold;
            color: #173753;
            margin: 10px 0;
        }
        .header p {
            font-size: 16px;
            color: #555;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
        }
        .history-table th, .history-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .history-table th {
            background-color: #173753;
            color: white;
            font-weight: bold;
        }
        .history-table td {
            background-color: #f9f9f9;
        }
        .history-table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }
        .status {
            background-color: #6daedb;
            padding: 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .notes {
            background-color: #2892d7;
            padding: 8px;
            border-radius: 4px;
            color: white;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-box .signature-line {
            border-top: 1px solid #333;
            width: 100%;
            margin: 20px auto;
        }
        .signature-label {
            font-size: 14px;
            color: #555;
        }
        .signature-name {
            font-size: 16px;
            font-weight: bold;
            color: #173753;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Asset History for {{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <p><strong>Department:</strong> {{ $employee->department }}</p>
            <p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>
            <p><strong>Reason for Returning Assets:</strong> Returned items as per company policy</p>
            <p><strong>Total Assets Returned:</strong> {{ count($history_items) }} Asset(s)</p>
        </div>

        @if(count($history_items) > 0)
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Category & Brand</th>
                        <th>Unit</th>
                        <th>Serial Number</th>
                        <th>Assigned Date</th>
                        <th>Return Date</th>
                        <th>Notes</th>
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
                <div class="signature-line"></div>
                <div class="signature-label">Employee's Signature</div>
            </div>

            <div class="signature-box">
                <div class="signature-name">Shaira Vae Sulit</div>
                <div class="signature-line"></div>
                <div class="signature-label">Manager, People and Culture</div>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <p><strong>For HR Use Only:</strong></p>
            <p><strong>Accountability Number:</strong> ________________________</p>
            <p><strong>Items Date Received:</strong> ________________________</p>
            <p><strong>Assets Date Validated:</strong> ________________________</p>
            <p><strong>Items Transferred To:</strong> ________________________</p>
        </div>
    </div>
</body>
</html>
