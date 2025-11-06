<div class="e-content prose prose-lg">
  @php(the_content())
</div>

@if ($pagination())
  <nav class="pagination" style="margin-block-start: var(--space-xl);" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
