import {DataTable} from "simple-datatables"
const elem = document.querySelectorAll('.data_table')
if (elem.length) {
         const config = {
             elem,
             filters: {"Job": ["Assistant", "Manager"],
                       "Email": [e => e.endsWith('.edu'), e => e.endsWith('.com')],
                       "Ext.": [e => e > 6000]},

             columns: [{ select: 4, type: 'date', format: 'MM/DD/YYYY' }]
         };

    const dataTable = new DataTable(".data_table",config);




}
/*
var lang_es = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}

let colSort = $('th.sort-by').index()
let colSortDesc = $('th.sort-by-desc').index()
let order = [[ 0, "asc" ]]

if (colSort>=0) {
    order = [[ colSort, "asc" ]]
}

if (colSortDesc>=0) {
    order = [[ colSortDesc, "desc" ]]
}

$('.data_table').DataTable({
    "order": order,
	"language": lang_es,
    "autoWidth": false,
	"columnDefs": [
        {
            "targets": 'no-sort',
            "orderable": false
        }
    ]
})
*/