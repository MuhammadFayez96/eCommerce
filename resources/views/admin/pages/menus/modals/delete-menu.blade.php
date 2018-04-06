<div class="modal fade" id="delete" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
                <input type="hidden" id="delete_token"/>
                <input type="hidden" id="delete_id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger"
                        onclick="ajaxDelete('{{url('menus/delete')}}/'+$('#delete_id').val(),$('#delete_token').val())">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
