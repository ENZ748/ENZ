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
            padding: 15px;
            background-color: white;
            margin: 10px auto;
            width: 95%;
            max-width: 720px; /* Adjusted for bandpaper width */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* For bandpaper dimensions (typically longer) */
            min-height: 1100px; /* Approximate bandpaper length */
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
            margin: 8px 0;
        }
        .header p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
            line-height: 1.3;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 1px solid #ddd;
            table-layout: fixed; /* Changed to fixed for bandpaper */
            font-size: 12px; /* Smaller text for bandpaper format */
        }
        .history-table th, .history-table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word;
        }
        .history-table th {
            background-color: #173753;
            color: white;
            font-weight: bold;
            white-space: nowrap;
        }
        .history-table th:nth-child(odd), .history-table td:nth-child(odd) {
            background-color: #f0f7ff;
        }
        .history-table th:nth-child(even), .history-table td:nth-child(even) {
            background-color: #e6f0ff;
        }
        .history-table th:nth-child(odd), .history-table th:nth-child(even) {
            background-color: #173753;
        }
        /* Column widths optimized for bandpaper */
        .history-table th:nth-child(1), .history-table td:nth-child(1) { width: 18%; }
        .history-table th:nth-child(2), .history-table td:nth-child(2) { width: 15%; }
        .history-table th:nth-child(3), .history-table td:nth-child(3) { width: 15%; }
        .history-table th:nth-child(4), .history-table td:nth-child(4) { width: 15%; }
        .history-table th:nth-child(5), .history-table td:nth-child(5) { width: 15%; }
        .history-table th:nth-child(6), .history-table td:nth-child(6) { width: 22%; }
        
        .status {
            background-color: #6daedb;
            padding: 5px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            display: inline-block;
            font-size: 11px;
        }
        .notes {
            background-color: #2892d7;
            padding: 5px;
            border-radius: 3px;
            color: white;
            font-size: 11px;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-box .signature-line {
            border-top: 1px solid #333;
            width: 100%;
            margin: 15px auto;
        }
        .signature-label {
            font-size: 12px;
            color: #555;
        }
        .signature-name {
            font-size: 14px;
            font-weight: bold;
            color: #173753;
            margin-bottom: 8px;
        }
        .hr-section {
            margin-top: 30px;
        }
        .hr-section p {
            margin: 5px 0;
            font-size: 14px;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        
        /* For bandpaper print settings */
        @media print {
            @page {
                size: 8.5in 13in; /* Standard bandpaper size */
                margin: 0.5in;
            }
            body {
                background-color: white;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-width: none;
            }
        }
        .logo {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <img class="logo" src="EnzLogo.png" alt="Logo">
            <h2>Asset History for John Doe</h2>
            <p><strong>Name of Item Holder:</strong> John Doe</p>
            <p><strong>Department:</strong> IT Department</p>
            <p><strong>Employee Number:</strong> EMP-12345</p>
            <p><strong>Reason for Returning Assets:</strong> Returned items as per company policy</p>
            <p><strong>Total Assets Returned:</strong> 2 Asset(s)</p>
        </div>

        <div class="table-wrapper">
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
                    <tr>
                        <td>Laptop - Dell</td>
                        <td>Latitude 5420</td>
                        <td>SN12345678</td>
                        <td>Jan 15, 2025</td>
                        <td>
                            <span class="status">Apr 11, 2025</span>
                        </td>
                        <td>
                            <div class="notes">Good condition, minor scratches</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Monitor - LG</td>
                        <td>UltraWide</td>
                        <td>LG87654321</td>
                        <td>Jan 15, 2025</td>
                        <td>
                            <span class="status">Apr 11, 2025</span>
                        </td>
                        <td>
                            <span>No Notes</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="hr-section">
            <p><strong>For HR Use Only:</strong></p>
            <p><strong>Accountability Number:</strong> ________________________</p>
            <p><strong>Items Date Received:</strong> ________________________</p>
            <p><strong>Assets Date Validated:</strong> ________________________</p>
            <p><strong>Items Transferred To:</strong> ________________________</p>
        </div>

        <div class="signature-section">
            <!-- Employee Signature (Left Side) -->
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Employee's Signature</div>
            </div>

            <!-- Manager Signature (Right Side) -->
            <div class="signature-box">
                <div class="signature-name">Shaira Vae Sulit</div>
                <div class="signature-line"></div>
                <div class="signature-label">Manager, People and Culture</div>
            </div>
        </div>
    </div>
</body>
</html>