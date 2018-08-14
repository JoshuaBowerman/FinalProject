$("#Add").click(function () {
   document.getElementById("list").innerHTML = document.getElementById("list").innerHTML + $("#target").val() + "<br>";
   $("#actual").val($("#actual").val() + "," + $("#target").val());
   $("#target").val("");
});