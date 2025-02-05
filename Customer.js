
let inventory = JSON.parse(localStorage.getItem("inventory")) || [];
let totalRevenue = parseFloat(localStorage.getItem("totalRevenue")) || 0;


function displayProducts() {
    const productsContainer = document.getElementById('products');
    productsContainer.innerHTML = ''; // Clear any existing products

    inventory.forEach(item => {
        if (item.quantity > 0) { // Only show products that are in stock
            const productDiv = document.createElement('div');
            productDiv.classList.add('product');

            // Determine the image source based on the product name
            let imageSrc = '';
            const itemName = item.name.toLowerCase(); // Convert to lowercase for case-insensitive comparison
            if (itemName === 'burger') {
                imageSrc = './burgur.jpg'; // Replace with the path to your burger image
            } else if (itemName === 'loaded fries') {
                imageSrc = './loadedfries.jpg'; // Replace with the path to your loaded fries image
            } else if (itemName === 'small pizza') {
                imageSrc = './SmallPizza.jpg'; // Replace with the path to your small pizza image
            } else {
                imageSrc = './default-image.jpg'; // Default image for other products
            }

            // Generate the product card HTML
            productDiv.innerHTML = `
                <img src="${imageSrc}" alt="${item.name}" style="width: 150px; height: 150px; object-fit: cover;">
                <h3>${item.name}</h3>
                <p>Price: $${item.price.toFixed(2)}</p>
                <p>Stock: ${item.quantity}</p>
                <button onclick="buyProduct('${item.name}')">Buy</button>
            `;

            // Append the product card to the container
            productsContainer.appendChild(productDiv);
        }
    });
}

// Function to handle product purchase
function buyProduct(itemName) {
    const item = inventory.find(item => item.name === itemName);

    if (item && item.quantity > 0) {
        item.quantity--; // Decrease quantity
        totalRevenue += item.price; // Add to total revenue

        // Save updated data to localStorage
        localStorage.setItem("totalRevenue", totalRevenue.toFixed(2));
        localStorage.setItem("inventory", JSON.stringify(inventory));

        alert(`You have bought ${item.name} for $${item.price.toFixed(2)}`);
        displayProducts(); // Refresh product display
    } else {
        alert('Item is out of stock');
    }
}

// Initial call to display products
displayProducts();



