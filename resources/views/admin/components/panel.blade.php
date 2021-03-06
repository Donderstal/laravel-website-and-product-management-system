<div class="card">
    @if(isset($title))
        <div class="card-header">
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            <strong>{{ $title }}</strong>
        </div>
    @endif
    <div class="card-body">
        {{ !empty($body) ? $body : $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>