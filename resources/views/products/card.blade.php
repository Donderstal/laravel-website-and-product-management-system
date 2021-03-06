<a class="grid-y product-card" href="{{ route( 'products.show', ['slug' => $product->slug->slug]) }}">

    <div class="cell small-7 product-card__image-wrapper">
        <img class="product-card__car-image" src="{{ $product->cover ? route('image.action', ['cover', $product->cover->picture]) : mix(config('site.products.default_image_path')) }}">
    </div>
    <div class="cell small-3 grid-x product-card__top-text-row">
        <div class="cell small-12 grid-x">
            <div class="cell small-8 product-card__car-name">
                <span id="product-car__car-name--ruler">
                {{ $product['title'] }}
                </span>
            </div>
            <div class="cell small-4 product-card__car-price"> 
                @if ( $product['status'] === 'sold' ) 
                    Verkocht!
                @else
                    &euro; {{ number_format("$product->price",0,",",".") }} 
                @endif
            </div>
            <div class="cell small-12 product-card__car-model"> {{ $product['model']['title'] }} </div>
        </div>
        <div class="product-card__decorative-line">
        </div>
    </div>

    <div class="cell small-2 grid-x product-card__bottom-text-row">
        <div class="cell small-4">
            <div class="product-card__kilometers-header">KM stand</div>
            <div class="product-card__kilometers"> {{ $product['mileage'] }} </div>
        </div>
        <div class="cell small-4">
            <div class="product-card__year-header"> Jaar </div>
            <div class="product-card__year"> {{ $product['year'] }} </div>
        </div>
        <div class="cell small-4 product-card__check-me-wrapper">
            <p class="product-card__check-me-out"><u>BE</u>KIJKEN</p>
        </div>
    </div>
</a>
