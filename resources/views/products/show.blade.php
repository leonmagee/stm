@extends('layouts.layout')

@section('content')

@include('layouts.product-menu')

<div class="product-single">
  <div class="product-single__images">
    @if($product->img_url_1)
    <div class="product-single__images--url">
      @for($i = 1; $i
      <= $num_images; ++$i) <div class="product-single__images--url-item product-single__images--url-item_{{ $i }}">
        @if(strpos($product->{"img_url_" . $i}, 'video') !== false)
        <div class="video-wrap {{ ($i == 1) ? 'active' : 'hidden' }} img_url_{{ $i }}">
          <video controls>
            <source src="{{ $product->{'img_url_' . $i } }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        @else
        <img class="{{ ($i == 1) ? 'active' : 'hidden' }} img_url_{{ $i }}" src="{{ $product->{'img_url_' . $i } }}" />
        @endif
    </div>
    @endfor
  </div>
  <div class="product-single__images--row">
    @for($i = 1; $i <= $num_images; ++$i) @if($product->{"img_url_small_" . $i })
      <div class="product-single__images--item product-single__images--item_{{ $i }}" image_id="{{ $i }}">
        <img src="{{ $product->{"img_url_small_" . $i } }}" />
      </div>
      @endif
      @endfor
  </div>
  @else
  <div class="product-single__images--default"><i class="far fa-image"></i></div>
  @endif
  @if(count($products))
  <div class="product-single__carousel">
    <h2>Phones You May Also Like</h2>
    <div id="products-carousel" class="products-react-carousel" products='{{ $products }}'></div>
  </div>
  @endif
  @if(count($products2))
  <div class="product-single__carousel">
    <h2>Tempered Glass You May Also Like</h2>
    <div id="products-carousel2" class="products-react-carousel" products='{{ $products2 }}'></div>
  </div>
  @endif
  @if(count($products4))
  <div class="product-single__carousel">
    <h2>Wall Chargers You May Also Like</h2>
    <div id="products-carousel4" class="products-react-carousel" products='{{ $products4 }}'></div>
  </div>
  @endif
  @if(count($products6))
  <div class="product-single__carousel">
    <h2>Cases You May Also Like</h2>
    <div id="products-carousel6" class="products-react-carousel" products='{{ $products6 }}'></div>
  </div>
  @endif
