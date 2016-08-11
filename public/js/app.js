

function confirmation(event, text) {
  var answer = confirm(text);
  if (!answer) {
    event.preventDefault();
  }
}

$(document).ready(function () {
  $("form.save").submit(function(event) {
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

$('#deleteNoteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id = button.data('id'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('input[name="id"]').val(id);
});
