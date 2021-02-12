@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Edit Product</h3>

    <form method="POST" action="/products/edit/{{ $product->id }}" enctype="multipart/form-data" id="product-form">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex form-wrap-flex-products-top products-calc-total">
          <div class="field name">
            <label class="label" for="name">Product Name<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="name" name="name" autocomplete="off" value="{{ $product->name }}"
                required />
            </div>
          </div>
          <div class="field cost">
            <label class="label" for="our_cost">Our Price<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="number" min="0" step="0.01" id="our_cost" name="our_cost" autocomplete="off"
                value="{{ $product->our_cost }}" required />
            </div>
          </div>
          <div class="field cost">
            <label class="label" for="cost">Dealer Price<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="number" min="0" step="0.01" id="cost" name="cost" autocomplete="off"
                value="{{ $product->cost }}" required />
            </div>
          </div>
          <div class="field discount">
            <label class="label" for="discount">Discount %</label>
            <div class="control">
              <input class="input" type="number" min="0" id="discount" name="discount" autocomplete="off"
                value="{{ $product->discount }}" />
            </div>
          </div>
          <div class="field final-price">
            <label class="label" for="final-price">Final Price</label>
            <div class="control">
              <input class="input" id="final-price" autocomplete="off" disabled
                value="${{ $product->discount_cost() }}" />
            </div>
          </div>
          <div class="field available-on">
            <label class="label" for="available_on">Available On</label>
            <div class="control">
              <input class="input" type="text" id="available_on" name="available_on" autocomplete="off"
                value="{{ $product->available_on }}" />
            </div>
          </div>

        </div>

        <div class="columns">
          <div class="column is-one-third">
            {{-- attributes --}}
            <div class="form-wrap-flex form-wrap-flex-attributes">
              <div class="field full">
                <label class="label" for="">Attributes (4 max)</label>
                <div class="repeater-field-wrap" id="repeater-field-wrap">
                  @foreach($product->attributes as $attribute)
                  <div class="entry input-group">
                    <div class="field has-addons">
                      <input type="text" class="input name" name="attribute_names[]" placeholder="Attribute"
                        value="{{ $attribute->text }}">
                      <div class="input-group-append">
                        <button class="button is-danger remove-attribute" type="button"><i
                            class="fas fa-times"></i></button>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <div class="entry input-group">
                    <div class="field has-addons">
                      <input type="text" class="input name" name="attribute_names[]" placeholder="Attribute">
                      <div class="input-group-append">
                        <button class="button is-primary add-attribute" type="button"><i
                            class="fas fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-two-thirds">
            {{-- variations --}}
            <div class="form-wrap-flex form-wrap-flex-attributes">
              <div class="field full">
                <label class="label" for="">Colors / Quantity</label>
                <div class="repeater-field-wrap" id="repeater-field-wrap-variation">
                  @foreach($product->variations as $variation)
                  <div class="entry input-group existing">
                    <div class="field has-addons">
                      <input type="text" class="input name" name="variation_names[]" placeholder="Color Name"
                        value="{{ $variation->text }}">
                      <input type="number" class="input quantity" name="variation_quantity[]" placeholder="Quantity"
                        value="{{ $variation->quantity }}">
                      <input type="text" class="input quantity variation-color-input" name="variation_color[]"
                        placeholder="Color" value="{{ $variation->color }}">
                      <div class="color-preview"><a style="background-color: {{ $variation->color }}"
                          class="set-color"></a></div>
                      <div class="input-group-append">
                        <button class="button is-danger remove-variation" type="button"><i
                            class="fas fa-times"></i></button>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <div class="entry input-group">
                    <div class="field has-addons">
                      <input type="text" class="input name" name="variation_names[]" placeholder="Color Name">
                      <input type="number" class="input quantity" name="variation_quantity[]" placeholder="Quantity">
                      <input type="text" id="variation-color-init" class="input quantity" name="variation_color[]"
                        placeholder="Color">
                      <div class="color-preview"><a id="set-color-init" class="set-color"></a></div>
                      <div class="input-group-append">
                        <button class="button is-primary add-variation" type="button"><i
                            class="fas fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-wrap-flex form-wrap-flex-products-top">
          <div class="field description">
            <label class="label" for="description">Product Description</label>
            <div class="control">
              <div id="quill_editor" class="quill-wrap">{!! $product->description !!}</div>
              <textarea class="textarea quill_text" id="description" name="description"></textarea>
            </div>
          </div>
        </div>

        <div class="columns">
          <div class="column">
            <div class="form-wrap-flex form-wrap-flex-products-top">
              <div class="field description">
                <label class="label" for="details">Product Specifications</label>
                <div class="control">
                  <textarea class="textarea" id="details" name="details">{{ $product->details }}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="form-wrap-flex form-wrap-flex-products-top">
              <div class="field description">
                <label class="label" for="more_details">Product Parameters</label>
                <div class="control">
                  <textarea class="textarea" id="more_details"
                    name="more_details">{{ $product->more_details }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- main images --}}
        <div class="form-wrap-flex form-wrap-flex-images" id="preview_images">
          @for($i = 1; $i <= (1 + $num_images); ++$i) <div class="field sixth">
            <label class="label" for="product_upload_image_{{ $i }}">Image {{ $i }}</label>
            <div class="control">
              <div class="file">
                <label class="file-label">
                  <input type="hidden" name="img_url_{{ $i }}" value="{{ $product->{'img_url_' . $i} }}" />
                  <input class="file-input" type="file" id="product_upload_image_{{ $i }}" name="upload-image-{{ $i }}"
                    accept="image/*">
                  <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                      Choose a file…
                    </span>
                  </span>
                </label>
              </div>
              <div class="preview-image">
                @if($product->{"img_url_" . $i})
                <div class="preview-image__image output_{{ $i }}">
                  <img id="output_{{ $i }}" src={{ $product->{"img_url_" . $i} }} />
                  <i class="remove fas fa-times-circle" img_id="{{ $i }}"></i>
                </div>
                <div class="preview-image__default preview-image__default_{{ $i }} hide"><i class="far fa-image"></i>
                </div>
                @else
                <div class="preview-image__image hide_img output_{{ $i }}">
                  <img id="output_{{ $i }}" />
                </div>
                <div class="preview-image__default preview-image__default_{{ $i }}"><i class="far fa-image"></i></div>
                @endif
              </div>
            </div>
        </div>
        @endfor
      </div>

      {{-- tab videos --}}
      <div class="form-wrap-flex form-wrap-flex-images" id="tab_preview_videos">
        @for($i = 1; $i <= $tab_videos; ++$i) <div class="field half">
          <label class="label" for="product_upload_video_{{ $i }}">Tab Video {{ $i }}</label>
          <div class="control">
            <div class="file">
              <label class="file-label">
                <input type="hidden" name="tab_video_url_{{ $i }}" value="{{ $product->{'tab_video_url_' . $i} }}" />
                <input class="file-input" type="file" id="tab_product_upload_video_{{ $i }}"
                  name="tab-upload-video-{{ $i }}" accept="video/*">
                <span class="file-cta">
                  <span class="file-icon">
                    <i class="fas fa-upload"></i>
                  </span>
                  <span class="file-label">
                    Choose a file…
                  </span>
                </span>
              </label>
            </div>
            <div class="preview-image">
              @if($product->{"tab_video_url_" . $i})
              <div class="preview-image__image output_{{ $i }}">
                {{-- <img id="tab_output_{{ $i }}" src={{ $product->{"tab_video_url_" . $i} }} /> --}}
                <video controls>
                  <source src="{{ $product->{'tab_video_url_' . $i } }}" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                <i class="remove-video fas fa-times-circle" img_id="{{ $i }}"></i>
              </div>
              <div
                class="preview-image__default preview-image__default--video preview-image__default_tab_{{ $i }} hide"><i
                  class="far fa-play-circle"></i>
              </div>
              @else
              <div class="preview-image__default preview-image__default--video preview-image__default_tab_{{ $i }}"><i
                  class="far fa-play-circle"></i>
              </div>
              @endif
            </div>
          </div>
      </div>
      @endfor
  </div>

  {{-- tab images --}}
  <div class="form-wrap-flex form-wrap-flex-images" id="tab_preview_images">
    @for($i = 1; $i <= $tab_images; ++$i) <div class="field half">
      <label class="label" for="product_upload_image_{{ $i }}">Tab Image {{ $i }}</label>
      <div class="control">
        <div class="file">
          <label class="file-label">
            <input type="hidden" name="tab_img_url_{{ $i }}" value="{{ $product->{'tab_img_url_' . $i} }}" />
            <input class="file-input" type="file" id="tab_product_upload_image_{{ $i }}"
              name="tab-upload-image-{{ $i }}" accept="image/*">
            <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>
              <span class="file-label">
                Choose a file…
              </span>
            </span>
          </label>
        </div>
        <div class="preview-image">
          @if($product->{"tab_img_url_" . $i})
          <div class="preview-image__image tab_output_{{ $i }}">
            <img id="tab_output_{{ $i }}" src={{ $product->{"tab_img_url_" . $i} }} />
            <i class="remove-tab fas fa-times-circle" img_id="{{ $i }}"></i>
          </div>
          <div class="preview-image__default preview-image__default_tab_{{ $i }} hide"><i class="far fa-image"></i>
          </div>
          @else
          <div class="preview-image__image hide_img tab_output_{{ $i }}">
            <img id="tab_output_{{ $i }}" />
          </div>
          <div class="preview-image__default preview-image__default_tab_{{ $i }}"><i class="far fa-image"></i></div>
          @endif
        </div>
      </div>
  </div>
  @endfor
