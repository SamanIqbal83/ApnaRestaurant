// const itemList = [];
// const salesData = { dates: [], sales: [] };

// document.getElementById('addItemButton').addEventListener('click', () => {
//     const itemName = document.getElementById('itemName').value.trim();
//     const itemPrice = document.getElementById('itemPrice').value;

//     if (itemName && itemPrice) {
//         itemList.push({ name: itemName, price: parseFloat(itemPrice) });
//         localStorage.setItem('itemList', JSON.stringify(itemList));
//         alert('Item added!');
//     } else {
//         alert('Please fill out all fields.');
//     }
// });

// const ctx = document.getElementById('salesChart').getContext('2d');
// const salesChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: salesData.dates,
//         datasets: [{
//             label: 'Sales ($)',
//             data: salesData.sales,
//             backgroundColor: 'rgba(75, 192, 192, 0.2)',
//             borderColor: 'rgba(75, 192, 192, 1)',
//             borderWidth: 1
//         }]
//     }
// });

// function updateGraph(date, saleAmount) {
//     salesData.dates.push(date);
//     salesData.sales.push(saleAmount);
//     salesChart.update();
// }

// window.addEventListener('storage', (event) => {
//     if (event.key === 'newSale') {
//         const sale = JSON.parse(event.newValue);
//         updateGraph(sale.date, sale.amount);
//     }
// });
//new//
// let products = [];
// let salesData = {};

// document.getElementById("addProductButton").addEventListener("click", function () {
//     const name = document.getElementById("productName").value;
//     const price = parseFloat(document.getElementById("productPrice").value);

//     if (name && price) {
//         products.push({ name, price });
//         alert("Product added successfully!");
//         localStorage.setItem("products", JSON.stringify(products));
//         document.getElementById("productName").value = "";
//         document.getElementById("productPrice").value = "";
//     } else {
//         alert("Please enter valid product details!");
//     }
// });

// const salesChart = new Chart(document.getElementById("salesChart"), {
//     type: "bar",
//     data: {
//         labels: [],
//         datasets: [
//             {
//                 label: "Sales (in $)",
//                 data: [],
//                 backgroundColor: "rgba(75, 192, 192, 0.6)",
//             },
//         ],
//     },
// });

// function updateSalesChart() {
//     const today = new Date().toLocaleDateString();
//     const sales = salesData[today] || 0;

//     if (!salesChart.data.labels.includes(today)) {
//         salesChart.data.labels.push(today);
//     }

//     const index = salesChart.data.labels.indexOf(today);
//     salesChart.data.datasets[0].data[index] = sales;

//     salesChart.update();
// }

// window.addEventListener("storage", (event) => {
//     if (event.key === "salesData") {
//         salesData = JSON.parse(localStorage.getItem("salesData")) || {};
//         updateSalesChart();
//     }
// });
const menuForm = document.getElementById("menuForm");
        const menuPreview = document.getElementById("menuPreview");

        menuForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const name = document.getElementById("itemName").value;
            const price = document.getElementById("itemPrice").value;
            const image = document.getElementById("itemImage").value;

            const menuItem = document.createElement("div");
            menuItem.className = "col-md-4";
            menuItem.innerHTML = `
                <div class="card h-100">
                    <img src="${image}" class="card-img-top" alt="${name}">
                    <div class="card-body text-center">
                        <h5 class="card-title">${name}</h5>
                        <p class="card-text">${price}</p>
                    </div>
                </div>
            `;
            menuPreview.appendChild(menuItem);
            menuForm.reset();
        });
        function navigateToPage(page) {
            // Reset background styles
            document.body.style.backgroundImage = 'none';
        
            // Remove all potential page classes
            document.body.classList.remove('login-page', 'customer-page', 'admin-page');
        
            // Add the appropriate class for the new page
            if (page === 'customer') {
                document.body.classList.add('customer-page');
                document.body.style.backgroundImage = "url('cus_img.jpg')";
            } else if (page === 'admin') {
                document.body.classList.add('admin-page');
                document.body.style.backgroundColor = '#f0f0f0';
            } else if (page === 'login') {
                document.body.classList.add('login-page');
                document.body.style.backgroundImage = "url('res_imag.jpeg')";
            }
        }
        