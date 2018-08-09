var a = parseInt(document.getElementById("num-1").value);
var b = parseInt(document.getElementById("num-2").value);

function addition() {
  var ans=a+b;
  document.getElementById("ans").innerHTML = ans;
}

function subtraction() {
  var ans = a - b;
  document.getElementById("ans").innerHTML = ans;
}

function multiplication() {
  var ans = a * b;
  document.getElementById("ans").innerHTML = ans;
}

function division() {
  var ans = a / b;
  document.getElementById("ans").innerHTML = ans;
}

/*<script type="text/javascript" charset="utf-8"> 
  $(document).ready(function() {
 
    // Identify this question
    var thisQuestion = $('#question{QID}');
 
    // No weekends
    $('input[type="text"]', thisQuestion).datepicker('option', 'beforeShowDay', $.datepicker.noWeekends);
  });
</script>*/