<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\City;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    private function imageToBase64($path)
    {
        if (file_exists($path)) {
            $image = file_get_contents($path);
            return 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode($image);
        }
        return null;
    }
    public function generatePdf($token)
    {
        $order = Order::where('token', $token)->where('userId', Auth::user()->id)->first();
        if (!$order) {
            return redirect('/dashboard')->with('error', 'Order not found');
        }
        
        $order->load('order_products', 'order_products.product', 'user');
        $order->formatted_date  = Carbon::parse($order->created_at)->translatedFormat('l\, jS F Y');
        $order->formatted_hour  = Carbon::parse($order->created_at)->translatedFormat('h:i:s A');
        
        $logo_file = public_path('logo/laravel.png');

        $logo = file_get_contents($logo_file);
        $base64 = base64_encode($logo);
        $base64logo = 'data:image/png;base64,' . $base64;

        foreach ($order->order_products as $order_product) {
            $product_image_path = public_path('storage/' . $order_product->product->image);
            $order_product->product->image_base64 = $this->imageToBase64($product_image_path);
        }
        $city = City::where('cityId', $order->cityId)->first();
        $pdfContent = view('pdf.invoice', ['order' => $order, 'logo' => $base64logo, 'city' => $city])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $dompdf->stream('invoice.pdf', ['Attachment' => true]);
    }
}
