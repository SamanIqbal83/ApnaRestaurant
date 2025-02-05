
let totalRevenue = parseFloat(localStorage.getItem("totalRevenue")) || 0; // Initialize revenue from localStorage
let inventory = JSON.parse(localStorage.getItem("inventory")) || [];
let revenueData = JSON.parse(localStorage.getItem("revenueData")) || [];
let revenueDates = JSON.parse(localStorage.getItem("revenueDates")) || [];

// Initialize Sales Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: revenueDates, // Dates for each sale
        datasets: [{
            label: 'Sales Revenue ($)',
            data: revenueData, // Revenue values for each date
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                ticks: {
                    maxRotation: 45,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});

// Function to update total revenue
function updateRevenue() {
    document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
    updateGraph();
    localStorage.setItem("totalRevenue", totalRevenue.toFixed(2)); // Save updated total revenue
}

// Function to update the revenue graph
function updateGraph() {
    const today = new Date().toLocaleDateString();
    revenueData.push(totalRevenue);
    revenueDates.push(today);

    if (revenueData.length > 7) { // Keep last 7 entries
        revenueData.shift();
        revenueDates.shift();
    }

    revenueChart.data.labels = revenueDates;
    revenueChart.data.datasets[0].data = revenueData;
    revenueChart.update();

    // Save updated chart data to localStorage
    localStorage.setItem("revenueData", JSON.stringify(revenueData));
    localStorage.setItem("revenueDates", JSON.stringify(revenueDates));
}

// Function to load inventory from localStorage and display it
function loadInventory() {
    const inventoryTableBody = document.getElementById('inventoryTable').querySelector('tbody');
    inventoryTableBody.innerHTML = ''; // Clear the table

    inventory.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>${item.quantity}</td>
            <td><img src="${item.image}" alt="Item Image" width="80"></td>
            <td>
                <button onclick="sellItem('${item.name}')">${item.quantity > 0 ? "Sell" : "Out of Stock"}</button>
                <button onclick="deleteItem('${item.name}')">Delete</button>
            </td>
        `;
        inventoryTableBody.appendChild(row);
    });
}

// Function to handle form submission (Add Inventory Item)
document.getElementById('inventoryForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const itemName = document.getElementById('itemName').value;
    const itemPrice = parseFloat(document.getElementById('itemPrice').value);
    const itemQuantity = parseInt(document.getElementById('itemQuantity').value);
    const itemImage = document.getElementById('itemImage').files[0];

    if (itemName && !isNaN(itemPrice) && !isNaN(itemQuantity) && itemImage) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const newItem = {
                name: itemName,
                price: itemPrice,
                quantity: itemQuantity,
                image: e.target.result
            };

            inventory.push(newItem);
            localStorage.setItem("inventory", JSON.stringify(inventory)); // Save to localStorage
            loadInventory(); // Refresh the table
            document.getElementById('inventoryForm').reset();
        };
        reader.readAsDataURL(itemImage);
    } else {
        alert("Please fill out all fields correctly and upload an image!");
    }
});

// Function to simulate a sale (i.e., customer buys an item)
function sellItem(itemName) {
    const item = inventory.find(item => item.name === itemName);

    if (item && item.quantity > 0) {
        item.quantity--;
        totalRevenue += item.price;
        localStorage.setItem("inventory", JSON.stringify(inventory)); // Save updated inventory to localStorage
        updateRevenue();
        loadInventory(); // Refresh the table
    } else {
        alert('Item out of stock!');
    }
}

// Function to delete an item
function deleteItem(itemName) {
    inventory = inventory.filter(item => item.name !== itemName);
    localStorage.setItem("inventory", JSON.stringify(inventory)); // Save updated inventory to localStorage
    loadInventory(); // Refresh the table
}

// Load inventory and revenue when the page loads
window.onload = function () {
    loadInventory();
    updateRevenue(); // Initialize total revenue and chart
};
document.addEventListener("DOMContentLoaded", function () {
    // Remove all local storage data
    localStorage.clear();

    // Remove dynamically added elements (non-PHP)
    document.querySelectorAll(".js-added").forEach(element => element.remove());
});
document.addEventListener("DOMContentLoaded", function () {
    localStorage.clear(); // Clear local storage data
    document.querySelectorAll(".js-added").forEach(element => element.remove()); // Remove JS-added elements
});

function addJsData() {
    let newItem = document.createElement("p");
    newItem.textContent = "This is JS added data";
    newItem.classList.add("js-added");
    document.getElementById("dataContainer").appendChild(newItem);
    localStorage.setItem("jsData", "Some JS Data");
}

document.getElementById('inventoryForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('admin_dashboard.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Item added successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Failed to add item. Check console for details.');
    });
});