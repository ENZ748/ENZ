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
            width: 150px;
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
<p><strong>Issuance Number:</strong> {{ $item_forms->first()->issuance_number ?? 'N/A' }}</p>
<p><strong>Department:</strong> {{ $employee->department }}</p>
<p><strong>Name of Item Holder:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
<p><strong>Employee Number:</strong> {{ $employee->employee_number }}</p>

@if(count($item_forms) > 0)
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
            @foreach($item_forms as $item_form)
                <tr>
                    <td>{{ $item_form->assignedItem->item->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $item_form->assignedItem->item->brand->brand_name ?? 'N/A' }}</td>
                    <td>{{ $item_form->assignedItem->item->unit->unit_name ?? 'N/A' }}</td>

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
    <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-label">Signature over printed name of the Employee</div>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-label">Signature over printed name of the Manager, People and Culture</div>
    </div>
</div>

<!-- Date Section -->
<div class="date-section">
    <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</p>
</div>

</body>
</html>
