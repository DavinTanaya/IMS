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
    @endsection
    <div class="p-1">
        <div class="dark:bg-gray-800 sm:rounded-lg">
            <div class="grid-container gap-3">
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <h1 class="mb-3 text-2xl fw-bold">Invoice History</h1>
                    <p class="text mb-4 text-gray-500 text-sm"> All Invoice you have created in the past will be shown here. (Click To Open) </p>
                    <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                        <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                            <h3 class="text-lg font-bold">1. </h3>
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">#INV9239</h3>
                                <p class="text-gray-600">This is the content of the first card.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                            <h3 class="text-lg font-bold">2. </h3>
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">#INV9239</h3>
                                <p class="text-gray-600">This is the content of the first card.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                            <h3 class="text-lg font-bold">3. </h3>
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">#INV9239</h3>
                                <p class="text-gray-600">This is the content of the first card.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                            <h3 class="text-lg font-bold">4. </h3>
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">#INV9239</h3>
                                <p class="text-gray-600">This is the content of the first card.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 bg-white shadow-md rounded-lg p-3 transform transition-all hover:-translate-y-2 duration-300 hover:shadow-xl cursor-pointer">
                            <h3 class="text-lg font-bold">5. </h3>
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold">#INV9239</h3>
                                <p class="text-gray-600">This is the content of the first card.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <h1 class="title1 mb- text-xl fw-bold text-left">Product</h1>
                    <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">Lists of products that has been added to our inventory</p>
                    <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                        <div class="flex gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                            <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                            <div class="flex flex-col max-w-[60%]">
                                <h3 class="text-lg font-bold text-left">Sepatu NIKE</h3>
                                <p class="text-gray-600 text-left text-break">This is the content of the first card.</p>
                            </div>
                            <p class="text-gray-600 justify-self-end self-center text-lg" >Rp. 50.000</p>
                            <div class="self-center p-1 rounded-sm ml-4 w-6 aspect-square flex items-center justify-center hover:bg-bg duration-200 transition-all cursor-pointer bg-accent text-white">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <span class="material-icons text-blue-500 cursor-pointer">
                                        add_shopping_cart
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white px-4 py-4 min-h-full max-h-0 rounded-lg overflow-hidden">
                    <div class="min-h-[90%]">
                        <h1 class="title1 mb- text-xl fw-bold text-left">Invoice</h1>
                        <p class="text mb-4 text-gray-500 text-sm text-left border-bottom pb-3">An invoice will be created for the following items you have added</p>
                        <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                            <div class="flex gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                                <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                                <h3 class="text-lg justify-self-end self-center font-bold text-left">Sepatu NIKE</h3>
                                <p class="text-gray-600 justify-self-end self-center text-lg" >5</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-3 min-w-full justify-center" data-bs-toggle="modal" data-bs-target="#finalizeModal">
                            {{ __('Finalize Invoice') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                    <div class="flex gap-3">
                        <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                        <div class="flex flex-col">
                            <h3 class="text-lg font-bold">Sepatu NIKE</h3>
                            <p class="text-gray-600">Stock: 5</p>
                        </div>
                    </div>
                </div>
                <form action="">
                    <div class="mb-3">
                        <label for="exampleInputQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="exampleInputQuantity">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade finalizeModal" id="finalizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="flex flex-col gap-2 mt-3 overflow-auto max-h-[70%]">
                    <div class="flex gap-3 bg-white rounded-lg p-3 transform transition-all -translate-y-2 shadow-xl">
                        <img src="{{ asset('logo/logo.jpg') }}" alt="" class="img-fluid h-16 aspect-square object-cover rounded-md">
                        <h3 class="text-lg justify-self-end self-center font-bold text-left">Sepatu NIKE</h3>
                        <p class="text-gray-600 justify-self-end self-center text-lg" >5</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>