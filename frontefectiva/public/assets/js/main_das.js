/* Validar solo Números */

function soloNumero(e)
{
    var key = window.Event ? e.which : e.keyCode;
    return ((key >= 48 && key <= 57) || (key==8) || (key==45));
}


/* Validar solo Letras */

function soloLetra(e)
{
    var key = window.Event ? e.which : e.keyCode;
    return ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key==8) || (key==32) || (key==45) || (key==209) || (key==241));
}

