<?php
/*
 * $tm = 0 : No hay errores.
 * $tm = 1 : No existe la variable correspondiente a la sesión del usuario, no se puede cargar la página solicitada.
 * */
include_once dirname(__FILE__) . './../../php/Scripts/session_manager.php';
$tm = 0;
if ($session){
    ?>
    <div class="col-xl-12 h-100">
        <div class="row h-100">
            <div class="col-xl-12 align-self-center">
                <h1 class="display-4 text-center text-light">BIENVENIDO</h1>
            </div>
            <!--<div class="col-xl-12 pt-3 pb-3 align-self-center">-->
            <div class="col-xl-12 align-self-center">
                <div class="row ml-3 mr-3 h-100">
                    <div class="col-xl-6">
                        <div class="row h-100">
                            <h3 class="card-title col-xl-12 text-s30 text-light text-center">EVALUACIONES CERRADAS</h3>
                            <div class="col-xl-12 pt-4 pb-3 align-self-center">
                                <div class="table-responsive-sm">
                                    <table class="table table-hover table-dark">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Evaluacion</th>
                                                <th scope="col">Respuestas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Alcanos qwerty qwert qwr</td>
                                                <td>35</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Alcanos</td>
                                                <td>35</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Alcanos</td>
                                                <td>35</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Alcanos</td>
                                                <td>35</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Alcanos</td>
                                                <td>35</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row h-100">
                            <h3 class="col-xl-12 text-s30 text-light text-center">ESTUDIANTES APROBADOS</h3>
                            <div class="col-xl-12 pt-4 pb-3">
                                <div class="col-xl-12 align-self-center" id="curve_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2004',  1000,      400],
                ['2005',  1170,      460],
                ['2006',  660,       1120],
                ['2007',  1030,      540]
            ]);

            var options = {
                title: 'Company Performance',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
    <?php
} else {
    $toast = "<input type='hidden' id='toastAction' name='toastAction' value='1'>";
    echo "no hay session hay que informar que no se ha iniciado sesión o que los datos de la sesión han caducado";
}
