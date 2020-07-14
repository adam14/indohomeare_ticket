<?php $this->start('script'); ?>
<script>
    window.print();
</script>
<?php $this->end(); ?>
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
<page backtop="20px" backleft="20px" backright="29px">
    <table border="0" style="table-layout: fixed; width: 100%;">
        <tr>
            <td width="540"><?php echo $this->Html->image('logo-3.jpeg', ['width' => 200,'alt' => 'Ticketing', 'class' => 'pull-left']); ?></td>
            <td></td>
        </tr>
    </table>
    <p>
        <h3>No Kontrak : <?php echo $contracts->contract_no; ?></h3>
    </p>
    <hr />
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;" valign="top">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>PJ</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $contracts->pjs['fullname']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Pasien</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $contracts->patients['fullname']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Tanggal Mulai</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo (!empty($contracts->start_date)) ? date('d-m-Y', strtotime($contracts->start_date)) : ''; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Tanggal Berakhir</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo (!empty($contracts->end_date)) ? date('d-m-Y', strtotime($contracts->end_date)) : ''; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Dibuat Oleh</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $contracts->users['fullname']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Tanggal</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo (!empty($contracts->created_at)) ? date('d-m-Y', strtotime($contracts->created_at)) : ''; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Alamat Pasien</b></td>
                        <td style="padding: 3px;" valign="top" align="justify">: <?php echo $contracts->patients['address']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Subtotal</b></td>
                        <td style="padding: 3px;" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>- Perawat</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($subtotal_nurse, 'Rp '); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>- Terapi</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($subtotal_therapist, 'Rp '); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>- Alkes</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($subtotal_medic_tool, 'Rp '); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>- Transport</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($subtotal_transport, 'Rp '); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>- Event</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($subtotal_event, 'Rp '); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;" valign="top"><b>Jumlah Biaya</b></td>
                        <td style="padding: 3px;" valign="top">: <?php echo $this->Number->currency($total, 'Rp '); ?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%;" valign="top">
                &nbsp;
            </td>
        </tr>
    </table>
</page>