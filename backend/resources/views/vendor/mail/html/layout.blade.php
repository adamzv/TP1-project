

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
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}

                                    {{ $subcopy ?? '' }} </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 15px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    <p style="margin: 0;color: #ffffff;">V prípade problémov kontaktujte administrátora.<br/>

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
