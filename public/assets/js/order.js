   // Extract orders from table
   function getOrdersFromTable() {
    const rows = document.querySelectorAll('#orderTableBody tr');
    return Array.from(rows).map(row => {
        const cells = row.cells;
        return {
            id: cells[0].textContent.trim(),
            customer: cells[1].textContent.trim(),
            date: cells[2].textContent.trim(),
            status: cells[3].querySelector('span').textContent.trim(),
            total: parseFloat(cells[4].textContent.replace('$', '')),
            // Additional fields not in table (for demo purposes, we'll add defaults or leave undefined)
            email: '', // Not in table, will be added when creating/editing
            phone: '',
            products: [] // Not in table, will be added when creating/editing
        };
    });
}

let orders = getOrdersFromTable();
let filteredOrders = [...orders];

// Render orders to table
function renderOrders(orderList = filteredOrders) {
    const tbody = document.getElementById('orderTableBody');
    tbody.innerHTML = orderList.map(order => `
        <tr class="border-b hover:bg-gray-50">
            <td class="py-4 px-4 text-sm">${order.id}</td>
            <td class="py-4 px-4 text-sm">${order.customer}</td>
            <td class="py-4 px-4 text-sm">${order.date}</td>
            <td class="py-4 px-4">
                <span class="px-2 py-1 text-xs rounded-full ${getStatusClass(order.status)}">${order.status}</span>
            </td>
            <td class="py-4 px-4 text-sm">$${order.total.toFixed(2)}</td>
            <td class="py-4 px-4">
                <div class="flex items-center justify-end gap-2">
                    <button onclick="viewOrder('${order.id}')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                        <i class="ri-eye-line"></i>
                    </button>
                    <button onclick="editOrder('${order.id}')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button onclick="deleteOrder('${order.id}')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    updateOrderCounts(orderList);
}

// Status class mapping
function getStatusClass(status) {
    const classes = {
        'Pending': 'bg-yellow-100 text-yellow-800',
        'Completed': 'bg-green-100 text-green-800',
        'Processing': 'bg-blue-100 text-blue-800',
        'Cancelled': 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
}

// View order modal
function viewOrder(orderId) {
    const order = orders.find(o => o.id === orderId);
    const viewModal = document.createElement('div');
    viewModal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
    viewModal.innerHTML = `
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
            <div class="p-6 border-b flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Order Details</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-500">
                    <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                </button>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Order ID</p>
                        <p class="mt-1">${order.id}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1"><span class="px-2 py-1 text-xs rounded-full ${getStatusClass(order.status)}">${order.status}</span></p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customer</p>
                        <p class="mt-1">${order.customer}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Date</p>
                        <p class="mt-1">${order.date}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="mt-1">${order.email || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Phone</p>
                        <p class="mt-1">${order.phone || 'N/A'}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-sm font-medium text-gray-500 mb-4">Products</p>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Product</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Quantity</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Price</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${order.products.length > 0 ? order.products.map(product => `
                                    <tr class="border-t">
                                        <td class="px-4 py-2 text-sm">${product.name}</td>
                                        <td class="px-4 py-2 text-sm">${product.quantity}</td>
                                        <td class="px-4 py-2 text-sm">$${product.price.toFixed(2)}</td>
                                        <td class="px-4 py-2 text-sm">$${(product.quantity * product.price).toFixed(2)}</td>
                                    </tr>
                                `).join('') : `
                                    <tr><td colspan="4" class="px-4 py-2 text-sm text-center">No products added</td></tr>
                                `}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <p class="text-sm font-medium text-gray-500">Total Amount</p>
                    <p class="text-xl font-semibold mt-1">$${order.total.toFixed(2)}</p>
                </div>
            </div>
            <div class="p-6 border-t flex justify-end">
                <button onclick="exportOrderPDF('${order.id}')" class="px-4 py-2 text-sm bg-primary text-white rounded !rounded-button hover:bg-primary/90 flex items-center gap-2">
                    <i class="ri-file-pdf-line w-4 h-4 flex items-center justify-center"></i>
                    <span>Export as PDF</span>
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(viewModal);
}

// Edit order modal
function editOrder(orderId) {
    const order = orders.find(o => o.id === orderId);
    const editModal = document.createElement('div');
    editModal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
    editModal.innerHTML = `
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
            <div class="p-6 border-b flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Edit Order</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-500">
                    <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                </button>
            </div>
            <form class="p-6" onsubmit="event.preventDefault(); saveEditedOrder('${order.id}', this);">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Information</label>
                        <div class="space-y-4">
                            <input type="text" name="customerName" value="${order.customer}" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                            <input type="email" name="email" value="${order.email || ''}" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                            <input type="tel" name="phone" value="${order.phone || ''}" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Details</label>
                        <div class="space-y-4" id="editProductList">
                            ${order.products.length > 0 ? order.products.map(product => `
                                <div class="flex gap-4 product-row">
                                    <input type="text" name="productName" value="${product.name}" class="flex-1 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                                    <input type="number" name="quantity" value="${product.quantity}" class="w-24 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required min="1">
                                    <input type="number" name="price" value="${product.price}" class="w-32 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required step="0.01">
                                </div>
                            `).join('') : `
                                <div class="flex gap-4 product-row">
                                    <input type="text" name="productName" placeholder="Product Name" class="flex-1 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                                    <input type="number" name="quantity" placeholder="Quantity" class="w-24 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required min="1">
                                    <input type="number" name="price" placeholder="Price" class="w-32 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required step="0.01">
                                </div>
                            `}
                        </div>
                        <button type="button" onclick="addEditProductRow(this)" class="text-primary text-sm hover:text-primary/80 flex items-center gap-1 mt-2">
                            <i class="ri-add-line w-4 h-4 flex items-center justify-center"></i>
                            <span>Add Another Product</span>
                        </button>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                                ${['Pending', 'Processing', 'Completed', 'Cancelled'].map(status => `
                                    <option ${status === order.status ? 'selected' : ''}>${status}</option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Order Date</label>
                            <input type="date" name="date" value="${order.date}" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-4">
                    <button type="button" onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-sm border rounded !rounded-button hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-primary text-white rounded !rounded-button hover:bg-primary/90">Save Changes</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(editModal);
}

// Add product row in edit modal
function addEditProductRow(button) {
    const productList = button.previousElementSibling;
    const newRow = document.createElement('div');
    newRow.className = 'flex gap-4 product-row mt-4';
    newRow.innerHTML = `
        <input type="text" name="productName" placeholder="Product Name" class="flex-1 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
        <input type="number" name="quantity" placeholder="Quantity" class="w-24 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required min="1">
        <input type="number" name="price" placeholder="Price" class="w-32 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required step="0.01">
    `;
    productList.appendChild(newRow);
}

// Save edited order
function saveEditedOrder(orderId, form) {
    const productRows = form.querySelectorAll('.product-row');
    const products = Array.from(productRows).map(row => ({
        name: row.querySelector('input[name="productName"]').value,
        quantity: parseInt(row.querySelector('input[name="quantity"]').value),
        price: parseFloat(row.querySelector('input[name="price"]').value)
    }));
    const total = products.reduce((sum, p) => sum + (p.quantity * p.price), 0);
    const updatedOrder = {
        id: orderId,
        customer: form.querySelector('input[name="customerName"]').value,
        email: form.querySelector('input[name="email"]').value,
        phone: form.querySelector('input[name="phone"]').value,
        date: form.querySelector('input[name="date"]').value,
        status: form.querySelector('select[name="status"]').value,
        total: total,
        products: products
    };
    const index = orders.findIndex(o => o.id === orderId);
    orders[index] = updatedOrder;
    filteredOrders = [...orders];
    renderOrders();
    form.closest('.fixed').remove();
    showToast('Order updated successfully');
}

// Delete order modal
function deleteOrder(orderId) {
    const confirmModal = document.createElement('div');
    confirmModal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
    confirmModal.innerHTML = `
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto">
                    <i class="ri-error-warning-line text-red-600 text-xl"></i>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-center text-gray-900">Delete Order</h3>
                <p class="mt-2 text-sm text-center text-gray-500">Are you sure you want to delete this order? This action cannot be undone.</p>
                <div class="mt-6 flex items-center justify-center gap-4">
                    <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-sm border rounded !rounded-button hover:bg-gray-50">Cancel</button>
                    <button onclick="confirmDelete('${orderId}', this)" class="px-4 py-2 text-sm bg-red-600 text-white rounded !rounded-button hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(confirmModal);
}

// Confirm delete
function confirmDelete(orderId, button) {
    orders = orders.filter(o => o.id !== orderId);
    filteredOrders = filteredOrders.filter(o => o.id !== orderId);
    renderOrders();
    button.closest('.fixed').remove();
    showToast('Order deleted successfully');
}

// Toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Search orders
document.getElementById('searchInput').addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    filteredOrders = orders.filter(order =>
        order.id.toLowerCase().includes(searchTerm) ||
        order.customer.toLowerCase().includes(searchTerm)
    );
    renderOrders();
});

// Status filter dropdown
document.getElementById('statusFilter').addEventListener('click', function() {
    const dropdown = document.createElement('div');
    dropdown.className = 'absolute top-full mt-1 w-48 bg-white rounded shadow-lg border z-10';
    dropdown.innerHTML = `
        <div class="py-1">
            ${['All Status', 'Pending', 'Processing', 'Completed', 'Cancelled'].map(status => `
                <button class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50" onclick="filterByStatus('${status}')">${status}</button>
            `).join('')}
        </div>
    `;
    this.parentElement.appendChild(dropdown);
    const closeDropdown = (e) => {
        if (!dropdown.contains(e.target) && !this.contains(e.target)) {
            dropdown.remove();
            document.removeEventListener('click', closeDropdown);
        }
    };
    setTimeout(() => document.addEventListener('click', closeDropdown), 0);
});

function filterByStatus(status) {
    document.getElementById('statusFilter').querySelector('span').textContent = status;
    filteredOrders = status === 'All Status' ? [...orders] : orders.filter(order => order.status === status);
    renderOrders();
}

// Date filter dropdown
document.getElementById('dateFilter').addEventListener('click', function() {
    const dropdown = document.createElement('div');
    dropdown.className = 'absolute top-full mt-1 w-64 bg-white rounded shadow-lg border z-10 p-4';
    dropdown.innerHTML = `
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" id="startDate">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" id="endDate">
            </div>
            <div class="flex justify-end gap-2">
                <button class="px-3 py-1 text-sm border rounded !rounded-button hover:bg-gray-50" onclick="this.closest('.absolute').remove()">Cancel</button>
                <button class="px-3 py-1 text-sm bg-primary text-white rounded !rounded-button hover:bg-primary/90" onclick="applyDateFilter()">Apply</button>
            </div>
        </div>
    `;
    this.parentElement.appendChild(dropdown);
    const closeDropdown = (e) => {
        if (!dropdown.contains(e.target) && !this.contains(e.target)) {
            dropdown.remove();
            document.removeEventListener('click', closeDropdown);
        }
    };
    setTimeout(() => document.addEventListener('click', closeDropdown), 0);
});

function applyDateFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (startDate && endDate) {
        filteredOrders = orders.filter(order =>
            order.date >= startDate && order.date <= endDate
        );
        renderOrders();
        document.getElementById('dateFilter').querySelector('span').textContent = `${startDate} - ${endDate}`;
    }
    document.querySelector('.absolute').remove();
}

// Add order modal
document.getElementById('addOrderBtn').addEventListener('click', () => {
    document.getElementById('addOrderModal').classList.remove('hidden');
    document.getElementById('addOrderModal').classList.add('flex');
});

document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('addOrderModal').classList.add('hidden');
    document.getElementById('addOrderModal').classList.remove('flex');
});

