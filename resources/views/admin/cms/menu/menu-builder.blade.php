<div class="root dd position-relative" wire:sortable="updateSorting" wire:sortable-group="updateSortingGroup">
    <ol class="nested-group dd-list">
        @foreach ($items as $item)
            @include('admin.cms.menu.builder-item')
        @endforeach
    </ol>
</div>

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            initNestable();
        })

        function initNestable() {
            $('.dd').nestable({
                expandBtnHTML: null,
                maxDepth: 2,
                collapseBtnHTML: '',
                dragClass: 'draging d-none',
                placeClass: 'drag-placeholder',
                callback: function() {
                    let data = $('.dd').nestable('serialize');
                    @this.dispatch('updateSorting', {
                        data: data
                    });
                }
            });
        }

        function destroyNestable() {
            $('.dd').nestable('destroy');
        }

        function reInitNestable() {
            destroyNestable();
            initNestable();
        }
    </script>
@endpush
