    <div class="modal fade" tabindex="-1" id="createModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Pilih Status Pegawai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="row">
            <div class="col-6">
            <a href="{{ route('createPegawaiTetap') }}" class="btn btn btn-primary mb-1" style="width:100%">Tetap</a>
            </div>
            <div class="col-6">
            <a href="{{ route('createPegawaiKontrak') }}" class="btn btn btn-warning" style="width:100%">Kontrak</a>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
    </div>