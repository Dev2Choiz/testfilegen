
var FGTest = (function() {
    "use strict";

    var nbLines = [];
    var filegenData = [];
    var normalData  = [];

    var getData = function() {
        var that = this;
        that.nbLines = [];
        that.filegenData = [];
        that.normalData = [];

        $("#content table .nbLine").each(function () {
            that.nbLines.push(parseInt($(this).html()));
        });
        $("#content table .filegenValue").each(function () {
            that.filegenData.push(parseInt($(this).html()));
        });
        $("#content table .normalValue").each(function () {
            that.normalData.push(parseInt($(this).html()));
        });
    };

    var drawGraph = function() {
        this.getData();
        console.log(this.nbLines);
        console.log(this.filegenData);
        console.log(this.normalData);

        Highcharts.chart('container', {
            yAxis: {
                title: {
                    text: 'Mémoire utilisée'
                }
            },
            xAxis: {
                categories: this.nbLines,
                title: {
                    text: 'Nb lignes écrites'
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'top'
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    }
                }
            },
            series: [
                {
                    name: 'Avec générateur',
                    data: this.filegenData
                }, {
                    name: 'Normal',
                    data: this.normalData
                }
            ],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    };

    return {
        filegenData : filegenData,
        normalData : normalData,
        nbLines : nbLines,
        getData : getData,
        drawGraph : drawGraph
    };
})();

$(document).ready(function () {
    FGTest.drawGraph();
});