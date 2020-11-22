<!DOCTYPE html>
<html>


<body>
<a> Dobrý deň</a>


<form method="post" action="{{action ('Api\UsersController@eventEmail')}}" target="_blank">

    <input type="text" name="event_id" style="display:none" value="{{$eventid}}"/>

    <input type="text" name="email" style="display:none" value="{{$email}}"/>
    <input type="text" name="_token" style="display:none" value="{{csrf_token()}}"/>
    <input type="submit" value="Prihlásiť"/>
</form>


<form method="post" action="{{action ('Api\UsersController@eventUnregister')}}" target="_blank">

    <input type="text" name="event_id" style="display:none" value="{{$eventid}}"/>

    <input type="text" name="email" style="display:none" value="{{$email}}"/>
    <input type="text" name="_token" style="display:none" value="{{csrf_token()}}"/>
    <input type="submit" value="Odhlasit"/>
</form>

</body>
</html>
