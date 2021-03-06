@extends('layouts.layout')

@section('content')

@include('layouts.errors')

@include('mixins.sub-category-back', ['id' => $category->category->id, 'name' => $category->category->name])

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>{{ $category->name }}</h3>

    <div class="stm-cat">
      <form method="POST" action="/edit-sub-cat/{{ $category->id }}">
        @csrf
        <div class="form-wrap">
          <div class="form-wrap-flex">
            <div class="field">
              <label class="label" for="name">Sub Category Name</label>
              <div class="control item-flex">
                <input class="input" name="name" value="{{ $category->name }}" />
                <button class="button is-primary call-loader" type="submit">Update Name</button>
              </div>
            </div>
          </div>
        </div>
      </form>

    </div>



  </div>

</div>

@endsection
