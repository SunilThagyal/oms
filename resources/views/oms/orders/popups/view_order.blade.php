
<div id="viewOrderModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 {{ $viewOrderModal ? 'flex' : 'hidden' }}">
   <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
      <div class="p-6 border-b flex items-center justify-between">
         <h3 class="text-xl font-semibold text-gray-900">Order Details</h3>
         <button wire:click="closeModal('viewOrderModal')" class="text-gray-400 hover:text-gray-500">
         <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
         </button>
      </div>
      <div class="p-6 space-y-6">
         <div class="grid grid-cols-2 gap-4">
            <div>
               <p class="text-sm font-medium text-gray-500">Order ID</p>
               <p class="mt-1">ORD-{{isset($viewed_order) ?  hash_id($viewed_order?->id) : 'Nan'}}</p>
            </div>
            <div>
               <p class="text-sm font-medium text-gray-500">Status</p>
               <p class="mt-1"><span class="px-2 py-1 text-xs rounded-full  {{$viewed_order?->status_class ?? 'Nan'}}">{{$viewed_order?->status ?? 'Nan'}}</span></p>
            </div>
            <div>
               <p class="text-sm font-medium text-gray-500">Customer</p>
               <p class="mt-1">{{$viewed_order?->customer?->name ?? 'Nan'}}</p>
            </div>
            <div>
               <p class="text-sm font-medium text-gray-500">Date</p>
               <p class="mt-1">{{$viewed_order?->customer?->created_at ?? 'Nan'}}</p>
            </div>
            <div>
               <p class="text-sm font-medium text-gray-500">Email</p>
               <p class="mt-1">{{$viewed_order?->customer?->email ?? 'Nan'}}</p>
            </div>
            <div>
               <p class="text-sm font-medium text-gray-500">Phone</p>
               <p class="mt-1">{{$viewed_order?->customer?->customerDetails->phone ?? 'Nan'}}</p>
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
                     <tr class="border-t">
                        <td class="px-4 py-2 text-sm">Premium Wireless Headphones</td>
                        <td class="px-4 py-2 text-sm">1</td>
                        <td class="px-4 py-2 text-sm">$199.99</td>
                        <td class="px-4 py-2 text-sm">$199.99</td>
                     </tr>
                     <tr class="border-t">
                        <td class="px-4 py-2 text-sm">USB-C Charging Cable</td>
                        <td class="px-4 py-2 text-sm">2</td>
                        <td class="px-4 py-2 text-sm">$15.99</td>
                        <td class="px-4 py-2 text-sm">$31.98</td>
                     </tr>
                     <tr class="border-t">
                        <td class="px-4 py-2 text-sm">Phone Case</td>
                        <td class="px-4 py-2 text-sm">1</td>
                        <td class="px-4 py-2 text-sm">$29.99</td>
                        <td class="px-4 py-2 text-sm">$29.99</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="mt-6 text-right">
            <p class="text-sm font-medium text-gray-500">Total Amount</p>
            <p class="text-xl font-semibold mt-1">${{$order->total_price}}</p>
         </div>
      </div>
      <div class="p-6 border-t flex justify-end">
         <button onclick="alert('PDF export functionality would go here')" class="px-4 py-2 text-sm bg-primary text-white rounded hover:bg-primary/90 flex items-center gap-2">
         <i class="ri-file-pdf-line w-4 h-4 flex items-center justify-center"></i>
         <span>Export as PDF</span>
         </button>
      </div>
   </div>
</div>
