@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Create a Product</h3>

    <form method="POST" action="/product-new" enctype="multipart/form-data">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">
          <div class="field half">
            <label class="label" for="name">Product Name<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="name" name="name" autocomplete="off" value="{{ old('name') }}" />
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="cost">Cost<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="number" min="0" step="0.01" id="cost" name="cost" autocomplete="off"
                value="{{ old('cost') }}" />
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="discount">Discount</label>
            <div class="control">
              <input class="input" type="number" min="0" step="0.01" id="discount" name="discount" autocomplete="off"
                value="{{ old('discount') }}" />
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="image">Image</label>
            <div class="control">
              <div class="file">
                <label class="file-label">
                  <input class="file-input" type="file" id="image" name="upload-image">
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
            </div>
          </div>





          <div class="field full product-categories-checkboxes">
            <label class="label">Categories<span class="required">*</span></label>
            <div class="control">
              @foreach($categories as $category)
              <div class="category-item">
                <input type="checkbox" id="category-{{ $category->id }}" name="category-{{ $category->id }}" />
                <label class="label" for="category-{{ $category->id }}">{{ $category->name }}</label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Save Product</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
