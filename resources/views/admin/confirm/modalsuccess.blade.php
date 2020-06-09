<div id="successmodal" class="modal fade successModal" tabindex="-1" role="dialog" aria-labelledby="successmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="successimage">
                    <img class=" rounded-circle avatar-xl" src="{{asset('asset_admin/images/error/success-icon.png')}}" alt="200x200"
                         data-holder-rendered="true">
                </div>
                <div id="messagemodalconfirm" class="text-dark text-center">
                    <p id="successmessage">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function hideSuccessModal() {
        $('#successmodal').modal('hide')
        // $('body').removeClass('modal-open');
        // $('.modal-backdrop').remove();

    }
    function showSuccessModal(message) {
        $('#successmessage').html(message)
        $('#successmodal').modal('show')
    }
</script>
