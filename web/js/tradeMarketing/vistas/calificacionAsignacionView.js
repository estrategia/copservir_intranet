/**
* Objeto que maneja los calculos de los totales del formulario
*/

var CalificacionAsignacionView = function (cantidadCampos, cantidadUnidades, cantidadCategorias) {
	this.cantidadCampos = cantidadCampos;
	this.cantidadUnidades = cantidadUnidades;
	this.cantidadCategorias = cantidadCategorias;
	this.arrayTotales = [];

};

/**
* calculos de totales de manera horizontal
*/
CalificacionAsignacionView.prototype.calcularTotalPorVariables = function()
{
		for(i = 0; i < this.cantidadCampos; i++){

			var elemento = '#calificacionvariable-'+i+'-valor';
			var calificaUnidad = $(elemento).attr('data-califica-unidad');

			if(calificaUnidad === 'si'){

				var indice =  this.calcularIndice(i);
				this.calcularPromedioPorVariables(indice);
				i = (indice-1) +  this.cantidadUnidades;

			}else{
				var valor = $(elemento).val();
				var columnaTotal = '#total-'+i;
				$(columnaTotal).text(parseInt(valor));
			}
		}
}

/**
* detecta el evento de cambio de valor en el formulario y actualiza los calculos de los totales
*/
CalificacionAsignacionView.prototype.actualizarTotales = function(){

		var objeto = this;

		$('.form-control').change(function(event) {

			//:::::::::::::::::::::::::::::::::::
			// actualiza los valores horizontales
			//:::::::::::::::::::::::::::::::::::

			var indice = objeto.calcularIndice($(this).attr('data-index'));
			var calificaUnidad = $(this).attr('data-califica-unidad');

			if(calificaUnidad === 'si'){
				objeto.calcularPromedioPorVariables(indice);
			}else{
				var columnaTotal = '#total-'+ $(this).attr('data-index');
				var valor = $(this).val();
				$(columnaTotal).text(parseInt(valor));
			}

			//:::::::::::::::::::::::::::::::::
			// actualiza los valores verticales
			//:::::::::::::::::::::::::::::::::

			var contador = 0;
			var elementoCambio = this;
			var valorCambio = $(elementoCambio).val();
			var indiceCambio = $(elementoCambio).attr('data-index');

			for(var i = 0; i < objeto.cantidadCampos; i++){
			//
				var elemento = '#calificacionvariable-'+i+'-valor';
				var elementoCalificaUnidad = $(elemento).attr('data-califica-unidad');
				var cantidadVariables = $(elemento).attr('data-cantidad-variables');
				var sum = 0;
				var posicion = i;
				var salto = 1;
				var inicioPivote = i;
				var longitud = parseInt(inicioPivote)+parseInt(cantidadVariables) -1;

				if (elementoCalificaUnidad === 'si') {
					salto = objeto.cantidadUnidades;
					inicioPivote = i;
					longitud = ((i-objeto.cantidadUnidades) + (objeto.cantidadUnidades * cantidadVariables));

				}

				for (var j = inicioPivote; j <= longitud; j +=  salto) {

			 		var elemento2 = '#calificacionvariable-'+j+'-valor';
			 		var indiceElemento2 = $(elemento2).attr('data-index');
			 		var valorElemento2 = 0;
			 		if (indiceElemento2 == indiceCambio) {
			 			valorElemento2 = valorCambio;
			 		}else{
						valorElemento2 = $(elemento2).val();
					}

			 		sum += parseInt(valorElemento2);
			 	}

			 	var promedio = sum/cantidadVariables;

			 	if (elementoCalificaUnidad === 'si') {
			 		var columnaTotalUnidad = '#total-unidad-'+contador;
			 		$(columnaTotalUnidad).text(promedio);
			 		contador++;
			 	}else{

			 		for (var k = 0; k < objeto.cantidadUnidades; k++) {
			 			var columnaTotalUnidad = '#total-unidad-'+contador;
			 			$(columnaTotalUnidad).text(promedio);
			 			contador++;
			 		}
			 	}

				// acomodo la nueva posicion cuando califica unidad negocio
			 	if ((elementoCalificaUnidad == 'si') && (((i+1) % (objeto.cantidadUnidades)) == 0) ) {
			 		i = ((i-objeto.cantidadUnidades) + (objeto.cantidadUnidades * cantidadVariables));
			 	}else if (elementoCalificaUnidad != 'si') {
			 		i += parseInt((cantidadVariables-1));
			 	}
			 }

			 //:::::::::::::::::::::::::::::::::
 			// actualiza los valores totales
 			//:::::::::::::::::::::::::::::::::
			objeto.calcularTotales();
		});


}

