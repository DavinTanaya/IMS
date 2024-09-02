<x-app-layout>
    @section('head')
        <style>
            .grid-container {
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
                padding: 10px;
                height: 79vh;
            }
            .title2 {
                font-size: 1rem;
                font-weight: 500;F
            }

            .title1{
                font-size: 2rem;
                font-weight: 600;
            }
            
        </style>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Dashboard</title>
    @endsection
    <div class="p-1">
        <div class="dark:bg-gray-800 sm:rounded-lg">
            <div class="grid-container gap-3">
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <h1 class="mb-3 text-2xl fw-bold">Invoice History</h1>
                    <p class="text mb-4 text-gray-500 text-sm"> All Invoice you have created in the past will be shown here. (Click To Open) </p>
                    <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                        @php
                            $counter = 1;
                        @endphp

                        @foreach ($orders as $order)
                            <a href="{{ route('invoice', ['token' => $order->token]) }}" class="flex gap-3 bg-white shadow-md rounded-lg p-3 mb-1 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                                <h3 class="text-lg font-bold">{{ $counter }}. </h3>
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-bold">#INV{{ $order->id + 1000 }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $order->formatted_date }}</p>
                                </div>
                                @php
                                    $counter++;
                                @endphp
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <h1 class="title1 mb- text-xl fw-bold text-left">Product</h1>
                    <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">Lists of products that have been added to our inventory</p>
                    <div class="d-flex flex-column gap-2 mt-3 overflow-auto max-h-[70%]">
                        <select class="form-select form-select-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="category-select" name="category">
                            <option value="{{ route('dashboard') }}">Select Category</option>
                            @foreach ($categories as $category)
                                @if($categoryFilter)
                                    <option value="{{ route('dashboard', ['category' => $category->name]) }}" {{ $category->name == $categoryFilter->name ? 'selected disabled' : ''}}>
                                        {{ $category->name }}
                                    </option>
                                @else
                                    <option value="{{ route('dashboard', ['category' => $category->name]) }}">
                                        {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @foreach ($products as $product)
                            <div class="relative">
                                @if ($product->stock == 0)
                                    <div class="d-flex align-items-center justify-between bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                                        <div class="d-flex align-items-center gap-3 flex-grow">
                                            <img src="{{ asset('storage/'.$product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                            <div class="d-flex flex-column">
                                                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                                                <p class="text-gray-600">Stock: {{ $product->stock }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <p class="text-gray-600 text-lg mb-0">Rp. {{ number_format($product->price, 0, ',', '.') }},00</p>
                                            <div class="d-flex align-items-center p-1 rounded-sm w-6 aspect-square justify-content-center bg-accent text-white">
                                                <button type="button" disabled>
                                                    <span class="material-icons text-blue-500">
                                                        add_shopping_cart
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center rounded-lg">
                                        <p class="text-red-600 text-center text-lg font-bold">Product is out of stock</p>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-between bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                                        <div class="d-flex align-items-center gap-3 flex-grow">
                                            <img src="{{ asset('storage/'.$product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                            <div class="d-flex flex-column">
                                                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                                                <p class="text-gray-600">Stock: {{ $product->stock }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <p class="text-gray-600 text-lg mb-0">Rp. {{ number_format($product->price, 0, ',', '.') }},00</p>
                                            <div class="d-flex align-items-center p-1 rounded-sm w-6 aspect-square justify-content-center hover:bg-bg duration-200 transition-all cursor-pointer bg-accent text-white">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-product-image="{{ asset('storage/'.$product->image) }}" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-stock="{{ $product->stock }}" data-store-route="{{ route('storeCart', ['id' => $product->id]) }}">
                                                    <span class="material-icons text-blue-500">
                                                        add_shopping_cart
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="bg-white px-4 py-4 rounded-lg overflow-hidden flex flex-col h-full">
                    <div class="flex flex-col flex-grow">
                        <h1 class="title1 mb- text-xl fw-bold text-left">Invoice</h1>
                        <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">An invoice will be created for the following items you have added</p>
                        @if ($carts->count() == 0)
                            <div class="flex flex-col gap-2 mt-3 overflow-auto  items-center justify-center h-full" style="max-height: 300px;">
                                <p class="text-lg text-gray-600">No items in cart</p>
                            </div>
                        @else
                            <div class="flex flex-col gap-2 mt-1 overflow-auto cart-card relative" style="max-height: 300px;">
                                @foreach ($carts as $cart)
                                <button class="relative flex gap-3 mt-2 bg-white rounded-lg p-3 transform transition-all -translate-y-1 shadow-md hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer" type="button" data-bs-toggle="modal" data-bs-target="#modalUpdateCart" data-cart-quantity="{{$cart->quantity}}" data-product-image="{{ asset('storage/'.$cart->product->image) }}" data-product-id="{{ $cart->product->id }}" data-product-name="{{ $cart->product->name }}" data-product-stock="{{ $cart->product->stock }}" data-update-route="{{ route('updateCart', ['id' => $cart->id]) }}" data-delete-route="{{ route('deleteCart', ['id' => $cart->id]) }}">
                                    <img src="{{ asset('storage/'.$cart->product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                    <h3 class="text-lg justify-self-end self-center font-bold text-left">{{ $cart->product->name }}</h3>
                                    <p class="text-gray-600 justify-self-end self-center text-lg">{{ $cart->quantity }}</p>
                                    <div class="edit-icon opacity-0 absolute inset-0 m-auto self-center justify-center flex items-center hover:bg-gray-500/65 hover:opacity-65 hover:rounded-lg min-w-full min-h-full">
                                        <span class="material-icons text-blue-500">
                                            edit
                                        </span>
                                    </div>
                                </button>
                                
                                @endforeach
                            </div>
                        @endif

                    </div>
                    @if ($carts->count() == 0)
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3 min-w-full justify-center">
                                {{ __('Finalize Invoice') }}
                            </x-primary-button>
                        </div>
                    @else
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3 min-w-full justify-center" data-bs-toggle="modal" data-bs-target="#finalizeModal">
                                {{ __('Finalize Invoice') }}
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdateCart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Cart</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="modalUpdateForm">
                        @csrf
                        @method('PATCH')
                        <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                            <div class="flex gap-3">
                                <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-bold">Product Name</h3>
                                    <p class="text-gray-600">Stock: 0</p>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" required min="1"/>
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modalDeleteButton" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal">Delete</button>
                    <button type="submit" form="modalUpdateForm" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="modalAddCart">
                    @csrf
                    <div class="modal-body">
                        <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                            <div class="flex gap-3">
                                <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-bold">Product Name</h3>
                                    <p class="text-gray-600">Stock: 0</p>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" :value="1" required min="1"/>
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade finalizeModal" id="finalizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Finalize</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('storeOrder') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="flex flex-col gap-2 mt-3" style="max-height: 200px; overflow-y: auto;">
                        @foreach ($carts as $cart)               
                            <div class="flex justify-between gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                                <div class="flex-1 flex items-center gap-3">
                                    <img src="{{ asset('storage/'.$cart->product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                    <h3 class="text-lg font-bold text-left">{{ $cart->product->name }}</h3>    
                                    <p class="text-gray-600 text-lg">{{ $cart->quantity }}</p>
                                </div>
                                <div class="flex items-center">
                                    <h4 class="text-lg text-right text-gray-600">Rp. {{ number_format($cart->total, 0, ',', '.') }},00</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="flex justify-end mt-4">
                        <h3 class="text-lg font-bold text-right text-red-500">Total: Rp. {{ $total_price }},00</h3>
                    </div>
                    <div>
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required placeholder="Jl. Laravel No 25"/>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                    <div class="my-3">
                        <x-input-label for="province-select" :value="__('Province')" />
                        <select class="form-select form-select-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="province-select" name="province">
                            <option value="" disabled>Select Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->provinceId }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('province')" />
                    </div>
                    <div class="my-3">
                        <x-input-label for="city-select" :value="__('City')" />
                        <select class="form-select form-select-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="city-select" name="city" disabled>
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->cityId }}" data-province-id="{{ $city->provinceId }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>
                    <div>
                        <x-input-label for="zip_code" :value="__('Zip Code')" />
                        <x-text-input id="zip_code" name="zip_code" type="number" class="mt-1 block w-full" :value="old('zip_code')" required placeholder="14350"/>
                        <x-input-error class="mt-2" :messages="$errors->get('zip_code')" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="modal" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-red-600 fw-bold">Remove Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to remove items from cart?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="POST" enctype="multipart/form-data" id="modalDeleteForm" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-green-400 border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                <div class="toast-body">
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-red-400 border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = document.getElementById('staticBackdrop');

            myModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var productName = button.getAttribute('data-product-name');
                var productStock = button.getAttribute('data-product-stock');
                var productImage = button.getAttribute('data-product-image');
                var storeRoute = button.getAttribute('data-store-route');

                var modalImage = myModal.querySelector('.modal-body img');
                var modalBody = myModal.querySelector('.modal-body');
                var modalForm = myModal.querySelector('.modal form');
                var modalXinput = myModal.querySelector('input[name="quantity"]');

                modalImage.src = productImage;
                modalBody.querySelector('h3').textContent = productName;
                modalBody.querySelector('p').textContent = 'Stock: ' + productStock;
                modalForm.action = storeRoute;
                modalXinput.setAttribute('max', productStock);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var myModal = document.getElementById('modalUpdateCart');

            myModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var productName = button.getAttribute('data-product-name');
                var productStock = button.getAttribute('data-product-stock');
                var productImage = button.getAttribute('data-product-image');
                var updateRoute = button.getAttribute('data-update-route');
                var deleteRoute = button.getAttribute('data-delete-route');
                var cartQuantity = button.getAttribute('data-cart-quantity');

                var modalImage = myModal.querySelector('.modal-body img');
                var modalBody = myModal.querySelector('.modal-body');
                var modalUpdateForm = myModal.querySelector('#modalUpdateForm');
                var modalDeleteButton = myModal.querySelector('#modalDeleteButton');
                var modalXinput = myModal.querySelector('input[name="quantity"]');

                modalImage.src = productImage;
                modalBody.querySelector('h3').textContent = productName;
                modalBody.querySelector('p').textContent = 'Stock: ' + productStock;
                modalUpdateForm.action = updateRoute;
                modalDeleteButton.setAttribute('data-delete-route', deleteRoute);
                modalXinput.setAttribute('max', productStock);
                modalXinput.value = cartQuantity;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var myModal = document.getElementById('confirmationModal');

            myModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var deleteRoute = button.getAttribute('data-delete-route');
                
                var modalDeleteForm = myModal.querySelector('#modalDeleteForm');
                modalDeleteForm.action = deleteRoute;
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 2000 
                    });
                });
                toastList.forEach(function (toast) {
                    toast.show();
                });
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        autohide: true,
                        delay: 2000 
                    });
                });
                toastList.forEach(function (toast) {
                    toast.show();
                });
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            var editIconContainer = document.querySelectorAll('.edit-icon');
            editIconContainer.forEach(function (icon) {
                var editIcon = icon.querySelector('.material-icons');

                icon.addEventListener('mouseover', function () {
                    icon.classList.remove('opacity-0');
                    icon.classList.add('opacity-100');
                    editIcon.classList.add('rounded-circle', 'bg-white', 'p-2');
                });

                icon.addEventListener('mouseout', function () {
                    icon.classList.remove('opacity-100');
                    icon.classList.add('opacity-0');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const confirmationModal = document.getElementById('confirmationModal');

            const modal = new bootstrap.Modal(confirmationModal);

            confirmationModal.addEventListener('hidden.bs.modal', function () {
                location.reload();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var provinceSelect = document.getElementById('province-select');
            var citySelect = document.getElementById('city-select');
            
            var allCityOptions = Array.from(citySelect.options);

            provinceSelect.addEventListener('change', function() {
                var selectedProvinceId = this.value;

                citySelect.innerHTML = '<option value="">Select City</option>';

                if (selectedProvinceId) {
                    citySelect.disabled = false;
                    
                    allCityOptions.forEach(function(option) {
                        if (option.dataset.provinceId === selectedProvinceId) {
                            citySelect.add(option.cloneNode(true));
                        }
                    });
                } else {
                    citySelect.disabled = true;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var categorySelect = document.getElementById('category-select');
            
            categorySelect.addEventListener('change', function() {
                var selectedValue = this.value;
                if (selectedValue) {
                    window.location.href = selectedValue;
                }
            });
        });
    </script>
</x-app-layout>