<div class="card card-{{ $color }} card-outline">
    <div class="card-header">
        <h3 class="card-title">
            {{ $title }}
        </h3>
        @if($tool && $title != '')
            <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm"
                        data-widget="collapse"
                        data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool btn-sm"
                        data-widget="remove"
                        data-toggle="tooltip"
                        title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
