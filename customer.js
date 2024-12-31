// const itemsContainer = document.getElementById('itemsContainer');

// function loadItems() {
//     const items = JSON.parse(localStorage.getItem('itemList')) || [];
//     itemsContainer.innerHTML = '';
//     items.forEach((item, index) => {
//         const itemDiv = document.createElement('div');
//         itemDiv.className = 'card';
//         itemDiv.innerHTML = `
//             <div class="card-body">
//                 <h3>${item.name}</h3>
//                 <p>Price: $${item.price}</p>
//                 <button class="btn btn-primary" onclick="buyItem(${index})">Buy</button>
//             </div>
//         `;
//         itemsContainer.appendChild(itemDiv);
//     });
// }

// function buyItem(index) {
//     const items = JSON.parse(localStorage.getItem('itemList')) || [];
//     const item = items[index];
//     const sale = { date: new Date().toLocaleDateString(), amount: item.price };
//     localStorage.setItem('newSale', JSON.stringify(sale));
//     alert(`${item.name} purchased!`);
// }

// loadItems();
//new//
// let products = JSON.parse(localStorage.getItem("products")) || [];
// let salesData = JSON.parse(localStorage.getItem("salesData")) || {};

// const productList = document.getElementById("productList");

// function displayProducts() {
//     productList.innerHTML = "";
//     products.forEach((product, index) => {
//         const productDiv = document.createElement("div");
//         productDiv.className = "card mb-2 p-2";
//         productDiv.innerHTML = `
//             <h5>${product.name}</h5>
//             <p>Price: $${product.price}</p>
//             <button class="btn btn-success" onclick="buyProduct(${index})">Buy</button>
//         `;
//         productList.appendChild(productDiv);
//     });
// }

// function buyProduct(index) {
//     const product = products[index];
//     const today = new Date().toLocaleDateString();

//     salesData[today] = (salesData[today] || 0) + product.price;
//     localStorage.setItem("salesData", JSON.stringify(salesData));

//     alert(`You bought ${product.name} for $${product.price}!`);
// }

// displayProducts();

// Sample menu items (can be fetched dynamically or added by admin)
// List of items (dummy data)
// Real-Time Clock
function showClock() {
    const clockDiv = document.getElementById("clock");
    const now = new Date();
    clockDiv.textContent = now.toLocaleTimeString();
}
setInterval(showClock, 1000);
showClock(); // Initialize the clock

// Redirect to Menu Page
document.getElementById("orderNowButton").addEventListener("click", function () {
    window.location.href = "menu.html"; // Adjust the path if needed
});
function showCustomerPage() {
    document.body.classList.remove('login-page');  // Remove login page class
    document.body.classList.add('customer-page');  // Add customer page class
}

// For example, when the login button is clicked, switch to the customer page
document.getElementById('loginButton').addEventListener('click', function() {
    showCustomerPage();
});
document.getElementById('loginButton').addEventListener('click', function() {
    document.body.style.backgroundImage = 'none';  // Remove background image
    document.body.classList.remove('login-page');
    document.body.classList.add('customer-page');  // Switch to customer page
});