</div>

<div class="form-wrap-flex form-wrap-flex-categories">
  <div class="field full product-categories-checkboxes category-area">
    <label class="label">Categories</label>
    <div class="control">
      @foreach($categories as $category)
      <div class="category-item">
        <input type="checkbox" cat_num="{{ $category->id }}" id="category-{{ $category->id }}"
          name="category-{{ $category->id }}" @if(in_array($category->id, $selected_cats)) checked @endif />
        <label class="label" for="category-{{ $category->id }}">{{ $category->name }}</label>
      </div>
      @endforeach
    </div>
  </div>

  @foreach($categories as $category)
  <div
    class="@if (in_array($category->id, $selected_cats)) active @endif field full product-categories-checkboxes sub-category-area sub-category-{{ $category->id }}">
    <label class="label">{{ $category->name }} Sub Categories</label>
    <div class="control">
      @foreach($category->sub_categories as $sub_category)
      <div class="category-item">
        <input type="checkbox" id="sub-category-{{ $sub_category->id }}" name="sub-category-{{ $sub_category->id }}"
          @if(in_array($sub_category->id, $selected_sub_cats))
        checked
        @endif/>
        <label class="label" for="sub-category-{{ $sub_category->id }}">{{ $sub_category->name }}</label>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach

</div>

