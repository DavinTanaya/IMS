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

            .btn-edit {
                display: none; /* Hide initially */
                position: absolute;
                top: 50%; /* Center vertically */
                right: 40%; /* Adjust distance from the right edge */
                transform: translateY(-50%); /* Center vertically by adjusting the position */
                background-color: rgba(128, 128, 128, 0.606); /* Optional: for better visibility */
                border-radius: 50%; /* Optional: to make it circular */
                padding: 10px; /* Adjust size */
            }

            .cart-card:hover .btn-edit {
                display: flex;
                align-items: center;
                justify-content: center;
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
                            <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 mb-1 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                                <h3 class="text-lg font-bold">{{ $counter }}. </h3>
                                <div class="flex flex-col">
                                    <h3 class="text-lg font-bold">#INV{{ $order->id + 1000 }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $order->formatted_date }}</p>
                                </div>
                                @php
                                    $counter++;
                                @endphp
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <h1 class="title1 mb- text-xl fw-bold text-left">Product</h1>
                    <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">Lists of products that have been added to our inventory</p>
                    <div class="d-flex flex-column gap-2 mt-3 overflow-auto max-h-[70%]">
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
                                            <p class="text-gray-600 text-lg mb-0">Rp. {{ $product->formatted_price }},00</p>
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
                                            <p class="text-gray-600 text-lg mb-0">Rp. {{ $product->formatted_price }},00</p>
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
                            <div class="flex flex-col gap-2 mt-3 overflow-auto cart-card relative" style="max-height: 300px;">
                                @foreach ($carts as $cart)
                                    <button class="flex gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-1 shadow-md hover:-translate-y-2 duration-300 hover:shadow-xl hover:bg-gray-500 cursor-pointer" type="button" data-bs-toggle="modal" data-bs-target="#modalUpdateCart" data-cart-quantity="{{$cart->quantity}}" data-product-image="{{ asset('storage/'.$cart->product->image) }}" data-product-id="{{ $cart->product->id }}" data-product-name="{{ $cart->product->name }}" data-product-stock="{{ $cart->product->stock }}" data-update-route="{{ route('updateCart', ['id' => $cart->id]) }}" data-delete-route="{{ route('deleteCart', ['id' => $cart->id]) }}" >
                                        <img src="{{ asset('storage/'.$cart->product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                        <h3 class="text-lg justify-self-end self-center font-bold text-left">{{ $cart->product->name }}</h3>
                                        <p class="text-gray-600 justify-self-end self-center text-lg">{{ $cart->quantity }}</p>
                                    </button>
                                    <button class="btn-edit">
                                        <span class="material-icons text-blue-500">
                                            edit
                                        </span>
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
                    <form action="" method="POST" enctype="multipart/form-data" id="modalDeleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                    </form>
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
                                    <h4 class="text-lg text-right text-gray-600">Rp. {{ $cart->formatted_total }},00</h4>
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

                console.log('Product Name:', productName);
                console.log('Product Stock:', productStock);
                console.log('Product Image:', productImage);
                console.log('Update Route:', updateRoute);
                console.log('Delete Route:', deleteRoute);
                console.log('Cart Quantity:', cartQuantity);

                var modalImage = myModal.querySelector('.modal-body img');
                var modalBody = myModal.querySelector('.modal-body');
                var modalUpdateForm = myModal.querySelector('#modalUpdateForm');
                var modalDeleteForm = myModal.querySelector('#modalDeleteForm');
                var modalXinput = myModal.querySelector('input[name="quantity"]');

                modalImage.src = productImage;
                modalBody.querySelector('h3').textContent = productName;
                modalBody.querySelector('p').textContent = 'Stock: ' + productStock;
                modalUpdateForm.action = updateRoute;
                modalDeleteForm.action = deleteRoute;
                modalXinput.setAttribute('max', productStock);
                modalXinput.value = cartQuantity;
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
    </script>
</x-app-layout>