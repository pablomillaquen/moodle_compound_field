import $ from "jquery";
import { getform, updateform, editor } from "local_jsonform/ajaxcalls";

export const init = (userid, fieldid) => {
	const formStructure = getform(userid,fieldid);

    $('#save').click(function(){
		sendData();
	});

	function sendData(){
		event.preventDefault();
		var type;
		var datos = $('#data').val();
		//Define if we need to update or insert data
		if($('#data').val() != ""){type='u';}else{type='i';}
		let user = $('#userid').val();
		let field = $('#fieldid').val();
		$('#data').val(JSON.stringify(editor.getValue()));
		var response = updateform(user, field, JSON.stringify(editor.getValue()), 1, type);
	}
};