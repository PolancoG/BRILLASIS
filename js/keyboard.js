const numeric = new Array('0','1','2','3','4','5','6','7','8','9');
const numericDecimal = new Array('0','1','2','3','4','5','6','7','8','9','.');
const alphabet = new Array(' ','a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z','á','é','í','ó','ú','ä','ë','ï','ö','ü');
const alphabet2 = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z','Á','É','Í','Ó','Ú','Ä','Ë','Ï','Ö','Ü');
const caracteres = new Array('@','.','¿','?',',','%','$','#','¡','!','&','/','+','_','-','=','^','(',')','[',']','{','}','"',"'",':',';','>','<','|');
const lettersOnly = alphabet.concat(alphabet2);


//Letras en mayusculas y minusculas incluyendo espacios y puntuacion.
function onlyLtt(key)
{
    return lettersOnly.includes(key);
}

function isNumber(key)//FUNCION VALIDAR DE SOLO ACEPTAR NUMEROS NADA MAS
{
    return numeric.includes(key);
}
/*
    FUNCION VALIDAR DE SOLO ACEPTAR NUMEROS Y PERMITIR DE PONER EL PUNTO(.) PARA NUMERO DECIMAL NADA MAS.
    OJO: POR EL MOMENTO Y DE COMO SE HIZO DA LA POSIBLIDAD DE QUE HAYA UN PUNTO DE MAS PERO POR LO MENOS ES UNO SOLO
    EN LA CUAL EN ALGUN PUNTO DE PODRIA MANEJAR ESE ASUNTO DE QUITARLO
*/
function isDecimal(value,key)
{
    var dectectPunto = value.split('.');
    return (numericDecimal.includes(key) && dectectPunto.length <= 2);
}
function isLetter(key)//FUNCION VALIDAR DE SOLO ACEPTAR SOLO LETRAS TANTO MAYUSCULA COMO NINUSCULA Y LOS ESPACIOS EN BLANCO NADA MAS
{
    return alphabet.includes(key);
}
function isAlphaNumeric(key)//FUNCION VALIDAR DE SOLO ALFANUMERICOS LETRAS Y NUMEROS NADA MAS
{
    return (alphabet.includes(key) || alphabet2.includes(key) || numeric.includes(key));
}
function isAlphaNumeric2(key)//FUNCION VALIDAR DE SOLO ALFANUMERICOS LETRAS, NUMEROS Y CARACTERES(Estos caracteres son los mas comunes que esta definidos arriba) NADA MAS
{
    return (alphabet.includes(key) || alphabet2.includes(key) || numeric.includes(key) || caracteres.includes(key));
}


