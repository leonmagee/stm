{{-- <div class="search-wrap">
  <form method="POST" action="/search-user">
    @csrf
    <input type="text" class="search" name="user_search" placeholder="Search Users..." />
    <button type="submit" class="submit">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div> --}}
<div class="field has-addons search-field">
  <form method="POST" action="/search-user" class="form-element" id="user-search-form">
    @csrf
    <p class="control">
      <span class="input-wrap">
        <input type="text" class="search" name="user_search" placeholder="Search Users..." />
      </span>
    </p>
    <p class="control">
      <a class="button mode search-submit" id="user-search-submit">
        <span class="icon is-small">
          <i class="fas fa-search"></i>
        </span>
      </a>
    </p>
  </form>
</div>
