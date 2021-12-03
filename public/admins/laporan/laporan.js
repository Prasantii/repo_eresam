


	$(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

         $(function () {
            // loaddata();

        });


        function goToTop() {
            $('html,body').animate({
                scrollTop: 0
            }, 1500);
        }

        function goToTable() {
            $('html,body').animate({
                scrollTop: 500
            }, 1500);
        }

	var table,spinner = $('#spinner');

	function loaddata(){
       table = $('#JenisKelamin').DataTable({
	            "bProcessing": true,
	            "bServerSide": true,
	            "autoWidth": true, 
	            "paginationType": "full_numbers",
	            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
	            "iDisplayLength": 10, 
	            "autoWidth": true,
	            "ajax":{
	                "url": "{{url('/data_lapjeniskelamin')}}",
	                "dataType": "json",
	                "type": "POST",
	                "data":{ _token: "{{csrf_token()}}"}
	            },
	           
	            "language": {
	                "url": "{{ asset('admins/js/vendor/datatables/language/Indonesia.json') }}"
	            },
	            responsive: true,
	            columnDefs: [
	                { orderable: false, targets: 0 },
	            ],
	            "order": [[ 0, 'asc' ]],
	            "columns": [
	                {
	                    "data": "no",
	                    render: function (data, type, row, meta) {
	                        return meta.row + meta.settings._iDisplayStart + 1;
	                    }
	                },
	                { data:  'uker'  },
	                { data:  'pria'  },
	                { data:  'perempuan'  },
	                { data:  'total'  }
	            ],

	      
        	});

		       table.on( 'order.dt search.dt', function () {
		            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
		                cell.innerHTML = i+1;
		            } );
		        } ).draw();
    	}

    function loaddatagolongan(){
       table = $('#Golongan').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
           //  dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
		         // "<'row'<'col-sm-12'tr>>" +
		         // "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/data_lap_golongan')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
           
            "language": {
                "url": "{{ asset('admins/js/vendor/datatables/language/Indonesia.json') }}"
            },
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 },
            ],
            "order": [[ 0, 'asc' ]],
            "columns": [
                {
                    "data": "no",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data:  'uker'  },
                { data:  'golongani_a_l'  },
                { data:  'golongani_a_p'  },
                { data:  'golongani_b_l'  },
                { data:  'golongani_b_p'  },
                { data:  'golongani_c_l'  },
                { data:  'golongani_c_p'  },
                { data:  'golongani_d_l'  },
                { data:  'golongani_d_p'  },
                { data:  'golonganii_a_l'  },
                { data:  'golonganii_a_p'  },
                { data:  'golonganii_b_l'  },
                { data:  'golonganii_b_p'  },
                { data:  'golonganii_c_l'  },
                { data:  'golonganii_c_p'  },
                { data:  'golonganii_d_l'  },
                { data:  'golonganii_d_p'  },
                { data:  'golonganiii_a_l'  },
                { data:  'golonganiii_a_p'  },
                { data:  'golonganiii_b_l'  },
                { data:  'golonganiii_b_p'  },
                { data:  'golonganiii_c_l'  },
                { data:  'golonganiii_c_p'  },
                { data:  'golonganiii_d_l'  },
                { data:  'golonganiii_d_p'  },
                { data:  'golonganiv_a_l'  },
                { data:  'golonganiv_a_p'  },
                { data:  'golonganiv_b_l'  },
                { data:  'golonganiv_b_p'  },
                { data:  'golonganiv_c_l'  },
                { data:  'golonganiv_c_p'  },
                { data:  'golonganiv_d_l'  },
                { data:  'golonganiv_d_p'  },
                { data:  'golonganiv_e_l'  },
                { data:  'golonganiv_e_p'  },
                { data:  'total'  },
            ],

      
        });

	}



        $(document).on("click", "#cari", function (){
        	var id = [];
		        $.each($("#jenis option:selected"), function(){            
		            id.push($(this).val());

		            if(id == ""){
		          		new Noty({
		                    type: 'error',
		                    layout: 'topRight',
		                    text: 'SILAHKAN PILIH JENIS LAPORAN',
		                    theme: 'nest',
		                    timeout: 4000,
		                }).show();
		          	}else if(id == "lap_jenis_kelamin"){
		          		
		          		loaddata();
		          		spinner.show();
			            setTimeout(function () {
			                $('#lap_jenis_kelamin').fadeIn(500);
			                goToTable();
			                spinner.fadeOut(500);
			                $('#cari').fadeOut(500);
			                // table.draw();
			            }, 1000);
		          	}else if(id == "lap_golongan"){
		          		
		          		loaddatagolongan();
		          		spinner.show();
			            setTimeout(function () {
			                $('#lap_golongan').fadeIn(500);
			                goToTable();
			                spinner.fadeOut(500);
			                $('#cari').fadeOut(500);
			                // table.draw();
			            }, 1000);
		          	}


		        });
	    });

	    $('.table-close').on('click', function () {
            goToTop();
            $('#lap_jenis_kelamin').fadeOut(2000);
            $('#lap_golongan').fadeOut(2000);
            $('#cari').fadeIn(500);
            table.destroy();

            // table2.destroy();
        });


	$('#hidden').hide();