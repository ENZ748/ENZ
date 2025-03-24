<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Selection Form</title>
    <script>
        // Function to update brand options based on category selection
        function updateBrandOptions() {
            const category = document.getElementById('category').value;
            const brandSelect = document.getElementById('brand');
            const unitSelect = document.getElementById('unit');

            // Clear current brand options
            brandSelect.innerHTML = '';
            unitSelect.innerHTML = '';

            // Default options
            let brandOptions = [];
            let unitOptions = [];

            if (category === 'laptop') {
                brandOptions = ['Samsung', 'Dell', 'HP'];
                unitOptions = ['piece', 'box'];
            } else if (category === 'electronics') {
                brandOptions = ['Sony', 'Panasonic', 'LG'];
                unitOptions = ['piece', 'box'];
            } else if (category === 'clothing') {
                brandOptions = ['Nike', 'Adidas', 'Puma'];
                unitOptions = ['piece'];
            } else if (category === 'furniture') {
                brandOptions = ['Ikea', 'Wayfair', 'Ashley'];
                unitOptions = ['piece'];
            }

            // Populate the brand dropdown with options based on the selected category
            brandOptions.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand.toLowerCase();
                option.textContent = brand;
                brandSelect.appendChild(option);
            });

            // Update the unit dropdown based on category
            unitOptions.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                unitSelect.appendChild(option);
            });
        }

        // Function to update unit options based on brand selection
        function updateUnitOptions() {
            const brand = document.getElementById('brand').value;
            const unitSelect = document.getElementById('unit');
            unitSelect.innerHTML = '';

            let unitOptions = [];

            if (brand === 'samsung') {
                unitOptions = ['piece', 'box', 'kg'];
            } else if (brand === 'dell') {
                unitOptions = ['piece', 'box'];
            } else if (brand === 'nike') {
                unitOptions = ['piece'];
            }

            // Populate the unit dropdown based on the selected brand
            unitOptions.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                unitSelect.appendChild(option);
            });
        }

        // Run the update functions when the page loads
        window.onload = function() {
            updateBrandOptions();
        };
    </script>
</head>
<body>
    <h2>Select Item Details</h2>
    <form action="/submit" method="post">
        <label for="item">Item:</label>
        <select id="item" name="item">
            <option value="item1">Item 1</option>
            <option value="item2">Item 2</option>
            <option value="item3">Item 3</option>
            <option value="item4">Item 4</option>
        </select><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category" onchange="updateBrandOptions()">
            <option value="electronics">Electronics</option>
            <option value="clothing">Clothing</option>
            <option value="furniture">Furniture</option>
            <option value="laptop">Laptops</option>
        </select><br><br>

        <label for="brand">Brand Name:</label>
        <select id="brand" name="brand" onchange="updateUnitOptions()">
            <!-- Brands will be populated based on the category -->
        </select><br><br>

        <label for="unit">Unit:</label>
        <select id="unit" name="unit">
            <!-- Units will be populated based on the brand -->
        </select><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
