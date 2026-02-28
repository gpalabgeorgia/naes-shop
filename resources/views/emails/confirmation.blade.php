<!DOCTYPE html>
<html>
    <head>
        <title>NAES</title>
    </head>
    <body>
        <table>
            <tr>
                <td>ძვირფასო {{ $name }}!</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>გთხოვთ დააწკაპოთ აქაუნთის გასააქტიურებელ ლინკზე :-<</td>
            </tr>
            <tr>
                <td><a href="{{ url('confirm/'.$code) }}">დაადასტურეთ აქაუნთის გააქტიურება</a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>მადლობას გიხდით ნდობისთვის,</td>
            </tr>
            <tr>
                <td>NAES ონლაინ მაღაზია</td>
            </tr>
        </table>
    </body>
</html>