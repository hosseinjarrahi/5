<li class="nav-item @if($root) has-treeview @endif">
    <a href="{{ $link }}" class="nav-link @if(url()->current() == $link) active @endif">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $label }}
            @if($root) <i class="right fa fa-angle-left"></i> @endif
        </p>
    </a>
    {{ $slot }}
</li>
