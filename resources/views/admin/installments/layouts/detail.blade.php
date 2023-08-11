{{-- Showing detail total_price, priods and sum current installments --}}
<ul class="list-group list-group-horizontal-md mb-5 mx-auto justify-content-center " id="installments-detail">
    <li class="col1 list-group-item list-group-item-warning">
        <span>مدت قرارداد:</span>
        <span>{{ $period }}</span>
    </li>
    <li class="col1 list-group-item list-group-item-primary">
        <span>مبلغ قرارداد:</span>
        <span>{{ $total_price_str }}</span>
        <small>تومان</small>
    </li>
    <li class="col1 list-group-item list-group-item-secondary">
        <span>مبلغ بیعانه:</span>
        <span >{{ $advance_payment }}</span>
        <small>تومان</small>
    </li>
    <li class="col1 list-group-item list-group-item-info">
        <span>جمع کل‌اقساط:</span>
        <span class="installments__total" data-total='{{ $installments_price }}'>{{-- handle with js --}}</span>
        <small>تومان</small>
    </li>
    <li class="col1 list-group-item list-group-item-success">
        <span>قابل پرداخت:</span>
        <span class="installments__payable" >{{ $payable }}</span>
        <small>تومان</small>
    </li>
    <li class="col1 list-group-item list-group-item-danger">
        <span>مانده اقساط:</span>
        <span class="installments__creditor">{{-- handle with js --}}</span>
        <small>تومان</small>
    </li>
</ul>
