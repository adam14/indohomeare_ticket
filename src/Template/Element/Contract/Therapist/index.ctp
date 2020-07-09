<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="page-head-line">Terapi</h4>
                <?php echo $this->Html->link('Tambah Baru', '#', ['class' => 'disable btn btn-sm btn-success', 'data-href' => $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'add', $contracts->id]), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'Tambah Data', 'title' => 'Click to Add', 'escape' => false]); ?>
                <div class="row">
                    <div class="col-md-12 margin-bottom-30">
                        <div class="panel panel-primary">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Terapi</th>
                                            <th>Sesi Terapi</th>
                                            <th>Harga Terapi</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($therapist_contracts)): ?>
                                            <?php $i = 1; ?>
                                            <?php foreach ($therapist_contracts as $value): ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $value['therapists']['name']; ?></td>
                                                    <td><?php echo $value['therapist_sessions']['name']; ?></td>
                                                    <td><?php echo $this->Number->currency($value['therapist_sessions']['price'], 'Rp '); ?></td>
                                                    <td>
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', '#', ['class' => 'btn btn-sm btn-info', 'data-href' => $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'edit', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#modal-form', 'data-label' => 'Ubah Data', 'title' => 'Click to Edit', 'escape' => false]); ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-trash"></i>', '#', ['class' => 'confirm btn btn-sm btn-danger', 'data-href' => $this->Url->build(['controller' => 'TherapistContracts', 'action' => 'delete', $value['id']]), 'data-toggle' => 'modal', 'data-target' => '#confirm', 'data-label' => 'Konfirmasi Hapus', 'data-message' => 'Yakin ingin menghapus data ini?', 'title' => 'Click to Delete', 'escape' => false]); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
