function dataTableSettings(table, data, Config){

	$(table).dataTable({
		"bProcessing": true,
		"data": data,
		"oLanguage": {
			"sProcessing": "Loading..."
		},
		"aaSorting": [],
		"sScrollX": "100%",
		"scrollX": true,
		"ordering" : true,
		"iDisplayLength" : 10,
		"searching" : true,
		"paging" : true,
		"info"  : true,
		"initComplete": function(settings, json) {
			$(".loader").fadeOut("slow");
		},

		/*

		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			$('td', nRow).attr('nowrap','nowrap');
			return nRow;
		}
		*/
	});

}