/**
* calcula el indice desde donde se empieza a sumar paa hacer los calculos de los totales por variable
*/
CalificacionAsignacionView.prototype.calcularIndice = function(posicion){
	return parseInt(Math.floor(posicion / this.cantidadUnidades) * (this.cantidadUnidades));
}

/**
* calcula el promedio si la variable califica unidades de negocio
*/
CalificacionAsignacionView.prototype.calcularPromedioPorVariables = function(indice)
{
		var sum = 0;
		for(i = indice; i < indice + this.cantidadUnidades; i++){
			var elemento = '#calificacionvariable-'+i+'-valor';
			var valor = parseInt($(elemento).val());
			sum += parseInt(valor);
		}

		var promedio = sum / this.cantidadUnidades;
		var numeroColumna  = (indice-1) + this.cantidadUnidades;
		var columnaTotal = '#total-'+numeroColumna;
		$(columnaTotal).text(promedio);
}


/**
* calculos de totales de manera vertical
*/
CalificacionAsignacionView.prototype.calcularTotalPorUnidades = function()
{
		var contador = 0;
		for(var i = 0; i < this.cantidadCampos; i++){

			var elemento = '#calificacionvariable-'+i+'-valor';
			var calificaUnidad = $(elemento).attr('data-califica-unidad');
			var cantidadVariables = $(elemento).attr('data-cantidad-variables');
			var sum = 0;
			var posicion = i;
			var salto = 1;
			var inicioPivote = i;
			var longitud = parseInt(inicioPivote)+parseInt(cantidadVariables) -1;

			if (calificaUnidad === 'si') {
				salto = this.cantidadUnidades;
				inicioPivote = i;
				longitud = ((i-this.cantidadUnidades) + (this.cantidadUnidades * cantidadVariables));

			}

			for (var j = inicioPivote; j <= longitud; j +=  salto) {

				var elemento2 = '#calificacionvariable-'+j+'-valor';
				var valor = $(elemento2).val();
				sum += parseInt(valor);
			}

			var promedio = sum/cantidadVariables;

			if (calificaUnidad === 'si') {
				var columnaTotal = '#total-unidad-'+contador;
				$(columnaTotal).text(promedio);
				contador++;
			}else{

				for (var k = 0; k < this.cantidadUnidades; k++) {
					var columnaTotal = '#total-unidad-'+contador;
					$(columnaTotal).text(promedio);
					contador++;
				}
			}

			// acomodo la nueva posicion cuando califica unidad negocio
			if ((calificaUnidad == 'si') && (((i+1) % (this.cantidadUnidades)) == 0) ) {
				i = ((i-this.cantidadUnidades) + (this.cantidadUnidades * cantidadVariables));
			}else if (calificaUnidad != 'si') {
				i += parseInt((cantidadVariables-1));
			}
		}
}

/**
* calculos de totales por categoria
*/
CalificacionAsignacionView.prototype.calcularTotales = function()
{

	var cantidadTotales = this.cantidadCategorias * this.cantidadUnidades;
	this.arrayTotales = [];

	for (var i = 0; i <= cantidadTotales; i++) {
		var longitud = ((i-this.cantidadUnidades) + (this.cantidadUnidades * this.cantidadCategorias));
		var sum = 0;

		for (var j = i; j <= longitud; j+=this.cantidadUnidades ) {
			var elemento = '#total-unidad-'+j;
			var valor = $(elemento).text();

			sum += parseFloat(valor);
		}

		var promedio = sum / this.cantidadCategorias;
		this.arrayTotales.push(promedio)

		if ( (((i+1) % (this.cantidadUnidades)) == 0) ) {
				i = longitud;
		}
	}

	for (var i = 0; i < this.cantidadUnidades; i++) {

		var elemento = '#total-definitivo-'+i;
		$(elemento).text(this.arrayTotales[i]);
	}

}