document.getElementById('cancelOrder').addEventListener('click', () => {
    document.getElementById('addOrderModal').classList.add('hidden');
    document.getElementById('addOrderModal').classList.remove('flex');
});

document.getElementById('addProduct').addEventListener('click', () => {
    const productList = document.getElementById('productList');
    const newRow = document.createElement('div');
    newRow.className = 'flex gap-4 product-row mt-4';
    newRow.innerHTML = `
        <input type="text" name="productName" placeholder="Product Name" class="flex-1 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
        <input type="number" name="quantity" placeholder="Quantity" class="w-24 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required min="1">
        <input type="number" name="price" placeholder="Price" class="w-32 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required step="0.01">
    `;
    productList.appendChild(newRow);
});

document.getElementById('orderForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const form = e.target;
    const productRows = form.querySelectorAll('.product-row');
    const products = Array.from(productRows).map(row => ({
        name: row.querySelector('input[name="productName"]').value,
        quantity: parseInt(row.querySelector('input[name="quantity"]').value),
        price: parseFloat(row.querySelector('input[name="price"]').value)
    }));
    const total = products.reduce((sum, p) => sum + (p.quantity * p.price), 0);
    const newOrder = {
        id: `ORD-2025-${(orders.length + 1).toString().padStart(3, '0')}`,
        customer: form.querySelector('input[name="customerName"]').value,
        email: form.querySelector('input[name="email"]').value,
        phone: form.querySelector('input[name="phone"]').value,
        date: form.querySelector('input[name="date"]').value,
        status: form.querySelector('select[name="status"]').value,
        total: total,
        products: products
    };
    orders.push(newOrder);
    filteredOrders = [...orders];
    renderOrders();
    form.closest('#addOrderModal').classList.add('hidden');
    form.closest('#addOrderModal').classList.remove('flex');
    showToast('Order created successfully');
});

