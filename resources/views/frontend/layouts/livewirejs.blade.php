<script>
    window.addEventListener("DOMContentLoaded", function() {
        window.Livewire.on("alert-success", function(e) {
            toastr.success(e)
        }), window.Livewire.on("alert-info", function(e) {
            toastr.info(e)
        }), window.Livewire.on("alert-warning", function(e) {
            toastr.warning(e)
        }), window.Livewire.on("alert-danger", function(e) {
            toastr.error(e)
        }), window.Livewire.on("confirmDelete", function(e) {
            confirm("Are you sure to delete this record ?") && window.Livewire.dispatch("delete", e)
        })
    });
</script>
