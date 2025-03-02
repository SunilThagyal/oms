@push('styles')
<link rel="stylesheet" href="{{asset('assets/css/product.css')}}">
@endpush
@extends('oms.layout.app')
@section('content')
<main class="flex-1 overflow-y-auto p-6">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col gap-6">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Product Management</h1>
                <div class="flex items-center gap-3 flex-wrap">
                    <button onclick="addProduct()" class="flex items-center gap-2 bg-primary text-white px-4 py-2 !rounded-button whitespace-nowrap">
                        <i class="ri-add-line w-5 h-5 flex items-center justify-center"></i>
                        Add Product
                    </button>
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-white border border-gray-300 px-4 py-2 !rounded-button whitespace-nowrap">
                            <i class="ri-download-line w-5 h-5 flex items-center justify-center"></i>
                            Export
                        </button>
                        <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-10">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Export as CSV</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Export as Excel</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Export as PDF</a>
                        </div>
                    </div>
                    <button onclick="toggleFilter()" class="flex items-center gap-2 bg-white border border-gray-300 px-4 py-2 !rounded-button whitespace-nowrap">
                        <i class="ri-filter-line w-5 h-5 flex items-center justify-center"></i>
                        Filter
                    </button>
                    <div class="relative flex-grow sm:max-w-xs">
                        <input type="text" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border border-gray-300 !rounded-button" id="searchInput" oninput="searchProducts()">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 flex items-center justify-center"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="table-container overflow-x-auto">
                    <table class="w-full min-w-[800px] table-auto">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="productTableBody">
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://public.readdy.ai/ai/img_res/b6ee332227c54b55fadc34f8ff380398.jpg" alt="Wireless Earbuds Pro" class="w-12 h-12 object-cover !rounded-button">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Wireless Earbuds Pro</div>
                                            <div class="text-sm text-gray-500">#1</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Electronics</td>
                                <td class="px-6 py-4 text-sm text-gray-900">$129.99</td>
                                <td class="px-6 py-4 text-sm text-gray-500">45</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewProduct(1)" class="text-gray-600 hover:text-gray-900">
                                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="editProduct(1)" class="text-blue-600 hover:text-blue-900">
                                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="deleteProduct(1)" class="text-red-600 hover:text-red-900">
                                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Other table rows remain the same -->
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://public.readdy.ai/ai/img_res/acf8b04e8c1b5109b67ddacea8810916.jpg" alt="Premium Cotton T-Shirt" class="w-12 h-12 object-cover !rounded-button">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Premium Cotton T-Shirt</div>
                                            <div class="text-sm text-gray-500">#2</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Clothing</td>
                                <td class="px-6 py-4 text-sm text-gray-900">$24.99</td>
                                <td class="px-6 py-4 text-sm text-gray-500">120</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewProduct(2)" class="text-gray-600 hover:text-gray-900">
                                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="editProduct(2)" class="text-blue-600 hover:text-blue-900">
                                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="deleteProduct(2)" class="text-red-600 hover:text-red-900">
                                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://public.readdy.ai/ai/img_res/f485bdac84802299de6ac6d7db512039.jpg" alt="Organic Coffee Beans" class="w-12 h-12 object-cover !rounded-button">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 line-through">Organic Coffee Beans</div>
                                            <div class="text-sm text-gray-500">#3</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Food</td>
                                <td class="px-6 py-4 text-sm text-gray-900">$19.99</td>
                                <td class="px-6 py-4 text-sm text-gray-500">0</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewProduct(3)" class="text-gray-600 hover:text-gray-900">
                                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="editProduct(3)" class="text-blue-600 hover:text-blue-900">
                                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="deleteProduct(3)" class="text-red-600 hover:text-red-900">
                                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://public.readdy.ai/ai/img_res/937453b0d30adfca3d0d3d910163713a.jpg" alt="Smart Watch Elite" class="w-12 h-12 object-cover !rounded-button">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Smart Watch Elite</div>
                                            <div class="text-sm text-gray-500">#4</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Electronics</td>
                                <td class="px-6 py-4 text-sm text-gray-900">$199.99</td>
                                <td class="px-6 py-4 text-sm text-gray-500">15</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewProduct(4)" class="text-gray-600 hover:text-gray-900">
                                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="editProduct(4)" class="text-blue-600 hover:text-blue-900">
                                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="deleteProduct(4)" class="text-red-600 hover:text-red-900">
                                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://public.readdy.ai/ai/img_res/89b859b61e7666fe46f668fa9df88e48.jpg" alt="Leather Wallet Classic" class="w-12 h-12 object-cover !rounded-button">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Leather Wallet Classic</div>
                                            <div class="text-sm text-gray-500">#5</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">Accessories</td>
                                <td class="px-6 py-4 text-sm text-gray-900">$49.99</td>
                                <td class="px-6 py-4 text-sm text-gray-500">30</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewProduct(5)" class="text-gray-600 hover:text-gray-900">
                                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="editProduct(5)" class="text-blue-600 hover:text-blue-900">
                                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                        <button onclick="deleteProduct(5)" class="text-red-600 hover:text-red-900">
                                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 flex items-center justify-between border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700">Show</span>
                        <select class="border border-gray-300 !rounded-button px-2 py-1" id="entriesPerPage" onchange="updateEntries()">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        <span class="text-sm text-gray-700">entries</span>
                    </div>
                    <div class="flex items-center gap-2" id="pagination">
                        <button class="px-3 py-1 border border-gray-300 !rounded-button disabled:opacity-50" id="prevPage" disabled onclick="prevPage()">Previous</button>
                        <button class="px-3 py-1 bg-primary text-white !rounded-button" id="page1">1</button>
                        <button class="px-3 py-1 border border-gray-300 !rounded-button" id="page2" onclick="goToPage(2)">2</button>
                        <button class="px-3 py-1 border border-gray-300 !rounded-button" id="page3" onclick="goToPage(3)">3</button>
                        <button class="px-3 py-1 border border-gray-300 !rounded-button" id="nextPage" onclick="nextPage()">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div id="filterPanel" class="fixed inset-y-0 right-0 w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium">Filters</h3>
                <button onclick="toggleFilter()" class="text-gray-400 hover:text-gray-500">
                    <i class="ri-close-line w-5 h-5 flex items-center justify-center"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select class="w-full border border-gray-300 !rounded-button px-3 py-2" id="filterCategory">
                        <option value="">All Categories</option>
                        <option>Electronics</option>
                        <option>Clothing</option>
                        <option>Food</option>
                        <option>Accessories</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                    <div class="flex items-center gap-2">
                        <input type="number" placeholder="Min" class="w-full border border-gray-300 !rounded-button px-3 py-2" id="filterMinPrice">
                        <span>-</span>
                        <input type="number" placeholder="Max" class="w-full border border-gray-300 !rounded-button px-3 py-2" id="filterMaxPrice">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="!rounded-button" id="filterInStock">
                            <span>In Stock</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="!rounded-button" id="filterOutOfStock">
                            <span>Out of Stock</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4 flex gap-2">
                    <button onclick="applyFilters()" class="flex-1 bg-primary text-white px-4 py-2 !rounded-button">Apply</button>
                    <button onclick="resetFilters()" class="flex-1 border border-gray-300 px-4 py-2 !rounded-button">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="productModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden px-4">
        <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-medium" id="modalTitle">Add Product</h3>
                <button onclick="closeModal('productModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="ri-close-line w-5 h-5 flex items-center justify-center"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="productForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" class="w-full border border-gray-300 !rounded-button px-3 py-2" name="name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select class="w-full border border-gray-300 !rounded-button px-3 py-2" name="category" required>
                            <option value="">Select Category</option>
                            <option>Electronics</option>
                            <option>Clothing</option>
                            <option>Food</option>
                            <option>Accessories</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="number" step="0.01" class="w-full border border-gray-300 !rounded-button px-3 py-2" name="price" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input type="number" class="w-full border border-gray-300 !rounded-button px-3 py-2" name="stock" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea class="w-full border border-gray-300 !rounded-button px-3 py-2" rows="3" name="description"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Images</label>
                        {{--  --}}
                        <div class="max-w-lg mx-auto">
                            <div id="upload-container"
                                class="mt-1 flex flex-col justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div id="upload-area" class="space-y-1 text-center cursor-pointer">
                                    <i class="fas fa-image mx-auto h-12 w-12 text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary focus-within:outline-none">
                                            <span>Upload images</span>
                                            <input id="file-upload" name="images" type="file" class="sr-only"  accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                                <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4"></div>
                                <p id="error-message" class="text-red-500 text-center mt-4 hidden">You can't upload more than 4 images at
                                    once.</p>
                            </div>
                        </div>
                        {{--  --}}
                    </div>
                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="!rounded-button" name="disabled">
                            <span class="text-sm text-gray-700">Disable Product</span>
                        </label>
                    </div>
                    <div class="flex gap-2 pt-4 flex-col sm:flex-row">
                        <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 !rounded-button">Save</button>
                        <button type="button" onclick="closeModal('productModal')" class="flex-1 border border-gray-300 px-4 py-2 !rounded-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden px-4">
        <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-medium">Product Details</h3>
                <button onclick="closeModal('viewModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="ri-close-line w-5 h-5 flex items-center justify-center"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4" id="viewProductDetails"></div>
                <div class="pt-4">
                    <button onclick="closeModal('viewModal')" class="w-full border border-gray-300 px-4 py-2 !rounded-button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden px-4">
        <div class="bg-white rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <i class="ri-error-warning-line text-red-500 text-5xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center mb-2">Delete Product</h3>
                <p class="text-gray-500 text-center mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
                <div class="flex gap-2 flex-col sm:flex-row">
                    <button onclick="confirmDelete()" class="flex-1 bg-red-500 text-white px-4 py-2 !rounded-button">Delete</button>
                    <button onclick="closeModal('deleteModal')" class="flex-1 border border-gray-300 px-4 py-2 !rounded-button">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    function initImageUploader(uploadAreaSelector, fileInputSelector, previewContainerSelector, errorMessageSelector, maxFiles = 4) {
    let uploadedFiles = [];

    const uploadArea = document.querySelector(uploadAreaSelector);
    const fileInput = document.querySelector(fileInputSelector);
    const previewContainer = document.querySelector(previewContainerSelector);
    const errorMessage = document.querySelector(errorMessageSelector);

    // Trigger file input on clicking the upload area
    uploadArea.addEventListener('click', function () {
        fileInput.click();
    });

    // Handle file selection and preview
    fileInput.addEventListener('change', function (event) {
        const files = event.target.files;

        if (uploadedFiles.length + files.length > maxFiles) {
            errorMessage.classList.remove('hidden');
            return;
        } else {
            errorMessage.classList.add('hidden');
        }

        Array.from(files).forEach(file => {
            uploadedFiles.push(file);
            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.classList.add('relative', 'border', 'border-gray-300', 'rounded-md', 'overflow-hidden');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview of uploaded image';
                img.classList.add('w-full', 'h-32', 'object-cover');

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '<i class="fas fa-times"></i>';
                removeButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-500', 'text-white', 'rounded-full', 'p-1', 'hover:bg-red-700');
                removeButton.addEventListener('click', () => {
                    const index = uploadedFiles.indexOf(file);
                    if (index > -1) {
                        uploadedFiles.splice(index, 1);
                    }
                    div.remove();
                });

                div.appendChild(img);
                div.appendChild(removeButton);
                previewContainer.appendChild(div);
            };

            reader.readAsDataURL(file);
        });

        // Clear the input so the same file can be selected again if needed
        event.target.value = '';
    });
}
initImageUploader('.space-y-1.text-center', '#file-upload', '#image-preview', '#error-message');
    </script>
<script src="{{ asset('assets/js/product.js') }}"></script>
@endpush
