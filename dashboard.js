// Elements
const loginSection = document.getElementById('loginSection');
const adminSection = document.getElementById('adminSection');
const customerSection = document.getElementById('customerSection');
const loginButton = document.getElementById('loginButton');
const addProductButton = document.getElementById('addProductButton');
const productList = document.getElementById('productList');
const productNameInput = document.getElementById('productName');
const productPriceInput = document.getElementById('productPrice');
const salesChartCanvas = document.getElementById('salesChart');

// Data
let products = JSON.parse(localStorage.getItem('products')) || [];
let salesData = JSON.parse(localStorage.getItem('salesData')) || { dates: [], sales: [] };

// Chart
let salesChart = new Chart(salesChartCanvas.getContext('2d'), {
    type: 'line',
    data: {
        labels: salesData.dates,
        datasets: [{
            label: 'Sales ($)',
            data: salesData.sales,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }],
    },
});

// Login Functionality
document.querySelector(".btn-primary").addEventListener("click", function () {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    if (username === "admin" && password === "1234") {
        window.location.href = "C:\Users\PMLS\Pictures\admin.html"; // Redirect to admin page
    } else if (username === "customer" && password === "1234") {
        window.location.href = "customer.html"; // Redirect to customer page
    } else {
        alert("Invalid username or password");
    }
});

// Admin: Add Product
addProductButton.addEventListener('click', () => {
    const name = productNameInput.value.trim();
    const price = parseFloat(productPriceInput.value);

    if (name && price) {
        products.push({ name, price });
        localStorage.setItem('products', JSON.stringify(products));
        alert('Product added successfully!');
        productNameInput.value = '';
        productPriceInput.value = '';
        loadProducts();
    } else {
        alert('Please provide valid product details.');
    }
});

function loadProducts() {
    // Refresh product list (optional for admin display).
}

// Customer: Load and Buy Products
function loadCustomerProducts() {
    productList.innerHTML = '';
    products.forEach((product, index) => {
        const productDiv = document.createElement('div');
        productDiv.innerHTML = `
            <h3>${product.name}</h3>
            <p>Price: $${product.price}</p>
            <button onclick="buyProduct(${index})">Buy</button>
        `;
        productList.appendChild(productDiv);
    });
}

function buyProduct(index) {
    const product = products[index];
    const date = new Date().toLocaleDateString();
    salesData.dates.push(date);
    salesData.sales.push(product.price);
    localStorage.setItem('salesData', JSON.stringify(salesData));
    salesChart.update();
    alert(`${product.name} purchased for $${product.price}`);
}
