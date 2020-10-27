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
      <form method="POST" action="/edit-cat/{{ $category->id }}">
        @csrf
        <div class="form-wrap">
          <div class="form-wrap-flex">
            <div class="field">
              <label class="label" for="sub-cat">New Subcategory for {{ $category->name }}</label>
              <div class="control item-flex">
                <input class="input" name="sub-cat" placeholder="Subcategory Name" />
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
      <div class="stm-cats__item">
        <span>{{ $cat->name }}</span>
        <a class="edit-link" href="categories/{{ $cat->id }}"><i class="fas fa-edit"></i></a>
        <a class="delete-link" href="delete-cat/{{ $cat->id }}"><i class="fas fa-trash-alt"></i></a>
      </div>
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
