var CalificacionAsignacionView = function (cantidadCampos, cantidadUnidades) {
	this.cantidadCampos = cantidadCampos;
	this.cantidadUnidades = cantidadUnidades;

};

CalificacionAsignacionView.prototype.calcularTotalPorVariables = function()
{
		for(i = 0; i < this.cantidadCampos; i++){

			var elemento = '#calificacionvariable-'+i+'-valor';
			var valor = $(elemento).val();
			var calificaUnidad = $(elemento).attr('data-califica-unidad');

			if(calificaUnidad === 'si'){

				var indice =  this.calcularIndice(i);
				this.calcularPromedioPorVariables(indice);
				i = (indice-1) +  this.cantidadUnidades;

			}else{
				var columnaTotal = '#total-'+i;
				$(columnaTotal).text(parseInt(valor));
			}
		}
}

CalificacionAsignacionView.prototype.calcularIndice = function(posicion){
	return parseInt(Math.floor(posicion / this.cantidadUnidades) * (this.cantidadUnidades));
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

CalificacionAsignacionView.prototype.calcularPromedioPorVariables = function(indice)
{
		var sum = 0;
		//console.log('indice: '+ indice);
		for(i = indice; i < indice + this.cantidadUnidades; i++){
			var elemento = '#calificacionvariable-'+i+'-valor';
			var valor = parseInt($(elemento).val());
			//console.log('valor: '+ valor);
			sum += parseInt(valor);
		}

		var promedio = sum / this.cantidadUnidades;
		var numeroColumna  = (indice-1) + this.cantidadUnidades;
		var columnaTotal = '#total-'+numeroColumna;
		$(columnaTotal).text(promedio);
		//console.log('termino');
		//console.log('promedio: '+ promedio);

}
