@component('mail::message')
# Order Placed Successfully!

Dear {{ $order->first_name }} {{ $order->last_name }},

Thank you for your order! Your order #{{ $order->id }} has been successfully placed and is currently
{{ ucfirst($order->status) }}.

**Order Details:**
* **Order Date:** {{ $order->created_at->format('M d, Y H:i A') }}
* **Total Amount:** ${{ number_format($order->total, 2) }}
* **Payment Method:** {{ ucfirst($order->payment_method) }}

**Shipping Information:**
* **Name:** {{ $order->first_name }} {{ $order->last_name }}
* **Address:** {{ $order->address_line_1 }}, {{ $order->address_line_2 }}
* **City, State, Zip:** {{ $order->city }}, {{ $order->state }}, {{ $order->zip_code }}
* **Country:** {{ $order->country }}
* **Email:** {{ $order->email }}
* **Phone:** {{ $order->phone }}

**Products Ordered:**
@component('mail::table')
| Product Name | Quantity | Price | Subtotal |
|:-------------|:---------|:------|:---------|
@foreach($order->orderItems as $item)
    | {{ $item->product->name ?? 'Product Not Found' }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} |
    ${{ number_format($item->quantity * $item->price, 2) }} |
@endforeach
@endcomponent

You can view your order details at any time by visiting your dashboard:
@component('mail::button', ['url' => route('user.orders.show', $order->id)])
View Order
@endcomponent

We will notify you once your order has been shipped.

Thanks,
{{ config('app.name') }}
@endcomponent