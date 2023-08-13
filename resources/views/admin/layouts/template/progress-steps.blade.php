@isset($id)
    <div class="row align-items-center justify-content-between mb-3 mx-0 contract-quick-access">
        <div class="col-3 col-xl-3 rounded  text-center {{ is_url_active(['contracts.edit']) ? 'active' : '' }}">
            <a href="{{ route('contracts.edit', $id) }}" class="d-block py-1 py-xl-2">
                <span class="contract-quick-access__title">قرارداد</span>
            </a>
        </div>
        <div class="col-3 col-xl-3 rounded  text-center {{ is_url_active(['installments.create']) ? 'active' : '' }}">
            <a href="{{ route('installments.create', $id) }}" class="d-block py-1 py-xl-2">
                <span class="contract-quick-access__title">اقساط</span>
            </a>
        </div>
        <div class="col-3 col-xl-3 rounded  text-center {{ is_url_active(['receives.create']) ? 'active' : '' }}">
            <a href="{{ route('receives.create', $id) }}" class="d-block py-1 py-xl-2">
                <span class="contract-quick-access__title">دریافتی‌ها</span>
            </a>
        </div>
    </div>
@endisset
