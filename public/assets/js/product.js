// Table data extraction
function getProductsFromTable() {
    const rows = document.querySelectorAll('#productTableBody tr');
    return Array.from(rows).map(row => {
        const cells = row.cells;
        const image = cells[0].querySelector('img').src;
        const name = cells[0].querySelector('.text-sm.font-medium').textContent.trim();
        const id = parseInt(cells[0].querySelector('.text-sm.text-gray-500').textContent.replace('#', ''));
        const category = cells[1].textContent.trim();
        const price = parseFloat(cells[2].textContent.replace('$', ''));
        const stock = parseInt(cells[3].textContent);
        const status = cells[4].querySelector('span').textContent.trim();
        const isDisabled = cells[0].querySelector('.text-sm.font-medium').classList.contains('line-through');

        return { id, name, category, price, stock, status, images: [image], disabled: isDisabled };
    });
}

// Render products to table
function renderProducts(products, page = 1, entriesPerPage = 10) {
    const tbody = document.getElementById('productTableBody');
    const start = (page - 1) * entriesPerPage;
    const end = start + entriesPerPage;
    const paginatedProducts = products.slice(start, end);

    tbody.innerHTML = paginatedProducts.map(product => `
        <tr>
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <img src="${product.images[0]}" alt="${product.name}" class="w-12 h-12 object-cover !rounded-button">
                    <div>
                        <div class="text-sm font-medium text-gray-900 ${product.disabled ? 'line-through' : ''}">${product.name}</div>
                        <div class="text-sm text-gray-500">#${product.id}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-500">${product.category}</td>
            <td class="px-6 py-4 text-sm text-gray-900">$${product.price.toFixed(2)}</td>
            <td class="px-6 py-4 text-sm text-gray-500">${product.stock}</td>
            <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${product.status === 'In Stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${product.status}
                </span>
            </td>
            <td class="px-6 py-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <button onclick="viewProduct(${product.id})" class="text-gray-600 hover:text-gray-900">
                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                    </button>
                    <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-900">
                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                    </button>
                    <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">
                        <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');

    updatePagination(products.length, page, entriesPerPage);
}

// Pagination functions
function updatePagination(totalItems, currentPage, entriesPerPage) {
    const totalPages = Math.ceil(totalItems / entriesPerPage);
    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = currentPage === totalPages;
    document.getElementById('page1').classList.toggle('bg-primary', currentPage === 1);
    document.getElementById('page1').classList.toggle('text-white', currentPage === 1);
    document.getElementById('page2').classList.toggle('bg-primary', currentPage === 2);
    document.getElementById('page2').classList.toggle('text-white', currentPage === 2);
    document.getElementById('page3').classList.toggle('bg-primary', currentPage === 3);
    document.getElementById('page3').classList.toggle('text-white', currentPage === 3);
}

function prevPage() {
    const products = getProductsFromTable();
    const entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
    const currentPage = parseInt(document.querySelector('#pagination .bg-primary').textContent);
    if (currentPage > 1) {
        renderProducts(products, currentPage - 1, entriesPerPage);
    }
}

function nextPage() {
    const products = getProductsFromTable();
    const entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
    const currentPage = parseInt(document.querySelector('#pagination .bg-primary').textContent);
    const totalPages = Math.ceil(products.length / entriesPerPage);
    if (currentPage < totalPages) {
        renderProducts(products, currentPage + 1, entriesPerPage);
    }
}

function goToPage(page) {
    const products = getProductsFromTable();
    const entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
    renderProducts(products, page, entriesPerPage);
}

function updateEntries() {
    const products = getProductsFromTable();
    const entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
    renderProducts(products, 1, entriesPerPage);
}

// UI interactions
function toggleDropdown() {
    document.getElementById('exportDropdown').classList.toggle('hidden');
}

function toggleFilter() {
    document.getElementById('filterPanel').classList.toggle('translate-x-full');
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Product actions
function viewProduct(id) {
    const products = getProductsFromTable();
    const product = products.find(p => p.id === id);
    const details = document.getElementById('viewProductDetails');
    details.innerHTML = `
        <div class="mb-4">
            <img src="${product.images[0]}" alt="${product.name}" class="w-full h-64 object-cover !rounded-button">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <p class="mt-1 text-sm text-gray-900 ${product.disabled ? 'line-through' : ''}">${product.name}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <p class="mt-1 text-sm text-gray-900">${product.category}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Price</label>
            <p class="mt-1 text-sm text-gray-900">$${product.price.toFixed(2)}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Stock</label>
            <p class="mt-1 text-sm text-gray-900">${product.stock}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <p class="mt-1 text-sm text-gray-900">${product.status}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Product Status</label>
            <p class="mt-1 text-sm text-gray-900">${product.disabled ? 'Disabled' : 'Active'}</p>
        </div>
    `;
    openModal('viewModal');
}

function editProduct(id) {
    const products = getProductsFromTable();
    const product = products.find(p => p.id === id);
    document.getElementById('modalTitle').textContent = 'Edit Product';
    const form = document.getElementById('productForm');
    form.elements['name'].value = product.name;
    form.elements['category'].value = product.category;
    form.elements['price'].value = product.price;
    form.elements['stock'].value = product.stock;
    form.elements['description'].value = product.description || '';
    form.elements['disabled'].checked = product.disabled;
    form.dataset.editId = id; // Store ID for editing
    openModal('productModal');
}

function addProduct() {
    document.getElementById('modalTitle').textContent = 'Add Product';
    const form = document.getElementById('productForm');
    form.reset();
    delete form.dataset.editId; // Clear edit ID
    openModal('productModal');
}

function deleteProduct(id) {
    document.getElementById('deleteModal').dataset.deleteId = id;
    openModal('deleteModal');
}

function confirmDelete() {
    const id = parseInt(document.getElementById('deleteModal').dataset.deleteId);
    let products = getProductsFromTable();
    products = products.filter(p => p.id !== id);
    renderProducts(products);
    closeModal('deleteModal');
}

// Filter and search
function applyFilters() {
    let products = getProductsFromTable();
    const category = document.getElementById('filterCategory').value;
    const minPrice = document.getElementById('filterMinPrice').value;
    const maxPrice = document.getElementById('filterMaxPrice').value;
    const inStock = document.getElementById('filterInStock').checked;
    const outOfStock = document.getElementById('filterOutOfStock').checked;

    if (category) products = products.filter(p => p.category === category);
    if (minPrice) products = products.filter(p => p.price >= parseFloat(minPrice));
    if (maxPrice) products = products.filter(p => p.price <= parseFloat(maxPrice));
    if (inStock && !outOfStock) products = products.filter(p => p.status === 'In Stock');
    if (outOfStock && !inStock) products = products.filter(p => p.status === 'Out of Stock');

    renderProducts(products);
    toggleFilter();
}

function resetFilters() {
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterMinPrice').value = '';
    document.getElementById('filterMaxPrice').value = '';
    document.getElementById('filterInStock').checked = false;
    document.getElementById('filterOutOfStock').checked = false;
    const products = getProductsFromTable();
    renderProducts(products);
    toggleFilter();
}

function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    let products = getProductsFromTable();
    if (searchTerm) {
        products = products.filter(p =>
            p.name.toLowerCase().includes(searchTerm) ||
            p.category.toLowerCase().includes(searchTerm)
        );
    }
    renderProducts(products);
}

// Form submission
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const products = getProductsFromTable();
    const newProduct = {
        id: form.dataset.editId ? parseInt(form.dataset.editId) : Math.max(...products.map(p => p.id), 0) + 1,
        name: form.elements['name'].value,
        category: form.elements['category'].value,
        price: parseFloat(form.elements['price'].value),
        stock: parseInt(form.elements['stock'].value),
        status: parseInt(form.elements['stock'].value) > 0 ? 'In Stock' : 'Out of Stock',
        images: [form.elements['images'].files[0] ? URL.createObjectURL(form.elements['images'].files[0]) : products[0]?.images[0] || 'https://via.placeholder.com/150'],
        disabled: form.elements['disabled'].checked,
        description: form.elements['description'].value
    };

    if (form.dataset.editId) {
        const index = products.findIndex(p => p.id === parseInt(form.dataset.editId));
        products[index] = newProduct;
    } else {
        products.push(newProduct);
    }
    renderProducts(products);
    closeModal('productModal');
});

// Event listeners
document.addEventListener('click', function(e) {
    if (!e.target.closest('#exportDropdown') && !e.target.closest('button:not(#sidebarToggle)')) {
        document.getElementById('exportDropdown').classList.add('hidden');
    }
});

// Initial render
document.addEventListener('DOMContentLoaded', () => {
    const products = getProductsFromTable();
    renderProducts(products, 1, 10);
});
