@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Manage Slides</h3>
    <form method="POST" action="/slides-update" enctype="multipart/form-data" id="product-form">
      <div class="form-wrap">
        @csrf

        <div class="form-wrap-flex form-wrap-flex-images" id="preview_images">
          @for($i = 1; $i <= $num_slides; ++$i) <?php $slide = isset($slides[$i - 1]) ? $slides[$i - 1]->url : false; ?>
            <div class="field half">
            <label class="label" for="product_upload_image_{{ $i }}">Slide {{ $i }}</label>
            <div class="control">
              <div class="file">
                <label class="file-label">
                  <input type="hidden" name="img_url_{{ $i }}" value="{{ $slide }}" />
                  <input class="file-input" type="file" id="product_upload_image_{{ $i }}" name="upload-image-{{ $i }}"
                    accept="image/*">
                  <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                      Choose an Image…
                    </span>
                  </span>
                </label>
              </div>
              <div class="preview-image">
                @if($slide)
                <div class="preview-image__image output_{{ $i }}">
                  <img class="full-height" id="output_{{ $i }}" src={{ $slide }} />
                  <i class="remove fas fa-times-circle" img_id="{{ $i }}"></i>
                </div>
                <div class="preview-image__default preview-image__default_{{ $i }} hide"><i class="far fa-image"></i>
                </div>
                @else
                <div class="preview-image__image hide_img output_{{ $i }}">
                  <img class="full-height" id="output_{{ $i }}" />
                  <i class="remove fas fa-times-circle" img_id="{{ $i }}"></i>
                </div>
                <div class="preview-image__default preview-image__default_{{ $i }}"><i class="far fa-image"></i></div>
                @endif
              </div>
            </div>
        </div>
        @endfor
      </div>
  </div>
</div>
</div>
<button class="button is-primary call-loader" type="submit">Update Slides</button>

</div>
</div>

</form>
@endsection
