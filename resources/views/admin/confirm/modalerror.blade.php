<div id="errormodal" class="modal fade errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="errorimage">
                    <img class=" rounded-circle avatar-xl" src="{{asset('asset_admin/images/error/error-icon.png')}}" alt="200x200"
                         data-holder-rendered="true">
                </div>
                <div id="messagemodalconfirm" class="text-dark text-center">
                    <p id="errormessage">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function hideErrorModal() {
        $('#errormodal').modal('hide')
    }
    function showErrorModal(message) {
        $('#errormessage').html(message)
        $('#errormodal').modal('show')
    }
</script>
