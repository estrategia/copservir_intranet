/**
* Objeto que maneja los calculos de los totales del formulario
*/

var ReporteAsignacionView = function (cantidadCampos, cantidadUnidades, cantidadEspacios) {
		this.cantidadCampos = cantidadCampos;
		this.cantidadUnidades = cantidadUnidades;
		this.cantidadEspacios = cantidadEspacios;
		this.arrayPromedios = [];

};

/**
* calculos de los promedios por unidad de negocio (de manera horizontal)
*/
ReporteAsignacionView.prototype.calcularTotalPorUnidades = function()
{
		for(i = 0; i < this.cantidadCampos; i+= this.cantidadEspacios){
				var longitud = i +  this.cantidadEspacios;
				var contador = 0;
				var promedio = 0;
				for (var j = i; j < longitud; j++) {
					var elementoCalificacion = '#calificacion-'+j;
					var elementoPorcentaje = '#porcentaje-'+contador;
					valorCalificacion  =  parseFloat($(elementoCalificacion).text());
					valorPorcentaje  =  parseFloat($(elementoPorcentaje).text()) / 100;
					promedio += valorPorcentaje * valorCalificacion;
					contador++;
				}
				this.arrayPromedios.push(promedio)
		}

		this.setPromediosUnidades();
}

ReporteAsignacionView.prototype.calcularTotalRango = function()
{
		var suma = 0;

		for (var i = 0; i < this.cantidadUnidades; i++) {
			var elementoTotalPromedio = '#promedio-unidad-'+i;
			var elementoPorcentajeUnidad = '#porcentaje-unidad-'+i;

			var valorTotalPromedio  =  parseFloat($(elementoTotalPromedio).text());
			var valorPorcentajeUnidad = parseFloat($(elementoPorcentajeUnidad).text()) / 100;

			suma += valorTotalPromedio * valorPorcentajeUnidad;
		}

		this.setTotalRango(suma);
}

/**
* Asigna los promedios en la posicion de la tabla
*/
ReporteAsignacionView.prototype.setPromediosUnidades = function()
{
		for (var i = 0; i < this.cantidadUnidades; i++) {
			var elementoTotalPromedio = '#promedio-unidad-'+i;
			$(elementoTotalPromedio).text(this.arrayPromedios[i]);
		}
}

/**
* Asigna el calculo del total
*/
ReporteAsignacionView.prototype.setTotalRango = function(total)
{
		console.log('setTotalRango');
		$('#total-rango').text(total);
}
