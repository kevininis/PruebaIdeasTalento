var saldoTotal = 5000;
var dinero = [500, 200, 100, 50, 20, 10, 5, 2, 1, 0.5, 0.2, 0.1, 0.02, 0.01];
var resultado = document.getElementById("Resultado");
var reinicio = document.getElementById('reinicio');
var unaOperacion = 0;


// FUNCION PARA CALCULAR EL DINERO
function darDinero () {
    let debitado = [];
    // VALIDAMOS QUE SOLO HAGA UNA OPERACION POR TRANSACCION
    if (unaOperacion < 1) {
        // OBTENEMOS EL VALOR QUE QUIERE DEBITAR EL USUARIO
        let solicitado = document.getElementById('DineroSolicitado').value; 
        // VALIDAMOS SEA MAYOR A 0 LO QUE QUIERE DEBITAR EL USUARIO
        if (solicitado > 0) {
            // VALIDAMOS QUE LO QUE QUIERE DEBITAR NO EXCEDA QUE EL CAJERO TIENE
            if (saldoTotal >= solicitado) {
                // VARIABLE PARA HACER UNA SUMA PARA QUE NO NOS PACEMOS DE LOS BILLETES QUE SON NECESARIOS
                let contador = 0;
                unaOperacion =+ 1;
                // HACERMOS UN FOREACH PARA RECORRER TODOS LOS VALORES
                dinero.forEach(billete => {
                    // VERIFICAMOS QUE EL BILLETE NO SEA MAYOR AL SOLICITADO
                    if (billete <= solicitado) {
                        // HACEMOS EL CALCULO
                        let calculo = solicitado / billete;
                        // SE METE AL ARRAY LA ESTRUCTURA CON LOS CALCULOS
                        debitado.push(' ' + billete + ' => ' + Math.trunc(calculo));
                        // EN UN CONTADOR LLEVAMOS LA CUENTA DE LOS QUE SE HA DEBITADO
                        contador = (billete * Math.trunc(calculo));
                        // LE RESTAMOS ESE CONTADOR A LO SOLICITADO PARA QUE NOS DEVUELVA UNA CANTIDAD 
                        // MÁS CERCANA AL SIGUIENTE BILLETE
                        solicitado = solicitado - contador;
                        // CONVERTIMOS A DOS DECIMALES APROXIMADOS
                        let aprox = solicitado.toFixed(2);
                        // SE LO ASIGNAMOS A LOS SOLICITADO NUEVAMENTE
                        solicitado = aprox;
                        
                    } else {
                        debitado.push(' ' + billete + ' => ' + 0);
                    }
                });
                // SE IMPRIME EL RESULTADO EN PANTALLA
                resultado.innerHTML = debitado;
                // LE RESTAMOS AL SALDO DEL CAJERO LO QUE DEBITÓ EL USUARIO
                saldoTotal =-solicitado;
                // Y SE MUESTRA EL BOTTON PARA REINICIAR TODO
                reinicio.removeAttribute("style");
            } else {    
                let p = "No se puede debitar esa cantidad";
                resultado.innerHTML = p;
            }
        } else {
            alert('No puedes debitar 0')
        }
    } else {
        alert('Solo puedes realizar una operación por transacción');
    }
    
}

function nuevaTransaccion () {
    // ESCONDEMOS EL BOTON DE NUEVA TRANSACCION
    reinicio.setAttribute("Style", "display: none;");
    // BORRAMOS LA RESPUESTA DEL SOFTWARE
    resultado.innerHTML = '';
    // BORRAMOS EL CONTENIDO DEL INPUT
    document.getElementById("DineroSolicitado").value = '';
    document.getElementById("DineroSolicitado").focus();
    // REINICIAMOS LAS OPRERACIONES QUE PUEDES REALIZAR
    unaOperacion = 0;
}