</div>
<div class="product-single__right product-details">
  <div class="product-details__title">{{ $product->name }}</div>
  <div class="product-details__rating">
    <div id="rate-yo-wrap">
      <div id="rateYoDisplay" class="rate_yo_no_hover" rating="{{ (floor($product->rating * 2) / 2) }}">
        <div class="product-details__rating-modal">
          <div class="product-details__rating-modal--header">
            Total Ratings: {{ $ratings_total }}
          </div>
          @foreach($ratings_array as $item)
          <div class="product-details__rating-item">
            <?php $percent_width = \App\Helpers::get_percent($item[1], $ratings_total); ?>
            <div class="percentage-bar">
              <div class="percentage-bar__stars">{{ $item[0] }} Stars</div>
              <div class="percentage-bar__block">
                <div style="width: {{ $percent_width }}%" class="percentage-bar__block--inner"></div>
              </div>
              <div class="percentage-bar__percentage">{{ intval($percent_width) }}%</div>
            </div>
          </div>
          @endforeach
          <div class="product-details__rating-modal--footer">
            <a class="review-scroll" href="#product-tabs">See All Reviews</a>
          </div>
        </div>
      </div>
      <div class="product-details__rating-modal">
        <div class="product-details__rating-modal--header">
          Total Ratings: {{ $ratings_total }}
        </div>
        @foreach($ratings_array as $item)
        <div class="product-details__rating-item">
          <?php $percent_width = \App\Helpers::get_percent($item[1], $ratings_total); ?>
          <div class="percentage-bar">
            <div class="percentage-bar__stars">{{ $item[0] }} Stars</div>
            <div class="percentage-bar__block">
              <div style="width: {{ $percent_width }}%" class="percentage-bar__block--inner"></div>
            </div>
            <div class="percentage-bar__percentage">{{ intval($percent_width) }}%</div>
          </div>
        </div>
        @endforeach
        <div class="product-details__rating-modal--footer">
          @if($ratings_total)
          <a class="review-scroll" href="#product-tabs">See All Reviews</a>
          @endif
        </div>
      </div>
    </div>
    {{-- <div class="product-details__rating--link">
      <a class="review-scroll" href="#product-tabs">Leave a Review</a>
    </div> --}}
    <div class="product-details__compare"><a class="review-scroll" href="#product-tabs"><i class="fas fa-pen"></i>Leave
        a
        Review</a></div>
  </div>

  @if($related_products = $product->get_related())
  <div class="product-details__compare"><a class="saved-favorites__item--link-compare modal-delete-open"
      item_id={{ $product->id }}><i class="fas fa-eye"></i>Compare with Similar
      Items</a></div>
  @endif

  <div class="product-details__flex-space-wrap">
    @if($product->discount)
    <div class="product-details__cost">${{ $product->cost }}<span
        class="product-details__cost--orig"><span>${{ $product->orig_price }}</span></div>
    <div class="product-details__discount">
      <div class="product-details__discount--inner"><i class="fas fa-tag"></i>{{ $product->discount }}% Off
      </div>
    </div>
    @else
    <div class="product-details__cost">${{ $product->cost }}</div>
    @endif
    <form method="POST" action="/add-to-cart" class="product-details__form">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}" />
      <div class="product-details__cart">
        <div class="product-details__cart--inner">

          @if($product->in_stock())
          @if(count($product->variations))
          <div class="product-details__variations">
            <div class="select is-green">
              <select name="variation" id="variation-select">
                @foreach($product->variations as $variation)
                @if($variation->quantity)
                <option quantity="{{ $variation->quantity }}" value="{{ $variation->text }}">{{ $variation->text }}
                </option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          @endif
          <div class="product-details__quantity">
            <input class="input" type="number" min="1" name="quantity" id="quantity-input" class="quantity-input"
              placeholder="{{ $product->initial_quantity() }} Max" max_quantity="{{ $product->initial_quantity() }}"
              required />
          </div>
          <button class="add-to-cart"><i class="fas fa-cart-plus"></i>Add To Cart</button>
          @else
          <div class="out-of-stock">
            <div class="out-of-stock__text">Sold Out</div>
            @if($product->available_on)
            @if(\Carbon\Carbon::parse($product->available_on)->gt(\Carbon\Carbon::now()))
            <div class="out-of-stock__date">Available on
              {{ \Carbon\Carbon::parse($product->available_on)->format('F j, Y') }}</div>
            @endif
            @endif
          </div>
          @endif
        </div>
      </div>
    </form>
  </div>
  <div class="product-details__description">
    {!! $product->description !!}
  </div>

  <div class="product-details__tabs tabs is-toggle" id="product-tabs">
    <ul>
      <li class="is-active" tab="tab-1"><a>Product Images & Videos</a></li>
      <li tab="tab-2"><a>Product Specifications</a></li>
      <li tab="tab-3"><a>Product Parameters</a></li>
      <li tab="tab-4"><a>Product Reviews</a></li>
    </ul>
  </div>

  <div class="product-details__tabs-content tabs-content">

    <div class="tab-item active" id="tab-1">
      <div class="product-details__images">
        @for($i = 1; $i<= $num_tab_videos; ++$i) @if($product->{'tab_video_url_' . $i })
          <div class="product-details__images--item">
            <video controls poster="{{ $product->{'tab_video_poster_' . $i } }}">
              <source src="{{ $product->{'tab_video_url_' . $i } }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
          @endif
          @endfor
          @for($i = 1; $i<= $num_tab_images; ++$i) @if($product->{'tab_img_url_' . $i })
            <div class="product-details__images--item">
              <img src="{{ $product->{'tab_img_url_' . $i } }}" />
            </div>
            @endif
            @endfor
      </div>
    </div>

    <div class="tab-item background" id="tab-2">
      <div class="product-details__details">
        {!! $product->details !!}
      </div>
    </div>

    <div class="tab-item background" id="tab-3">
      <div class="product-details__details">
        {!! $product->more_details !!}
      </div>
    </div>

    <div class="tab-item background" id="tab-4">
      <div class="product-reviews">
        @if($product->was_purchased())
        <div class="product-reviews__first modal-open-review">
          @if($product->has_review())
          Edit your review <i class="fas fa-user-edit"></i>
          @elseif(count($product->reviews))
          Leave a review <i class="fas fa-user-edit"></i>
          @else
          Be the first to Leave a review <i class="fas fa-user-edit"></i>
          @endif
        </div>
        @else
        You must purchase this product to leave a review.
        @endif
        @foreach($product->reviews as $review)
        <div class="product-review">
          <div class="product-review__stars">
            <div class="rate_yo_review rate_yo_no_hover" rating="{{ $review->rating() }}"></div>
          </div>
          <div class="product-review__text">
            {{ $review->review }}
          </div>
          <div class="product-review__attribution">
            {{ $review->user->company }} - <span>{{ $review->updated_at->format('M d, Y') }}</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>


  </div>

  @if(\Auth()->user()->isAdmin())
  <div class="product-details__edit">
    <a href="/products/edit/{{ $product->id }}">Edit</a>
  </div>
  @endif
</div>
</div>

<div class="modal" id="review-modal">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box left">

      <h3 class="title">{{ $product->has_review() ? 'Edit Your Review' : 'Leave a Review' }}</h3>

      <form method="POST" action="/review-create-update">
        @csrf
        <input type="hidden" name="product_id" value={{ $product->id }} />
        <div class="field">
          <label class="label">Rate This Product</label>
          <div id="rateYo" rating="{{ $product->your_rating() }}" product_id="{{ $product->id }}"></div>
        </div>
        <div class="field">
          <label class="label">Your Review</label>
          <textarea class="textarea" name="review">{{ $product->review() }}</textarea>
        </div>
        <div class="field">
          <button class="button is-primary call-loader"
            type="submit">{{ $product->has_review() ? 'Update' : 'Submit' }}</button>
          <a class="modal-review-close button is-danger">Cancel</a>
        </div>
      </form>

    </div>

  </div>

  <button class="modal-close is-large" aria-label="close"></button>

</div>

@include('products.compare-modal', ['item' => $product, 'related' => $related_products])

@include('layouts.scroll-up')

@endsection
