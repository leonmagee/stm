@extends('layouts.layout')

@section('content')

@include('layouts.errors')

@include('mixins.category-back')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>{{ $category->name }}</h3>

    <div class="stm-cat flex">
      <form method="POST" action="/edit-cat/{{ $category->id }}">
        @csrf
        <div class="form-wrap">
          <div class="form-wrap-flex">
            <div class="field">
              <label class="label" for="name">Category Name</label>
              <div class="control item-flex">
                <input class="input" name="name" value="{{ $category->name }}" />
                <button class="button is-primary call-loader" type="submit">Update Name</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <form method="POST" action="/add-sub-cat">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id }}" />
        <div class="form-wrap">
          <div class="form-wrap-flex">
            <div class="field">
              <label class="label" for="sub_cat_name">New Subcategory for {{ $category->name }}</label>
              <div class="control item-flex">
                <input class="input" name="sub_cat_name" placeholder="Subcategory Name" />
                <button class="button is-primary call-loader" type="submit">Add New</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="stm-cats">
      @if($category->sub_categories->count())
      @foreach($category->sub_categories as $cat)
      @include('mixins.cat-item', [
      'id' => $cat->id,
      'name' => $cat->name,
      'url' => 'sub-categories',
      'delete_url' => 'delete-sub-cat',
      'delete_text' => 'Delete Sub Category',
      'warning' => 'This will delete all associated category data for products.'
      ])
      @endforeach
      @else
      <div class="no-sub-cats">
        There are no sub categories.
      </div>
      @endif
    </div>

  </div>

</div>

@endsection
