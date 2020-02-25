@extends('layouts.layout')

@section('content')

<div class="stm-grid-wrap notes-wrap">

  @foreach( $notes as $note )
  @if(isset($note->user))
  <div class="single-grid-item note-wrap">

    <div class="flex-item notes-icon-wrap">
      <i class="fas fa-edit"></i>
    </div>

    <div class="flex-item note-text">
      <div>
        <span><a href="/users/{{ $note->user_id }}">{{ $note->user->company }} - {{ $note->user->name }}</a></span>
      </div>
      <div>
        <span>{{ $note->text }}</span>
      </div>

    </div>
    <div class="flex-item note-end">
      <div>
        <span>Author: {{ $note->author }}</span>
      </div>
      <div>
        <span>Date: {{ $note->created_at->format('m/d/Y') }}</span>
      </div>
    </div>

  </div>
  @endif
  @endforeach

</div>

@endsection
