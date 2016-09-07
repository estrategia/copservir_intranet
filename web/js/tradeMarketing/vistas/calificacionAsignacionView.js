var CalificacionAsignacionView = function (cantidadCampos, cantidadUnidades) {
	this.cantidadCampos = cantidadCampos;
	this.cantidadUnidades = cantidadUnidades;

};

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

CalificacionAsignacionView.prototype.actualizarTotalesPorVariables = function(){

		var objeto = this;

		$('.form-control').change(function(event) {

			var indice = objeto.calcularIndice($(this).attr('data-index'));
			var calificaUnidad = $(this).attr('data-califica-unidad');

			if(calificaUnidad === 'si'){
				objeto.calcularPromedioPorVariables(indice);
			}else{
				var columnaTotal = '#total-'+ $(this).attr('data-index');
				var valor = $(this).val();
				$(columnaTotal).text(parseInt(valor));
			}

		});
}

CalificacionAsignacionView.prototype.calcularIndice = function(posicion){
	return parseInt(Math.floor(posicion / this.cantidadUnidades) * (this.cantidadUnidades));
}

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

//---------------------------

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
			if (calificaUnidad === 'si') {
				salto = this.cantidadUnidades;
			}

			for (var j = 0; j <= cantidadVariables; j +=  salto) {

				var elemento2 = '#calificacionvariable-'+posicion+'-valor';
				var valor = $(elemento2).val();
				sum += parseInt(valor);
				posicion = i + j;
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
					console.log('IFFF');
					i = ((i-this.cantidadUnidades) + (this.cantidadUnidades * cantidadVariables));
				}else if (calificaUnidad != 'si') {
					console.log('else if');
					i += parseInt((cantidadVariables-1));

				}
		}
}
