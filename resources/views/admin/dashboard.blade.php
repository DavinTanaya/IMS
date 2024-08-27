<x-app-layout>
    @section('head')
        <style>
            .grid-container {
                display: grid;
                grid-template-columns: 5fr 4fr;
                padding: 10px;
                height: 79vh;
            }
            .title2 {
                font-size: 1rem;
                font-weight: 500;
            }

            .title1{
                font-size: 2rem;
                font-weight: 600;
            }
            
        </style>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    @endsection
    <div class="p-1">
        <div class="dark:bg-gray-800 sm:rounded-lg">
            <div class="grid-container gap-3">
                <div class="bg-white px-4 py-4 min-h-full rounded-lg overflow-hidden position-relative">
                    <h1 class="title1 mb- text-xl fw-bold text-left">Product</h1>
                    <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">
                        Lists of products that have been added to our inventory
                    </p>
                
                    <div class="position-absolute top-5 end-5 p-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            Add Product +
                        </a>
                    </div>                    
                    <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                        @foreach ($products as $product)
                                <div class="flex gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <a href="{{ route('dashboard', ['id'=>$product->id]) }}">
                                            <h3 class="text-lg font-bold text-left">{{ $product->name }}</h3>
                                            <p class="text-gray-600 text-left text-break">Stock: {{ $product->stock }}</p>    
                                        </a>
                                    </div>
                                    <p class="text-gray-600 text-lg mt-4">Rp. {{ $product->price }}</p>
                                    <div class="d-flex align-items-center p-1 rounded-sm ml-3 mb-0 w-6 aspect-square justify-content-center hover:bg-bg duration-200 transition-all cursor-pointer bg-accent text-white">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-delete-route="{{ route('deleteProduct', ['id' => $product->id]) }}" data-product-name="{{ $product->name }}" data-product-stock="{{ $product->stock }}" data-product-price="{{ $product->price }}" data-product-image="{{ asset('storage/' . $product->image) }}">                                            >
                                            <span class="material-icons text-red-500">delete</span>
                                        </button>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>

                @if($productForm)
                    <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                        <div class="min-h-[90%]">
                            <h1 class="title1 mb- text-xl fw-bold text-left">Edit Product</h1>
                            <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">Enter the following the information to edit a product</p>
                            <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[50vh]">
                                <form action="{{ route('editProduct', ['id'=>$productForm->id]) }}" method="POST" enctype="multipart/form-data" class="mt-0 space-y-6">
                                    @csrf
                                    <div class="hover:bg-slate-300 duration-200 transition-all cursor-pointer group bg-slate-200 w-48 aspect-square rounded-xl relative flex items-center justify-center flex-col overflow-hidden">
                                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="imageInputEdit" name="image">
                                        <img id="previewImages" class="w-full h-full object-cover hidden" alt="Image preview">
                                        <img id="oldImage" src="{{ asset('storage/'.$productForm->image) }}" class="w-full h-full object-cover" alt="Image preview">    
                                    </div>                                    
                                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                    <div>
                                        <x-input-label for="name" :value="__('Product Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $productForm->name }}" required/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" value="{{ $productForm->price }}" required min="1"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    </div>
                                    <div>
                                        <x-input-label for="stock" :value="__('Stock')" />
                                        <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" value="{{ $productForm->stock }}" required min="1"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                                    </div>
                                    <div>
                                        <label for="category" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                        <select class="form-select form-select-md mb-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" aria-label=".form-select-lg example" id="category" name="categoryId">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $productForm->categoryId ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                            <option value="create" class="btn btn-primary">Create Category</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('categoryId')" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <button type="submit" class="btn btn-primary">Create Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                        <div class="min-h-[90%]">
                            <h1 class="title1 mb- text-xl fw-bold text-left">Add Product</h1>
                            <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">Enter the following the information to add a new product</p>
                            <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[50vh]">
                                <form action="{{ route('storeProduct') }}" method="POST" enctype="multipart/form-data" class="mt-0 space-y-6">
                                    @csrf
                                    <div class="hover:bg-slate-300 duration-200 transition-all cursor-pointer group bg-slate-200 w-48 aspect-square rounded-xl relative flex items-center justify-center flex-col overflow-hidden">
                                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="imageInput" name="image">
                                        <img id="previewImage" class="w-full h-full object-cover hidden" alt="Image preview">
                                        <span class="material-icons text-gray-500" id="uploadIcon">
                                            add_a_photo
                                        </span>
                                        <p class="text-gray-500 text-sm group-hover:text-light transition-all duration-200" id="uploadText">Add Product Image</p>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                    <div>
                                        <x-input-label for="name" :value="__('Product Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price')" required min="1"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    </div>
                                    <div>
                                        <x-input-label for="stock" :value="__('Stock')" />
                                        <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" :value="old('stock')" required min="1"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                                    </div>
                                    <div>
                                        <label for="category" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                        <select class="form-select form-select-md mb-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" aria-label=".form-select-lg example" id="category" name="categoryId">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                            <option value="create" class="btn btn-primary">Create Category</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('categoryId')" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <button type="submit" class="btn btn-primary">Create Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('storeCategory') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="flex flex-col gap-2 overflow-auto max-h-[10vh]">
                            <div>
                                <x-input-label for="category_name" :value="__('Category Name')" />
                                <x-text-input id="category_name" name="name" type="text" class="mt-1 block w-full" :value="old('category_name')" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                        <div class="flex gap-3">
                            <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">Product Name</h3>
                                <p class="text-gray-600">Stock: 0</p>
                            </div>
                        </div>
                    </div>
                    <h1 class="fw-bold text-center text-red-500">Are you sure you want to delete this product?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('dashboard') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if (session('message'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                  <div class="toast-body">
                    {{ session('message') }}
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
                var deleteRoute = button.getAttribute('data-delete-route');

                var modalImage = myModal.querySelector('.modal-body img');
                var modalBody = myModal.querySelector('.modal-body');
                var modalForm = myModal.querySelector('.modal-footer form');

                modalImage.src = productImage;
                modalForm.action = deleteRoute;
                modalBody.querySelector('h3').textContent = productName;
                modalBody.querySelector('p').textContent = 'Stock: ' + productStock;
            });
        });
        @if(!$productForm)
            document.getElementById('imageInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const uploadIcon = document.getElementById('uploadIcon');
                const uploadText = document.getElementById('uploadText');
                const previewImage = document.getElementById('previewImage');
                
                if(file){
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        uploadIcon.classList.add('hidden');
                        uploadText.classList.add('hidden')
                    }
                    reader.readAsDataURL(file);
                }
            });
        @else
            document.getElementById('imageInputEdit').addEventListener('change', function(event) {
                console.log('File input changed');
                const file = event.target.files[0];
                const previewImage = document.getElementById('previewImages');
                const oldImage = document.getElementById('oldImage');
                
                if (file) {
                    console.log('File selected:', file);
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        console.log('FileReader result:', e.target.result);
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        oldImage.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        @endif


        document.getElementById('category').addEventListener('change', function(event) {
            if (event.target.value === 'create') {
                var createCategoryModal = new bootstrap.Modal(document.getElementById('createCategoryModal'));
                createCategoryModal.show();
            }
        });

        document.getElementById('createCategoryModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('category').value = '';
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
    </script>
</x-app-layout>