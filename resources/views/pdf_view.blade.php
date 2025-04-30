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
        }
        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            width: 150px; /* Medium size */
            height: auto;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #173753;
            color: white;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-evenly;
        } 
        .signature-box {
            width: 45%;
            margin-top: 100px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
            margin: 10px 0 5px 0;
        }
        .signature-label {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
        }
        .signature-name {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
            font-weight: bold;
        }
        .terms {
            margin: 20px 0;
            font-size: 11px;
            line-height: 1.4;
        }
        .date-section {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="logo-container">
    <img src="data:image/png;base64,{{ $logo }}" alt="Logo" class="logo">
</div>
<h1>ACCOUNTABILITY FORM</h1>

    <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</p>
    <p><strong>Issuance Number:</strong> ENZACT{{ \Carbon\Carbon::now()->format('Y') }}1</p>
    <p><strong>Department:</strong> {{ $employee->department }}</p>
    <p><strong>Name of Item Holder:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
    <p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>

    @if(count($assigned_items) > 0)
        <h3>Assigned Items</h3>

        <table>
            <thead>
                <tr>
                    <th>Category & Brand</th>
                    <th>Unit</th>
                    <th>Serial Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assigned_items as $assigned_item)
                    <tr>
                        <td>{{ $assigned_item->item->category->category_name }} - {{ $assigned_item->item->brand->brand_name }}</td>
                        <td>{{ $assigned_item->item->unit->unit_name }}</td>
                        <td>{{ $assigned_item->item->serial_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No assets currently assigned.</p>
    @endif

    <div class="terms">
        <p>I understand that this has been loaned to me and is the sole property of ENZ Education Consultancy Services. I am expected to exercise due care in my use of this property and to utilize such property only for authorized purposes. Negligence in the care and use will be considered cause for disciplinary action.</p>
        <p>I also understand that the company property must be returned to ENZ Education Consultancy Services at the time of my separation from employment or when it is requested by my manager or supervisor and that I will be charged for any property issued and not returned to the Company.</p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <!-- Employee Signature on the left -->
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Signiture over printed name of the Employee's</div>
        </div>

        <!-- Manager Signature on the right -->
        <div class="signature-box">
            <div class="signature-name">Shaira Vae Sulit</div>
            <div class="signature-line"></div>
            <div class="signature-label">Signiture over printed name of the Manager, People and Culture</div>
        </div>
    </div>

    <!-- Date Section -->
    <div class="date-section">
        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</p>
    </div>
</body>
</html>