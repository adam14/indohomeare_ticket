<?php $this->start('script'); ?>
<script>
    window.print();
</script>
<?php $this->end(); ?>
<h2>No Kontrak : <?php echo $contracts->contract_no; ?></h2>
<?php
    $subtotal_nurse = 0;
    $subtotal_therapist = 0;
    $subtotal_medic_tool = 0;
    $subtotal_transport = 0;
    $subtotal_event = 0;
    $total = 0;

    if (!empty($nurse_contracts)) {
        foreach ($nurse_contracts as $value) {
            $subtotal_nurse = $subtotal_nurse + $value['nurse_sessions']['price'];
        }
        $total += $subtotal_nurse;
    }

    if (!empty($therapist_contracts)) {
        foreach ($therapist_contracts as $value) {
            $subtotal_therapist = $subtotal_therapist + $value['therapist_sessions']['price'];
        }
        $total += $subtotal_therapist;
    }

    if (!empty($medic_tool_contracts)) {
        foreach ($medic_tool_contracts as $value) {
            $subtotal_medic_tool = $subtotal_medic_tool + $value['total_price'];
        }
        $total += $subtotal_medic_tool;
    }

    if (!empty($transport_contracts)) {
        foreach ($transport_contracts as $value) {
            $subtotal_transport = $subtotal_transport + $value['transport_times']['price'];
        }
        $total += $subtotal_transport;
    }

    if (!empty($event_contracts)) {
        foreach ($event_contracts as $value) {
            $subtotal_event = $subtotal_event + $value['price'];
        }
        $total += $subtotal_event;
    }
?>
<hr>
<table>
<tr>
    <td>Nomor Kontrak</td>
    <td>: <?php echo $contracts->contract_no; ?></td>
</tr>
<tr>
    <td>PJ</td>
    <td>: <?php echo $contracts->pjs['fullname']; ?></td>
</tr>
<tr>
    <td>Pasien</td>
    <td>: <?php echo $contracts->patients['fullname']; ?></td>
</tr>
<tr>
    <td>Tanggal Mulai</td>
    <td>: <?php echo (!empty($contracts->start_date)) ? date('d-m-Y', strtotime($contracts->start_date)) : ''; ?></td>
</tr>
<tr>
    <td>Tanggal Berakhir</td>
    <td>: <?php echo (!empty($contracts->end_date)) ? date('d-m-Y', strtotime($contracts->end_date)) : ''; ?></td>
</tr>
<tr>
    <td>Dibuat Oleh</td>
    <td>: <?php echo $contracts->users['fullname']; ?></td>
</tr>
<tr>
    <td>Tanggal</td>
    <td>: <?php echo (!empty($contracts->created_at)) ? date('d-m-Y', strtotime($contracts->created_at)) : ''; ?></td>
</tr>
<tr>
    <td>Subtotal</td>
    <td>
        <p>Perawat      : <?php echo $this->Number->currency($subtotal_nurse, 'Rp '); ?></p>
        <p>Terapi       : <?php echo $this->Number->currency($subtotal_therapist, 'Rp '); ?></p>
        <p>Alkes        : <?php echo $this->Number->currency($subtotal_medic_tool, 'Rp '); ?></p>
        <p>Transport    : <?php echo $this->Number->currency($subtotal_transport, 'Rp '); ?></p>
        <p>Event        : <?php echo $this->Number->currency($subtotal_event, 'Rp '); ?></p>
    </td>
</tr>
<tr>
    <td>Jumlah Biaya</td>
    <td>: <?php echo $this->Number->currency($total, 'Rp '); ?></td>
</tr>
<tr>
    <td>Alamat Pasien</td>
    <td>: <?php echo $contracts->patients['address']; ?></td>
</tr>
</table>
