(function() {

    var color = {
        NP: "rgba(255, 99, 132, 0.75)",
        NPAI: "rgba(54, 162, 235, 0.75)",
        SAV: "rgba(255, 206, 86, 0.75)",
        EC: "rgba(75, 192, 192, 0.75)",
        EP: "rgba(153, 102, 255, 0.75)",
    }

    const ctxDone = document.getElementById('done-canvas').getContext('2d');
    const ctxInWork = document.getElementById('inwork-canvas').getContext('2d');

    /**
     * Build radar chart
     */
     $.post({
        url: "./?p=stats",
        data: {
            action: "ajax_get_inwork_chart_data",
        },
        success: function(data) {
            data = JSON.parse(data);
            buildRadarChart(data);
        }
    });

    function buildRadarChart(data) {
        const chartInWork = new Chart(ctxInWork, {
            type: 'radar',
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'En cours'
                    }
                }
            },
            data: {
                labels: [
                    'A réceptionner',
                    'A diagnostiquer',
                    'A remplacer',
                    'A rembourser',
                    'A réexpédier',
                  ],
                  datasets: [{
                    label: 'NP',
                    data: [
                        data.NP.receive,
                        data.NP.diagnostic,
                        data.NP.replacement,
                        data.NP.repayment,
                        data.NP.reship
                    ],
                    fill: true,
                    backgroundColor: color.NP,
                    borderColor: color.NP,
                    pointBackgroundColor: color.NP,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: color.NP
                  }, {
                    label: 'NPAI',
                    data: [
                        data.NPAI.receive,
                        data.NPAI.diagnostic,
                        data.NPAI.replacement,
                        data.NPAI.repayment,
                        data.NPAI.reship
                    ],
                    fill: true,
                    backgroundColor: color.NPAI,
                    borderColor: color.NPAI,
                    pointBackgroundColor: color.NPAI,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: color.NPAI
                  },{
                    label: 'SAV',
                    data: [
                        data.SAV.receive,
                        data.SAV.diagnostic,
                        data.SAV.replacement,
                        data.SAV.repayment,
                        data.SAV.reship
                    ],
                    fill: true,
                    backgroundColor: color.SAV,
                    borderColor: color.SAV,
                    pointBackgroundColor: color.SAV,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: color.SAV
                  },{
                    label: 'EC',
                    data: [
                        data.EC.receive,
                        data.EC.diagnostic,
                        data.EC.replacement,
                        data.EC.repayment,
                        data.EC.reship
                    ],
                    fill: true,
                    backgroundColor: color.EC,
                    borderColor: color.EC,
                    pointBackgroundColor: color.EC,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: color.EC
                  },{
                    label: 'EP',
                    data: [
                        data.EP.receive,
                        data.EP.diagnostic,
                        data.EP.replacement,
                        data.EP.repayment,
                        data.EP.reship
                    ],
                    fill: true,
                    backgroundColor: color.EP,
                    borderColor: color.EP,
                    pointBackgroundColor: color.EP,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: color.EP,
                  },
                ]
            } 
        });
    }

    /**
     * Build donut chart
     */
    $.post({
        url: "./?p=stats",
        data: {
            action: "ajax_get_done_chart_data",
        },
        success: function(data) {
            data = JSON.parse(data);
            buildDonutChart(data);
        }
    });

    function buildDonutChart(data) {
        const chartDone = new Chart(ctxDone, {
            type: 'doughnut',
    
            data: {
                labels: ['NP', 'NPAI', 'SAV', 'EC', 'EP'],
                datasets: [{
                    label: '# de tickets',
                    data: [
                        data.NP,
                        data.NPAI,
                        data.SAV,
                        data.EC,
                        data.EP
                    ],
                    backgroundColor: [color.NP, color.NPAI, color.SAV, color.EC, color.EP],
                    borderColor: [color.NP, color.NPAI, color.SAV, color.EC, color.EP],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            } 
        });
    }
    

})()