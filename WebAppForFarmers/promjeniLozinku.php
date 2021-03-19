<?php
    echo "  <table>
            <tr><td>Unesite staru lozinku:</td><td><input type = 'password' name = 'stara' id ='old' onblur = 'provjeraStareLoz();'></td>
            <tr><td>Unesite novu lozinku:</td><td><input type = 'password' id='pass' name = 'nova' onblur = 'provjeraIzraza();'></td></tr>
            <tr><td>Ponovo unesite novu lozinku: </td><td><input type = 'password' id ='potvpass' name = 'novapot'></td></tr>
            <input type = 'hidden' name = 'skri' id='skriv'>
            <tr><td colspan='2'><center><input type = 'button' class = 'button' name = 'potvrda' value = 'Potvrdi' onClick = 'potvrda();'></center></td></tr>
            </table>
        ";
?>