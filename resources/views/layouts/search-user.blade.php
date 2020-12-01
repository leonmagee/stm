<div class="field has-addons search-field">
  <form method="POST" action="/search-user" class="form-element">
    @csrf
    <span class="input-wrap">
      <input type="text" class="search" name="user_search" placeholder="Search Users..." />
    </span>
    <p class="control">
      <a class="button mode search-submit" id="user-search-submit">
        <span class="icon is-small">
          <i class="fas fa-search"></i>
        </span>
      </a>
    </p>
  </form>
</div>
