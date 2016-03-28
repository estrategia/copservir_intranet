<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Resultado busqueda';
?>
<!--
<div class="app_timeline">
                <img class="archivo-timeline" usemap="#archivo-timeline" src="http://chart.apis.google.com/chart?cht=s&amp;chs=908x70&amp;chxt=x&amp;chm=o,1F6492,0,0,30.0,0&amp;chd=t:0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26|20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20|0,16,20,52,166,413,204,174,76,29,21,36,35,72,57,79,87,139,249,416,56,101,142,87,417,82&amp;chds=0,26,0,40,0,417&amp;chxl=0:||1992|1993|1994|1995|1996|1997|1998|1999|2000|2001|2002|2003|2004|2005|2006|2007|2008|2009|2010|2011|2012|2013|2014|2015|2016|" alt="Línea de tiempo">
                <map name="archivo-timeline">
                  <area shape="rect" coords="17,0,50,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1992&amp;pagina=1" title="1992 - 16 resultados"><area shape="rect" coords="51,0,84,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1993&amp;pagina=1" title="1993 - 20 resultados"><area shape="rect" coords="85,0,118,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1994&amp;pagina=1" title="1994 - 52 resultados"><area shape="rect" coords="119,0,152,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1995&amp;pagina=1" title="1995 - 166 resultados"><area shape="rect" coords="153,0,186,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1996&amp;pagina=1" title="1996 - 413 resultados"><area shape="rect" coords="187,0,220,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1997&amp;pagina=1" title="1997 - 204 resultados"><area shape="rect" coords="221,0,254,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1998&amp;pagina=1" title="1998 - 174 resultados"><area shape="rect" coords="255,0,288,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=1999&amp;pagina=1" title="1999 - 76 resultados"><area shape="rect" coords="289,0,322,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2000&amp;pagina=1" title="2000 - 29 resultados"><area shape="rect" coords="323,0,356,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2001&amp;pagina=1" title="2001 - 21 resultados"><area shape="rect" coords="357,0,390,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2002&amp;pagina=1" title="2002 - 36 resultados"><area shape="rect" coords="391,0,424,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2003&amp;pagina=1" title="2003 - 35 resultados"><area shape="rect" coords="425,0,458,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2004&amp;pagina=1" title="2004 - 72 resultados"><area shape="rect" coords="459,0,492,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2005&amp;pagina=1" title="2005 - 57 resultados"><area shape="rect" coords="493,0,526,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2006&amp;pagina=1" title="2006 - 79 resultados"><area shape="rect" coords="527,0,560,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2007&amp;pagina=1" title="2007 - 87 resultados"><area shape="rect" coords="561,0,594,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2008&amp;pagina=1" title="2008 - 139 resultados"><area shape="rect" coords="595,0,628,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2009&amp;pagina=1" title="2009 - 249 resultados"><area shape="rect" coords="629,0,662,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2010&amp;pagina=1" title="2010 - 416 resultados"><area shape="rect" coords="663,0,696,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2011&amp;pagina=1" title="2011 - 56 resultados"><area shape="rect" coords="697,0,730,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2012&amp;pagina=1" title="2012 - 101 resultados"><area shape="rect" coords="731,0,764,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2013&amp;pagina=1" title="2013 - 142 resultados"><area shape="rect" coords="765,0,798,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2014&amp;pagina=1" title="2014 - 87 resultados"><area shape="rect" coords="799,0,832,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2015&amp;pagina=1" title="2015 - 417 resultados"><area shape="rect" coords="833,0,866,70" href="?q=cortulua&amp;producto=eltiempo&amp;a=2016&amp;pagina=1" title="2016 - 82 resultados"></map>            </div>
-->
<?php foreach ($resultados as $resultado): ?>
    <?= $resultado->fechaActualizacion ?>
    <?= $resultado->titulo ?>
    <?= $resultado->contenido ?>
<?php endforeach; ?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var container = document.getElementById('example4.2');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();

    dataTable.addColumn({ type: 'string', id: 'Role' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
      [ 'President', 'George Washington', new Date(1789, 1, 1), new Date(1789, 12, 31) ],
      [ 'President', 'John Adams', new Date(1797, 2, 4), new Date(1801, 2, 4) ],
      [ 'President', 'Thomas Jefferson', new Date(1801, 2, 4), new Date(1809, 2, 4) ]]);

    var options = {
      timeline: { groupByRowLabel: true }
    };

    chart.draw(dataTable, options);
  }
</script>

<div id="example4.2" style="height: 200px;"></div>
