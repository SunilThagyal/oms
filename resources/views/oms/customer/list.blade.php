@push('styles')
<link rel="stylesheet" href="{{asset('assets/css/customer.css')}}">
@endpush
@extends('oms.layout.app')

@section('content')
<main class="flex-1 overflow-y-auto p-6">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-900">Customer Management</h1>
                <button onclick="showAddCustomerModal()" class="bg-primary text-white px-4 py-2 !rounded-button flex items-center gap-2">
                    <i class="ri-add-line w-5 h-5 flex items-center justify-center"></i>
                    <span class="whitespace-nowrap">Add Customer</span>
                </button>
            </div>
            <div class="flex gap-1 p-1 bg-gray-100 rounded-full w-fit">
                <button onclick="switchTab('all')" id="allTab" class="px-4 py-2 rounded-full text-sm font-medium bg-white text-gray-900 shadow-sm">All Users</button>
                <button onclick="switchTab('deleted')" id="deletedTab" class="px-4 py-2 rounded-full text-sm font-medium text-gray-600">Deleted Users</button>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <input type="text" id="searchInput" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 flex items-center justify-center"></i>
                </div>
                <div class="flex gap-2">
                    <button onclick="showFilters()" class="px-4 py-2 border border-gray-200 rounded-lg text-sm !rounded-button whitespace-nowrap flex items-center gap-2">
                        <i class="ri-filter-3-line w-5 h-5 flex items-center justify-center"></i>
                        <span>Filters</span>
                    </button>
                    <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm !rounded-button whitespace-nowrap">
                        <i class="ri-download-2-line w-5 h-5 flex items-center justify-center"></i>
                    </button>
                </div>
                <div id="filterModal" class="modal">
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-xl font-semibold">Filters</h2>
                                    <button onclick="hideFilters()" class="text-gray-400 hover:text-gray-600">
                                        <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                                    </button>
                                </div>
                                <form id="filterForm" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                        <div class="flex gap-4">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="gender" value="male" class="mr-2">
                                                <span class="text-sm">Male</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="gender" value="female" class="mr-2">
                                                <span class="text-sm">Female</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                        <select name="country" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm pr-8">
                                            <option value="">All Countries</option>
                                            <option value="US">United States</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="CA">Canada</option>
                                        </select>
                                    </div>
                                    <div class="flex justify-end gap-4 mt-6">
                                        <button type="button" onclick="clearFilters()" class="px-4 py-2 border border-gray-200 rounded-lg text-sm !rounded-button">Clear</button>
                                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm !rounded-button">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="activeCustomers" class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Customer</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Contact</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Address</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Orders</th>
                            <th class="text-right py-4 px-4 text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="activeCustomerTableBody">
                        <tr class="border-b" data-id="1" data-gender="female" data-country="US" data-state="CA" data-city="SF">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">EA</div>
                                    <div>
                                        <div class="font-medium text-gray-900">Elizabeth Anderson</div>
                                        <div class="text-sm text-gray-500">Tech Solutions Inc.</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>elizabeth.anderson@example.com</div>
                                    <div class="text-gray-500">+1 (555) 123-4567</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-600">789 Oak Avenue, San Francisco, CA 94105</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>2 orders</div>
                                    <div class="text-gray-500">Last order 2025-02-25</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewCustomer(1)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="editCustomer(1)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="deleteCustomer(1)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b" data-id="2" data-gender="male" data-country="US" data-state="WA" data-city="Seattle">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">MR</div>
                                    <div>
                                        <div class="font-medium text-gray-900">Michael Richardson</div>
                                        <div class="text-sm text-gray-500">Global Innovations Ltd.</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>michael.richardson@example.com</div>
                                    <div class="text-gray-500">+1 (555) 987-6543</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-600">456 Pine Street, Seattle, WA 98101</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>1 order</div>
                                    <div class="text-gray-500">Last order 2025-02-24</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewCustomer(2)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="editCustomer(2)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="deleteCustomer(2)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b" data-id="3" data-gender="female" data-country="US" data-state="TX" data-city="Austin">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">ST</div>
                                    <div>
                                        <div class="font-medium text-gray-900">Sarah Thompson</div>
                                        <div class="text-sm text-gray-500">Creative Designs Co.</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>sarah.thompson@example.com</div>
                                    <div class="text-gray-500">+1 (555) 234-5678</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-600">123 Maple Drive, Austin, TX 78701</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>2 orders</div>
                                    <div class="text-gray-500">Last order 2025-02-23</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewCustomer(3)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="editCustomer(3)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="deleteCustomer(3)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="deletedCustomers" class="overflow-x-auto hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Customer</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Contact</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Address</th>
                            <th class="text-left py-4 px-4 text-sm font-medium text-gray-600">Orders</th>
                            <th class="text-right py-4 px-4 text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="deletedCustomerTableBody">
                        <tr class="border-b" data-id="4" data-gender="male" data-country="UK" data-state="London" data-city="London">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">JB</div>
                                    <div>
                                        <div class="font-medium text-gray-900">James Brown</div>
                                        <div class="text-sm text-gray-500">Brown Enterprises</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>james.brown@example.com</div>
                                    <div class="text-gray-500">+44 (20) 1234-5678</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-600">10 Downing Street, London, UK</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>3 orders</div>
                                    <div class="text-gray-500">Last order 2025-01-15</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewCustomer(4)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="editCustomer(4)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="restoreCustomer(4)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-refresh-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b" data-id="5" data-gender="female" data-country="CA" data-state="ON" data-city="Toronto">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">LM</div>
                                    <div>
                                        <div class="font-medium text-gray-900">Laura Miller</div>
                                        <div class="text-sm text-gray-500">Miller Co.</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>laura.miller@example.com</div>
                                    <div class="text-gray-500">+1 (416) 555-1234</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-600">321 Birch Road, Toronto, ON M5V 2T6</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm">
                                    <div>1 order</div>
                                    <div class="text-gray-500">Last order 2025-02-10</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex justify-end gap-2">
                                    <button onclick="viewCustomer(5)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="editCustomer(5)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                    <button onclick="restoreCustomer(5)" class="p-2 text-gray-400 hover:text-gray-600">
                                        <i class="ri-refresh-line w-5 h-5 flex items-center justify-center"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="addCustomerModal" class="modal">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold">Add New Customer</h2>
                        <button onclick="hideAddCustomerModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                        </button>
                    </div>
                    <form id="customerForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="male" class="mr-2" required>
                                        <span class="text-sm">Male</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="female" class="mr-2">
                                        <span class="text-sm">Female</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                                <input type="text" name="company" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <select name="country" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm pr-8">
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                <select name="state" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm pr-8">
                                    <option value="">Select State</option>
                                    <option value="CA">California</option>
                                    <option value="NY">New York</option>
                                    <option value="TX">Texas</option>
                                    <option value="London">London</option>
                                    <option value="ON">Ontario</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <select name="city" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm pr-8">
                                    <option value="">Select City</option>
                                    <option value="SF">San Francisco</option>
                                    <option value="LA">Los Angeles</option>
                                    <option value="NY">New York City</option>
                                    <option value="London">London</option>
                                    <option value="Toronto">Toronto</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm"></textarea>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button type="button" onclick="hideAddCustomerModal()" class="px-6 py-2 border border-gray-200 rounded-lg text-sm !rounded-button">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg text-sm !rounded-button">
                                <span id="modalSubmitText">Save Customer</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="viewCustomerModal" class="modal">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold">Customer Details</h2>
                        <div class="flex gap-2">
                            <button onclick="exportToPDF()" class="px-4 py-2 bg-primary text-white rounded-lg text-sm !rounded-button flex items-center gap-2">
                                <i class="ri-file-pdf-line w-5 h-5 flex items-center justify-center"></i>
                                <span>Export PDF</span>
                            </button>
                            <button onclick="hideViewCustomerModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                            <div id="customerDetails" class="space-y-4"></div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium mb-4">Order History</h3>
                            <div id="orderHistory" class="space-y-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    let activeTab = 'all';

    // Extract customers from respective tables
    function getActiveCustomersFromTable() {
        const rows = document.querySelectorAll('#activeCustomerTableBody tr');
        return Array.from(rows).map(row => {
            const cells = row.cells;
            const id = parseInt(row.dataset.id);
            const name = cells[0].querySelector('.font-medium').textContent;
            const company = cells[0].querySelector('.text-sm.text-gray-500').textContent;
            const email = cells[1].querySelector('div:first-child').textContent;
            const phone = cells[1].querySelector('.text-gray-500').textContent;
            const address = cells[2].textContent.trim();
            const orderCount = parseInt(cells[3].querySelector('div:first-child').textContent.split(' ')[0]);
            const lastOrderDate = cells[3].querySelector('.text-gray-500').textContent.replace('Last order ', '');
            return {
                id,
                name,
                company,
                email,
                phone,
                address,
                orders: orderCount > 0 ? [{ id: `ORD-${id.toString().padStart(3, '0')}`, date: lastOrderDate, amount: 0, status: 'Completed' }] : [],
                gender: row.dataset.gender || '',
                country: row.dataset.country || '',
                state: row.dataset.state || '',
                city: row.dataset.city || ''
            };
        });
    }

    function getDeletedCustomersFromTable() {
        const rows = document.querySelectorAll('#deletedCustomerTableBody tr');
        return Array.from(rows).map(row => {
            const cells = row.cells;
            const id = parseInt(row.dataset.id);
            const name = cells[0].querySelector('.font-medium').textContent;
            const company = cells[0].querySelector('.text-sm.text-gray-500').textContent;
            const email = cells[1].querySelector('div:first-child').textContent;
            const phone = cells[1].querySelector('.text-gray-500').textContent;
            const address = cells[2].textContent.trim();
            const orderCount = parseInt(cells[3].querySelector('div:first-child').textContent.split(' ')[0]);
            const lastOrderDate = cells[3].querySelector('.text-gray-500').textContent.replace('Last order ', '');
            return {
                id,
                name,
                company,
                email,
                phone,
                address,
                orders: orderCount > 0 ? [{ id: `ORD-${id.toString().padStart(3, '0')}`, date: lastOrderDate, amount: 0, status: 'Completed' }] : [],
                gender: row.dataset.gender || '',
                country: row.dataset.country || '',
                state: row.dataset.state || '',
                city: row.dataset.city || ''
            };
        });
    }

    let customers = getActiveCustomersFromTable();
    let deletedCustomers = getDeletedCustomersFromTable();

    // Render customers to respective tables
    function renderCustomers() {
        const activeTbody = document.getElementById('activeCustomerTableBody');
        const deletedTbody = document.getElementById('deletedCustomerTableBody');

        activeTbody.innerHTML = customers.map(customer => `
            <tr class="border-b" data-id="${customer.id}" data-gender="${customer.gender}" data-country="${customer.country}" data-state="${customer.state}" data-city="${customer.city}">
                <td class="py-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                            ${customer.name.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${customer.name}</div>
                            <div class="text-sm text-gray-500">${customer.company}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm">
                        <div>${customer.email}</div>
                        <div class="text-gray-500">${customer.phone}</div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm text-gray-600">${customer.address}</div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm">
                        <div>${customer.orders.length} orders</div>
                        <div class="text-gray-500">${customer.orders.length ? `Last order ${customer.orders[0].date}` : 'No orders'}</div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="flex justify-end gap-2">
                        <button onclick="viewCustomer(${customer.id}, 'active')" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                        <button onclick="editCustomer(${customer.id}, 'active')" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                        <button onclick="deleteCustomer(${customer.id})" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-delete-bin-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');

        deletedTbody.innerHTML = deletedCustomers.map(customer => `
            <tr class="border-b" data-id="${customer.id}" data-gender="${customer.gender}" data-country="${customer.country}" data-state="${customer.state}" data-city="${customer.city}">
                <td class="py-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                            ${customer.name.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${customer.name}</div>
                            <div class="text-sm text-gray-500">${customer.company}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm">
                        <div>${customer.email}</div>
                        <div class="text-gray-500">${customer.phone}</div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm text-gray-600">${customer.address}</div>
                </td>
                <td class="py-4 px-4">
                    <div class="text-sm">
                        <div>${customer.orders.length} orders</div>
                        <div class="text-gray-500">${customer.orders.length ? `Last order ${customer.orders[0].date}` : 'No orders'}</div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="flex justify-end gap-2">
                        <button onclick="viewCustomer(${customer.id}, 'deleted')" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-eye-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                        <button onclick="editCustomer(${customer.id}, 'deleted')" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-edit-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                        <button onclick="restoreCustomer(${customer.id})" class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="ri-refresh-line w-5 h-5 flex items-center justify-center"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');

        // Show/hide tables based on active tab
        document.getElementById('activeCustomers').style.display = activeTab === 'all' ? 'block' : 'none';
        document.getElementById('deletedCustomers').style.display = activeTab === 'deleted' ? 'block' : 'none';
    }

    // Modal controls
    function showAddCustomerModal() {
        document.getElementById('addCustomerModal').style.display = 'block';
        document.getElementById('modalSubmitText').textContent = 'Save Customer';
        document.getElementById('customerForm').reset();
        delete document.getElementById('customerForm').dataset.editId;
    }

    function hideAddCustomerModal() {
        document.getElementById('addCustomerModal').style.display = 'none';
    }

    function showViewCustomerModal() {
        document.getElementById('viewCustomerModal').style.display = 'block';
    }

    function hideViewCustomerModal() {
        document.getElementById('viewCustomerModal').style.display = 'none';
    }

    // View customer details
    function viewCustomer(id, source) {
        const customerList = source === 'active' ? customers : deletedCustomers;
        const customer = customerList.find(c => c.id === id);
        const detailsDiv = document.getElementById('customerDetails');
        const orderHistoryDiv = document.getElementById('orderHistory');
        detailsDiv.innerHTML = `
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-500">Full Name</div>
                    <div>${customer.name}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Email</div>
                    <div>${customer.email}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Phone</div>
                    <div>${customer.phone}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Company</div>
                    <div>${customer.company || 'N/A'}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Address</div>
                    <div>${customer.address}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Gender</div>
                    <div>${customer.gender || 'N/A'}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Country</div>
                    <div>${customer.country || 'N/A'}</div>
                </div>
            </div>
        `;
        orderHistoryDiv.innerHTML = customer.orders.length > 0 ? customer.orders.map(order => `
            <div class="p-4 border border-gray-200 rounded-lg">
                <div class="flex justify-between items-center mb-2">
                    <div class="font-medium">${order.id}</div>
                    <div class="text-sm text-gray-500">${order.date}</div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">$${order.amount.toFixed(2)}</div>
                    <div class="px-3 py-1 text-xs rounded-full ${
                        order.status === 'Completed' ? 'bg-green-100 text-green-800' :
                        order.status === 'Processing' ? 'bg-blue-100 text-blue-800' :
                        'bg-gray-100 text-gray-800'
                    }">${order.status}</div>
                </div>
            </div>
        `).join('') : '<p class="text-sm text-gray-500">No order history available</p>';
        showViewCustomerModal();
    }

    // Delete customer
    function deleteCustomer(id) {
        const customer = customers.find(c => c.id === id);
        const warningModal = document.createElement('div');
        warningModal.className = 'modal';
        warningModal.innerHTML = `
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                <i class="ri-error-warning-line w-6 h-6 flex items-center justify-center"></i>
                            </div>
                            <h2 class="text-xl font-semibold">Delete Customer</h2>
                        </div>
                        <div class="mb-6">
                            <p class="text-gray-600 mb-2">Are you sure you want to delete this customer?</p>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                        ${customer.name.split(' ').map(n => n[0]).join('')}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">${customer.name}</div>
                                        <div class="text-sm text-gray-500">${customer.email}</div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-red-600 text-sm mt-4">This action cannot be undone.</p>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button onclick="this.closest('.modal').remove()" class="px-4 py-2 border border-gray-200 rounded-lg text-sm !rounded-button">Cancel</button>
                            <button onclick="confirmDelete(${id}, this)" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm !rounded-button flex items-center gap-2">
                                <i class="ri-delete-bin-line w-4 h-4 flex items-center justify-center"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(warningModal);
        warningModal.style.display = 'block';
    }

    function confirmDelete(id, button) {
        const customer = customers.find(c => c.id === id);
        const index = customers.indexOf(customer);
        if (index !== -1) {
            deletedCustomers.push(customers.splice(index, 1)[0]);
            renderCustomers();
            button.closest('.modal').remove();
            showNotification('Customer deleted successfully', 'red');
        }
    }

    // Switch between tabs
    function switchTab(tab) {
        activeTab = tab;
        document.getElementById('allTab').className = `px-4 py-2 rounded-full text-sm font-medium ${tab === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'}`;
        document.getElementById('deletedTab').className = `px-4 py-2 rounded-full text-sm font-medium ${tab === 'deleted' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'}`;
        renderCustomers();
    }

    // Restore customer
    function restoreCustomer(id) {
        const customer = deletedCustomers.find(c => c.id === id);
        const index = deletedCustomers.indexOf(customer);
        if (index !== -1) {
            customers.unshift(deletedCustomers.splice(index, 1)[0]);
            renderCustomers();
            showNotification('Customer restored successfully', 'green');
        }
    }

    // Edit customer
    function editCustomer(id, source) {
        const customerList = source === 'active' ? customers : deletedCustomers;
        const customer = customerList.find(c => c.id === id);
        const form = document.getElementById('customerForm');
        form.name.value = customer.name;
        form.email.value = customer.email;
        form.phone.value = customer.phone;
        form.company.value = customer.company || '';
        form.address.value = customer.address;
        form.gender.value = customer.gender || 'male';
        form.country.value = customer.country || '';
        form.state.value = customer.state || '';
        form.city.value = customer.city || '';
        document.getElementById('modalSubmitText').textContent = 'Update Customer';
        form.dataset.editId = id;
        form.dataset.source = source;
        showAddCustomerModal();
    }

    // Show filters modal
    function showFilters() {
        document.getElementById('filterModal').style.display = 'block';
    }

    function hideFilters() {
        document.getElementById('filterModal').style.display = 'none';
    }

    function clearFilters() {
        document.getElementById('filterForm').reset();
        renderCustomers();
    }

    // Export to PDF (placeholder)
    function exportToPDF() {
        showNotification('PDF exported successfully!', 'green');
    }

    // Notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 bg-${type}-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2`;
        notification.innerHTML = `
            <i class="ri-${type === 'red' ? 'delete-bin-line' : 'refresh-line'} w-5 h-5 flex items-center justify-center"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    // Add or update customer
    document.getElementById('customerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const customer = {
            id: formData.get('editId') ? parseInt(formData.get('editId')) : Math.max(...customers.concat(deletedCustomers).map(c => c.id), 0) + 1,
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            company: formData.get('company') || '',
            address: formData.get('address'),
            orders: formData.get('editId') ? ((formData.get('source') === 'active' ? customers : deletedCustomers).find(c => c.id === parseInt(formData.get('editId'))).orders || []) : [],
            gender: formData.get('gender') || '',
            country: formData.get('country') || '',
            state: formData.get('state') || '',
            city: formData.get('city') || ''
        };
        if (formData.get('editId')) {
            const sourceList = formData.get('source') === 'active' ? customers : deletedCustomers;
            const index = sourceList.findIndex(c => c.id === parseInt(formData.get('editId')));
            sourceList[index] = customer;
        } else {
            customers.push(customer);
        }
        renderCustomers();
        hideAddCustomerModal();
        e.target.reset();
        showNotification(formData.get('editId') ? 'Customer updated successfully' : 'Customer added successfully', 'green');
    });

    // Search customers
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredCustomers = (activeTab === 'all' ? customers : deletedCustomers).filter(customer =>
            customer.name.toLowerCase().includes(searchTerm) ||
            customer.email.toLowerCase().includes(searchTerm) ||
            customer.company.toLowerCase().includes(searchTerm)
        );
        renderCustomers(filteredCustomers);
    });

    // Filter form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const genders = formData.getAll('gender');
        const country = formData.get('country');
        let filteredCustomers = activeTab === 'all' ? [...customers] : [...deletedCustomers];

        if (genders.length > 0) {
            filteredCustomers = filteredCustomers.filter(customer => genders.includes(customer.gender));
        }
        if (country) {
            filteredCustomers = filteredCustomers.filter(customer => customer.country === country);
        }

        renderCustomers(filteredCustomers);
        hideFilters();
    });

    // Initial render
    renderCustomers();
</script>
@endpush
