    @php
        $totalAmount = 0;
    @endphp
    @foreach($cart as $productId => $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['price'] }}</td>
            <td>{{ $item['bonus'] }}</td>
            @php
                $subtotal = $item['quantity'] * $item['price'];
                $totalAmount += $subtotal;
            @endphp
            <td>{{ $subtotal }}</td>
            <td>
                <button class="btn btn-danger remove-from-cart" data-article-id="{{ $productId }}">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    @endforeach
    

   
        <tr>
            <td colspan="4"><h6>Total à payer</h6></td>
            <td id="total-amount"><h6>{{ $totalAmount ?? 0 }} @if(isset($settings['currency'])){{ $settings['currency'] }}@else CDF @endif</h6></td>
        </tr>
    
