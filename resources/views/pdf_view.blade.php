<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountability Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            font-size: 12px;
            width: 8.5in; /* Standard bond paper width */
            max-width: 100%;
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #173753;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
            table-layout: auto; /* Makes columns fit content */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #5a92c5;
            vertical-align: middle;
        }
        th {
            background-color: #173753;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e8f1f9;
        }
        tr:hover {
            background-color: #d0e1f2;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .signature-box {
            width: 48%;
            margin-top: 0;
        }
        .signature-line {
            border-top: 1px solid #173753;
            width: 100%;
            margin: 10px 0 5px 0;
        }
        .signature-label {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
            color: #173753;
        }
        .signature-name {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
            font-weight: bold;
            color: #173753;
        }
        .terms {
            margin: 20px 0;
            font-size: 11px;
            line-height: 1.4;
            /* Removed border, padding, and background */
        }
        .date-section {
            margin-top: 30px;
            color: #173753;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo {
            max-width: 100px;
            height: auto;
        }
        .header-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        .header-info p {
            margin: 5px 0;
            color: #173753;
        }
        .header-info strong {
            display: inline-block;
            width: 150px;
        }
        h3 {
            color: #173753;
            border-bottom: 2px solid #5a92c5;
            padding-bottom: 5px;
        }
        .page-container {
            min-height: 11in; /* Standard bond paper height */
            position: relative;
            padding-bottom: 30px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0.5in;
            }
            .page-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
<div class="page-container">
    <!-- Added logo-container div to center the logo -->
    <div class="logo-container">
        <img class="logo" src="EnzLogo.png" alt="Logo">
    </div>
    <h1>ACCOUNTABILITY FORM</h1>

    <div class="header-info">
        <p><strong>Date:</strong> Apr 11, 2025</p>
        <p><strong>Issuance Number:</strong> ENZACT20251</p>
        <p><strong>Department:</strong> IT Department</p>
        <p><strong>Name of Item Holder:</strong> John Doe</p>
        <p><strong>Employee Number:</strong> EMP-12345</p>
    </div>

    <h3>Assigned Items</h3>

    <table>
        <thead>
            <tr>
                <th width="40%">Category & Brand</th>
                <th width="30%">Unit</th>
                <th width="30%">Serial Number</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Laptop - Dell</td>
                <td>Latitude 5420</td>
                <td>SN12345678</td>
            </tr>
            <tr>
                <td>Monitor - LG</td>
                <td>UltraWide</td>
                <td>LG87654321</td>
            </tr>
        </tbody>
    </table>

    <div class="terms">
        <p>I understand that this has been loaned to me and is the sole property of ENZ Education Consultancy Services. I am expected to exercise due care in my use of this property and to utilize such property only for authorized purposes. Negligence in the care and use will be considered cause for disciplinary action.</p>
        <p>I also understand that the company property must be returned to ENZ Education Consultancy Services at the time of my separation from employment or when it is requested by my manager or supervisor and that I will be charged for any property issued and not returned to the Company.</p>
    </div>

    <div class="signature-section">
        <!-- Employee Signature (Left Side) -->
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Employee's Signature</div>
        </div>

        <!-- Manager Signature (Right Side) -->
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-name">Shaira Vae Sulit</div>
            <div class="signature-label">Manager, People and Culture</div>
        </div>
    </div>

    <!-- Date Section -->
    <div class="date-section">
        <p><strong>Date:</strong> Apr 11, 2025</p>
    </div>
</div>
</body>
</html>