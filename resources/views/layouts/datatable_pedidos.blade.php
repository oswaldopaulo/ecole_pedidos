<link href="{{asset('css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('datatables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('datatables/extensions/Select/css/select.bootstrap.min.css')}}" rel="stylesheet">

   

<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/buttons.bootstrap.min.js')}}"></script>

<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/buttons.html5.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Responsive/js/responsive.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datatables/extensions/Select/js/dataTables.select.min.js')}}"></script>


<script type="text/javascript">

$(document).ready(function() {

	/* $('#tabela thead th').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Localizar '+title+'" />' );
	    } );
	  */  
	var table = $('#tabela').DataTable( {

		

		
		"pageLength": 50,
		//dom: 'Bfrtip',
		
		lengthChange: false,
		buttons: [

			
	            {
	                text: 'Novo Pedido',

	                action: function ( e, dt, node, config ) {
	                    novo();
	                    
	                }

                
	                
	            },
	            {
	                text: 'Checar Pedido',

	                action: function ( e, dt, node, config ) {
	                	envialogix();
	                    
	                }

                
	                
	            },
			
			{ 
	    			extend: 'excelHtml5',
	    			fieldSeparator: '\t'

			},
			'csvHtml5',
			'pdfHtml5',
			'print'
		],
		
		 "order": [[ 1, "asc" ]],
		
		 "oLanguage": {
            				"sProcessing": "Processando...",
							"sLengthMenu": "Mostrar _MENU_ registros",
							"sZeroRecords": "Não foram encontrados resultados",
							"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
							"sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
							"sInfoFiltered": "(filtrado de _MAX_ registros no total)",
							"sInfoClienteFix": "",
							"sSearch": "Buscar:",
							"sUrl": "",
							"oPaginate": {
								"sFirst":    "Primeiro",
								"sPrevious": "Anterior",
								"sNext":     "Seguinte",
								"sLast":     "ultimo"
							},
							
							buttons: {
									"print": "IMPRIMIR"
									
								},

								
							
        				},
		
		
        				 
	} );
	 table.buttons().container()
     .appendTo( '#tabela_wrapper .col-sm-6:eq(0)' );

	 table.columns().every( function () {
	        var that = this;
	 
	        $( 'input', this.header() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	
} );
</script>