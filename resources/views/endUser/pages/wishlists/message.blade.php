@if ($message)
    <div class='card product-item border-0 mb-4'>
        <div class='card-body border-left border-right text-center p-0 pt-4 pb-3'>
            <div class='d-flex justify-content-center h4 mt-1'>
                <span class='mt-5 text-success p-2'>deleted</span>
            </div>
        </div>
    </div>
@else
    <div class='alert alert-danger'>
        <p>item not found!</p>
    </div>
@endif
