<x-ui.collapse.Collapse id="card-sum-detail">
    <div role="button" class="mb-3 btn btn-sm btn-outline-secondary rounded">
        مشاهده ریز حساب‌ها
        <i class="far fa-angle-down"></i>
        <br>
    </div>

    <x-slot name='content'>
        <div class="row pb-5">
            @foreach ($cards as $card)
                <div class="col-lg-6">
                    <div class="row mx-0 px-0 border-2 border-bottom py-3">
                        <div class="col-6">
                            @if ($card['link'])
                                <form action="{{ $card['link'] }}">
                                    <input type="hidden" name="receives" value="{{ json_encode($card['receives']) }}">
                                    <input type="hidden" name="directory" value="cards">
                                    <input type="hidden" name="cardName" value="{{ $card['name'] }} {{ $periodTitle }}">
                                    <button class="btn btn-link" title="مشاهده حساب">{{ $card['name'] }}</button>
                                </form>
                            @else
                                <span>{{ $card['name'] }}</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <span>{{ number_format($card['amount']) }}</span>
                            <small>تومان</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-ui.collapse.Collapse>
