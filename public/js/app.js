

function confirmation(event, text) {
  var answer = confirm(text);
  if (!answer) {
    event.preventDefault();
  }
}

$(document).ready(function () {
  $("form").submit(function(event) {
    if ($('input[name="title"], input[name="content"]').val().length == 0) {
      alert('Skriv in en titel');
      event.preventDefault();
    }
  });
});

//define template
var template = $('#sections .section:first').clone();

//define counter
var sectionsCount = 1;

//add new section
$('body').on('click', '.addsection', function() {

    //increment
    sectionsCount++;

    //loop through each input
    var section = template.clone().find(':input').each(function(){

        //set id to store the updated section number
        var newId = this.id + sectionsCount;

        //update for label
        $(this).prev().attr('for', newId);

        //update id
        this.id = newId;

    }).end()

    //inject new section
    .appendTo('#sections');
    return false;
});

//remove section
$('#sections').on('click', '.remove', function() {
    //fade out section
    $(this).parent().fadeOut(300, function(){
        //remove parent element (main section)
        $(this).parent().parent().empty();
        return false;
    });
    return false;
});
