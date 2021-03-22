        <div class="row">
            <div class="col-lg-12 d-flex align-items-center">
                <div class="flex" style="max-width: 100%">
                    <div class="form-row">
                        <div class="col-12 col-md-10 mb-2"></div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="form-label" for="custom-select"></label>
                            <button type="button" class="btn btn-accent pr-add" data-toggle="modal" data-target="#type_modal">
                                <i class="material-icons icon--left">library_add</i> New
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-lg-32pt">
            <div class="table-responsive" data-toggle="lists" data-lists-sort-by="js-lists-values-date" data-lists-sort-desc="true" data-lists-values='["js-lists-values-name", "js-lists-values-company", "js-lists-values-phone", "js-lists-values-date"]'>
                <table id="product_type_table" class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>Product Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- // END Header Layout Content -->
<div class="modal fade bs-modal-sm" id="type_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form mothod="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Type</label>
                        <input type="text" id="ptype" name="ptype" class="form-control required" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success add-type">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
var productTypeDT = null;
$(document).ready(function() {
    productTypeDT = $('#product_type_table').DataTable({
        "info": false,
        "paging": false,
        "searching": false,
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": {
            "url": SITE_URL + "admin/productTypeList",
            "dataType": "json",
            "type": "POST",
        },
        "columns": [
            { "name": "index", "data": "index", "width": "5%" },
            { "name": "pid", "data": "pid", "width": "30%" },
            { "name": "type", "data": "type", "width": "40%" },
            { "name": "status", "data": "status", "width": "10%" },
            { "name": "action", "data": "action", "width": "15%" },
        ],
        "fnDrawCallback": function (oSettings) {
            if (oSettings.json.expired) {
                swal({
                    title: "WARNING",
                    text: "Your session has timed out. Please sign in again.",
                }).then(function () {
                    location.href = oSettings.json.url;
                });
            }

            $('.remove-type').click(function() {
                var _this = this;
                swal({
                    title: "",
                    text: "Are you sure want to remove this?",
                    showCancelButton: true
                }).then(function() {
                    removeRow(_this);
                });
            })
        }
    });

    $('.add-type').click(function() {
        addProductType(this);
    });

});

addProductType = function(el) {
    var form = $(el).closest('form');
    form.validate({
        errorClass: 'text-danger',
        submitHandler: function() {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    params: form.serializeArray()
                },
                url: SITE_URL + 'admin/createproducttype',
                success: function(data) {
                    if (data.expired) {
                        swal({
                            title: "WARNING",
                            text: data.message,
                        }).then(function () {
                            location.href = data.url;
                        });
                    } else {
                        productTypeDT.draw();
                        $('#type_modal').modal('hide');
                    }
                }
            })
        }
    });
}

removeRow = function(el) {
    $.ajax({
        type: 'POST',
        dataType: 'text',
        data: {
            param: $(el).data("id"),
        },
        url: '<?=site_url("admin/removeProductType")?>',
        success: function(data) {
            productTypeDT.draw();
        }
    });
}
</script>