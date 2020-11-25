<!DOCTYPE html>
<html>
<style>

.middiv{
    position: center;
    text-align: center;
}

.button {
    margin-top: 20px;
    margin-right: 20px;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}

.nadpis{

    float: left;
    text-align: center;
    color: #ffffff;
    font-family: "Arial", sans-serif;
    vertical-align: middle;

}

</style>


<body style="margin: 0; padding: 0;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
               
                <tr>
                    <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0;">

                        <div style="float: left; margin-left: 20px">
                            <h2 class="nadpis"> <img src="{{asset('pictures/logo-ukf.png')}}" style="vertical-align: middle;" width="100" height="100">
                           Univerzita Konštantína Filozofa v Nitre</h2></div>


                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif;">
                                    <h1 style="font-size: 24px; margin: 0;">Dobrý deň,</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                                    <p style="margin: 0;">teší nás Váš záujem o prihlásenie sa na udalosť. Váš záujem potvrdíte kliknutím na tlačidlo, Prihlásiť.
                                        Prosíme me Vás o rýchlu reakciu na tento email, nakoľko počet miest je limitovaný a pokiaľ účasť nepotvrdíte
                                        nebudeme s Vami počítať. V prípade, že pozvánku potvrdíte ponechajte si tento email v prípade ak by ste sa chceli odhlásiť a prenchať tak miesto niekomu inému. Ďakujeme.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                        <tr>
                                            <td width="260" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 25px 0 0 0;">
                                                            <p style="margin: 0;">V prípade, že ste sa naozaj rozhodli zúčastniť udalosti, kliknite na toto tlačidlo.</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="middiv">
                                                                <form method="post" action="{{action ('Api\UsersController@eventEmail')}}" target="_blank">

                                                                    <input type="text" name="event_id" style="display:none" value="{{$eventid}}"/>

                                                                    <input type="text" name="email" style="display:none" value="{{$email}}"/>
                                                                    <input type="text" name="_token" style="display:none" value="{{csrf_token()}}"/>
                                                                    <input class="button" style="background-color: #4CAF50;" type="submit" value="Prihlásiť"/>
                                                                </form>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td width="260" valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 25px 0 0 0;">
                                                            <p style="margin: 0;">Ak sa chcete z udalosti odhlásiť, kliknite na tlačidlo odhlásiť, ktoré účasť zruší.</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                       <td>
                                                           <div class="middiv">
                                                               <form method="post" action="{{action ('Api\UsersController@eventUnregister')}}" target="_blank">

                                                                   <input type="text" name="event_id" style="display:none" value="{{$eventid}}"/>

                                                                   <input type="text" name="email" style="display:none" value="{{$email}}"/>
                                                                   <input type="text" name="_token" style="display:none" value="{{csrf_token()}}"/>
                                                                   <input class="button" type="submit" style="background-color: #f44336;" value="Odhlasit"/>
                                                               </form>


                                                           </div>

                                                       </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 15px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    <p style="margin: 0;">V prípade problémov kontaktujte administrátora.<br/>

                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>


</html>
