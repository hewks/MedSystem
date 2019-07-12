<!-- Admin section -->
<section class="hw-page-section hw-page-administradores">

    <!-- Table -->
    <div class="hw-page-section-table">
        <div class="hw-page-section-header">
            <div class="ps-header-section-left">
                <h4 class="hw-page-section-title"><?= $page_title ?></h4>
            </div>
            <div class="hw-header-section-right">
                <a href="<?= base_url() ?>Back/<?= $section ?>/create_pdf" class="hw-section-download"><i class="fas fa-file-export"></i></a>
            </div>
        </div>
        <div class="hw-page-section-body">
            <table class="hw-table table table-striped table-bordered" style="width: 100% !important;" id="tableSectionTable">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Documento</td>
                        <td>Tipo Documento</td>
                        <td>Act</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Documento</td>
                        <td>Tipo Documento</td>
                        <td>Act</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Table -->

</section>
<!-- Admin section -->

<!-- Modal -->
<div class="modal" id="historyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historias Clinicas (<span id="customer_id"></span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-history">
                <ul id="modalBodyHistory">                    
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->