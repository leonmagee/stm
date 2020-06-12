@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Edit Product</h3>

    <form method="POST" action="/products/edit/{{ $product->id }}" enctype="multipart/form-data" id="product-form">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex form-wrap-flex-products-top">
          <div class="field name">
            <label class="label" for="name">Product Name<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="name" name="name" autocomplete="off" value="{{ $product->name }}"
                required />
            </div>
          </div>
          <div class="field cost">
            <label class="label" for="cost">Cost<span class="required">*</span></label>
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

        <div class="form-wrap-flex form-wrap-flex-products-top">
          <div class="field description">
            <label class="label" for="details">Product Details</label>
            <div class="control">
              <textarea class="textarea" id="details" name="details">{{ $product->details }}</textarea>
            </div>
          </div>
        </div>

        <div class="form-wrap-flex form-wrap-flex-products-top">
          <div class="field description">
            <label class="label" for="more_details">More Details</label>
            <div class="control">
              <textarea class="textarea" id="more_details" name="more_details">{{ $product->more_details }}</textarea>
            </div>
          </div>
        </div>

        <div class="form-wrap-flex form-wrap-flex-images">
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
                <div class="preview-image__image">
                  <img id="output_{{ $i }}" src={{ $product->{"img_url_" . $i} }} />
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

      <div class="form-wrap-flex form-wrap-flex-images">
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
              <div class="preview-image__image">
                <img id="tab_output_{{ $i }}" src={{ $product->{"tab_img_url_" . $i} }} />
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

  <div class="form-wrap-flex form-wrap-flex-attributes">
    <div class="field full">
      <label class="label" for="">Attributes</label>
      <div id="repeater-field-wrap">
        @foreach($product->attributes as $attribute)
        <div class="entry input-group">
          <div class="field has-addons">
            <input type="text" class="input name" name="attribute_names[]" placeholder="Particpant Name"
              value="{{ $attribute->text }}">
            <div class="input-group-append">
              <button class="button is-danger remove-attribute" type="button"><i class="fas fa-times"></i></button>
            </div>
          </div>
        </div>
        @endforeach
        <div class="entry input-group">
          <div class="field has-addons">
            <input type="text" class="input name" name="attribute_names[]" placeholder="Attribute">
            <div class="input-group-append">
              <button class="button is-primary add-attribute" type="button"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
  <div class="field flex-margin">
    <div class="control">
      <button class="button is-primary call-loader" type="submit">Update Product</button>
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
  var quill_settings = {
    modules: {
    toolbar: [
    [{ header: [1, 2, 3, 4, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    ]
    },
    placeholder: 'Enter Your Text...',
    theme: 'snow'
    };
    new Quill('#quill_editor', quill_settings);
    //new Quill("#quill_editor-add-new", quill_settings);
</script>

@endsection
