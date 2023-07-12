// delete event
$('.bi-trash').click((e) => {
    if(confirm("Are you sure you want to delete this")){
        // console.dir(e.target.nextElementSibling);
        e.target.nextElementSibling.submit();
    }
   
})

// json restful api
$.ajax({
    type: "POST",
    url: "json.php",
    success: function (response) {
        console.log(response);
    }
})

// check box
$('.checkForm').click((e) => {
    
    $id = e.target.form[0].id;

    if(e.target.form[0].checked){
        $check = 1;
        // console.dir(e.target.parentElement.parentElement.parentElement.classList.add("text-through"));
        e.target.parentElement.parentElement.parentElement.classList.add("text-line");
    } else if(e.target.checked == false){
        $check = 0;
        e.target.parentElement.parentElement.parentElement.classList.remove("text-line");
    };

    $.ajax({
        type: 'POST',
        url: 'update.php',
        data: {
            id: $id,
            check: $check
        },
        success: function (response){
            console.log(response);
        }
    })
})