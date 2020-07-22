<?php $this->start('script'); ?>
<script>
    // window.print();
</script>
<?php $this->end(); ?>
<page backtop="20px" backleft="20px" backright="29px">
    <p>
        <h3>Periode : <?php echo date('d/m/Y', $start_date); ?> - <?php echo date('d/m/Y', $end_date); ?></h3>
    </p>
    <hr />
    <table style="width: 100%;">
        <tr>
            <td valign="top">
                <table style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="text-align: left;">
                            <th style="padding: 3px;">Permintaan Jasa</th>
                            <th style="padding: 3px;">Draft</th>
                            <th style="padding: 3px;">Deal</th>
                            <th style="padding: 3px;">Done</th>
                            <th style="padding: 3px;">No Response</th>
                            <th style="padding: 3px;">Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nurses as $value): ?>
                            <tr>
                                <td style="padding: 3px;"><?php echo $value['permintaan_jasa']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_draft']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_deal']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_done']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_no_response']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_cancel']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($medic_tools as $value): ?>
                            <tr>
                                <td style="padding: 3px;"><?php echo $value['permintaan_jasa']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_draft']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_deal']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_done']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_no_response']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_cancel']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($therapists as $value): ?>
                            <tr>
                                <td style="padding: 3px;"><?php echo $value['permintaan_jasa']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_draft']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_deal']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_done']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_no_response']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_cancel']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($transports as $value): ?>
                            <tr>
                                <td style="padding: 3px;"><?php echo $value['permintaan_jasa']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_draft']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_deal']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_done']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_no_response']; ?></td>
                                <td style="padding: 3px;"><?php echo $value['status_cancel']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</page>