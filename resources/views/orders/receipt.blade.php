<x-layouts.app>
    @php
        $orderData = $order ?? [];
        $orderNumber = $orderData['id'] ?? '';
        $items = $orderData['items'] ?? [];
        $placedAt = $orderData['placed_at'] ?? null;
        $contact = $orderData['contact'] ?? ['email' => '', 'phone' => ''];
        $payment = $orderData['payment'] ?? ['brand' => '', 'last4' => ''];
        $total =
            $orderData['total'] ??
            array_reduce($items, fn($carry, $item) => $carry + ($item['price'] ?? 0) * ($item['qty'] ?? 1), 0);
        $downloadPdfUrl = route('orders.receipt', $orderNumber) . '?format=pdf';
        $downloadExcelUrl = route('orders.receipt', $orderNumber) . '?format=excel';
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

    @include('orders.partials.receipt-body', [
        'orderNumber' => $orderNumber,
        'items' => $items,
        'placedAt' => $placedAt,
        'contact' => $contact,
        'payment' => $payment,
        'total' => $total,
        'downloadPdfUrl' => $downloadPdfUrl,
        'downloadExcelUrl' => $downloadExcelUrl,
        'showActions' => true,
    ])
</x-layouts.app>
