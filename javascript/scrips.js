$(document).ready(function(){
$("#submit").click(function(){
var name = $("#username").val();
var password = $("#passwor").val();
var country = $("#country").val();
var bday = $("#bday").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'name1='+ name + '&password1='+ password + '&country='+ country + '$bday';
if(name==''||password==''||country==''||bday=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "register.php",
data: dataString,
cache: false,
success: function(result){
alert(result);
}
});
}
return false;
});
});