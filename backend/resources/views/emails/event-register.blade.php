<!DOCTYPE html>
<html>
<body>
<p>Dobrý deň, </p>



<p> Pre prihlásenie na event kliknite sem ->  <button class="odoslat">Prihlasit</button></p>


<p> Pre odhlásenie na event kliknite sem -> </p>

</body>


<script type="text/javascript">



    $(".odoslat").click(function(e){

        //e.preventDefault();

        let eventid = ${{{$eventid}}};
        let email = ${{{$email}}};

        $.ajax({
            type:'POST',
            url:"/TP1-project/backend/api/users/eventEmail",
            data:{event_id:eventid, email:email},
            success:function(data){
                alert(data.success);
            }
        });

    });
</script>
</html>