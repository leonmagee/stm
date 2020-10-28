<div class="stm-cats__item">
  <a class="edit-link" href="/{{ $url }}/{{ $id }}"><i class="fas fa-edit"></i></a>
  <a class="edit-name" href="/{{ $url }}/{{ $id }}">{{ $name }}</a>
  <a class="delete-link modal-delete-open" item_id={{ $id }}><i class="fas fa-trash-alt"></i></a>
</div>
<div class="modal" id="delete-item-modal-{{ $id }}">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <h4 class="title modal-title">Are You Sure?</h4>
      <p class="modal-text">{{ $warning }}</p>
      <a href="/{{ $delete_url }}/{{ $id }}" class="button is-danger">{{ $delete_text }}</a>
      <a class="modal-delete-close-button button is-primary" item_id={{ $id }}>Cancel</a>
    </div>

  </div>

  <button class="modal-delete-close is-large" aria-label="close" item_id={{ $id }}></button>

</div>
