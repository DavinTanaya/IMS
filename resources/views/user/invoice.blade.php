<x-app-layout> 
    @section('head')
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Invoice</title>
    @endsection

    <div class="mx-3 mb-3 bg-white flex-1 rounded-lg">
        <div class="d-flex align-items-center justify-content-between">
            <img src="{{ asset('logo/laravel.png') }}" alt="" class="img-fluid w-[30%] user-select-none pe-none" draggable="false">
            <div class="mr-[10%]">
                <h1 class="text-4xl font-bold">Invoice #{{ $order->id + 1000 }}</h1>
            </div>
            <a href="{{ route('download.invoice', ['token'=> $order->token]) }}" class="mr-12 bg-gray-200 d-flex p-2 text-gray-500 rounded-lg -translate-y-1 shadow-lg hover:bg-gray-300 hover:-translate-y-2 cursor-pointer">
                <p class="pr-1">Print</p>
                <span class="material-icons">
                    print
                </span>
            </a>
        </div>
        <div class="mx-6">
            <div class="mt-3">
                <div class="d-flex justify-content-between">
                    <div class="ml-6">
                        <p class="text-md text-white font-bold user-select-none">.</p>
                        <p class="text-md text-white font-bold user-select-none text-right">.</p>
                        <h2 class="text-xl font-bold">Bill To</h2>
                        <p class="text-gray-500">{{ $order->user->name }}</p>
                        <p class="text-gray-500">{{ $order->user->email }}</p>
                        <p class="text-gray-500">{{ $order->user->phone_number }}</p>
                    </div>
                    <div class="max-w-[19%]">
                        <div class="text-md font-bold text-right">
                            <p>{{ $order->formatted_date }}</p>
                            <p>{{ $order->formatted_hour }}</p>
                        </div>
                        <div class="ml-2">
                            <h2 class="text-xl font-bold">Ship To</h2>
                            <p class="text-gray-500">{{ $order->user->name }}</p>
                            <p class="text-gray-500">{{ $order->user->email }}</p>
                            <p class="text-gray-500">{{ $order->user->phone_number }}</p>
                            <p class="text-gray-500 text-break">{{ $order->address . ', ' . $city->name . ', ' . $order->province->name}}</p>
                            <p class="text-gray-500">{{ $order->zip_code }}</p>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <table class="table table-bordered table-responsive rounded-lg">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->order_products as $order_products)
                            <tr class="font-normal align-middle">
                                <td class="max-w-[10px]">
                                    <p class="text-lg text-break">{{ $order_products->product->name }}</p>
                                    <p class="text-sm text-gray-500">Category: {{ $order_products->product->category->name }}</p>
                                </td>
                                <td><img src="{{ asset('storage/' . $order_products->product->image) }}" alt="" class="img-fluid max-w-[100px] max-h-[100px]"></td>
                                <td>{{ $order_products->quantity }}</td>
                                <td>Rp. {{ number_format($order_products->product->price, 0, ',', '.') }},00</td>
                                <td>Rp. {{ number_format($order_products->total, 0, ',', '.') }},00</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold" style="border:none;">
                            <td colspan="3" style="border:none;"></td>
                            <td class="text-left text-lg" style="border: solid 1px #e5e7eb; background-color:#f8f9fa; color:red;">Total</td>
                            <td class="table-light" style="border: solid 1px #e5e7eb; color:red;">Rp. {{ number_format($order->order_products->sum('total'), 0, ',', '.') }},00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>    
</x-app-layout>