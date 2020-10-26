@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Categories</h3>


    <div class="stm-cats">
      @foreach($cats as $cat)
      <div class="stm-cats__item">
        <span>{{ $cat->name }}</span>
        <a class="edit-link" href="/categories/{{ $cat->id }}"><i class="fas fa-edit"></i></a>
        <a class="delete-link" href="/delete-cat/{{ $cat->id }}"><i class="fas fa-trash-alt"></i></a>
      </div>
      @endforeach
    </div>

  </div>

</div>

@endsection