// Export dropdown
document.getElementById('exportBtn').addEventListener('click', function() {
    const dropdown = document.createElement('div');
    dropdown.className = 'absolute top-full right-0 mt-1 w-48 bg-white rounded shadow-lg border z-10';
    dropdown.innerHTML = `
        <div class="py-1">
            <button class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50 flex items-center gap-2" onclick="exportAllOrders('pdf')">
                <i class="ri-file-pdf-line w-4 h-4 flex items-center justify-center"></i>
                <span>Export as PDF</span>
            </button>
            <button class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50 flex items-center gap-2" onclick="exportAllOrders('doc')">
                <i class="ri-file-word-line w-4 h-4 flex items-center justify-center"></i>
                <span>Export as DOC</span>
            </button>
        </div>
    `;
    this.parentElement.appendChild(dropdown);
    const closeDropdown = (e) => {
        if (!dropdown.contains(e.target) && !this.contains(e.target)) {
            dropdown.remove();
            document.removeEventListener('click', closeDropdown);
        }
    };
    setTimeout(() => document.addEventListener('click', closeDropdown), 0);
});

// Export single order as PDF
function exportOrderPDF(orderId) {
    const order = orders.find(o => o.id === orderId);
    const content = `
        Order Details
        -------------
        Order ID: ${order.id}
        Customer: ${order.customer}
        Date: ${order.date}
        Status: ${order.status}
        Email: ${order.email || 'N/A'}
        Phone: ${order.phone || 'N/A'}
        Products:
        ${order.products.length > 0 ? order.products.map(p => `- ${p.name} x${p.quantity} @ $${p.price.toFixed(2)} = $${(p.quantity * p.price).toFixed(2)}`).join('\n') : 'No products'}
        Total Amount: $${order.total.toFixed(2)}
    `.trim();
    const blob = new Blob([content], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `order-${order.id}.txt`;
    a.click();
    window.URL.revokeObjectURL(url);
    showToast('Order details exported successfully');
}

// Export all orders
function exportAllOrders(format) {
    let content = '';
    if (format === 'pdf') {
        content = `
            Orders Report
            -------------
            Generated on: ${new Date().toLocaleString()}
            ${filteredOrders.map(order => `
                Order ID: ${order.id}
                Customer: ${order.customer}
                Date: ${order.date}
                Status: ${order.status}
                Total: $${order.total.toFixed(2)}
                -------------------
            `).join('\n')}
        `.trim();
    } else if (format === 'doc') {
        content = `
            Orders Report
            Date: ${new Date().toLocaleString()}
            ${filteredOrders.map(order => `
                • Order ${order.id}
                - Customer: ${order.customer}
                - Date: ${order.date}
                - Status: ${order.status}
                - Total: $${order.total.toFixed(2)}
            `).join('\n')}
        `.trim();
    }
    const blob = new Blob([content], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `orders-report.${format === 'pdf' ? 'txt' : 'txt'}`;
    a.click();
    window.URL.revokeObjectURL(url);
    document.querySelector('#exportBtn + .absolute')?.remove();
    showToast(`Orders exported successfully`);
}

// Update order counts
function updateOrderCounts(orderList = orders) {
    document.getElementById('all-count').textContent = orderList.length;
    document.getElementById('pending-count').textContent = orderList.filter(o => o.status === 'Pending').length;
    document.getElementById('processing-count').textContent = orderList.filter(o => o.status === 'Processing').length;
    document.getElementById('completed-count').textContent = orderList.filter(o => o.status === 'Completed').length;
    document.getElementById('cancelled-count').textContent = orderList.filter(o => o.status === 'Cancelled').length;
}

// Tab button functionality
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.tab-button').forEach(b => {
            b.classList.remove('active', 'border-primary', 'text-primary');
            b.classList.add('border-transparent', 'text-gray-500');
        });
        button.classList.add('active', 'border-primary', 'text-primary');
        button.classList.remove('border-transparent', 'text-gray-500');
        const status = button.dataset.status;
        filteredOrders = status === 'all' ? [...orders] : orders.filter(order => order.status === status);
        renderOrders();
    });
});

// Initial render
renderOrders();
