/**
 * @author Administrator
 */
function onSubmit(){
	if($("#username").val()==''||$('#password').val()=='')return false;
	return true;
}
