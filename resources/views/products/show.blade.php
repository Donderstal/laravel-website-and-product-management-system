@extends('layouts.master')

@section('content')

<script type="text/javascript">
    var gallery = {!! json_encode($product->gallery) !!}
</script>

<section class="product-page">

    <div class="grid-x">
        <div class="grid-x cell small-12 product-page__top-part-wrapper">

            <div class="cell small-12 large-5 product-page__image-header">
                <div class="product-page__header-img-wrapper">

                    <img class="product-page__image-header__img" id="product-image" src="{{ $product->cover ? route('image.action', ['cover', $product->cover->picture]) : mix(config('site.products.default_image_path')) }}">

                    <div class="product-page__image-header__button-wrapper">
                        <button id="product-gallery__left-button" class="ons-aanbod__bottom-button"> 
                            <img class="button-arrow-left svg-injection" src="{{ mix('img/ui-icons/arrow.svg') }}"> 
                        </button>
                            <span class="product-gallery__counter"> 
                                <span id="product-gallery__counter">1</span> / {{ sizeof($product->gallery) }}
                            </span>
                        <button id="product-gallery__right-button" class="ons-aanbod__bottom-button"> 
                            <img class="button-arrow-right svg-injection" src="{{ mix('img/ui-icons/arrow.svg') }}">  
                        </button>
                    </div>     

                </div>

            </div>

            <div class="cell small-12 large-7 product-page__main-info">
                <div class="product-page__main-info__inner">

                    <div class="product-page__main-info__subsection">
                        <h1 class="product-page__main-header-font">{{ $product->brand->title }}</h1>

                        <p id="bel-mij-terug__product-name" class="product-page__main-subtitle-font">{{ $product->title }}</p>
                    </div>

                    @if($product->status !== 'sold')
                    <div class="product-page__main-info__price-subsection">
                        <p class="product-page__price-font">
                            @if ( $product['status'] === 'sold' ) 
                                Verkocht!
                            @else
                                &euro; {{ number_format("$product->price",0,",",".") }} 
                            @endif    
                        </p>
                        <p class="product-page__VAT-font"> BTW niet verrekenbaar</p>
                    </div>

                    <div class="grid-x product-page__contact-details__subsection">

                        <div class="cell small-12">
                            <h3 class="product-page__main-subtitle-font">Interesse?</h3>                        
                        </div>

                        <div class="cell small-6 product-page__contact-inner-div">
                            <div class="product-page__contact-small-font">Bellen </div>
                            <div>
                                <a class="product-page__call-me__telephone-number product-page__clickable-link" target="_blank" href="tel:0356944646"><u>03</u>5 694 4646</a> 
                            </div>
                        </div>

                        <div class="cell small-4 end product-page__contact-inner-div">
                            <div class="product-page__contact-small-font">Delen </div>
                            <div class="product-page__social-icons-wrapper"> 
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" target="_blank" class="product-page__ui-icon">
                                    <img  class="product-icon svg-injection" src="{{ mix('img/ui-icons/facebook.svg') }}">
                                </a>
                                <a class="product-page__ui-icon" id="product-page__copy-link">
                                    <img class="product-icon svg-injection" src="{{ mix('img/ui-icons/link.svg') }}"> 
                                </a>
                                <a href="mailto:info@companybv.nl"  class="product-page__ui-icon">
                                    <img class="product-icon svg-injection" src="{{ mix('img/ui-icons/mail.svg') }}">
                                </a>
                            </div>
                        </div>

                        <div class="cell small-12 product-page__decorative-line">
                        </div>

                        @if ($errors->any())
                        <div class="cell small-12 alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (Session::has('message'))
                        <div class="cell small-12 large-6 sent-message">
                            <div class="message-{{ Session::get('message')['type'] }}">{{ Session::get('message')['text'] }}</div>
                            </div>
                        @endif

                        @if (!Session::has('message'))
                        <form class="grid-x cell small-12" action="{{ route('products.store', ['slug' => $slug_object->slug ]) }}" method="post">
                        {{@csrf_field()}}
                            <div class="cell small-12 medium-6 product-page__input-div">
                                <input id="bel-mij-terug__naam" class="product-page__input {{$errors->has('name') ? 'is-invalid-input' : null}}" placeholder="Naam" name="name" required value="{{ old('name') }}">
                            </div>

                            <div class="cell small-12 medium-6 product-page__input-div">
                                <input id="bel-mij-terug__tel" class="product-page__input {{$errors->has('telephone') ? 'is-invalid-input' : null}}" placeholder="Telefoon nr." name="telephone" required value="{{ old('telephone') }}">
                            </div>

                            <input id="bel-mij-terug__prod" class="product-page__input" placeholder="Telefoon nr." name="product" required value="{{ $product->brand->title . ' ' . $product->title }}">

                            <div id="bel-mij-terug" class="cell small-12 product-page__call-me__button product-page__contact-large-font">
                                <button class="product-page__call-me-button product-page__clickable-link"><u>Bel</u> mij terug</button>
                            </div>
                        </form>
                        @endif
                        
                    </div>

                    @else 
                    <div class="grid-x product-page__main-info__subsection">
                        <div class="cell small-12">
                            <h2 class="product-page__verkocht-header">Verkocht</h2>
                        </div>

                        <div class="cell small-12">
                            <h3 class="product-page__main-subtitle-font">Interesse?</h3>
                        </div>

                        <div class="cell small-12">
                            <p class="product-page__contact-small-font">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div>

                        <div class="cell small-12 product-page__contact-large-font">
                            <a class="product-page__call-me__telephone-number product-page__clickable-link" href="{{ route('page3') }}"><u>Na</u>ar Zoekopdracht</a>
                        </div>

                    </div>

                    @endif

                    <div class="grid-x product-page__main-info__subsection">
                        <div class="cell small-6">
                            <p class="product-page__detail-title-darkbg-font">Km stand</p>
                            <p class="product-page__detail-darkbg-font">{{ $product->mileage }} km</p>
                        </div>  

                        <div class="cell small-6">
                            <p class="product-page__detail-title-darkbg-font">Brandstof</p>
                            <p class="product-page__detail-darkbg-font">{{ config('site.products.fuel_types')[$product->fuel] }}</p>
                        </div>  

                        <div class="cell small-6">
                            <p class="product-page__detail-title-darkbg-font">Kleur</p>
                            <p class="product-page__detail-darkbg-font">{{ $product->color->title }}</p>
                        </div>  

                        <div class="cell small-6">
                            <p class="product-page__detail-title-darkbg-font">Transmissie</p>
                            <p class="product-page__detail-darkbg-font">{{ config('site.products.transmission_types')[$product->transmission] }}</p>
                        </div>  
                    </div>

                    <div class="product-page__main-info__subsection">
                        <p id="product-page__specificaties-bekijken" class="product-page__all-specs-font"><img class="product-page__all-specs-arrow svg-injection" src="{{ mix('img/ui-icons/arrow.svg') }}"> <u>BE</u>KIJK ALLE SPECIFICATIES</p>
                    </div>

                </div>
            </div>
        </div>

        <div id="product-page__specificaties" class="cell small-12 product-page__specificaties">
            <div class="grid-x product-page__specificaties__inner">
                <div class="cell small-12 product-page__specificaties__header"> 
                    <h1 class="product-page__main-header-dark-font">
                        SPECIFICATIES
                    </h1>
                </div>         
                @foreach($product->specification as $specification)
                <div class="cell small-6 large-3 product-page__specificaties__subsection"> 
                    <p class="product-page__detail-title-lightbg-font">
                        {{ $specification->title }}
                    </p>
                    <p class="product-page__detail-lightbg-font">
                        {{ $specification->value }}
                    </p>
                </div>    
                @endforeach
            </div>
        </div>

        <div class="cell small-12 product-page__opties">
            <div class="grid-x product-page__opties__inner">
                <div class="cell small-12 product-page__opties__header"> 
                    <h1 class="product-page__main-header-font">
                        OPTIES
                    </h1>
                </div>   

            {{-- Options --}}
                <div class="cell small-12 grid-x product-page__all-options-wrapper">
                    @foreach($product->options as $options)
                    <div class="grid-x cell small-12 product-page__option-wrapper">
                        <div class="cell small-12">
                            <p class="product-page__main-subtitle-font--white">
                                {{ $options->title }}
                            </p>
                        </div>
                        <div class="grid-x cell small-12">
                                @foreach($options->items as $item)
                                <div class="cell small-12 medium-6 large-4">
                                    <p class="product-page__options-font">- {{ $item->title }}</p>
                                </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="product-page__main-info__subsection">
                    <p id="product-page__meer-opties" class="product-page__all-specs-font"><img class="product-page__all-specs-arrow svg-injection" src="{{ mix('img/ui-icons/plus.svg') }}"> <u>ME</u>ER WEERGEVEN</p>
                </div>
            </div>
        </div>

        <div class="cell small-12 product-page__remarks hide-for-small">
            <div class="grid-x product-page__remarks-inner">
                <div class="cell small-12">
                    <h1 class="product-page__main-header-font">
                        OPMERKINGEN
                    </h1>
                </div>

                <div class="cell small-12 medium-4 product-page__remarks-subsection">
                    <p>{{ $product->model->title }} {{ $product->title }}</p>
                    <p>{{ $product->note }}</p>
                </div>
                <div class="cell small-12 medium-4 product-page__remarks-subsection">
                    <p>Bel voor meer informatie, een proefrit of een afspraak.</p>
                    <div class="grid-x product-page__contact-details">

                        <div class="cell small-1">
                              <p><i class="fas fa-phone"></i></p>
                        </div>
                        <div class="cell small-11">
                              <p  class="product-page__contact-paragraph"><a class="contact-details__anchor" target="_blank" href="tel:0356944646"> <u>06</u> - 1234 5678</a></p>
                        </div>      

                     </div>
                </div>
            </div>
        </div>

        <div class="cell small-12 product-page__service">
            <div class="grid-x product-page__service-inner">
                <div class="cell small-12 product-page__service-subsection">
                    <p class="product-page__bottom-specs-title-font">VOORZIEN VAN</p>
                </div>

                <div class="cell small-12 grid-x product-page__services-wrapper">
                    @foreach($product->services as $services)
                    <div class="cell grid-x small-12 medium-6">
                        <div class="cell small-12 large-2">
                            <p class="product-page__service-subtitle">{{ $services->title }}</p> 
                        </div>
                        <div class="cell small-12 large-10">
                            <p class="product-page__service-desc">{{ $services->value }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="cell small-12 product-page__main-info__subsection">
                    <p id="product-page__meer-voorzien-van" class="product-page__all-specs-font--dark"><img class="product-page__all-specs-arrow--dark svg-injection" src="{{ mix('img/ui-icons/plus.svg') }}"> <u>ME</u>ER WEERGEVEN</p>
                </div>
            </div>
        </div>

        <div class="cell small-12 product-page__decorative-line--bottom">
        </div>

        <div class="cell small-12 product-page__over-company">
            <div class="grid-x product-page__over-company__inner">
                <div class="cell small-12">
                    <p class="product-page__bottom-specs-title-font">OP ZOEK NAAR EEN VERGELIJKBARE AUTO?</p>
                </div>
                <div class="cell small-12 medium-6 large-4 product-page__over-company__subsection">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
                </div>
                <div class="cell small-12 medium-6 large-4 product-page__over-company__subsection">
                    <p class="product-page__over-company__subheader">Geopend:</p>
                    Maandag t/m vrijdag van 08.00 tot 18.00 uur. 
                    Zaterdag van 10.00 tot 17.00 uur.

                    Excepteur sint occaecat cupidatat non proident.
                </div>
                <div class="cell small-12 medium-6 large-4 product-page__over-company__subsection">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </div>
            </div>
        </div>

        <div class="grid-x cell small-12 product-page__related-products">

            <div class="cell small-12">
                <h2 class="homepage__featured-title">UITGELICHT</h2>
            </div>

            <div class="cell small-12 homepage__featured-cars grid-x">
                @foreach($related_products as $related)
                <div class="cell small-12 large-4">
                    @include('products.card', ['product' => $related])
                </div>
                @endforeach
            </div>
        </div>

    <div>
</section>

@endsection