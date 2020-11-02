@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Manage Slides</h3>
    <form method="POST" action="/slides-update" enctype="multipart/form-data" id="product-form">
      <div class="form-wrap">
        @csrf

        <div class="slider-admin list-group list-group-sort" id="preview_images">
          @foreach($slides as $slide)
          <div class="field" id="{{ $slide->id }}" order="{{ $slide->order }}">
            <div class="control">
              <div class="preview-image">
                @if($slide->url)
                <div class="preview-image__image output_{{ $slide->id }}">
                  <img class="full-height" id="output_{{ $slide->id }}" src={{ $slide->url }} />
                  <i class="remove fas fa-times-circle" img_id="{{ $slide->id }}"></i>
                </div>
                <div class="preview-image__default preview-image__default_{{ $slide->id }} hide"><i
                    class="far fa-image"></i>
                </div>
                @else
                <div class="preview-image__image hide_img output_{{ $slide->id }}">
                  <img class="full-height" id="output_{{ $slide->id }}" />
                  <i class="remove fas fa-times-circle" img_id="{{ $slide->id }}"></i>
                </div>
                <div class="preview-image__default preview-image__default_{{ $slide->id }}"><i class="far fa-image"></i>
                </div>
                @endif
              </div>
              <div class="file">
                <label class="file-label">
                  <input type="hidden" name="img_url_{{ $slide->id }}" value="{{ $slide->url }}" />
                  <input class="file-input" type="file" id="product_upload_image_{{ $slide->id }}"
                    name="upload-image-{{ $slide->id }}" accept="image/*">
                  <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                      Choose New Image…
                    </span>
                  </span>
                </label>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>
</div>
<button class="button is-primary call-loader" type="submit">Update Slides</button>

</div>
</div>

</form>
@endsection
