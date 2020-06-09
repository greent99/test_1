<div id="modalConfirm" class="modal fade confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="headmodalconfirm" class="modal-header badge-warning">
                <h5 class="text-light modal-title mt-0" id="mySmallModalLabel">{{\Illuminate\Support\Facades\Lang::get('en.pt_notification')}}!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="imagemodalconfirm" class=" text-center">
                    <div id="warningimage">
                        <img class=" rounded-circle avatar-xl" src="{{asset('asset_admin/images/error/warning-icon.png')}}" alt="200x200"
                             data-holder-rendered="true">
                    </div>
                </div>
                <div id="messagemodalconfirm" class="text-dark text-center">
                    <p id="warningmessage">
                        Bạn có chắc chắc muốn xóa hay không
                    </p>
                </div>
            </div>
            <div id="footermodalconfirm" class="modal-footer">
                <button onclick="accept()" type="button" class="btn btn-success" id="modal-btn-si">{{\Illuminate\Support\Facades\Lang::get('en.pt_yes')}}</button>
                <button onclick="reject()" type="button" class="btn btn-primary" id="modal-btn-no">{{\Illuminate\Support\Facades\Lang::get('en.pt_no')}}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var data;
    //chap nhan
    function accept() {
        showConfirmModal(2)
        sendDataByAjax(data,'POST')
    }
    //lay du lieu 1 dong
    function getOneObj(element) {
        showConfirmModal(1)
        var dataId = $(element).attr("data-id")
        var dataUrl = $(element).attr("data-url")
        var dataFlag = $(element).attr("data-flag")
        var idArr = []
        idArr.push(dataId)
        data = {idArr:idArr,url:dataUrl,flag:dataFlag};
    }
    //lay du lieu nhieu dong
    function getAllObj(element) {
        showConfirmModal(1)
        var dataUrl = $(element).attr("data-url")
        var dataFlag = $(element).attr("data-flag")
        var idArr = getRowCheck();
        data = {idArr:idArr,url:dataUrl,flag:dataFlag};
    }
    //gui du lieu thong qua ajax
    function sendDataByAjax(data,method)
    {
        $.ajax({
            url:data['url'],
            method: method,
            data:{
                data: data,
                _token:$('meta[name="_token"]').attr('content'),
            },
            success: function(response)
            {
                var data = JSON.parse(response)
                console.log(data)
                if(data['status'])
                {
                    deleteRow(data['data'])
                    console.log('IE co bug nha microsoft?')
                    f()
                    showConfirmModal(3,data['message'])
                }
                else
                {
                    showConfirmModal(4,data['message'])
                }
            },
            error: function(xhr) {
              console.log(xhr)
            }
        });
    }
    //tu choi modal
    function reject() {
        $('#modalConfirm').modal('hide');
    }
    //delete html
    function deleteRow(arr)
    {
        for(var id of arr)
        {
            document.getElementById('row_' + id).remove()
        }
    }
    //check all box
    function checkAll()
    {
        var value = $('#check_all').is(':checked');
        jQuery("input[name='checkbox']").each(function () {
            $(this).prop( "checked", value );
        })
    }
    function hideWarningModal() {
        $('#modalConfirm').modal('hide')
    }
    function showWarningModal() {
        $('#modalConfirm').modal('show')
    }
    function showConfirmModal(index,data=null) {
        switch (index) {
            case 1:
                showWarningModal()
                hideSuccessModal()
                hideErrorModal()
                hideLoadingModal()
                break;
            case 2:
                showLoadingModal()
                hideSuccessModal()
                hideErrorModal()
                hideWarningModal()
                break;
            case 3:
                showSuccessModal(data)
                hideLoadingModal()
                hideErrorModal()
                hideWarningModal()
                break;
            case 4:
                showErrorModal(data)
                hideLoadingModal()
                hideErrorModal()
                hideWarningModal()
                break;
        }
    }
   function f() {
        var isIE = window.ActiveXObject || "ActiveXObject" in window;
        if (isIE) {
            $('.modal').removeClass('fade');
        }
    }
    // xuat file pdf
    function exportExcel(element) {
        var type = $(element).attr('data-type')
        var flag = $(element).attr('data-flag')
        var rowArr = getRowCheck()
        var dataUrl = $(element).attr('data-url')
        showExportCheck()
        var attrArr = getExportAttrCheck()
        if(attrArr.length>0)
        {
            if(rowArr.length>0)
                data = data = {attrArr:attrArr,rowArr:rowArr,url:dataUrl,type:type,flag:flag};
        }
        console.log(data)
        if(!(typeof data === 'undefined')) {
            sendDataByAjax(data, 'POST')
        }
    }

    function exportPdf() {

    }
    //lay cac truong thuoc tinh duoc check
    function getExportAttrCheck() {
        var listAttrExport = []
        jQuery("input[name='checkExport']").each(function () {
            if(this.checked) {
                var value = $(this).attr('data-attr')
                listAttrExport.push(value)
            }
        })
        return listAttrExport
    }
    function showExportCheck() {
        jQuery("input[name='checkExport']").each(function () {
            $(this).removeAttr('hidden')
        })
    }
    function hideExportCheck() {
        jQuery("input[name='checkExport']").each(function () {
            $(this).attr('hidden', 'true')
        })
    }

    function getRowCheck() {
        var arr = []
        jQuery("input[name='checkbox']").each(function ()
        {
            if (this.checked == true)
            {
                arr.push(this.value)
            }
        })
        return arr;
    }

    function loadThmbImage(path)
    {

    }

</script>
