$(document).ready(function()
{

    if($("a.delete").length)
    {
        $("a.delete").click(function(e){

            e.preventDefault();

            if(confirm("Are you sure to Delete this item"))
            {
                window.location.href = $(this).attr("href");
            }

        })
    }
});