<div class="form-wrap-flex form-wrap-flex-archives">
  <div class="field">
    <label class="label" for="name">Archived Status<span class="required">*</span></label>
    <div class="control">
      <label class="radio">
        <input type="radio" name="archived" value="0" @if(!$product->archived) checked @endif>
        Live
      </label>
      <label class="radio">
        <input type="radio" name="archived" value="1" @if($product->archived) checked @endif>
        Archived
      </label>
    </div>
  </div>
</div>


<div class="field flex-margin">
  <div class="control">
    <button class="button is-primary call-loader" type="submit">Update Product</button>
    <a class="button is-danger modal-open call-loader margin-left" href="#">Delete Product</a>
    <a class="button is-info modal-open-2 call-loader margin-left" href="#">Duplicate Product</a>
  </div>
</div>
</div>
</form>
@if(count($blocked_users))
<div class="blocked-users">
  <label class="label" for="name">Product Blocked For:</label>
  @foreach($blocked_users as $blocked)
  <div class="blocked-users__item"><span>{{ $blocked->user->company . ' - ' . $blocked->user->name }}</span>
    <a href="/remove-blocked-user/{{ $blocked->id }}"><i class="fas fa-trash-alt"></i></a>
  </div>
  @endforeach
</div>
@endif
<form method="POST" action="/block-dealer">
  @csrf
  <div class="form-wrap">
    <div class="form-wrap-flex form-wrap-flex-blocked-dealers">
      <div class="field">
        <label class="label" for="name">Block This Product For:</label>
        <div class="control item-flex">
          <input type="hidden" name="product_id" value="{{ $product->id }}" />
          <div class="select">
            <select name="user_id">
              <option>--</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <button class="button is-danger call-loader" type="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
</form>
@if(count($reserved_users))
<div class="blocked-users">
  <label class="label" for="name">Product Exclusive For:</label>
  @foreach($reserved_users as $reserved)
  <div class="blocked-users__item"><span>{{ $reserved->user->company . ' - ' . $reserved->user->name }}</span>
    <a href="/remove-reserved-user/{{ $reserved->id }}"><i class="fas fa-trash-alt"></i></a>
  </div>
  @endforeach
</div>
@endif
<form method="POST" action="/reserve-dealer">
  @csrf
  <div class="form-wrap">
    <div class="form-wrap-flex form-wrap-flex-blocked-dealers">
      <div class="field">
        <label class="label" for="name">Make This Product Exclusive For:</label>
        <div class="control item-flex">
          <input type="hidden" name="product_id" value="{{ $product->id }}" />
          <div class="select">
            <select name="user_id">
              <option>--</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->company }} - {{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <button class="button is-danger call-loader" type="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
</form>
</div>
</div>


@endsection

@section('page-script')
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script>
  var colors_ojb = {'color': ["#1b9aaa", "#06e5aa", "#ef476f", "#ffc43d", "#51e5ff", "#55759e", "#e98a15", "#f6c659",
    "#204e9b", "#751f1c", "#000000", "#e60000", "#ff9900", "#ffff00", "#008a00", "#0066cc", "#9933ff", "#ffffff", "#facccc",
    "#ffebcc", "#ffffcc", "#cce8cc", "#cce0f5", "#ebd6ff", "#bbbbbb", "#f06666", "#ffc266", "#ffff66", "#66b966", "#66a3e0",
    "#c285ff", "#888888", "#a10000", "#b26b00", "#b2b200", "#006100", "#0047b2", "#6b24b2", "#444444", "#5c0000", "#663d00",
    "#666600", "#003700", "#002966", "#3d1466"]};
  var quill_settings = {
    modules: {
    toolbar: [
    [{ header: [1, 2, 3, 4, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [colors_ojb]
    ]
    },
    placeholder: 'Enter Your Text...',
    theme: 'snow'
    };
    new Quill('#quill_editor', quill_settings);
</script>

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<a class="button is-danger call-loader" href="/products/delete/{{ $product->id }}">Delete Product</a>
<a href="#" class="modal-close-button button is-primary">Cancel</a>


@endsection

@section('modal-2')

<h3 class="title">Are You Sure?</h3>

<a class="button is-info call-loader" href="/products/duplicate/{{ $product->id }}">Dupliacate Product</a>
<a href="#" class="modal-close-button button is-primary">Cancel</a>

@endsection
