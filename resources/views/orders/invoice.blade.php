<x-layouts.app>
    @php
        $orderData = $order ?? [];
        $orderNumber = $orderData['id'] ?? 'INV-0000';
        $items = $orderData['items'] ?? [];
        $placedAt = $orderData['placed_at'] ?? '2021-03-22';
        $billingAddress = $orderData['billing_address'] ?? [];
        $shippingAddress = $orderData['shipping_address'] ?? $billingAddress;
        $payment = $orderData['payment'] ?? ['brand' => 'Card', 'last4' => '0000'];
        $shipping = $orderData['shipping'] ?? 0;
        $tax = $orderData['tax'] ?? 0;
        $subtotal = array_reduce($items, fn($carry, $item) => $carry + ($item['price'] ?? 0) * ($item['qty'] ?? 1), 0);
        $total = $orderData['total'] ?? $subtotal + $shipping + $tax;
        $downloadPdfUrl = route('orders.invoice', $orderNumber) . '?format=pdf';
        $downloadExcelUrl = route('orders.invoice', $orderNumber) . '?format=excel';
    @endphp

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        @media print {

            header,
            footer,
            nav,
            #scrollToTop,
            .print-hidden {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            main {
                padding: 0 !important;
            }

            .container {
                max-width: none !important;
                width: 100% !important;
            }
        }
    </style>

    @include('orders.partials.invoice-body', [
        'orderNumber' => $orderNumber,
        'items' => $items,
        'placedAt' => $placedAt,
        'billingAddress' => $billingAddress,
        'shippingAddress' => $shippingAddress,
        'payment' => $payment,
        'shipping' => $shipping,
        'tax' => $tax,
        'subtotal' => $subtotal,
        'total' => $total,
        'downloadPdfUrl' => $downloadPdfUrl,
        'downloadExcelUrl' => $downloadExcelUrl,
        'showActions' => true,
    ])
</x-layouts.app>
