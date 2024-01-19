<script type="text/javascript">
ready(function() {
    var barChartCanvas = document.getElementById('salesChart').getContext("2d");
    barChartCanvas.height = 300;
    var myChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: {
            labels: {!! $sales_label !!},
            datasets: [{
                label: 'Transaction',
                data: {!! $sales_data !!},
                backgroundColor: '#02cc9c'
            }]
        },
        options: {
            responsive: true,
            legend: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            if (Math.floor(label) === label) {
                                return label;
                            }
                        },
                    }
                }],
            },
        }
    });

    var salesCanvas  = document.getElementById('salesValueChart').getContext("2d");
    salesCanvas.height = 300;
    var salesChart   = new Chart(salesCanvas, {
        type: 'bar',
        data: {
            labels: {!! $sales_label !!},
            datasets: [{
                label: 'Successful Purchase',
                data: {!! $sales_value !!},
                backgroundColor: '#f39c2a'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            return label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        },
                    }
                }],
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Rp. ' +tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                }
            }
        }
    });

    var salesCanvas  = document.getElementById('visitorChart').getContext("2d");
    salesCanvas.height = 300;
    var salesChart   = new Chart(salesCanvas, {
        type: 'line',
        data: {
            labels: {!! $analytic_label !!},
            datasets: [{
                label: 'Visitors',
                data: {!! $analytic_visitors !!},
                backgroundColor: '#228aca'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            return label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        },
                    }
                }],
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' Visitors';
                    },
                }
            }
        }
    });
});
</script>
