@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Categories</h3>

    <div class="stm-cat">
      <form method="POST" action="/add-cat">
        @csrf
        <div class="form-wrap">
          <div class="form-wrap-flex">
            <div class="field">
              <label class="label" for="name">Category Name</label>
              <div class="control item-flex">
                <input class="input" name="name" placeholder="Category Name" />
                <button class="button is-primary call-loader" type="submit">Add New</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="stm-cats">
      @foreach($cats as $cat)
      @include('mixins.cat-item', [
      'id' => $cat->id,
      'name' => $cat->name,
      'url' => 'categories',
      'delete_url' => 'delete-cat',
      'delete_text' => 'Delete Category',
      'warning' => 'This will delete all associated sub categories and category data for products.'
      ])
      @endforeach
    </div>

  </div>

</div>

@endsection
