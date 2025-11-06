<form role="search" method="get" class="search-form" action="{{ home_url('/') }}" style="display: flex; gap: var(--space-sm); max-width: 100%;">
  <label style="flex: 1;">
    <span class="sr-only">
      {{ _x('Search for:', 'label', 'sage') }}
    </span>

    <input
      type="search"
      placeholder="{!! esc_attr_x('Search &hellip;', 'placeholder', 'sage') !!}"
      value="{{ get_search_query() }}"
      name="s"
      class="input"
      style="width: 100%; padding: var(--space-sm) var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--bg-primary); color: var(--text-primary); font-size: var(--font-size-base);"
    >
  </label>

  <button type="submit" class="button button--primary" style="white-space: nowrap;">
    {{ _x('Search', 'submit button', 'sage') }}
  </button>
</form>
