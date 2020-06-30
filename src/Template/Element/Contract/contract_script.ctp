<script>
    function selectNurses() {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurse']); ?>',
            dataType: 'json',
            success: function(result) {
                $('#Nurses').empty();
				$('#Nurses').append(new Option('-- Please Select --', ''));

                for (i = 0; i < result.data.length; i++) {
                    $('#Nurses').append('<option value="'+ result.data[i]['id'] +'" category="'+ result.data[i]['nurse_category_id'] +'">'+ result.data[i]['fullname'] +'</option>');
                }
            }
        });
    }

    function listNurse(contract_id) {
        var data_nurse_contract = {
            'contract_id' : contract_id
        };

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->Url->build(['controller' => 'Contracts', 'action' => 'getAllNurseContract']); ?>',
            data: data_nurse_contract,
            dataType: 'json',
            beforeSend: function() {
                $('#bodyNurse').html('');
            },
            success: function(result) {
                console.log(result);

                if (result.data.data.length > 0) {
                    for (i = 0; i < result.data.data.length; i++) {
                        $('#bodyNurse').append(`
                            <tr>
                                <td>`+ result.data.data[i]['nurses']['fullname'] +`</td>
                                <td>`+ result.data.data[i]['nurse_sessions']['name'] +`</td>
                                <td>`+ formatRupiah(result.data.data[i]['nurse_sessions']['price']) +`</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-sm btn-info" id="ButtonEditContractNurse"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger" id="ButtonDeleteContractNurse"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        `);
                    }
                }
            }
        });
    }

    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    $(document).ready(function() {
        var contract_id = '<?php echo (!empty($contracts)) ? $contracts['id'] : ''; ?>';

        /** Nurse */
        listNurse(contract_id);

        $('#NurseAdd').hide();

        $('#ButtonAddContractNurse').on('click', function() {
            $('#NurseAdd').show();

            $('#ButtonAddContractNurse').hide();
            $('#NurseList').hide();
            selectNurses();
        });

        $('#SaveAddContractNurse').on('click', function() {
            var nurse_id = $('#Nurses').val();
            var nurse_session_id = $('#NurseSessions').val();
            var data_nurse_contract = {
                'nurse_id' : nurse_id,
                'nurse_session_id' : nurse_session_id,
                'contract_id' : contract_id
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'saveNurseContract']); ?>',
                data: data_nurse_contract,
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'true') {
                        listNurse(contract_id);

                        $('#NurseAdd').hide();
                        $('#ButtonAddContractNurse').show();
                        $('#NurseList').show();

                        $('#Nurses').empty();
                        $('#Nurses').append(new Option('-- Please Select --', ''));
                        $('#NurseSessions').empty();
                        $('#NurseSessions').append(new Option('-- Please Select --', ''));
                    }
                }
            });
        });

        $('#CancelAddContractNurse').on('click', function() {
            $('#NurseAdd').hide();

            $('#ButtonAddContractNurse').show();
            $('#NurseList').show();

            $('#Nurses').empty();
			$('#Nurses').append(new Option('-- Please Select --', ''));
            $('#NurseSessions').empty();
			$('#NurseSessions').append(new Option('-- Please Select --', ''));
        });

        $('#Nurses').on('change', function(e) {
			var nurse_id = $(this).val();
			var nurse_category_id = $('#Nurses option:selected').attr("category");
			var data_nurse_session = {
				'nurse_id' : nurse_id,
				'nurse_category_id' : nurse_category_id
			}

			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build(['controller' => 'NurseContracts', 'action' => 'getNurseSessions']) ?>',
				data: data_nurse_session,
				dataType: "json",
				success: function(result) {
					$('#NurseSessions').empty();
					$('#NurseSessions').append(new Option('-- Please Select --', ''));

					for (i = 0; i < result.data.length; i++) {
						$('#NurseSessions').append('<option value="'+ result.data[i].id +'">'+ result.data[i].name +' [Rp. '+ formatRupiah(result.data[i].price) +']</option>');
					}
				}
			});
		});
        /** End */
    });
</script>