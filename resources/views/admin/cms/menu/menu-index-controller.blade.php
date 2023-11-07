<x-slot name="pageTitle">
    {{ __('menu.index.title') }}
</x-slot>
    
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <livewire:admin.cms.menu.menu-table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
